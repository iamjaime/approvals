<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApproverGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approver_groups', function (Blueprint $table) {
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

        Schema::create('approver_group_users', function (Blueprint $table) {
            $table->increments('id');

            if(Schema::hasTable('teams')){
                //This means that our package is now specific to spark because we are referencing the teams table
                //Foreign Key Referencing the id on the team table.
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            }

            //user in that group
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            //Approver group id
            $table->integer('approver_group_id')->unsigned();
            $table->foreign('approver_group_id')->references('id')->on('approver_groups')->onDelete('cascade');

            //clearance level....
            $table->integer('level')->unsigned()->nullable();

            $table->timestamps();
        });

        Schema::create('approver_group_requests', function (Blueprint $table) {
            $table->increments('id');

            if(Schema::hasTable('teams')){
                //This means that our package is now specific to spark because we are referencing the teams table
                //Foreign Key Referencing the id on the team table.
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            }

            //Foreign Key Referencing the id on the approvals table.
            $table->integer('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('approvals')->onDelete('cascade');

            //Foreign Key Referencing the id on the approvers table.
            $table->integer('approver_group_id')->unsigned();
            $table->foreign('approver_group_id')->references('id')->on('approver_groups')->onDelete('cascade');

            //user in that group ( then we can grab their clearance level in the event that we have clearance rules )
            $table->integer('approver_group_user_id')->unsigned();
            $table->foreign('approver_group_user_id')->references('id')->on('approver_group_users')->onDelete('cascade');

            $table->enum('status', ['pending','approved', 'declined'])->default('pending');

            $table->string('token')->nullable();

            $table->timestamps();
        });


        Schema::table('approvals', function (Blueprint $table){
            //if the approval is of type quick then we use the "approvals" table.
            //if it's of type "group" then we use the approver_group_requests table
            $table->enum('type', ['quick', 'group'])->after('status')->nullable();
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
            $table->dropColumn('type');

        });


        Schema::table('approver_group_requests', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }

            $table->dropForeign(['approval_id']);
            $table->dropForeign(['approver_group_id']);
            $table->dropForeign(['approver_group_user_id']);
        });


        Schema::table('approver_group_users', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }

            $table->dropForeign(['user_id']);
            $table->dropForeign(['approver_group_id']);
        });


        Schema::table('approver_groups', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }
        });


        Schema::dropIfExists('approver_group_requests');
        Schema::dropIfExists('approver_group_users');
        Schema::dropIfExists('approver_groups');
    }
}
