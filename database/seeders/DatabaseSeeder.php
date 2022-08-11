<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        /*         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
         ]);


         \App\Models\User::factory(10)->create();
        \App\Models\User::factory(1)->create(['email' => 'admin@example.com']);
        */
        $this->call(LaratrustSeeder::class);

        \App\Models\Category::factory(10)->create()
            ->each(function ($category) {
                \App\Models\Product::factory(5)->create([
                    'category_id' => $category->id
                ]);
            });
        $clients = \App\Models\Client::factory(10)->create();
        $clients->take(3)
            ->each(function ($client) {
                Order::factory(3)->create(['client_id' => $client->id])
                    ->each(function ($order) {
                        $order->products()->attach([
                            1 => ['quantity' => rand(1, 10), 'unit_price' => rand(1, 150)],
                            2 => ['quantity' => rand(1, 10), 'unit_price' => rand(1, 150)],
                            3 => ['quantity' => rand(1, 10), 'unit_price' => rand(1, 150)]
                        ]);
                    });
            });

        $this->command->comment('###### Login credentials ######');
        $this->command->table(['Email', 'Password'], [['email' => 'super-admin@app.com', 'password' => 'password']]);

    }
}
