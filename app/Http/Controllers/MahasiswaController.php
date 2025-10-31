<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MahasiswaController extends Controller
{
    /**
     * Check if the authenticated user is an admin.
     */
    private function isAdmin()
    {
        $role = auth('web')->user()->is_admin;
        return match ($role) {
            0 => false,
            1 => true,
        };
    }

    /**
     * Get mahasiswa data from spreadsheet.
     */
    public function syncMahasiswa(int $year)
    {
        // Get current users and users from spreadsheet
        $currentUsers = User::where('is_admin', false)->get();
        $users = User::getMahasiswaFromSheet($year);

        // Sync users
        try {
            // Collect NIMs from spreadsheet
            $spreadsheetNims = collect($users)->pluck('nim')->toArray();

            foreach ($users as $user) {
                $currentUser = $currentUsers->firstWhere('nim', $user['nim']);

                if ($currentUser) {
                    // Update existing user and set status to 'aktif'
                    $currentUser->update(array_merge((array)$user, ['status' => 'aktif']));
                } else {
                    // Create new user with status 'aktif'
                    User::create(array_merge((array)$user, ['status' => 'aktif']));
                }
            }

            // Set status to 'nonaktif' for users not in spreadsheet
            User::where('is_admin', false)
                ->whereNotIn('nim', $spreadsheetNims)
                ->update(['status' => 'nonaktif']);

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Data mahasiswa tahun ' . $year . ' berhasil disinkronisasi.'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Terjadi kesalahan saat menyinkronkan data mahasiswa: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check admin access
        // $isAdmin = $this->isAdmin();
        // if (!$isAdmin) {
        //     return redirect()->route('dashboard');
        // }

        // Fetch mahasiswa data with related program studi
        $mahasiswa = User::with('program_studi')
            ->where('is_admin', false)
            ->get();
        $programStudi = ProgramStudi::all();
        return Inertia::render('mahasiswa/Index', [
            'mahasiswa' => $mahasiswa,
            'programStudi' => $programStudi,
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check admin access
        // $isAdmin = $this->isAdmin();
        // if (!$isAdmin) {
        //     return redirect()->route('dashboard');
        // }

        // Validate input data
        $validatedData = $request->validate([
            'nim' => 'required|string|digits:10|unique:mahasiswa,nim',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:mahasiswa,email',
            'id_program_studi' => 'required|exists:program_studi,id',
            'angkatan' => 'required|integer|min:2000|max:2100',
            'avatar' => 'nullable|image|max:4096|mimes:jpeg,png,jpg,webp',
        ], [
            'nim.digits' => 'NIM harus terdiri dari 10 digit.',
            'nim.unique' => 'NIM sudah terdaftar.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'id_program_studi.exists' => 'Program studi tidak valid.',
            'angkatan.min' => 'Angkatan minimal tahun 2000.',
            'angkatan.max' => 'Angkatan maksimal tahun 2100.',
            'avatar.image' => 'Foto profil harus berupa gambar.',
            'avatar.max' => 'Ukuran foto profil maksimal 4MB.',
            'avatar.mimes' => 'Foto profil harus berupa file dengan ekstensi jpeg, png, jpg, atau webp.',
        ]);

        try {
            // Store avatar if exists
            $avatarPath = null;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                // Get the uploaded file
                $avatarFile = $request->file('avatar');
                $avatarName = time() . '_' . $avatarFile->getClientOriginalName();

                // Define the avatar destination path
                $avatarDestination = Storage::disk('public')->path('foto-mahasiswa');
                if (!file_exists($avatarDestination)) {
                    mkdir($avatarDestination, 0755, true);
                }

                // Store the avatar file
                Storage::disk('public')->putFileAs('foto-mahasiswa', $avatarFile, $avatarName);
                $avatarPath = 'foto-mahasiswa/' . $avatarName;
            }

            // Create new mahasiswa
            User::create([
                'nim' => $validatedData['nim'],
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'] ?? null,
                'id_program_studi' => $validatedData['id_program_studi'],
                'angkatan' => $validatedData['angkatan'],
                'avatar' => $avatarPath,
                'password' => $validatedData['email'] ? bcrypt('pemirafmipa') : null,
                'email_verified_at' => $validatedData['email'] ? now()->toDateTime() : null,
            ]);

            // Redirect back with success message
            return back()->with('alert', ['type' => 'success', 'title' => 'Data mahasiswa berhasil dibuat.']);
        } catch (\Exception $e) {
            return back()->with('alert', ['type' => 'success', 'title' => 'Terjadi kesalahan saat membuat data mahasiswa: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nim)
    {
        // Check admin access
        // $isAdmin = $this->isAdmin();
        // if (!$isAdmin) {
        //     return redirect()->route('dashboard');
        // }

        // Validate input data
        $validatedData = $request->validate([
            'nim' => 'required|string|digits:10',
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'id_program_studi' => 'required|exists:program_studi,id',
            'angkatan' => 'required|integer|min:2000|max:2100',
            'avatar' => 'nullable|image|max:4096|mimes:jpeg,png,jpg,webp',
        ], [
            'nim.digits' => 'NIM harus terdiri dari 10 digit.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'id_program_studi.exists' => 'Program studi tidak valid.',
            'angkatan.min' => 'Angkatan minimal tahun 2000.',
            'angkatan.max' => 'Angkatan maksimal tahun 2100.',
            'avatar.image' => 'Foto profil harus berupa gambar.',
            'avatar.max' => 'Ukuran foto profil maksimal 4MB.',
            'avatar.mimes' => 'Foto profil harus berupa file dengan ekstensi jpeg, png, jpg, atau webp.',
        ]);

        try {
            // Find the mahasiswa to update
            $mahasiswa = User::where('nim', $nim)->firstOrFail();

            // Check if there is any data with the same NIM and email (excluding current mahasiswa)
            $existingNim = User::where('nim', $validatedData['nim'])
                ->whereNot('nim', $nim)
                ->first();
            if ($existingNim) {
                return redirect()->back()->with('alert', ['type' => 'error', 'title' => 'NIM sudah terdaftar oleh mahasiswa lain.']);
            }

            $existingEmail = User::where('email', $validatedData['email'])
                ->whereNot('nim', $nim)
                ->first();
            if ($existingEmail) {
                return redirect()->back()->with('alert', ['type' => 'error', 'title' => 'Email sudah terdaftar oleh mahasiswa lain.']);
            }

            // Handle avatar upload
            $avatarPath = $mahasiswa->avatar;
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
                // Delete old avatar if exists
                if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
                    Storage::disk('public')->delete($avatarPath);
                }

                // Store new avatar
                $avatarFile = $request->file('avatar');
                $avatarName = time() . '_' . $avatarFile->getClientOriginalName();
                Storage::disk('public')->putFileAs('foto-mahasiswa', $avatarFile, $avatarName);
                $avatarPath = 'foto-mahasiswa/' . $avatarName;
            }

            // Update mahasiswa
            $mahasiswa->update([
                'nim' => $validatedData['nim'],
                'nama' => $validatedData['nama'],
                'email' => $validatedData['email'] ?? null,
                'id_program_studi' => $validatedData['id_program_studi'],
                'angkatan' => $validatedData['angkatan'],
                'avatar' => $avatarPath,
                'password' => $validatedData['email'] ? bcrypt('pemirafmipa') : null,
                'email_verified_at' => $validatedData['email'] ? now()->toDateTime() : null,
            ]);

            return redirect()->back()->with('alert', ['type' => 'success', 'title' => 'Data mahasiswa berhasil diperbarui.']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type' => 'error', 'title' => 'Terjadi kesalahan saat memperbarui data mahasiswa: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nim)
    {
        // Check admin access
        // $isAdmin = $this->isAdmin();
        // if (!$isAdmin) {
        //     return redirect()->route('dashboard');
        // }

        try {
            // Find mahasiswa
            $mahasiswa = User::where('nim', $nim)->firstOrFail();

            // Delete avatar if exists
            if ($mahasiswa->avatar && Storage::disk('public')->exists($mahasiswa->avatar)) {
                Storage::disk('public')->delete($mahasiswa->avatar);
            }

            // Delete mahasiswa
            $mahasiswa->delete();
            return redirect()->back()->with('alert', ['type' => 'success', 'title' => 'Data mahasiswa berhasil dihapus.']);
        } catch (\Exception $e) {
            return redirect()->back()->with('alert', ['type' => 'error', 'title' => 'Terjadi kesalahan saat menghapus data mahasiswa: ' . $e->getMessage()]);
        }
    }
}
