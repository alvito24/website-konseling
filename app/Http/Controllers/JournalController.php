<?php
namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        $journals = auth()->user()->journals()->latest()->get();
        return view('journal.index', compact('journals'));
    }

    public function store(Request $request)
    {
        $request->validate(['content'=>'required','visibility'=>'required']);
        Journal::createEncrypted(auth()->id(), $request->content, $request->visibility, $request->mood ?? null);
        return back()->with('success','Jurnal tersimpan (terenkripsi).');
    }

    public function decrypt($id)
    {
        $journal = Journal::findOrFail($id);

        // access check: owner or role guru_bk/admin
        if (auth()->id() !== $journal->user_id && !in_array(auth()->user()->role, ['guru_bk','admin'])) {
            abort(403);
        }

        $plain = decrypt($journal->encrypted_content);

        // record audit log
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'decrypt_journal',
            'target_type' => 'journal',
            'target_id' => $journal->id,
            'ip' => request()->ip(),
            'meta' => null
        ]);

        return view('journal.show', compact('journal','plain'));
    }
}
