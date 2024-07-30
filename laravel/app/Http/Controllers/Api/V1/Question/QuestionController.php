<?php

namespace App\Http\Controllers\Api\V1\Question;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\{
    StoreQuestionRequest,
    UpdateQuestionRequest
};
use App\Http\Resources\Question\QuestionResource;
use App\Repositories\Interfaces\Question\QuestionRepositoryInterface;
use App\Services\Interfaces\Question\QuestionServiceInterface;

class QuestionController extends Controller
{
    protected $questionService;
    protected $questionRepository;
    public function __construct(
        QuestionServiceInterface $questionService,
        QuestionRepositoryInterface $questionRepository
    ) {
        $this->questionService = $questionService;
        $this->questionRepository = $questionRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->questionService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $response = $this->questionService->create();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::CREATED : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = new QuestionResource($this->questionRepository->findById($id));
        return response()->json([
            'status' => 'success',
            'messages' => '',
            'data' => $question ?? []
        ], ResponseEnum::OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, string $id)
    {
        $response = $this->questionService->update($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $response = $this->questionService->destroy($id);
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }
}
