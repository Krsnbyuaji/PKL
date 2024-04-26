<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pak Koordinator',
            'email' => 'koordinator@gmail.com',
            'password' => Hash::make('koordinator'),
            'role' => 'Koordinator',
        ]);

        DB::table('users')->insert([
            'name' => 'Mas Design',
            'email' => 'designer@gmail.com',
            'password' => Hash::make('designer'),
            'role' => 'Designer',
        ]);

        DB::table('users')->insert([
            'name' => 'Pak QC',
            'email' => 'qc@gmail.com',
            'password' => Hash::make('qc'),
            'role' => 'QC',
        ]);
    }
}
