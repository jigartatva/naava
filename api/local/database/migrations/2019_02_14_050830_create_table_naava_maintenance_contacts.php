<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNaavaMaintenanceContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->string('name',80);
            $table->string('title',255);
            $table->string('phone',18);
            $table->string('mobile_phone',18);
            $table->string('email',255);
            $table->string('address',500)->nullable();
            $table->string('contact_type',50)->nullable();
            $table->string('priority_contacting_method',20)->nullable();
            $table->string('secondary_contacting_method',20)->nullable();
            $table->string('spoken_language',500)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('group_id')->references('id')->on('wall_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_contacts');
    }
}
