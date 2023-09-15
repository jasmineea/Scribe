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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('order_amount', 8, 2)->default(0);
            $table->enum('status', ['payment-pending','pending', 'processing','printing','shipped','delivered','draft','on-going','paused','pending-pickup','picked']);
            $table->string('uploaded_recipient_file')->nullable();
            $table->string('campaign_name')->nullable();
            $table->enum('campaign_type', ['one-time','on-going'])->default('one-time');
            $table->longText('campaign_message')->nullable();
            $table->integer('schedule_status')->default(0);
            $table->integer('auto_charge')->default(0);
            $table->integer('threshold')->default(0);
            $table->integer('threshold_order_created')->default(0);
            $table->integer('repeat_number')->default(1);
            $table->dateTime('schedule_date')->nullable();
            $table->string('final_printing_file')->nullable();
            $table->json('order_json')->nullable();
            $table->bigInteger('payment_method_id')->unsigned()->default(0);
            $table->bigInteger('parent_order_id')->unsigned()->default(0);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
