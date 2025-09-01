<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // ربط العقد بالموظف
            $table->string('contract_file')->nullable(); // صورة العقد
            $table->date('start_date'); // تاريخ بدء العقد
            $table->date('end_date'); // تاريخ انتهاء العقد
            $table->string('salary')->nullable();
            $table->boolean('is_renewed')->default(false);
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
        Schema::dropIfExists('employment_contracts');
    }
}
