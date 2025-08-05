<?php

namespace Database\Seeders;

use App\Models\TrainingClassification;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $classifications = [
            ['name' => 'تصنيف عام', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'التنمية البشرية', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'التدريب التقني', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'التدريب الصحي', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'الإدارة والقيادة', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'المالية والمحاسبة', 'created_at' => $now, 'updated_at' => $now],
        ];

        TrainingClassification::insert($classifications);
    }
}
