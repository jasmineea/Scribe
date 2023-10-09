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
        Schema::create('master_file_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('master_file_id')->nullable()->default(0);
            $table->text('message')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('master_files', function (Blueprint $table) {
            $table->string('post_uploaded_recipient_file')->nullable();
            $table->timestamp('post_downloaded_at')->nullable();
            $table->integer('post_downloaded_times')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_file_messages');
    }
};
