<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Quizz;

use App\Repositories\Interfaces\Quizz\QuizzRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Quizz\QuizzServiceInterface;
use Illuminate\Support\Facades\DB;

class QuizzService extends BaseService implements QuizzServiceInterface
{
    protected $quizzRepository;
    public function __construct(
        QuizzRepositoryInterface $quizzRepository,
    ) {
        $this->quizzRepository = $quizzRepository;
    }
    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
        ];
        $select = ['id', 'title', 'description', 'image', 'canonical', 'publish', 'topic_id'];
        $relation = [
            [
                'questions' => function ($query) {
                    $query->with('answers', fn ($query) => $query->select(['id', 'content', 'question_id']));
                }
            ], 'topic'
        ];

        $data = request('pageSize') && request('page')
            ? $this->quizzRepository->pagination($select, $condition, request('pageSize'), [], [], $relation)
            : $this->quizzRepository->all($select, $relation);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = request()->except('_token, _method');
            $quizz = $this->quizzRepository->create($payload);
            $quizz->questions()->sync($payload['question_ids']);

            return successResponse('Thêm mới thành công.');
        }, 'Thêm mới thất bại.');
    }


    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');

            $this->quizzRepository->update($id, $payload);

            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Cập nhập thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Cập nhập thất bại.',
                'data' => null
            ];
        }
    }


    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->quizzRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại');
    }
}
