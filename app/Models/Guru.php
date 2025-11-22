<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $sekolah_id
 * @property string $nama_guru
 * @property string $nip
 * @property string $telepon
 * @property string $alamat
 * @property int $student_quota Maximum number of students this guru can add
 * @property int $student_count Current number of students added by this guru
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sekolah_id',
        'nama_guru',
        'nip',
        'telepon',
        'alamat',
        'student_quota',
        'student_count',
    ];

    /**
     * Get the user associated with this guru.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<User>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the school this guru belongs to.
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Get the class this guru is assigned to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<KelompokKelas>
     */
    public function kelompokKelas()
    {
        return $this->hasOne(KelompokKelas::class);
    }
}
