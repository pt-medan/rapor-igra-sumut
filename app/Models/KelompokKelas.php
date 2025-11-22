<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sekolah_id
 * @property int $guru_id
 * @property string $nama_kelompok
 * @property string $tahun_ajaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class KelompokKelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'sekolah_id',
        'guru_id',
        'nama_kelompok',
        'tahun_ajaran',
    ];

    /**
     * Get the school this class belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Sekolah>
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Get the teacher (wali kelas) assigned to this class.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Guru>
     */
    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }

    /**
     * Get all students in this class.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Siswa>
     */
    public function siswas()
    {
        return $this->hasMany(Siswa::class);
    }
}
