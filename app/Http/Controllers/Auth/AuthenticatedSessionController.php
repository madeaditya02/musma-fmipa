<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = User::find(Auth::user()->nim);
        if (!$user->is_admin && $user->status === 'aktif') {
            // Generate surat suara
            $kegiatan = Kegiatan::where('tahun', now()->year)
                ->where('waktu_selesai', '>', now())
                ->with('mahasiswa')
                ->get();
            if ($kegiatan->isNotEmpty()) {
                foreach ($kegiatan as $k) {
                    $k->mahasiswa()->syncWithoutDetaching([$user->nim => ['has_vote' => null]]);
                }
            }
        }

        return redirect()->intended(route('home', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
