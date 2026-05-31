<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('drug_interactions', function (Blueprint $table) {
            $table->id();
            $table->string('ingredient_a'); // المادة الفعالة الأولى
            $table->string('ingredient_b'); // المادة الفعالة الثانية
            $table->enum('severity', ['mild','moderate','severe'])->default('moderate');
            $table->text('description_ar');
            $table->text('description_en');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('drug_interactions'); }
};
