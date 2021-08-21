<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Hash;

class UserSeeder extends Seeder
{
    public const COUNT = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->truncate();
        collect([
            'admin',
            'user01',
            'user02',
        ])->each(
            fn ($userName) => User::query()->create([
                'name'              => $userName,
                'email'             => "{$userName}@example.net",
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
            ])
        );
    }
}
