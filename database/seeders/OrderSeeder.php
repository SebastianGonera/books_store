<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        Order::factory()
            ->count(30)
            ->create()
            ->each(function (Order $order) use ($users) {
               $order->update(['user_id' => $users->random()->id]);
            });
    }
}
