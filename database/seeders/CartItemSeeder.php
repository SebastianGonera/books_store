<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        CartItem::factory()
            ->count(50)
            ->create()
            ->each(function ($cartItem) use ($users, $books) {
                $cartItem->update([
                    'user_id' => $users->random()->id,
                    'book_id' => $books->random()->id,
                ]);
            });
    }
}
