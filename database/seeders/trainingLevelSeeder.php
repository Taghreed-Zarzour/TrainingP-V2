<?php

namespace Database\Seeders;

use App\Models\trainingLevel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class trainingLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $levels = [
            ['name' => 'مبتدئ', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'متوسط', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'متقدم', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'محترف', 'created_at' => $now, 'updated_at' => $now],
        ];

        trainingLevel::insert($levels);

    }
}
