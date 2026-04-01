<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_machine_tbl_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_machine');
            $table->string('status_change', 10)->nullable();
            $table->dateTime('date')->nullable();
            $table->text('note')->nullable();
            $table->string('user', 15)->nullable();

            $table->foreign('id_machine')
                  ->references('id')
                  ->on('master_machine_tbl')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_machine_tbl_log');
    }
};
