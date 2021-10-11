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
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id');
            $table->text('prefix')->nullable();
            $table->text('content');
            $table->integer('order')->unsigned()->default(0);
            $table->unsignedBigInteger('question_type_id');
            $table->boolean('is_active')->default(false);
            $table->boolean('is_fractional')->default(false);
            $table->unsignedBigInteger('group_id')->default(0);
            $table->integer('page_number')->default(1);
            $table->timestamps();
        });

        Schema::create('question_test', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('test_id');
            $table->foreign('test_id')->references('id')->on('tests')
                ->onDelete('cascade');
            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions')
                ->onDelete("cascade");
            $table->unique(['test_id', 'question_id']);
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
        Schema::dropIfExists('question_test');
        Schema::dropIfExists('questions');
    }
}
