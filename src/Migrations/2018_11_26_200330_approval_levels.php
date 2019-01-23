<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ApprovalLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_levels', function (Blueprint $table) {
            $table->increments('id');

            if(Schema::hasTable('teams')){
                //This means that our package is now specific to spark because we are referencing the teams table
                //Foreign Key Referencing the id on the team table.
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            }

            //Foreign Key Referencing the id on the approval_elements table.
            $table->integer('approval_element_id')->unsigned();
            $table->foreign('approval_element_id')->references('id')->on('approval_elements')->onDelete('cascade');

            $table->string('name');

            $table->text('description');

            $table->integer('required_yes_count');

            $table->integer('required_no_count');

            //clearance level order number (used for hiearchy)....
            $table->decimal('level_order', 3, 2)->unsigned()->nullable();

            $table->timestamps();
        });

        Schema::create('approval_level_users', function (Blueprint $table) {
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

            //Approver level id
            $table->integer('approval_level_id')->unsigned();
            $table->foreign('approval_level_id')->references('id')->on('approval_levels')->onDelete('cascade');


            $table->timestamps();
        });

        Schema::create('approval_level_requests', function (Blueprint $table) {
            $table->increments('id');

            if(Schema::hasTable('teams')){
                //This means that our package is now specific to spark because we are referencing the teams table
                //Foreign Key Referencing the id on the team table.
                $table->integer('team_id')->unsigned()->nullable();
                $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            }

            //Foreign Key Referencing the id on the approval_process table.
            $table->integer('approval_process_id')->unsigned();
            $table->foreign('approval_process_id')->references('id')->on('approval_processes')->onDelete('cascade');

            //Foreign Key Referencing the id on the approval_elements table.
            $table->integer('approval_element_id')->unsigned();
            $table->foreign('approval_element_id')->references('id')->on('approval_elements')->onDelete('cascade');

            //Foreign Key Referencing the id on the approval_levels table.
            $table->integer('approval_level_id')->unsigned();
            $table->foreign('approval_level_id')->references('id')->on('approval_levels')->onDelete('cascade');

            //Foreign Key Referencing the id on the approval_level_users table.
            $table->integer('approval_level_user_id')->unsigned();
            $table->foreign('approval_level_user_id')->references('id')->on('approval_level_users')->onDelete('cascade');


            $table->enum('status', ['pending','approved', 'declined'])->default('pending');

            $table->string('token')->nullable();

            $table->timestamps();
        });


        Schema::table('approval_requests', function (Blueprint $table){

            //Foreign Key Referencing the id on the approval levels table.
            $table->integer('current_assessment_level_id')->unsigned()->after('approval_process_id')->nullable();
            $table->foreign('current_assessment_level_id')->references('id')->on('approval_levels')->onDelete('cascade');
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
            $table->dropForeign(['current_assessment_level_id']);
            $table->dropColumn('current_assessment_level_id');
        });


        Schema::table('approval_level_requests', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }

            $table->dropForeign(['approval_element_id']);
            $table->dropForeign(['approval_level_id']);
            $table->dropForeign(['approval_level_user_id']);
            $table->dropForeign(['approval_process_id']);
        });


        Schema::table('approval_level_users', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }

            $table->dropForeign(['user_id']);
            $table->dropForeign(['approval_level_id']);
        });


        Schema::table('approval_levels', function($table) {

            if(Schema::hasTable('teams')){
                $table->dropForeign(['team_id']);
            }

            $table->dropForeign(['approval_element_id']);
        });


        Schema::dropIfExists('approval_level_requests');
        Schema::dropIfExists('approval_level_users');
        Schema::dropIfExists('approval_levels');
    }
}
