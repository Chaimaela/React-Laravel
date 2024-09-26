<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\password;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'chama',
            'email' => 'chama@email.com',
            'password'=> bcrypt('1234/34B'),
            'email_verified_at'=> time()
        ]);

        Project::factory()
        ->count(30)
        ->hasTasks(30)
        ->create();
    }
}
