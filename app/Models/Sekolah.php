<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $npsn
 * @property string $nama_sekolah
 * @property string|null $alamat
 * @property string|null $provinsi
 * @property string|null $kabupaten
 * @property string|null $kepala_sekolah
 * @property string|null $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Sekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'npsn',
        'nama_sekolah',
        'alamat',
        'provinsi',
        'kabupaten',
        'kepala_sekolah',
        'status',
    ];

    /**
     * Get all users associated with this school.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<User>
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get all teachers at this school.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Guru>
     */
    public function gurus()
    {
        return $this->hasMany(Guru::class);
    }

    /**
     * Get all classes at this school.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<KelompokKelas>
     */
    public function kelompokKelas()
    {
        return $this->hasMany(KelompokKelas::class);
    }

    /**
     * Get all students at this school.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Siswa>
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
