<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->increments('id');


            if(Schema::hasTable('teams')){
                //This means that our package is now specific to spark because we are referencing the teams table
                //Foreign Key Referencing the id on the team table.
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            }


            //Foreign Key Referencing the id on the users table.
            $table->integer('requester_id')->unsigned();
            $table->foreign('requester_id')->references('id')->on('users')->onDelete('cascade');


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
        Schema::table('approvals', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }

            $table->dropForeign(['requester_id']);
        });
        Schema::dropIfExists('approvals');
    }
}
