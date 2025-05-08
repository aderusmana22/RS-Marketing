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
        Schema::create('rs_masters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();;
            $table->string('rs_no', 255);
            $table->foreignId('revision_id')->constrained('revisions')->cascadeOnDelete();;
            $table->string('rs_number', 255);
            $table->date('date');
            $table->string('reason', 255);
            $table->string('objectives', 255);
            $table->string('cost_center', 255);
            $table->string('batch_code', 255);
            $table->string('est_potential', 255);
            $table->string('initiator_nik', 255);
            $table->string('route_to', 255);
            $table->string('status', 255)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rs_masters');
    }
};
