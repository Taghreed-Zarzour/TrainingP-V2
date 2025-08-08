<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // تعطيل قيود المفتاح الأجنبي مؤقتاً (مهم لتجنب مشاكل المسح المرتبط بالعلاقات)
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    // مسح بيانات الجداول المرتبطة بالسييدرز
    DB::table('countries')->truncate();
    DB::table('provided_services')->truncate();
    DB::table('work_sectors')->truncate();
    DB::table('work_fields')->truncate();
    DB::table('education_levels')->truncate();
    DB::table('annual_budgets')->truncate();
    DB::table('employee_numbers')->truncate();
    DB::table('languages')->truncate();
    DB::table('experience_areas')->truncate();
    DB::table('user_types')->truncate();
    DB::table('organization_types')->truncate();
    DB::table('organization_sectors')->truncate();
    DB::table('program_types')->truncate();
    DB::table('training_classifications')->truncate();
    DB::table('training_levels')->truncate();

    // إعادة تفعيل قيود المفتاح الأجنبي
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    // تشغيل السييدرز
    $this->call([
      CountrySeeder::class,
      ProvidedServiceSeeder::class,
      SectorSeeder::class,
      FieldOfWorkSeeder::class,
      EducationLevelSeeder::class,
      AnnualBudgetSeeder::class,
      EmployeeNumberSeeder::class,
      LanguagesTableSeeder::class,
      ExperienceAreaSeeder::class,
      UserTypeSeeder::class,
      OrganizationTypesTableSeeder::class,
      OrganizationSectorsTableSeeder::class,
      ProgramTypeSeeder::class,
      TrainingClassificationSeeder::class,
      TrainingLevelSeeder::class,
    ]);
  }
}
