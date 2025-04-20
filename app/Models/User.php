<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nis',
        'name',
        'email',
        'password',
        'role',
        'gender',
        'date_of_birth',
        'address',
        'phone',
        'father_name',
        'father_phone',
        'mother_name',
        'mother_phone',
        'division_id',
        'batch_id',
        'status',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'date_of_birth'     => 'date',
    ];

    /**
     * Get the division that the santri belongs to.
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the batch that the santri belongs to.
     */
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    /**
     * Check if user is a santri.
     */
    public function isSantri()
    {
        return $this->role === 'santri';
    }

    /**
     * Check if user is a mentor.
     */
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    /**
     * Check if user is an admin.
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
