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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->noActionOnDelete();

            $table->string('topic');
            $table->text('description');
            $table->enum('status', ['new', 'on_process', 'done'])->default('new');
            $table->timestamp('answered_date')->nullable();
            $table->unsignedBigInteger('answered_by')->nullable();
            $table->foreign('answered_by')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
