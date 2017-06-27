<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('prefix')->nullable();
            $table->text('content');
            $table->integer('order')->unsigned()->default(0);
            $table->integer('question_type_id')->unsigned();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_fractional')->default(false);
            $table->integer('group_id')->unsigned()->default(0);
            $table->integer('page_number')->default(1);
            $table->timestamps();
        });

        Schema::create('question_test', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('test_id')->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');
            $table->integer('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->unique(['test_id', 'question_id']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('question_test');
        Schema::dropIfExists('questions');
    }
}
