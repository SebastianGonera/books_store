<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $books = Book::all();

        OrderItem::factory()
            ->count(60)
            ->create()
            ->each(function (OrderItem $orderItem) use ($books, $orders) {
               $orderItem->update([
                   'book_id' => $books->random()->id,
                   'order_id' => $orders->random()->id
               ]);
            });
    }
}
