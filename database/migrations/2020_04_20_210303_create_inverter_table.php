<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInverterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Inverters', function (Blueprint $table) {
            $table->integer('Serial')->primary();
            $table->string('Name', 32)->nullable();
            $table->string('Type', 32)->nullable();
            $table->string('SW_Version', 32)->nullable();
            $table->integer('TimeStamp')->nullable();
            $table->integer('TotalPac')->nullable();
            $table->bigInteger('EToday')->nullable();
            $table->bigInteger('ETotal')->nullable();
            $table->double('OperatingTime')->nullable();
            $table->double('FeedInTime')->nullable();
            $table->string('Status', 10)->nullable();
            $table->string('GridRelay', 10)->nullable();
            $table->float('Temperature')->nullable();
        });
    }
}
