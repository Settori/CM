<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Week;



class WeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d', strtotime('2021-10-25'));
        $users = [3,4,1,2];
        $uid = 0;
        for ($x=0; $x<100; $x++) {

            Week::create([
                'user_id' => $users[$uid],
                'day' => $date
            ]);
            $date = date("Y-m-d",strtotime(date("Y-m-d", strtotime($date)) . " +1 week"));
            $uid += 1;
            if ($uid >= count($users)) $uid = 0;
        }

    }
}
