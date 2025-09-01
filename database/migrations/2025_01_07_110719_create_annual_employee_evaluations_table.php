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
        Schema::create('annual_employee_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->enum('quality_of_work', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('quality_of_work_comment_head')->nullable(); 
            $table->text('quality_of_work_comment_gm')->nullable(); 
            $table->enum('discipline_punctuality', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('discipline_punctuality_comment_head')->nullable(); 
            $table->text('discipline_punctuality_comment_gm')->nullable();
            $table->enum('problem_solving', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('problem_solving_comment_head')->nullable(); 
            $table->text('problem_solving_comment_gm')->nullable();
            $table->enum('conflict_management', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('conflict_management_comment_head')->nullable(); 
            $table->text('conflict_management_comment_gm')->nullable();
            $table->enum('time_effectiveness_time_responsiveness_availability', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('time_effectiveness_time_responsiveness_availability_comment_head')->nullable(); 
            $table->text('time_effectiveness_time_responsiveness_availability_comment_gm')->nullable();
            $table->enum('initiative_flexibility', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('initiative_flexibility_comment_head')->nullable(); 
            $table->text('initiative_flexibility_comment_gm')->nullable();
            $table->enum('cooperation_teamwork', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('cooperation_teamwork_comment_head')->nullable(); 
            $table->text('cooperation_teamwork_comment_gm')->nullable();
            $table->enum('knowledge_of_position', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('knowledge_of_position_comment_head')->nullable(); 
            $table->text('knowledge_of_position_comment_gm')->nullable();
            $table->enum('creativity_innovation', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('creativity_innovation_comment_head')->nullable(); 
            $table->text('creativity_innovation_comment_gm')->nullable();
            $table->text('performance_goals')->nullable();
            $table->enum('over_all_rating', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable();
            $table->text('over_all_comment')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annual_employee_evaluations');
    }
};
