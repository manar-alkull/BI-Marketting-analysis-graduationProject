<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSentimentValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sentiment_values', function (Blueprint $table) {
            $table->increments('id');
            $table->string('polarity', 50);
            $table->string('subjectivity', 50);
            $table->float('polarity_confidence', 10, 2);
            $table->float('subjectivity_confidence', 10, 2);
            $table->string('post_id');
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
        Schema::dropIfExists('sentiment_values');
    }
}
