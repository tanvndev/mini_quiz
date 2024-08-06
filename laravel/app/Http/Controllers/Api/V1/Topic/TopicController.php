<?php

namespace App\Http\Controllers\Api\V1\Topic;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\{
    StoreTopicRequest,
    UpdateTopicRequest
};
use App\Http\Resources\Topic\TopicCollection;
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
        $this->authorize('modules', 'topics.index');

        $paginator = $this->topicService->paginate();
        $data = new TopicCollection($paginator);
        return successResponse('', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTopicRequest $request)
    {
        $this->authorize('modules', 'topics.store');

        $response = $this->topicService->create();
        return handleResponse($response, ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('modules', 'topics.show');

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
        $this->authorize('modules', 'topics.update');

        $response = $this->topicService->update($id);
        return handleResponse($response);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('modules', 'topics.destroy');

        $response = $this->topicService->destroy($id);
        return handleResponse($response);
    }
}
