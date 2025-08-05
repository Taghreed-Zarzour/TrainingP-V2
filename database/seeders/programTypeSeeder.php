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
            ['name' => 'برنامج تدريبي', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'ورشة عمل', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'دورة قصيرة', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'محاضرة', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'ندوة', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'برنامج تأهيلي', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'برنامج استشاري', 'created_at' => $now, 'updated_at' => $now],
        ];
        
        foreach ($programTypes as $type) {
            programType::create($type);
        }  
    }
}
