<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author', 'isbn', 'category_id', 'publisher',
        'published_year', 'stock', 'total_stock', 'description',
        'cover', 'rack_location',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function ratings()
    {
        return $this->hasMany(BookRating::class);
    }

    public function averageRating(): float
    {
        return round($this->ratings()->avg('rating') ?? 0, 1);
    }

    public function ratingCount(): int
    {
        return $this->ratings()->count();
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    public function coverUrl(): ?string
    {
        if ($this->cover && trim($this->cover) !== '') {
            return asset('storage/' . $this->cover);
        }
        return null;
    }
}
