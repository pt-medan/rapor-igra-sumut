<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $siswa_id
 * @property string $tahun_ajaran
 * @property string $semester
 * @property string|null $agama_budi_pekerti
 * @property string|null $jati_diri
 * @property string|null $literasi_sains
 * @property int|null $sakit
 * @property int|null $izin
 * @property int|null $tanpa_keterangan
 * @property string|null $catatan_kesehatan
 * @property string|null $catatan_guru
 * @property array|null $ekstrakurikuler
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Penilaian extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran',
        'semester',
        'agama_budi_pekerti',
        'jati_diri',
        'literasi_sains',
        'sakit',
        'izin',
        'tanpa_keterangan',
        'catatan_kesehatan',
        'catatan_guru',
        'ekstrakurikuler',
    ];

    protected $casts = [
        'ekstrakurikuler' => 'array',
    ];

    /**
     * Get the student this assessment belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Siswa>
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    /**
     * Get the displayable text for the semester.
     *
     * @param  string  $value
     * @return string
     */
    public function getSemesterAttribute($value)
    {
        if ($value === '1') {
            return 'Ganjil';
        }

        if ($value === '2') {
            return 'Genap';
        }

        return $value;
    }

    /**
     * Set the semester from displayable text to a storable value.
     *
     * @param  string  $value
     * @return void
     */
    public function setSemesterAttribute($value)
    {
        if (strtolower($value) === 'ganjil') {
            $this->attributes['semester'] = '1';
        } elseif (strtolower($value) === 'genap') {
            $this->attributes['semester'] = '2';
        } else {
            $this->attributes['semester'] = $value;
        }
    }
}
