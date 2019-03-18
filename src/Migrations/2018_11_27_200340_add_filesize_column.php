<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilesizeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('approval_request_documents', function (Blueprint $table) {

            $table->string('document_filesize')->after('document_url');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_request_documents', function (Blueprint $table){

            $table->dropColumn('document_filesize');

        });
    }
}
