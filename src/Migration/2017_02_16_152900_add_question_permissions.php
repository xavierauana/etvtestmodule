<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddQuestionPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $permissions = [
            [
                'code'  => 'createQuestion',
                'label' => 'Create New Question',
            ],
            [
                'code'  => 'editQuestion',
                'label' => 'Edit Question',
            ],
            [
                'code'  => 'deleteQuestion',
                'label' => 'Delete Question',
            ],
        ];

        if (Schema::hasTable('permissions')) {
            foreach ($permissions as $permission) {
                $_permission = DB::table('permissions')->where('code', $permission['code'])->first();

                if (!$_permission) {
                    DB::table('permissions')->insert($permission);
                }
            }
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
