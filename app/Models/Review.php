<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';
    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'comment',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
