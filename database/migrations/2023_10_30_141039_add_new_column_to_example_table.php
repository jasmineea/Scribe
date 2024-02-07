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
        Schema::create('master_design_files', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable()->default(0);
            $table->string('campaign_name')->nullable();
            $table->string('front_design')->nullable();
            $table->string('back_design')->nullable();
            $table->string('main_design')->nullable();
            $table->string('inner_design')->nullable();
            $table->timestamp('downloaded_at')->nullable();
            $table->integer('downloaded_times')->default(0);
            $table->integer('total_records')->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('status', ['0','1','2'])->default(0);
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('master_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_design_files');
    }
};
