<?php
/**
 * Author: Xavier Au
 * Date: 26/3/2018
 * Time: 1:35 PM
 */

namespace Anacreation\Etvtest\Services;


use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use App\User;

class AttemptService
{
    public function createAttemptForUser(
        Test $test, GradingService $service, User $user
    ): Attempt {
        $new_attempt = new Attempt();
        $new_attempt->attempt = $service->result;
        $new_attempt->user_id = $user->id;
        $new_attempt->test_id = $test->id;

        $correctAns = count(array_filter($service->result,
            function (array $questionCheck) {
                return !!$questionCheck['is_correct'];
            }));

        $result = $service->result;
        $total =  count($result);
        $score =  $correctAns / $total;

        $new_attempt->score =  $score;
        $new_attempt->save();

        return $new_attempt;
    }
}