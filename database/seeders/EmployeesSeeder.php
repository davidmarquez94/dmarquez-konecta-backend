<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            [
                'name' => 'David Marquez',
                'email' => 'davidmarquez.dev@gmail.com'
            ],
            [
                'name' => 'Felipe Gonzalez',
                'email' => 'felipegonzalez@email.com'
            ],
        ]);
    }
}
