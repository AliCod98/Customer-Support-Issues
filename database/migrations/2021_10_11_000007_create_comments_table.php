<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('issue_id');
            $table->unsignedInteger('author_id');
            $table->longText('comment_text');
            $table->timestamps();
            $table->softDeletes();

            //foreing key
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}