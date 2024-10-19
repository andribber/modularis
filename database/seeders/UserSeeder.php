<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'Local User',
                'email' => 'a@a.com',
            ],
            [
                'name' => 'Another Local User',
                'email' => 'b@a.com',
            ],
        ]);
    }
}
