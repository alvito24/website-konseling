<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentRef;
use App\Models\StaffRef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function pendingUsers()
    {
        $this->authorize('approve-users');

        $pendingUsers = User::where('is_verified', false)
            ->with(['studentsRef', 'staffRef'])
            ->latest()
            ->paginate(20);

        return view('admin.pending-users', compact('pendingUsers'));
    }

    public function verifyUser(Request $request, User $user)
    {
        $this->authorize('approve-users');

        if ($user->role === 'siswa') {
            $request->validate([
                'nis' => 'required|exists:students_ref,nis'
            ]);

            $student = StudentRef::where('nis', $request->nis)->first();
            $user->update([
                'is_verified' => true,
                'ref_id' => $student->id
            ]);
        } else {
            $request->validate([
                'nip' => 'required|exists:staff_ref,nip'
            ]);

            $staff = StaffRef::where('nip', $request->nip)
                ->where('position', $user->role)
                ->first();

            if (!$staff) {
                return back()->with('error', 'NIP tidak sesuai dengan posisi user.');
            }

            $user->update([
                'is_verified' => true,
                'ref_id' => $staff->id
            ]);
        }

        $user->notify(new \App\Notifications\AccountVerified);

        return back()->with('success', 'Sip! User udah berhasil diverifikasi dan bisa login sekarang.');
    }

    public function rejectUser(User $user)
    {
        $this->authorize('approve-users');

        $user->notify(new \App\Notifications\AccountRejected);
        $user->delete();

        return back()->with('success', 'User ditolak dan dihapus dari sistem.');
    }
}