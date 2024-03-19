<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toInsert = ['full time', 'Part time', 'Annual hours', 'Contractor'];

        foreach ($toInsert as $contract) {
            DB::table('contracts')->insert([
                'name' => $contract
            ]);
        }
    }
}
