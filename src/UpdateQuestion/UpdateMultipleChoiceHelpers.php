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
    public static function ParseDataForAnswersAndChoices($data): array  {
        $correctChoiceId = [];

        $choices = array_map(function ($choice) use (&$correctChoiceId) {
            if ($choice['is_corrected']) {
                $correctChoiceId[] = $choice['id'];
            }

            return [
                "id"           => $choice['id'],
                "content"      => $choice['content'],
                "is_corrected" => $choice['is_corrected'],
            ];
        }, $data['choices']);

        return [$correctChoiceId, $choices];
    }
}