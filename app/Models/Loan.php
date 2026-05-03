<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Loan extends Model
{
    protected $fillable = [
        'loan_code', 'member_id', 'book_id', 'user_id',
        'loan_date', 'due_date', 'return_date', 'status',
        'fine_days', 'fine_amount', 'fine_paid', 'notes',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'fine_paid' => 'boolean',
    ];

    const FINE_PER_DAY = 1000; // Rp 1.000 per hari

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function returnRequest()
    {
        return $this->hasOne(ReturnRequest::class);
    }

    public function calculateFine(): array
    {
        $returnDate = $this->return_date ?? Carbon::today();
        $overdueDays = 0;
        if ($returnDate->gt($this->due_date)) {
            $overdueDays = (int) $this->due_date->diffInDays($returnDate);
        }
        return [
            'days'   => $overdueDays,
            'amount' => $overdueDays * self::FINE_PER_DAY,
        ];
    }

    public function isOverdue(): bool
    {
        if ($this->status === 'returned') return false;
        return Carbon::today()->gt($this->due_date);
    }

    public function isPendingApproval(): bool
    {
        return $this->status === 'pending_approval';
    }

    public function isActive(): bool
    {
        return in_array($this->status, ['borrowed', 'overdue']);
    }

    public static function generateCode(): string
    {
        $last = static::latest()->first();
        $num = $last ? (int) substr($last->loan_code, 4) + 1 : 1;
        return 'PJM-' . str_pad($num, 5, '0', STR_PAD_LEFT);
    }
}
