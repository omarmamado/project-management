<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employment_allowances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employment_contract_id')->constrained()->onDelete('cascade'); // ربط البدل بالعقد
            $table->string('allowance_type')->nullable(); // نوع البدل (مثال: accommodation، المواصلات، etc.)
            $table->decimal('amount')->nullable(); // مبلغ البدل
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
        Schema::dropIfExists('employment_allowances');
    }
}
