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
        Schema::disableForeignKeyConstraints();

        Schema::create('paychecks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('employee_id')->constrained();
            $table->unsignedInteger('net_amount')->nullable();
            $table->timestamp('payed_at')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paychecks');
    }
};
