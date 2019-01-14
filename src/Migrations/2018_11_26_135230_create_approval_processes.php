<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalProcesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_processes', function (Blueprint $table) {
            $table->increments('id');

            if(Schema::hasTable('teams')){
                //This means that our package is now specific to spark because we are referencing the teams table
                //Foreign Key Referencing the id on the team table.
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            }

            $table->string('name');
            $table->text('description');
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

        Schema::table('approval_processes', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }
        });

        Schema::dropIfExists('approval_processes');
    }
}
