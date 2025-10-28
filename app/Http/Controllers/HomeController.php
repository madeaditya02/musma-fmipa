<?php

namespace App\Http\Controllers;

use App\Http\Resources\KandidatResource;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $year = now()->year;
        $kegiatan = Kegiatan::with('kandidat.mahasiswa')->where('tahun', $year)->get()->first()->toResource();
        return Inertia::render('Index', ['kegiatan' => $kegiatan]);
    }
}
