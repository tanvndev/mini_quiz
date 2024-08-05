<?php

namespace App\Http\Controllers\Api\V1\Quizz;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quizz\{
    StoreQuizzRequest,
    UpdateQuizzRequest
};
use App\Http\Resources\Quizz\QuizzCollection;
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
        $paginator = $this->quizzService->paginate();
        $data = new QuizzCollection($paginator);
        return successResponse('', $data);
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
        $response = new QuizzResource($this->quizzRepository->findById($id));
        return successResponse('', $response);
    }

    public function do(string $canonical)
    {
        $relation = [
            [
                'questions' => function ($query) {
                    $query->with('answers', fn ($query) => $query->select(['id', 'content', 'question_id']));
                }
            ], 'topic'
        ];

        $response = new QuizzResource($this->quizzRepository->findByWhere(['canonical' => ['=', $canonical]], ['*'], $relation));
        return successResponse('', $response);
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
