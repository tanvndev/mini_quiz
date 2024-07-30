<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Question;

use App\Repositories\Interfaces\Question\QuestionRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Question\QuestionServiceInterface;
use Illuminate\Support\Facades\DB;

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
            'publish' => request('publish')
        ];
        $select = ['id', 'name', 'publish', 'description', 'canonical'];
        $orderBy = ['id' => 'desc'];

        $questions = request('pageSize') && request('page')
            ? $this->questionRepository->pagination($select, $condition, request('pageSize'), $orderBy)
            : $this->questionRepository->all($select);

        $questions->transform(function ($question) {
            $question->key = $question->id;
            return $question;
        });

        return $this->successResponse('', $questions);
    }

    public function create()
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ trường bên dưới
            $payload = request()->except('_token');
            $question = $this->questionRepository->create($payload);

            $countCorrectAnswer = $this->createAnswers($question, $payload['answers'] ?? []);

            $question->type = $countCorrectAnswer === 1 ? 'single_choice' : 'multi_choice';
            $question->save();

            DB::commit();
            return $this->successResponse('Thêm mới thành công.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return $this->errorResponse('Thêm mới thất bại.');
        }
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

    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');

            $this->questionRepository->update($id, $payload);

            DB::commit();
            return $this->successResponse('Thêm mới thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Thêm mới thất bại.');
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->questionRepository->delete($id);

            DB::commit();
            return $this->successResponse('Thêm mới thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Thêm mới thất bại.');
        }
    }
}
