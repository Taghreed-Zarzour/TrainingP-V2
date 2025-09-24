<?php

namespace Database\Seeders;

use App\Models\programType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class programTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
{
    $now = Carbon::now();
    $programTypes = [
        ['name' => 'تدريب مكثف', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'دورة تدريبية قصيرة', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'برنامج تدريبي طويل المدى', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'برنامج تدريبي فردي', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'برنامج تدريبي جماعي', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'معسكر تدريبي', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'ورشة عمل', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'دبلوم', 'created_at' => $now, 'updated_at' => $now],
        ['name' => 'محاضرة/ويبنار', 'created_at' => $now, 'updated_at' => $now],
    ];
    
    foreach ($programTypes as $type) {
        programType::create($type);
    }  
}

}
