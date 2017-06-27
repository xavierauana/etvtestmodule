<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTestPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        $permissions = [
            [
                'code'  => 'createTest',
                'label' => 'Create New Test',
            ],
            [
                'code'  => 'editTest',
                'label' => 'Edit Test',
            ],
            [
                'code'  => 'deleteTest',
                'label' => 'Delete Test',
            ],
        ];

        if (Schema::hasTable("permissions")) {
            foreach ($permissions as $permission) {
                $_permission = DB::table('permissions')->where('code', $permission['code'])->first();

                if (!$_permission) {
                    DB::table('permissions')->insert($permission);
                }
            }
        }
    }

    public function down() {

    }
}
