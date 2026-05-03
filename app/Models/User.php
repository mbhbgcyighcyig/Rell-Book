<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'address', 'avatar'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isPetugas(): bool  { return $this->role === 'petugas'; }
    public function isPeminjam(): bool { return $this->role === 'peminjam'; }
    public function isStaff(): bool    { return in_array($this->role, ['admin', 'petugas']); }

    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Fallback: UI Avatars dengan inisial nama
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=4f46e5&color=fff&bold=true&size=128';
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'user_id');
    }

    // Peminjam punya member record
    public function member()
    {
        return $this->hasOne(Member::class, 'email', 'email');
    }
}
