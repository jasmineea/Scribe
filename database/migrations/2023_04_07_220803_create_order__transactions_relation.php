<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('transaction_id')->unsigned()->default(0);
            //$table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->bigInteger('order_id')->unsigned()->default(0);
            //$table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order__transactions_relation');
    }
};
