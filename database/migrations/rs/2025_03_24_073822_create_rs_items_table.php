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
        Schema::create('rs_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rs_id')->constrained('rs_masters')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('item_details')->cascadeOnDelete();
            $table->integer('qty_issued');
            $table->integer('qty_req');
            $table->string('batch_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rs_items');
    }
};
