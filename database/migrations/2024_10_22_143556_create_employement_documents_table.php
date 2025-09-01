<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployementDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employement_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ربط الوثائق بالموظف
            $table->string('id_card')->nullable(); // صورة البطاقة الشخصية
            $table->string('birth_certificate')->nullable(); // شهادة الميلاد
            $table->string('graduation_certificate')->nullable(); // شهادة التخرج
            $table->string('criminal_record')->nullable(); // الوثيقة الجنائية
            $table->string('military_certificate')->nullable(); // شهادة الجيش
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
        Schema::dropIfExists('employement_documents');
    }
}
