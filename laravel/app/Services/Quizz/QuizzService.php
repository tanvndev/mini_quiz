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
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'publish', 'description', 'canonical'];

        if (request('pageSize') && request('page')) {

            $quizzs = $this->quizzRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
            );

            foreach ($quizzs as $key => $quizzCatalogue) {
                $quizzCatalogue->key = $quizzCatalogue->id;
            }
        } else {
            $quizzs = $this->quizzRepository->all($select);
        }

        return [
            'status' => 'success',
            'messages' => '',
            'data' => $quizzs
        ];
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
