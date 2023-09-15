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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount', 8, 2)->default(0);
            $table->decimal('wallet_balance', 8, 2)->default(0);
            $table->decimal('currency_amount', 8, 2)->default(0);
            $table->tinyInteger('status')->default(1)->unsigned();
            $table->enum('type', ['Cr','Dr'])->default('Dr');
            $table->string('payment_method')->nullable();
            $table->string('online_transaction_id')->nullable()->default('-');
            $table->string('comment')->nullable();
            $table->json('transaction_json');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
