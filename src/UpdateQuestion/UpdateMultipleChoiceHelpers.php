<?php
/**
 * Author: Xavier Au
 * Date: 19/2/2017
 * Time: 11:15 AM
 */

namespace Anacreation\Etvtest\UpdateQuestion;


class UpdateMultipleChoiceHelpers
{
    public static function ParseDataForQuestionContent($data): array {
        $basic = [
            'content'     => $data['content'],
            'is_active'   => $data['is_active'],
            'prefix'      => $data['prefix'],
            'page_number' => $data['page_number'],
        ];
        if (isset($data['order'])) {
            $basic['order'] = $data['order'];
        }

        return $basic;
    }
}