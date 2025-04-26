<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('sales_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('medicine_id')->constrained()->restrictOnDelete();
            $table->string('batch_id');
            $table->integer('quantity')->default(0);
            $table->decimal('selling_price')->default(0.00);
            $table->decimal('discount')->default(0.00);
            $table->decimal('total_price')->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sales_items');
    }
};
