<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'mahasiswa';

    protected $primaryKey = 'nim';

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nim',
        'id_program_studi',
        'nama',
        'angkatan',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the program_studi that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program_studi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'id_program_studi', 'id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public static function getMahasiswaFromSheet(int $tahun)
    {
        // Get spreadsheet file
        $spreadsheetPath = database_path('data-mahasiswa/data-mahasiswa-' . $tahun . '.xlsx');
        if (!file_exists($spreadsheetPath)) {
            $spreadsheetPath = database_path('data-mahasiswa/data-mahasiswa-2025.xlsx'); // Ganti sesuai kebutuhan
        }
        $spreadsheet = IOFactory::load($spreadsheetPath);

        // Get list program studi and set up an array to hold mahasiswa data
        $programStudi = ProgramStudi::all();
        $mahasiswaData = [];

        // Loop through each worksheet
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            $data = $worksheet->toArray();
            foreach ($data as $index => $row) {
                // Skip header row
                if ($index === 0) {
                    continue;
                }

                // Get program studi ID
                $row[4] = str_replace('Sarjana ', '', $row[4]);
                $prodiId = $programStudi->firstWhere('nama', $row[4])?->id;

                // Get status aktif/nonaktif
                $status = explode(' ', strtolower($row[5]))[0] === 'aktif' ? 'aktif' : 'nonaktif';

                // Map row data to user attributes
                $mahasiswaData[] = [
                    'nim' => $row[1],
                    'nama' => $row[2],
                    'id_program_studi' => $prodiId,
                    'angkatan' => (int) $row[6],
                    'status' => $status,
                ];
            }
        }

        return $mahasiswaData;
    }
}
