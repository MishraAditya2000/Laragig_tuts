<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(5)->create();

        $user=User::factory()->create(
            [
                'name'=>'Jhon Doe',
                'email'=>'jhon@gmail.com'
            ]
        );
        Listing::factory(3)->create([
            'user_id'=>$user->id
        ]);
    }
}
