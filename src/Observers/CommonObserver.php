<?php
/**
 * Author: Xavier Au
 * Date: 6/1/2018
 * Time: 5:45 PM
 */

namespace Anacreation\Etvtest\Observers;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

abstract class CommonObserver
{
    /**
     * Listen to the User created event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function created(Model $model) {
        $this->record($model, __FUNCTION__);
    }

    /**
     * Listen to the User created event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function updated(Model $model) {
        $this->record($model, __FUNCTION__);
    }

    /**
     * Listen to the User deleted event.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function deleted(Model $model) {
        $this->record($model, __FUNCTION__);
    }

    private function record(Model $model, string $action) {

        $table = env('RECORD_TABLE');

        if (Schema::hasTable($table) and $admin = request()->user('admin')) {
            DB::table($table)->insert([
                'model'      => get_class($model),
                'model_id'   => $model->id,
                'action'     => $action,
                'admin_id'   => $admin->id,
                'created_at' => Carbon::now()
            ]);
        }
    }
}