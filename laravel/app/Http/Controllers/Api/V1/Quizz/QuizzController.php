<?php

namespace App\Http\Controllers\Api\V1\Quizz;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quizz\{
    StoreQuizzRequest,
    UpdateQuizzRequest
};
use App\Http\Resources\Quizz\QuizzResource;
use App\Repositories\Interfaces\Quizz\QuizzRepositoryInterface;
use App\Services\Interfaces\Quizz\QuizzServiceInterface;

class QuizzController extends Controller
{
    protected $quizzService;
    protected $quizzRepository;
    public function __construct(
        QuizzServiceInterface $quizzService,
        QuizzRepositoryInterface $quizzRepository
    ) {
        $this->quizzService = $quizzService;
        $this->quizzRepository = $quizzRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = $this->quizzService->paginate();
        $statusCode = $response['status'] == 'success' ? ResponseEnum::OK : ResponseEnum::INTERNAL_SERVER_ERROR;
        return response()->json($response, $statusCode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizzRequest $request)
    {
        // return response()->json($request->all());
        return handleResponse($this->quizzService->create(), ResponseEnum::CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = new QuizzResource($this->quizzRepository->findById($id));
        return successResponse('', $question);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizzRequest $request, string $id)
    {
        return handleResponse($this->quizzService->update($id));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return handleResponse($this->quizzService->destroy($id));
    }
}
