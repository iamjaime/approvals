<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprovers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvers', function (Blueprint $table) {
            $table->increments('id');

            //Foreign Key Referencing the id on the approvals table.
            $table->integer('approval_id')->unsigned();
            $table->foreign('approval_id')->references('id')->on('approvals')->onDelete('cascade');

            //Foreign Key Referencing the id on the approvers table.
            $table->integer('approver_id')->unsigned();
            $table->foreign('approver_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ['pending','approved', 'declined'])->default('pending');

            $table->string('token')->nullable();

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
        Schema::table('approvers', function($table) {
            $table->dropForeign(['approval_id']);
            $table->dropForeign(['approver_id']);
        });

        Schema::dropIfExists('approvers');
    }
}
