<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) {
            User::updateOrCreate(
                ['email' => (string) env('ADMIN_EMAIL')],
                [
                    'name' => env('ADMIN_NAME', 'Admin'),
                    'password' => (string) env('ADMIN_PASSWORD'),
                ]
            );
        }

        if (! app()->environment('production')) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

            Visitor::factory()->count(15)->create();
        }
    }
}
