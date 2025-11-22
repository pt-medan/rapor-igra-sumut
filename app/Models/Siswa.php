<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $sekolah_id
 * @property int $kelompok_kelas_id
 * @property string $nama_lengkap
 * @property string|null $nisn
 * @property string|null $tempat_lahir
 * @property \DateTime|null $tanggal_lahir
 * @property string|null $jenis_kelamin
 * @property string|null $alamat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'sekolah_id',
        'kelompok_kelas_id',
        'nama_lengkap',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Get the school this student belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Sekolah>
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Get the class this student belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<KelompokKelas>
     */
    public function kelompokKelas()
    {
        return $this->belongsTo(KelompokKelas::class);
    }

    /**
     * Get all assessments for this student.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Penilaian>
     */
    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    /**
     * Get the full text for jenis kelamin.
     *
     * @param  string  $value
     * @return string
     */
    public function getJenisKelaminAttribute($value)
    {
        if ($value === 'L') {
            return 'Laki-laki';
        }

        if ($value === 'P') {
            return 'Perempuan';
        }

        return $value;
    }

    /**
     * Set the jenis kelamin from full text to a storable value.
     *
     * @param  string  $value
     * @return void
     */
    public function setJenisKelaminAttribute($value)
    {
        if (strtolower($value) === 'laki-laki') {
            $this->attributes['jenis_kelamin'] = 'L';
        } elseif (strtolower($value) === 'perempuan') {
            $this->attributes['jenis_kelamin'] = 'P';
        } else {
            $this->attributes['jenis_kelamin'] = $value;
        }
    }
}
