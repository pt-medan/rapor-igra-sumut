<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int|null $sekolah_id
 * @property int|null $kelompok_kelas_id
 * @property string $role
 * @property string $status
 * @property \DateTime|null $email_verified_at
 * @property \DateTime|null $validated_at
 * @property int|null $validated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Guru|null $guru
 * @property-read Sekolah|null $sekolah
 * @property-read KelompokKelas|null $kelompokKelas
 * @property-read User|null $validator
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     * 
     * Valid roles:
     * - 'guru': Teacher role who can manage their own class, students, and assessments
     * - 'admin_provinsi': Provincial admin who can validate users and manage system-wide settings
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'sekolah_id',
        'kelompok_kelas_id',
        'role',
        'status',
        'validated_at',
        'validated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
            'validated_at' => 'datetime',
        ];
    }

    /**
     * Get the school that the user belongs to.
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class);
    }

    /**
     * Get the guru profile associated with the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<Guru>
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * Get the user who validated this account.
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Get the users that this user has validated.
     */
    public function validatedUsers()
    {
        return $this->hasMany(User::class, 'validated_by');
    }

    /**
     * Get the kelompok kelas chosen by the user during registration.
     */
    public function kelompokKelas()
    {
        return $this->belongsTo(KelompokKelas::class);
    }
}
