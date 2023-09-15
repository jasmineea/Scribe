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
        Schema::create('meta_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable()->default(0);
            $table->integer('listing_id')->nullable()->default(0);
            $table->string('meta_id')->nullable();
            $table->string('type')->nullable();
            $table->string('meta_key')->nullable();
            $table->string('meta_value')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('contacts', function ($table) {
            $table->longText('message')->nullable()->after('zip');
        });
        Schema::table('listings', function ($table) {
            $table->longText('message')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_datas');
    }
};
