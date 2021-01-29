<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer')->insert([
            'name' => 'Kamal',
            'phone' => '9550184196',
            'email' => 'kamal@gmail.com',
        ]);

        DB::table('customer')->insert([
            'name' => 'Teja',
            'phone' => '8688079590',
            'email' => 'teja@gmail.com',
        ]);

        DB::table('customer')->insert([
            'name' => 'Sabiha',
            'phone' => '8247354466',
            'email' => 'sabiha@gmail.com',
        ]);
    }
}
