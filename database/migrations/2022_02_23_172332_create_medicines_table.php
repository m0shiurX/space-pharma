<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_id')->constrained();
            $table->string('name')->unique();
            $table->text('generic_name')->nullable();
            $table->text('strength')->nullable();
            $table->string('category');
            $table->string('unit');
            $table->decimal('purchase_price')->default(0.00);
            $table->decimal('selling_price')->default(0.00);
            $table->decimal('discount')->default(0.00);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicines');
    }
};
