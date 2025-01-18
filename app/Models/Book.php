<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'description',
        'price',
        'stock',
        'image_url',
        'category_id',
    ];

    public function makeDTO(): Book{
        $categoryId = $this['category_id'];
        $categoryName = Category::where('id', $categoryId)->value('name');
        $this['category'] = $categoryName;
        unset($this['created_at']);
        unset($this['updated_at']);
        unset($this['category_id']);
        return $this;
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
