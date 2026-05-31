<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar');
            $table->string('name_en');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->string('active_ingredient')->nullable(); // المادة الفعالة
            $table->string('manufacturer')->nullable();
            $table->string('barcode')->nullable()->unique();
            $table->boolean('requires_prescription')->default(false);
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->integer('min_stock_alert')->default(10);
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->string('dosage_form')->nullable(); // شكل الجرعة: أقراص، شراب، حقن
            $table->string('strength')->nullable();    // التركيز: 500mg
            $table->string('package_size')->nullable();// حجم العبوة: 20 قرص
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('products'); }
};
