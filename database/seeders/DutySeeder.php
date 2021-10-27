<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Duty;
use App\Models\Point;


class DutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $duties = ['Kuchnia', 'Kibel', 'Korytarz', 'Łazienka', 'Śmieci'];

        foreach ($duties as $d) {
            Duty::create([
                'name' => $d,
            ]);
        }
    }
}
