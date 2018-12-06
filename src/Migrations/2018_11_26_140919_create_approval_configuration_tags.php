<?php

/**
 * This serves as a pivot table between "approval_configurations" and "tags"
 * because an "approval_configuration" can have many tags
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalConfigurationTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_configuration_tags', function (Blueprint $table) {
            $table->increments('id');

            //Foreign Key Referencing the id on the approval configurations table.
            $table->integer('approval_configuration_id')->unsigned();
            $table->foreign('approval_configuration_id')->references('id')->on('approval_configurations')->onDelete('cascade');

            //Foreign Key Referencing the id on the tags table.
            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');

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
        Schema::table('approval_configuration_tags', function($table) {
            $table->dropForeign(['approval_configuration_id']);
            $table->dropForeign(['tag_id']);
        });

        Schema::dropIfExists('approval_configuration_tags');
    }
}
