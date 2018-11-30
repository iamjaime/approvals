<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_configurations', function (Blueprint $table) {
            $table->increments('id');

            //Foreign Key Referencing the id on the approvals table.
            $table->integer('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('approvals')->onDelete('cascade');

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('yes')->default(1); //number of yes's required before auto approval
            $table->integer('no')->default(0); //number of no's required before auto denial
            $table->timestamps();
        });

        Schema::table('approvals', function (Blueprint $table) {
            //Foreign Key Referencing the id on the approvals table.
            $table->integer('approval_configuration_id')->after('requester_id')->unsigned();
            $table->foreign('approval_configuration_id')->references('id')->on('approval_configurations')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_configurations', function($table) {
            $table->dropForeign(['approval_id']);
        });

        Schema::table('approvals', function($table) {
            $table->dropForeign(['approval_configuration_id']);
        });


        Schema::dropIfExists('approval_configurations');
    }
}
