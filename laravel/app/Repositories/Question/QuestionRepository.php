<?php
// Trong Laravel, Repository Pattern thường được sử dụng để tạo các lớp repository, giúp tách biệt logic của ứng dụng khỏi cơ sở dữ liệu.
namespace App\Repositories\Question;

use App\Models\Question;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Question\QuestionRepositoryInterface;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    protected $model;
    public function __construct(
        Question $model
    ) {
        $this->model = $model;
    }
}
