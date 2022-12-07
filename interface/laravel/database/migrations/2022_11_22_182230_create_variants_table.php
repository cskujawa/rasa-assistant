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
        Schema::create('variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_model_id')->constrained()
                ->onDelete('cascade');
            $table->string('nhtsa_vehicle_id', 255);
            $table->string('name', 255);
            $table->string('description', 255);
            $table->boolean('has_safety_data')->default(false);
            $table->string('picture_url', 255)->nullable();
            $table->string('overall_safety_rating', 255)->nullable();
            $table->string('overall_front_crash_rating', 255)->nullable();
            $table->string('front_crash_driver_side_rating', 255)->nullable();
            $table->string('front_crash_passenger_side_rating', 255)->nullable();
            $table->string('overall_side_crash_rating', 255)->nullable();
            $table->string('side_crash_driver_side_rating', 255)->nullable();
            $table->string('side_crash_passenger_side_rating', 255)->nullable();
            $table->string('overall_side_barrier_rating', 255)->nullable();
            $table->string('side_pole_crash_rating', 255)->nullable();
            $table->string('rollover_rating', 255)->nullable();
            $table->string('front_crash_picture_url', 255)->nullable();
            $table->string('side_crash_picture_url', 255)->nullable();
            $table->string('side_pole_crash_picture_url', 255)->nullable();
            $table->string('complaints_count', 255)->nullable();
            $table->string('complaints_url', 255)->nullable();
            $table->string('recalls_count', 255)->nullable();
            $table->string('recalls_url', 255)->nullable();
            $table->string('investigations_count', 255)->nullable();
            $table->string('investigations_url', 255)->nullable();
            $table->string('electronic_stability_control', 255)->nullable();
            $table->string('forward_collision_warning', 255)->nullable();
            $table->string('lane_departure_warning', 255)->nullable();
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
        Schema::dropIfExists('variants');
    }
};
