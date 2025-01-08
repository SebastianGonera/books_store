<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        Review::factory()
            ->count($users->count())
            ->create()
            ->each(function (Review $review) use ($users, $books) {
                $review->update([
                    'user_id' => $users->random()->id,
                    'book_id' => $books->random()->id
                ]);
            });
    }
}
