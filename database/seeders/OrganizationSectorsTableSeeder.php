<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSectorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organization_sectors')->insert([
            ['name' => 'التكنولوجيا'],
            ['name' => 'الرعاية الصحية'],
            ['name' => 'المالية'],
            ['name' => 'التعليم'],
            ['name' => 'التجزئة'],
        ]);
    }
}