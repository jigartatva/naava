<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNaavaWallGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wall_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->string('name',80);
            $table->string('street',500);
            $table->string('street_two',500);
            $table->string('city',255);
            $table->string('state',255);
            $table->string('zipcode',18);
            $table->string('country',90);
            $table->string('service_team_geo_area',500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            /* Foreign key references */
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wall_groups');
    }
}
