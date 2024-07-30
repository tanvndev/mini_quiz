<?php

namespace App\Http\Controllers\Api\V1\Topic;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\{
    StoreTopicRequest,
    UpdateTopicRequest
};
use App\Http\Resources\Topic\TopicResource;
use App\Repositories\Interfaces\Topic\TopicRepositoryInterface;
use App\Services\Interfaces\Topic\TopicServiceInterface;

class TopicController extends Controller
{
    protected $topicService;
    protected $topicRepository;
    public function __construct(
        TopicServiceInterface $topicService,
        TopicRepositoryInterface $topicRepository
    ) {
        $this->topicService = $topicService;
        $this->topicRepository = $topicRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->topicService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request)
    {
        $response = $this->topicService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = new TopicResource($this->topicRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $topic ?? []
        ], ResponseEnum::OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTopicRequest $request, string $id)
    {
        $response = $this->topicService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->topicService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
