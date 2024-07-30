<?php

namespace App\Services\Interfaces\Topic;

interface TopicServiceInterface
{
    public function paginate();
    public function create();
    public function update($id);
    public function destroy($id);
    public function updateStatus();
    public function updateStatusMultiple();
}
