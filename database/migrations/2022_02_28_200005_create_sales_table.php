<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->restrictOnDelete();
            $table->string('invoice_no')->unique();
            $table->date('sales_date')->useCurrent();
            $table->decimal('sub_total')->default(0.00);
            $table->decimal('invoice_discount')->default(0.00);
            $table->decimal('vat')->default(0.00);
            $table->decimal('grand_total')->default(0.00);
            $table->decimal('paid_amount')->default(0.00);
            $table->decimal('exchange_amount')->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
