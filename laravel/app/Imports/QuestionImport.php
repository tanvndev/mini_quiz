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
            $question = Question::create([
                'type' => $row['type'],
                'topic_id' => $row['topic'],
                'content' => $row['question'],
            ]);

            $correctAnswer = strtolower($row['correct']);
            // dd($correctAnswer);

            collect(['a', 'b', 'c', 'd', 'e', 'f'])
                ->filter(fn ($key) => !empty($row[$key]))
                ->each(function ($key) use ($question, $row, $correctAnswer) {
                    $question->answers()->create([
                        'content' => $row[$key],
                        'is_correct' => strtolower($key) === $correctAnswer,
                    ]);
                });
        });
    }
}
