<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_evaluations', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ربط التقييم بالموظف
            $table->enum('initiative_flexibility', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); // حالة "المبادرة والمرونة"
            $table->text('initiative_comment_employee')->nullable(); // تعليق الموظف على "المبادرة والمرونة"
            $table->text('initiative_comment_manager')->nullable(); // تعليق المدير على "المبادرة والمرونة"
            $table->enum('knowledge_position', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); // حالة "المعرفة بالوظيفة"
            $table->text('knowledge_comment_employee')->nullable(); // تعليق الموظف على "المعرفة بالوظيفة"
            $table->text('knowledge_comment_manager')->nullable(); // تعليق المدير على "المعرفة بالوظيفة"
            $table->enum('time_effectiveness', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); // حالة "الفعالية الزمنية"
            $table->text('time_comment_employee')->nullable(); // تعليق الموظف على "الفعالية الزمنية"
            $table->text('time_comment_manager')->nullable(); // تعليق المدير على "الفعالية الزمنية"
            $table->enum('overall_rating', ['Exceeds expectations', 'Meets expectations', 'Needs improvement', 'Unacceptable'])->nullable(); 
            $table->text('overall_comment')->nullable();// التقييم العام
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_evaluations');
    }
}
