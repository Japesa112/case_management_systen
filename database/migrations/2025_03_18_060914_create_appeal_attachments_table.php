<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() {
        Schema::create('appeal_attachments', function (Blueprint $table) {
            $table->id('attachment_id'); // Primary key
            $table->unsignedBigInteger('appeal_id'); // Foreign key
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->string('file_type', 50)->nullable();
            $table->dateTime('upload_date')->default(now());
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('appeal_id')->references('appeal_id')->on('appeals')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('appeal_attachments');
    }
};
