<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('delivery_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->decimal('delivery_fee', 8, 2)->default(25);
            $table->decimal('free_delivery_threshold', 8, 2)->default(200);
            $table->integer('estimated_days')->default(1);
            $table->boolean('is_active')->default(true);
            $table->json('cities')->nullable(); // list of city names
            $table->timestamps();
        });

        // Seed default zones
        \DB::table('delivery_zones')->insert([
            ['name_ar'=>'القاهرة الكبرى','name_en'=>'Greater Cairo','delivery_fee'=>15,'free_delivery_threshold'=>150,'estimated_days'=>1,'cities'=>json_encode(['القاهرة','الجيزة','القليوبية']),'created_at'=>now(),'updated_at'=>now()],
            ['name_ar'=>'الإسكندرية','name_en'=>'Alexandria','delivery_fee'=>20,'free_delivery_threshold'=>200,'estimated_days'=>1,'cities'=>json_encode(['الإسكندرية']),'created_at'=>now(),'updated_at'=>now()],
            ['name_ar'=>'دلتا النيل','name_en'=>'Nile Delta','delivery_fee'=>25,'free_delivery_threshold'=>250,'estimated_days'=>2,'cities'=>json_encode(['المنصورة','الزقازيق','طنطا','دمياط','كفر الشيخ']),'created_at'=>now(),'updated_at'=>now()],
            ['name_ar'=>'صعيد مصر','name_en'=>'Upper Egypt','delivery_fee'=>35,'free_delivery_threshold'=>300,'estimated_days'=>3,'cities'=>json_encode(['أسيوط','سوهاج','قنا','الأقصر','أسوان','المنيا']),'created_at'=>now(),'updated_at'=>now()],
            ['name_ar'=>'باقي المحافظات','name_en'=>'Other Governorates','delivery_fee'=>30,'free_delivery_threshold'=>300,'estimated_days'=>2,'cities'=>json_encode([]),'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
    public function down(): void { Schema::dropIfExists('delivery_zones'); }
};
