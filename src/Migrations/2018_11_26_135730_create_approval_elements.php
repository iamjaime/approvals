<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_elements', function (Blueprint $table) {
            $table->increments('id');
            if(Schema::hasTable('teams')){
                //This means that our package is now specific to spark because we are referencing the teams table
                //Foreign Key Referencing the id on the team table.
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            }

            $table->integer('approval_process_id')->unsigned();
            $table->foreign('approval_process_id')->references('id')->on('approval_processes')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

        });



        //Lets make sure that all approval processes have 1 approval_element_id attached to it.
        Schema::table('approval_processes', function (Blueprint $table){
            $table->integer('approval_element_id')->unsigned()->after('description')->nullable();
            $table->foreign('approval_element_id')->references('id')->on('approval_elements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_elements', function ($table) {
            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }
            $table->dropForeign(['approval_process_id']);
        });

        Schema::table('approval_processes', function($table) {
            $table->dropForeign(['approval_element_id']);
            $table->dropColumn(['approval_element_id']);
        });


        Schema::dropIfExists('approval_elements');
    }
}
