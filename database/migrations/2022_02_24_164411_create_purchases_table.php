<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufacturer_id')->constrained()->restrictOnDelete();
            $table->string('invoice_no')->nullable();
            $table->date('purchase_date')->useCurrent();
            $table->decimal('sub_total')->default(0.00);
            $table->decimal('vat')->default(0.00);
            $table->decimal('discount')->default(0.00);
            $table->decimal('grand_total')->default(0.00);
            $table->decimal('paid_amount')->default(0.00);
            $table->decimal('due_amount')->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
