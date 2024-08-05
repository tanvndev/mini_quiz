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
        $select = ['id', 'name', 'publish', 'description', 'canonical'];
        $condition = [
            'search' => request('search'),
            'publish' => request('publish'),
        ];

        $data = request('pageSize') && request('page')
            ? $this->topicRepository->pagination($select, $condition, request('pageSize'))
            : $this->topicRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $this->topicRepository->create($payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }


    public function update($id)
    {

        return $this->executeInTransaction(function () use ($id) {

            $payload = request()->except('_token', '_method');
            $this->topicRepository->update($id, $payload);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }


    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {

            $this->topicRepository->delete($id);

            return successResponse('Tạo mới thành công.');
        }, 'Tạo mới thất bại.');
    }
}
