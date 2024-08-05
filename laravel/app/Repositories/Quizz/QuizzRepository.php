<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Quizz;

use App\Models\Quizz;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Quizz\QuizzRepositoryInterface;

class QuizzRepository extends BaseRepository implements QuizzRepositoryInterface
{
    protected $model;
    public function __construct(
        Quizz $model
    ) {
        $this->model = $model;
    }
}
