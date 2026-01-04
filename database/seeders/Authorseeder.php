<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class Authorseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            'name' => 'imadmin',
            'email' => 'imadmin@example.com',
            'password' => Hash::make('imadmin123'),
            'image' => null,
            'status' => 1,
            'token' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
