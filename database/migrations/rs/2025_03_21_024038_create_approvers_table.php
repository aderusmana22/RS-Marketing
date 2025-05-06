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
        Schema::create('approvers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rs_id')->constrained('rs_masters')->cascadeOnDelete();;
            $table->string('approver_nik');
            $table->integer('level');
            $table->string('status')->default('pending');
            $table->string('unique_token');
            $table->string('notes');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvers');
    }
};
