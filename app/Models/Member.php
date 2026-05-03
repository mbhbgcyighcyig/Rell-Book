<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'member_code', 'name', 'email', 'phone', 'address',
        'gender', 'birth_date', 'id_card', 'status', 'membership_expiry',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'membership_expiry' => 'date',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->whereIn('status', ['borrowed', 'overdue', 'pending_approval']);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function hasOverdueLoans(): bool
    {
        return $this->loans()->where('status', 'overdue')->where('fine_paid', false)->exists();
    }
}
