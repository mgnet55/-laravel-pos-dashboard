<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
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

        $this->command->comment('###### Login credentials ######');
        $this->command->table(['Email', 'Password'], [['email' => 'super-admin@app.com', 'password' => 'password']]);

    }
}
