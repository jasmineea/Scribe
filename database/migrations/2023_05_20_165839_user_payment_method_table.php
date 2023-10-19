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
        Schema::create('user_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('pm_user_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('status', ['0','1'])->default(0);
            $table->enum('is_default', ['0','1'])->default(0);
            $table->string('card_type')->nullable();
            $table->string('last_4_digits')->nullable();
            $table->string('expiry_date')->nullable();
            $table->enum('payment_method_type', ['square', 'stripe'])->default('square');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('listing_id')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payment_methods');
    }
};
