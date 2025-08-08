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

$now = now();
$classifications = [
    ['name' => 'اختبار البرمجيات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الابتكار', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الاختراق', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الأمن السيبراني وحماية البيانات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الإدارة المالية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الإعلانات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'البرمجة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التحول الرقمي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التخطيط والتنفيذ الاستراتيجي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التسويق التقليدي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التسويق الرقمي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التشفير وإدارة الوصول', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التصوير', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التفاوض', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التفكير الإبداعي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التفكير التصميمي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التفكير النقدي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التمويل الجماعي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'التيسير', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الحوسبة السحابية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الحوكمة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الذكاء العاطفي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'السيرة الذاتية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'العلاقات مع المانحين', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'العمل المستقل', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'القيادة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'المبيعات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'المحاسبة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'المراقبة والتقييم', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'المغالطات المنطقية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'المنهجية الرشيقة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الموارد البشرية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'الموشن جرافيك', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'أتمتة العمليات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'أدوات الذكاء الاصطناعي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'أمن الشبكات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة الأداء', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة البرامج', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة الجودة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة الفرق', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة المتاجر الإلكترونية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة المخدمات Servers', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة المشاريع', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة المنتجات الرقمية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة قواعد البيانات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'إدارة وسائل التواصل الاجتماعي', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'بناء الشراكات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'بناء العلاقات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تحسين حساب لينكد ان', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تحسين محركات البحث (SEO)', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تحليل البيانات', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تدريب المدربين', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تصميم العروض التقديمية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تطوير البرمجيات الخلفية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تطوير الواجهات وتجربة المستخدم', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تطوير الويب', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تطوير تطبيقات الموبايل', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تطوير واجهات الاستخدام', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'تعلم الآلة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'خدمة العملاء', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'دراسة الجدوى', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'ريادة الأعمال', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'كتابة التقارير', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'كتابة المحتوى', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'كتابة مقترحات المشاريع', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'مفاهيم العمل التنموي والإنساني', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'مقابلات العمل', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'منهجية لين', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'مهارات التواصل', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'مهارات القوة', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'مونتاج الفيديو', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'نماذج الأعمال التجارية', 'created_at' => $now, 'updated_at' => $now],
    ['name' => 'هندسة البيانات', 'created_at' => $now, 'updated_at' => $now],
];
        TrainingClassification::insert($classifications);
    }
}
