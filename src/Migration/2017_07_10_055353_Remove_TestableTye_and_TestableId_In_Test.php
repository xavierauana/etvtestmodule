<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTestableTyeAndTestableIdInTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        if (Schema::hasColumn('tests', 'testable_type')) {
            Schema::table('tests', function (Blueprint $table) {
                $table->removeColumn('testable_type');
            });
        }
        if (Schema::hasColumn('tests', 'testable_id')) {
            Schema::table('tests', function (Blueprint $table) {
                $table->removeColumn('testable_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
