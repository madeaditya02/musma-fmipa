<?php

namespace App\Http\Controllers;

use App\Events\VoteCandidate;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class VoteController extends Controller
{
    public function index(string $id, Request $request) 
    {
        if (Auth::user()->is_admin) {
            return back()->with('alert', ['type' => 'error', 'title' => 'Anda adalah admin', 'message' => 'Sebagai admin, anda tidak berhak untuk melakukan voting.']);
        }
        $kegiatan = Kegiatan::with('kandidat.mahasiswa.program_studi')->findOrFail($id);
        if ($kegiatan->tahun == now()->year && $kegiatan->is_user_allowed()) {
            return Inertia::render('Vote', ['kegiatan' => $kegiatan]);
        }
        return back()->with('alert', ['type' => 'error', 'title' => 'Anda sudah vote', 'message' => 'Terima kasih sudah memilih calon ketua DPM FMIPA']);
    }

    public function vote(string $id, Request $request)
    {
        $user = Auth::user();
        $data = $request->validate(['kandidat' => 'required']);
        $kegiatan = Kegiatan::findOrFail($id);
        $kegiatan->mahasiswa()->sync([$user->nim => ['has_vote' => now()]]);
        $kandidat = $kegiatan->kandidat()->where('id', $data['kandidat'])->get()->first();
        $kandidat->jumlah_suara = $kandidat->jumlah_suara + 1;
        $kandidat->save();
        // VoteCandidate::dispatch($kegiatan);
        return to_route('home')->with('alert', ['type' => 'success', 'title' => 'Vote berhasil dilakukan', 'message' => 'Terima kasih sudah memilih calon ketua DPM FMIPA']);
    }
}
