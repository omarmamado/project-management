<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cash_request_id')->constrained()->onDelete('cascade'); // يربط مع طلب المصروف
            $table->string('item_name'); // اسم الصنف
            $table->string('price'); // السعر
          
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
        Schema::dropIfExists('cash_request_items');
    }
}
