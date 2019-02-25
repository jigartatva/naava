<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNaavaCustomers extends Migration
{    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',80);
            $table->string('street',500);
            $table->string('street_two',500);
            $table->string('city',255);
            $table->string('state',255);
            $table->string('zipcode',18);
            $table->string('country',90);
            $table->string('business_id',255);
            $table->string('service_team_geo_area',500)->nullable();
            $table->string('company_type',50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
