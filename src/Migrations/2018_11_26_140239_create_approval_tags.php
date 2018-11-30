<?php

/**
 * This serves as a pivot table between "approvals" and "tags"
 * because an "approval" can have many tags
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovalTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_tags', function (Blueprint $table) {
            $table->increments('id');

            //Foreign Key Referencing the id on the approvals table.
            $table->integer('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('approvals')->onDelete('cascade');

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

        Schema::table('approval_tags', function($table) {
            $table->dropForeign(['approval_id']);
            $table->dropForeign(['tag_id']);
        });

        Schema::dropIfExists('approval_tags');
    }
}
