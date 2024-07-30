<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Topic;

use App\Models\Topic;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Topic\TopicRepositoryInterface;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface
{
    protected $model;
    public function __construct(
        Topic $model
    ) {
        $this->model = $model;
    }
}
