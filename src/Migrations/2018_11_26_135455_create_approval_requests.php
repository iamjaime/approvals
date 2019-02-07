<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_requests', function (Blueprint $table) {
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


            //Foreign Key Referencing the id on the approval processes table.
            $table->integer('approval_process_id')->unsigned();
            $table->foreign('approval_process_id')->references('id')->on('approval_processes')->onDelete('cascade');


            $table->enum('status', ['pending','awarded', 'denied'])->default('pending');


            $table->timestamps();
        });


        Schema::create('approval_request_documents', function (Blueprint $table) {

            $table->increments('id');

            $table->string('document_name');
            $table->string('document_url');

            //Foreign Key Referencing the id on the users table.
            $table->integer('approval_request_id')->unsigned();
            $table->foreign('approval_request_id')->references('id')->on('approval_requests')->onDelete('cascade');


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
        Schema::table('approval_requests', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }

            $table->dropForeign(['requester_id']);
            $table->dropForeign(['approval_process_id']);
        });

        Schema::table('approval_request_documents', function($table) {
            $table->dropForeign(['approval_request_id']);
        });

        Schema::dropIfExists('approval_requests');
        Schema::dropIfExists('approval_request_documents');
    }
}
