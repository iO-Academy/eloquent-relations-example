<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toInsert = [
            [
                'name' => 'Fire warden',
                'description' => 'Complete fire warden training'
            ],
            [
                'name' => 'First aider',
                'description' => 'Basic first aid course'
            ],
            [
                'name' => 'Mental health first aider',
                'description' => 'Mental health care training'
            ]
        ];

        foreach ($toInsert as $cert) {
            DB::table('certifications')->insert($cert);
        }
    }
}
