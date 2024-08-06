<?php

namespace App\Services\Interfaces\Quizz;

interface QuizzServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusMultiple();
    public function handleMark();
    public function historyUser();
    public function historyDetail(string $id);
    public function history();
}
