<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->string('id');
            $table->string('location')->nullable($value = true);
            $table->text('textData');
            $table->dateTimeTz('date')->nullable($value = true);
            $table->integer('product_id')->nullable($value = true);
            $table->string('customer_id')->nullable($value = true);
            $table->enum('socialMedia', ['twitter', 'facebook'])->nullable($value = true);
            $table->boolean('analysed')->default(0);
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
