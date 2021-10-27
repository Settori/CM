<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Option;


class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::create([
            'name' => 'week_user',
            'value' => '1'
        ]);

    }
}
