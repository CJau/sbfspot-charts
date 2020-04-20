<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DayData', function (Blueprint $table) {
            $table->integer('TimeStamp');
            $table->integer('Serial');
            $table->bigInteger('TotalYield');
            $table->bigInteger('Power');
            $table->boolean('PVOutput');

            $table->primary([
                'TimeStamp',
                'Serial',
            ]);

            $table->foreign('Serial')->references('Serial')->on('Inverters')->onDelete('CASCADE');
        });
    }
}
