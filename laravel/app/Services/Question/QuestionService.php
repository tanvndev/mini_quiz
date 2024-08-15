<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Question;

use App\Imports\QuestionImport;
use App\Repositories\Interfaces\Question\QuestionRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Question\QuestionServiceInterface;
use Maatwebsite\Excel\Facades\Excel;

class QuestionService extends BaseService implements QuestionServiceInterface
{
    protected $questionRepository;
    public function __construct(
        QuestionRepositoryInterface $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'searchFields' => ['content'],
            'publish' => request('publish'),
        ];
        $select = ['id', 'content', 'type', 'topic_id'];
        $orderBy = ['id' => 'desc'];

        $data = request('pageSize') && request('page')
            ? $this->questionRepository->pagination($select, $condition, request('pageSize'), $orderBy, [], ['topic', 'answers'])
            : $this->questionRepository->all($select);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = request()->except('_token');
            $question = $this->questionRepository->create($payload);

            $this->createAnswersAndUpdateQuestionType($question, $payload);

            return successResponse('Thêm mới thành công.');
        }, 'Thêm mới thất bại.');
    }

    public function update($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $payload = request()->except('_token', '_method');

            $question = $this->questionRepository->save($id, $payload);
            $question->answers()->delete();

            $this->createAnswersAndUpdateQuestionType($question, $payload);

            return successResponse('Cập nhập thành công.');
        }, 'Cập nhập thất bại.');
    }

    private function createAnswers($question, array $answers): int
    {
        $countCorrectAnswer = 0;
        foreach ($answers as $answer) {
            $isCorrect = isset($answer['is_correct']) && $answer['is_correct'] == 'true' ? true : false;
            $countCorrectAnswer += $isCorrect ? 1 : 0;
            $question->answers()->create([
                'content' => $answer['content'],
                'is_correct' => $isCorrect,
            ]);
        }
        // dd($countCorrectAnswer);
        return $countCorrectAnswer;
    }

    private function createAnswersAndUpdateQuestionType($question, array $payload)
    {
        $countCorrectAnswer = $this->createAnswers($question, $payload['answers']);
        $question->type = $countCorrectAnswer === 1 ? '1' : '2';
        $question->save();
    }


    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->questionRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại.');
    }

    public function uploadQuestionWithFile()
    {
        return $this->executeInTransaction(function () {
            $file = request()->file('file');
            Excel::import(new QuestionImport, $file);

            return successResponse('Nhập câu hỏi thành công.');
        }, 'Nhập câu hỏi thất bại.');
    }
}
