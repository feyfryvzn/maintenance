<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_machine_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('asset_no', 15)->nullable();
            $table->integer('sub_no')->nullable();
            $table->string('plant', 5)->nullable();
            $table->string('descript_asset', 30)->nullable();
            $table->string('image', 5)->nullable();
            $table->string('invent_number', 25)->nullable();
            $table->string('machine_number', 20)->nullable();
            $table->string('machine_name', 25)->nullable();
            $table->string('machine_brand', 20)->nullable();
            $table->string('machine_type', 20)->nullable();
            $table->string('machine_spec', 20)->nullable();
            $table->string('machine_power', 20)->nullable();
            $table->string('machine_made', 20)->nullable();
            $table->enum('machine_status', ['0', '1'])->default('1');
            $table->string('machine_info', 30)->nullable();
            $table->string('machine_loc', 10)->nullable();
            $table->string('mfg_number', 30)->nullable();
            $table->string('install_date', 10)->nullable();
            $table->string('production_date', 10)->nullable();
            $table->enum('status', ['ACTIVE', 'NOT ACTIVE'])->default('ACTIVE');
            $table->string('created_by', 15)->nullable();
            $table->dateTime('created_date')->nullable();
            $table->string('updated_by', 15)->nullable();
            $table->dateTime('updated_date')->nullable();
            $table->string('voided_by', 15)->nullable();
            $table->dateTime('voided_date')->nullable();
            $table->text('note')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_machine_tbl');
    }
};
