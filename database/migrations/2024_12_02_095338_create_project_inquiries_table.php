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
        Schema::create('project_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade'); 
            $table->string('name'); 
            $table->enum('creator_status', ['pending', 'approved', 'rejected'])->default('pending'); 
            $table->enum('manager_status', ['pending', 'approved', 'rejected'])->default('pending'); 
            $table->timestamps();
        });
        
            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_inquiries');
    }
};
