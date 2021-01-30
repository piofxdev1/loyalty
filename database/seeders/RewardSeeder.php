<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rewards')->insert([
            'customer_id' => 1,
            'phone' => '9550184196',
        ]);

        DB::table('rewards')->insert([
            'customer_id' => 2,
            'phone' => '8688079590',
        ]);

        DB::table('rewards')->insert([
            'customer_id' => 3,
            'phone' => '8247354466',
        ]);
    }
}
