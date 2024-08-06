<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Quizz;

use App\Models\Result;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Quizz\ResultRepositoryInterface;

class ResultRepository extends BaseRepository implements ResultRepositoryInterface
{
    protected $model;
    public function __construct(
        Result $model
    ) {
        $this->model = $model;
    }
}
