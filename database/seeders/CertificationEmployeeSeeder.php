<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificationEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toInsert = [
            [
                'certification_id' => 1,
                'employee_id' => 1,
            ],
            [
                'certification_id' => 2,
                'employee_id' => 1,
            ], [
                'certification_id' => 2,
                'employee_id' => 2,
            ], [
                'certification_id' => 3,
                'employee_id' => 2,
            ], [
                'certification_id' => 1,
                'employee_id' => 4,
            ],
        ];

        foreach ($toInsert as $cert) {
            DB::table('certification_employee')->insert($cert);
        }
    }
}
