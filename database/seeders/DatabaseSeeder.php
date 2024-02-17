<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(100)->create();
        \App\Models\Company::factory(150)->create();

        $users = \App\Models\User::all();
        $companies = \App\Models\Company::all();


        for ($i = 0; $i < 2000; $i++) {
            $user = $users->random();
            $company = $companies->random();
            \App\Models\Comment::factory()->create([
                'user_id' => $user->id,
                'company_id' => $company->id
            ]);
        }

    }
}
