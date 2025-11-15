<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\AuditLog;
use App\Notifications\KonselingNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class KonselingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin' || $user->role === 'guru_bk') {
            $konselings = Konseling::with(['siswa', 'guru_bk'])->latest()->get();
        } elseif ($user->role === 'siswa') {
            $konselings = Konseling::where('siswa_id', $user->id)->latest()->get();
        } elseif ($user->role === 'wali_kelas') {
            $konselings = Konseling::whereHas('siswa', function($q) use ($user) {
                $q->where('wali_kelas_id', $user->id);
            })->latest()->get();
        } else {
            $konselings = Konseling::whereHas('siswa', function($q) use ($user) {
                $q->where('orangtua_id', $user->id);
            })->latest()->get();
        }

        return view('konseling.index', compact('konselings'));
    }

    public function create()
    {
        return view('konseling.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_konseling' => 'required|in:akademik,karir,pribadi,sosial',
            'topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date|after:today',
            'waktu' => 'required',
        ]);

        $konseling = Konseling::create([
            'siswa_id' => Auth::id(),
            'jenis_konseling' => $request->jenis_konseling,
            'topik' => $request->topik,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'status' => 'pending',
        ]);

        return redirect()->route('konseling.show', $konseling)->with('success', 'Permintaan konseling berhasil dibuat!');
    }

    public function show(Konseling $konseling)
    {
        $this->authorize('view', $konseling);
        return view('konseling.show', compact('konseling'));
    }

    public function edit(Konseling $konseling)
    {
        $this->authorize('update', $konseling);
        return view('konseling.edit', compact('konseling'));
    }

    public function accept(Konseling $konseling)
    {
        $this->authorize('update', $konseling);
        abort_if($konseling->status !== 'pending', 403, 'Konseling sudah diproses');

        $konseling->update([
            'status' => 'accepted',
            'guru_bk_id' => Auth::id(),
        ]);

        $konseling->siswa->notify(new KonselingNotification(
            $konseling,
            'Permintaan konseling Anda telah diterima.',
            route('konseling.show', $konseling)
        ));

        return back()->with('success', 'Permintaan konseling berhasil diterima');
    }

    public function reject(Konseling $konseling)
    {
        $this->authorize('update', $konseling);
        abort_if($konseling->status !== 'pending', 403, 'Konseling sudah diproses');

        $konseling->update([
            'status' => 'rejected',
            'guru_bk_id' => Auth::id(),
        ]);

        $konseling->siswa->notify(new KonselingNotification(
            $konseling,
            'Permintaan konseling Anda telah ditolak.',
            route('konseling.show', $konseling)
        ));

        return back()->with('success', 'Permintaan konseling telah ditolak');
    }

    public function update(Request $request, Konseling $konseling)
    {
        $this->authorize('update', $konseling);
        
        $request->validate([
            'jenis_konseling' => 'required|in:akademik,karir,pribadi,sosial',
            'topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'status' => 'required|in:pending,approved,completed,cancelled',
        ]);

        $konseling->update($request->all());

        return redirect()->route('konseling.show', $konseling)->with('success', 'Konseling berhasil diupdate!');
    }

    public function destroy(Konseling $konseling)
    {
        $this->authorize('delete', $konseling);
        
        $konseling->delete();
        return redirect()->route('konseling.index')->with('success', 'Konseling berhasil dihapus!');
    }

    public function approve(Konseling $konseling)
    {
        $this->authorize('approve', $konseling);
        
        $konseling->update([
            'status' => 'approved',
            'guru_bk_id' => Auth::id(),
        ]);

        return redirect()->route('konseling.show', $konseling)->with('success', 'Konseling berhasil disetujui!');
    }

    public function complete(Konseling $konseling)
    {
        $this->authorize('complete', $konseling);
        
        $konseling->update([
            'status' => 'completed',
        ]);

        return redirect()->route('konseling.show', $konseling)->with('success', 'Konseling telah selesai!');
    }
}