<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_expiry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('batch_number');
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date');
            $table->integer('quantity');
            $table->integer('remaining_quantity');
            $table->enum('status', ['active','near_expiry','expired','recalled'])->default('active');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('product_expiry'); }
};
