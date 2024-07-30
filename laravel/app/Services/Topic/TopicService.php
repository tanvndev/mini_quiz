<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Topic;

use App\Repositories\Interfaces\Topic\TopicRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Topic\TopicServiceInterface;
use Illuminate\Support\Facades\DB;

class TopicService extends BaseService implements TopicServiceInterface
{
    protected $topicRepository;
    public function __construct(
        TopicRepositoryInterface $topicRepository,
    ) {
        $this->topicRepository = $topicRepository;
    }
    public function paginate()
    {
        // addslashes là một hàm được sử dụng để thêm các ký tự backslashes (\) vào trước các ký tự đặc biệt trong chuỗi.
        $condition['search'] = addslashes(request('search'));
        $condition['publish'] = request('publish');
        $select = ['id', 'name', 'publish', 'description', 'canonical'];

        if (request('pageSize') && request('page')) {

            $topics = $this->topicRepository->pagination(
                $select,
                $condition,
                request('pageSize'),
                ['id' => 'desc'],
            );

            foreach ($topics as $key => $topicCatalogue) {
                $topicCatalogue->key = $topicCatalogue->id;
            }
        } else {
            $topics = $this->topicRepository->all($select);
        }


        return [
            'status' => 'success',
            'messages' => '',
            'data' => $topics
        ];
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');

            $this->topicRepository->create($payload);

            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Thêm mới thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => $e->getMessage(),
                'data' => null
            ];
        }
    }


    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');

            $this->topicRepository->update($id, $payload);

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
        DB::beginTransaction();
        try {
            $this->topicRepository->delete($id);

            DB::commit();
            return [
                'status' => 'success',
                'messages' => 'Xóa thành công.',
                'data' => null
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status' => 'error',
                'messages' => 'Xóa thất bại.',
                'data' => null
            ];
        }
    }
}
