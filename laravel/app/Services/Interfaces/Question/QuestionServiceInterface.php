<?php

namespace App\Services\Interfaces\Question;

interface QuestionServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusMultiple();
    public function uploadQuestionWithFile();
}
