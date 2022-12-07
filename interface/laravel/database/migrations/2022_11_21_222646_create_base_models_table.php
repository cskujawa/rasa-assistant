<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('make_id')->constrained()
                ->onDelete('cascade');
            $table->string('name', 255);
            $table->boolean('has_sales_data')->default(false);
            $table->integer('avg_price')->unsigned()->nullable();
            $table->string('autotrader_avg_price', 255)->nullable();
            $table->integer('autotrader_records_searched')->unsigned()->nullable();
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
        Schema::dropIfExists('base_models');
    }
};
