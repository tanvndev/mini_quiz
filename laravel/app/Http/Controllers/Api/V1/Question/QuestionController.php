<?php

namespace App\Http\Controllers\Api\V1\Question;

use App\Enums\ResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Question\{StoreQuestionRequest, UpdateQuestionRequest};
use App\Http\Resources\Question\QuestionCollection;
use App\Http\Resources\Question\QuestionResource;
use App\Repositories\Interfaces\Question\QuestionRepositoryInterface;
use App\Services\Interfaces\Question\QuestionServiceInterface;
use Illuminate\Http\Request;

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

    public function index()
    {
        $paginator = $this->questionService->paginate();
        $data = new QuestionCollection($paginator);
        return successResponse('', $data);
    }

    public function store(StoreQuestionRequest $request)
    {
        return handleResponse($this->questionService->create(), ResponseEnum::CREATED);
    }

    public function show(string $id)
    {
        $question = new QuestionResource(
            $this->questionRepository->findById(
                $id,
                ['id', 'content', 'type', 'topic_id'],
                ['answers']
            )
        );
        return successResponse('', $question);
    }

    public function update(UpdateQuestionRequest $request, string $id)
    {
        return handleResponse($this->questionService->update($id));
    }

    public function destroy(string $id)
    {
        return handleResponse($this->questionService->destroy($id));
    }

    public function importQuestion(Request $request)
    {
        return handleResponse($this->questionService->uploadQuestionWithFile());
    }
}
