<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    protected $fillable = ['loan_id', 'user_id', 'status', 'notes', 'confirmed_at', 'confirmed_by'];

    protected $casts = ['confirmed_at' => 'datetime'];

    public function loan()         { return $this->belongsTo(Loan::class); }
    public function user()         { return $this->belongsTo(User::class); }
    public function confirmedBy()  { return $this->belongsTo(User::class, 'confirmed_by'); }

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isConfirmed(): bool { return $this->status === 'confirmed'; }
}
