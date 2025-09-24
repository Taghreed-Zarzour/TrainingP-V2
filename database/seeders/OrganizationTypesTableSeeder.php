<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organization_types')->insert([
            ['name' => 'غير ربحية'],
            ['name' => 'هيئة حكومية'],
            ['name' => 'شركة'],
            ['name' => 'شركة ناشئة'],
            ['name' => 'مؤسسة تعليمية'],
        ]);
    }
}