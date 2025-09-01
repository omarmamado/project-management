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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('note')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('project_inquiries_id')->nullable()->constrained('project_inquiries')->onDelete('cascade');
            $table->foreignId('phase_id')->nullable()->constrained('project_inquiry_phases')->onDelete('cascade'); // إضافة هذا الحقل
            $table->enum('priority', ['high', 'medium', 'low'])->default('low');
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->boolean('approved_by_manager')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};