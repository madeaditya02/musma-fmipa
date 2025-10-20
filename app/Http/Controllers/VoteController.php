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
        $kegiatan = Kegiatan::with('kandidat.mahasiswa')->findOrFail($id)->toResource();
        return Inertia::render('Vote', ['kegiatan' => $kegiatan]);
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
        VoteCandidate::dispatch($kegiatan);
        return to_route('home');
    }
}
