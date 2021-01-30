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
        DB::table('customers')->insert([
            'name' => 'Kamal',
            'phone' => '9550184196',
            'email' => 'kamal@gmail.com',
        ]);

        DB::table('customers')->insert([
            'name' => 'Teja',
            'phone' => '8688079590',
            'email' => 'teja@gmail.com',
        ]);

        DB::table('customers')->insert([
            'name' => 'Sabiha',
            'phone' => '8247354466',
            'email' => 'sabiha@gmail.com',
        ]);
    }
}
