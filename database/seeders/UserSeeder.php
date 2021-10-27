<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Szymuś',
            'avatar' => true,
            'email' => 'szymon.walosik@webfalcon.pl',
            'password' => Hash::make('WebF@lcon36'),
        ]);

        User::create([
            'name' => 'Rafał',
            'email' => 'rafal@qwe.pl',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Vova',
            'email' => 'vova@qwe.pl',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'name' => 'Daniel',
            'email' => 'daniel@qwe.pl',
            'password' => Hash::make('123456'),
        ]);
    }
}
