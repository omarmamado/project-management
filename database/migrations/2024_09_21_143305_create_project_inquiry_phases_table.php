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
        Schema::create('project_inquiry_phases', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->foreignId('project_inquiry_id')->constrained('project_inquiries')->onDelete('cascade');
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade'); 
            $table->date('start_date')->nullable(); 
            $table->date('end_date')->nullable();
            $table->date('start_date_manager')->nullable(); 
            $table->date('end_date_manager')->nullable(); 
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade'); 
            $table->json('dynamic_data')->nullable(); 
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending'); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_inquiry_phases');
    }
};
