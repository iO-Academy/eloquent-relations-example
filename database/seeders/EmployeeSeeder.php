<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toInsert = [
            [
                'name' => 'Kellie',
                'age' => 28,
                'start_date' => '2021/03/02',
                'contract_id' => 1,
            ],
            [
                'name' => 'Mark',
                'age' => 47,
                'start_date' => '2021/03/01',
                'contract_id' => 2,
            ],
            [
                'name' => 'Kash',
                'age' => 33,
                'start_date' => '2021/02/06',
                'contract_id' => 1,
            ],
        ];

        foreach ($toInsert as $employee) {
            DB::table('employees')->insert($employee);
        }
    }
}
