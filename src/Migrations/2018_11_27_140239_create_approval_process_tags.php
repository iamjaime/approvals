<?php

/**
 * This serves as a pivot table between "approval_processes" and "tags"
 * because an "approval_process" can have many tags
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalProcessTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_process_tags', function (Blueprint $table) {
            $table->increments('id');

            //Foreign Key Referencing the id on the approval processes table.
            $table->integer('approval_process_id')->unsigned();
            $table->foreign('approval_process_id')->references('id')->on('approval_processes')->onDelete('cascade');

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

        Schema::table('approval_process_tags', function($table) {
            $table->dropForeign(['approval_process_id']);
            $table->dropForeign(['tag_id']);
        });

        Schema::dropIfExists('approval_process_tags');
    }
}
