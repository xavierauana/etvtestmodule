<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 11:15 AM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


class UpdateMultipleChoiceHelpers
{
    public static function ParseDataForQuestionContent($data): array  {
        return  [
            'content'   => $data['content'],
            'is_active' => $data['is_active'],
            'prefix'    => $data['prefix'],
        ];
    }
}