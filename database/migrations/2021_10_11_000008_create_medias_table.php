<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediasTable extends Migration
{
    public function up()
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        Schema::create('medias', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('issue_id');
            $table->string('path', 255);
            $table->string('filename', 255);
            $table->string('type', 255);
            $table->string('size', 255);
            $table->timestamps();
            $table->softDeletes();

            //foreign Keys
            $table->foreign('issue_id')->references('id')->on('issues')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medias');
    }
}