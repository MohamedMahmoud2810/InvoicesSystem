<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_name');
            $table->unsignedBigInteger('term_line_id');
            $table->string('document')->default('Advanced Payment');
            $table->integer('due_days')->default(0);
            $table->string('expense_code')->default('total value');
            $table->string('currency')->default('EGP');
            $table->string('amount_type')->default('percent');
            $table->integer('percentage_to_pay')->default(0);
            $table->enum('payment_method', ['cash', 'cheque'])->default('cash');
            $table->text('note')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
