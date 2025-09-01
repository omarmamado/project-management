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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->text('note')->nullable(); 
            $table->foreignId('creator_id')->nullable()->constrained('users')->onDelete('cascade'); 
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('cascade'); 
            $table->foreignId('project_inquiries_id')->nullable()->constrained('project_inquiries')->onDelete('cascade'); 
            $table->date('completed_at')->nullable(); 
            $table->boolean('is_from_inquiry')->default(false); // إضافة هذا الحقل
            $table->enum('status', ['project_not_started', 'in_progress', 'completed'])->default('project_not_started');
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
