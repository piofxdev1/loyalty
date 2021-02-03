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
            'credits' => 100,
        ]);

        DB::table('rewards')->insert([
            'customer_id' => 2,
            'phone' => '8688079590',
            'credits' => 100,
        ]);

        DB::table('rewards')->insert([
            'customer_id' => 3,
            'phone' => '8247354466',
            'credits' => 100,
        ]);

        DB::table('rewards')->insert([
            'customer_id' => 1,
            'phone' => '9550184196',
            'redeem' => 10,
        ]);

        DB::table('rewards')->insert([
            'customer_id' => 3,
            'phone' => '8247354466',
            'redeem' => 30,
        ]);
    }
}
