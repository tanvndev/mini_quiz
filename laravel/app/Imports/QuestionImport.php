<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $rows->each(function ($row) {
            $correctAnswer = strtolower($row['correct']);
            $type = $row['type'];
            $topic = $row['topic'];

            if (empty($correctAnswer)) {
                throw new \Exception('Vui lòng không để trống đáp án chính xác.');
            }

            if (empty($type)) {
                throw new \Exception('Vui lòng không để trống loại câu hỏi.');
            }

            if (empty($topic)) {
                throw new \Exception('Vui lòng không để trống chủ đề câu hỏi.');
            }

            $question = Question::create([
                'type' => $type,
                'topic_id' => $row['topic'],
                'content' => $row['question'],
            ]);

            collect(['a', 'b', 'c', 'd', 'e', 'f'])
                ->filter(fn($key) => !empty($row[$key]))
                ->each(function ($key) use ($question, $row, $correctAnswer) {
                    $question->answers()->create([
                        'content' => $row[$key],
                        'is_correct' => strtolower($key) === $correctAnswer,
                    ]);
                });
        });
    }
}
