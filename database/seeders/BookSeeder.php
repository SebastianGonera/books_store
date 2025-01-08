<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

/**
 *
 */
class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        Book::factory()
            ->count(10)
            ->create()
            ->each(function (Book $book) use ($categories) {
                $book->update(['category_id' => $categories->random()->id]);
            });
    }
}
