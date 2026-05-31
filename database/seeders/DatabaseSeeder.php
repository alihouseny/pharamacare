<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        // ===== USERS =====
        User::create([
            'name'     => 'مدير النظام',
            'email'    => 'admin@pharmacy.com',
            'phone'    => '01000000000',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
        User::create([
            'name'     => 'د. أحمد الصيدلاني',
            'email'    => 'pharmacist@pharmacy.com',
            'phone'    => '01011111111',
            'password' => Hash::make('password'),
            'role'     => 'pharmacist',
        ]);
        User::create([
            'name'     => 'محمد علي',
            'email'    => 'customer@pharmacy.com',
            'phone'    => '01022222222',
            'password' => Hash::make('password'),
            'role'     => 'customer',
        ]);

        // ===== CATEGORIES =====
        $cats = [
            ['name_ar'=>'أدوية القلب والضغط',   'name_en'=>'Heart & Blood Pressure', 'slug'=>'heart',       'icon'=>'❤️'],
            ['name_ar'=>'مضادات حيوية',           'name_en'=>'Antibiotics',            'slug'=>'antibiotics', 'icon'=>'💊'],
            ['name_ar'=>'أدوية السكر',             'name_en'=>'Diabetes',               'slug'=>'diabetes',    'icon'=>'🩸'],
            ['name_ar'=>'مسكنات الألم',            'name_en'=>'Pain Relief',            'slug'=>'pain-relief', 'icon'=>'🩹'],
            ['name_ar'=>'فيتامينات ومكملات',       'name_en'=>'Vitamins & Supplements', 'slug'=>'vitamins',    'icon'=>'🌿'],
            ['name_ar'=>'العناية بالبشرة',         'name_en'=>'Skin Care',              'slug'=>'skincare',    'icon'=>'✨'],
            ['name_ar'=>'صحة الأطفال',             'name_en'=>'Baby & Child Health',    'slug'=>'baby',        'icon'=>'👶'],
            ['name_ar'=>'أدوية التنفس والحساسية', 'name_en'=>'Respiratory & Allergy',  'slug'=>'respiratory', 'icon'=>'🫁'],
        ];
        foreach ($cats as $c) Category::create(array_merge($c, ['is_active'=>true,'sort_order'=>0]));

        // ===== PRODUCTS =====
        $products = [
            // Heart & BP
            ['name_ar'=>'أمبريل 5 ملجم أقراص','name_en'=>'Enalapril 5mg Tablets',    'slug'=>'enalapril-5mg',
             'category_id'=>1,'active_ingredient'=>'Enalapril Maleate','manufacturer'=>'EIPICO',
             'requires_prescription'=>true, 'price'=>45.00,'stock'=>120,
             'dosage_form'=>'أقراص','strength'=>'5mg','package_size'=>'20 قرص'],
            ['name_ar'=>'أتينولول 50 ملجم',   'name_en'=>'Atenolol 50mg',             'slug'=>'atenolol-50mg',
             'category_id'=>1,'active_ingredient'=>'Atenolol','manufacturer'=>'CID',
             'requires_prescription'=>true,'price'=>32.00,'stock'=>85,
             'dosage_form'=>'أقراص','strength'=>'50mg','package_size'=>'30 قرص'],

            // Antibiotics
            ['name_ar'=>'أموكسيسيلين 500 ملجم','name_en'=>'Amoxicillin 500mg',       'slug'=>'amoxicillin-500mg',
             'category_id'=>2,'active_ingredient'=>'Amoxicillin','manufacturer'=>'Pfizer',
             'requires_prescription'=>true,'price'=>28.50,'stock'=>200,
             'dosage_form'=>'كبسولات','strength'=>'500mg','package_size'=>'21 كبسولة'],
            ['name_ar'=>'أزيثرومايسين 250 ملجم','name_en'=>'Azithromycin 250mg',     'slug'=>'azithromycin-250mg',
             'category_id'=>2,'active_ingredient'=>'Azithromycin','manufacturer'=>'Pharco',
             'requires_prescription'=>true,'price'=>52.00,'stock'=>75,
             'dosage_form'=>'أقراص','strength'=>'250mg','package_size'=>'6 أقراص'],

            // Diabetes
            ['name_ar'=>'ميتفورمين 500 ملجم',  'name_en'=>'Metformin 500mg',          'slug'=>'metformin-500mg',
             'category_id'=>3,'active_ingredient'=>'Metformin HCl','manufacturer'=>'EIPICO',
             'requires_prescription'=>true,'price'=>18.00,'stock'=>300,'is_featured'=>true,
             'dosage_form'=>'أقراص','strength'=>'500mg','package_size'=>'30 قرص'],
            ['name_ar'=>'جلوكوفاج 1000 ملجم',  'name_en'=>'Glucophage 1000mg',        'slug'=>'glucophage-1000mg',
             'category_id'=>3,'active_ingredient'=>'Metformin HCl','manufacturer'=>'Merck',
             'requires_prescription'=>true,'price'=>35.00,'sale_price'=>28.00,'stock'=>150,'is_featured'=>true,
             'dosage_form'=>'أقراص','strength'=>'1000mg','package_size'=>'30 قرص'],

            // Pain Relief
            ['name_ar'=>'بروفين 400 ملجم',      'name_en'=>'Brufen 400mg',             'slug'=>'brufen-400mg',
             'category_id'=>4,'active_ingredient'=>'Ibuprofen','manufacturer'=>'Abbott',
             'requires_prescription'=>false,'price'=>22.00,'stock'=>400,
             'dosage_form'=>'أقراص','strength'=>'400mg','package_size'=>'20 قرص'],
            ['name_ar'=>'بنادول إكسترا',         'name_en'=>'Panadol Extra',            'slug'=>'panadol-extra',
             'category_id'=>4,'active_ingredient'=>'Paracetamol + Caffeine','manufacturer'=>'GSK',
             'requires_prescription'=>false,'price'=>15.00,'sale_price'=>12.00,'stock'=>500,'is_featured'=>true,
             'dosage_form'=>'أقراص','strength'=>'500mg/65mg','package_size'=>'24 قرص'],

            // Vitamins
            ['name_ar'=>'فيتامين سي 1000 ملجم', 'name_en'=>'Vitamin C 1000mg',         'slug'=>'vitamin-c-1000mg',
             'category_id'=>5,'active_ingredient'=>'Ascorbic Acid','manufacturer'=>'Pharco',
             'requires_prescription'=>false,'price'=>55.00,'stock'=>250,'is_featured'=>true,
             'dosage_form'=>'أقراص فوارة','strength'=>'1000mg','package_size'=>'20 قرص'],
            ['name_ar'=>'أوميغا 3 فيش أويل',    'name_en'=>'Omega-3 Fish Oil 1000mg',  'slug'=>'omega3-1000mg',
             'category_id'=>5,'active_ingredient'=>'Omega-3 Fatty Acids','manufacturer'=>'Jamieson',
             'requires_prescription'=>false,'price'=>89.00,'sale_price'=>75.00,'stock'=>100,'is_featured'=>true,
             'dosage_form'=>'كبسولات جيلاتينية','strength'=>'1000mg','package_size'=>'60 كبسولة'],

            // Skincare
            ['name_ar'=>'نيفيا كريم مرطب',      'name_en'=>'NIVEA Moisturising Cream', 'slug'=>'nivea-cream',
             'category_id'=>6,'active_ingredient'=>'','manufacturer'=>'NIVEA',
             'requires_prescription'=>false,'price'=>38.00,'stock'=>180,
             'dosage_form'=>'كريم','strength'=>'','package_size'=>'150ml'],

            // Baby
            ['name_ar'=>'بانادول بيبي شراب',     'name_en'=>'Panadol Baby Syrup',       'slug'=>'panadol-baby',
             'category_id'=>7,'active_ingredient'=>'Paracetamol','manufacturer'=>'GSK',
             'requires_prescription'=>false,'price'=>24.00,'stock'=>200,'is_featured'=>true,
             'dosage_form'=>'شراب','strength'=>'120mg/5ml','package_size'=>'100ml'],

            // Respiratory
            ['name_ar'=>'فنتولين بخاخ',          'name_en'=>'Ventolin Inhaler',         'slug'=>'ventolin-inhaler',
             'category_id'=>8,'active_ingredient'=>'Salbutamol','manufacturer'=>'GSK',
             'requires_prescription'=>true,'price'=>42.00,'stock'=>90,'is_featured'=>true,
             'dosage_form'=>'بخاخ','strength'=>'100mcg','package_size'=>'200 جرعة'],
        ];

        foreach ($products as $p) {
            Product::create(array_merge([
                'description_ar' => 'دواء أصلي معتمد من وزارة الصحة',
                'description_en' => 'Authentic medicine approved by the Ministry of Health',
                'is_active'      => true,
                'is_featured'    => $p['is_featured'] ?? false,
                'min_stock_alert'=> 15,
            ], $p));
        }

        $this->command->info('✅ Seeded: 3 users, '.count($cats).' categories, '.count($products).' products');
    }
}
