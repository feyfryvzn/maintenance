<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_machine_image_tbl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_machine');
            $table->longText('file_image')->nullable();
            $table->text('file_name')->nullable();
            $table->string('created_by', 15)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->enum('status', ['ACTIVE', 'NOT ACTIVE'])->default('ACTIVE');

            $table->foreign('id_machine')
                  ->references('id')
                  ->on('master_machine_tbl')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_machine_image_tbl');
    }
};
