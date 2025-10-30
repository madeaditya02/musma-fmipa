<?php

namespace App\Http\Controllers;

use App\Events\VoteCandidate;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class VoteController extends Controller
{
    public function index(string $id, Request $request) 
    {
        if (Auth::user()->is_admin) {
            return back()->with('alert', ['type' => 'error', 'title' => 'Anda adalah admin', 'message' => 'Sebagai admin, anda tidak berhak untuk melakukan voting.']);
        }
        $kegiatan = Kegiatan::with('kandidat.mahasiswa.program_studi')->findOrFail($id);
        if (now()->isBefore($kegiatan->waktu_mulai)) {
            return back()->with('alert', ['type' => 'error', 'title' => 'Pemilihan belum dimulai', 'message' => 'Tunggu hingga periode pemilihan dimulai.']);
        }
        if (!($kegiatan->tahun == now()->year && $kegiatan->is_user_allowed())) {
            return back()->with('alert', ['type' => 'error', 'title' => 'Anda sudah vote', 'message' => 'Terima kasih sudah memilih calon ketua DPM FMIPA']);
        }
        return Inertia::render('Vote', ['kegiatan' => $kegiatan]);
    }

    public function vote(string $id, Request $request)
    {
        $user = Auth::user();
        $data = $request->validate(['kandidat' => 'required']);
        $kegiatan = Kegiatan::findOrFail($id);
        DB::table('surat_suara')->where('id_kegiatan', $id)->where('nim', $user->nim)->update(['has_vote' => now()]);
        // $kegiatan->mahasiswa()->sync([$user->nim => ['has_vote' => now()]]);
        $kandidat = $kegiatan->kandidat()->where('id', $data['kandidat'])->first();
        $kandidat->jumlah_suara++;
        $kandidat->save();
        // VoteCandidate::dispatch($kegiatan);
        return to_route('home')->with('alert', ['type' => 'success', 'title' => 'Vote berhasil dilakukan', 'message' => 'Terima kasih sudah memilih calon ketua DPM FMIPA']);
    }
}
