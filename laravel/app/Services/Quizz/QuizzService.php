<?php
// Trong Laravel, Service Pattern thường được sử dụng để tạo các lớp service, giúp tách biệt logic của ứng dụng khỏi controller.
namespace App\Services\Quizz;

use App\Models\Answer;
use App\Models\Result;
use App\Repositories\Interfaces\Quizz\QuizzRepositoryInterface;
use App\Repositories\Interfaces\Quizz\ResultRepositoryInterface;
use App\Services\BaseService;
use App\Services\Interfaces\Quizz\QuizzServiceInterface;
use Illuminate\Support\Facades\DB;

class QuizzService extends BaseService implements QuizzServiceInterface
{
    protected $quizzRepository;
    protected $resultRepository;
    public function __construct(
        QuizzRepositoryInterface $quizzRepository,
        ResultRepositoryInterface $resultRepository
    ) {
        $this->quizzRepository = $quizzRepository;
        $this->resultRepository = $resultRepository;
    }
    public function paginate()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
        ];
        $select = ['id', 'title', 'description', 'image', 'canonical', 'publish', 'topic_id'];
        $relation = [
            [
                'questions' => function ($query) {
                    $query->with('answers', fn ($query) => $query->select(['id', 'content', 'question_id']));
                }
            ], 'topic'
        ];

        $data = request('pageSize') && request('page')
            ? $this->quizzRepository->pagination($select, $condition, request('pageSize'), [], [], $relation)
            : $this->quizzRepository->all($select, $relation);

        return $data;
    }

    public function historyUser()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'publish' => request('publish'),
            'where' => [
                'user_id' => ['=', auth()->user()->id]
            ],
        ];
        $select = ['id', 'score', 'correct', 'duration', 'quizz_id'];

        $relation = ['result_answers', 'quizz'];

        $data = request('pageSize') && request('page')
            ? $this->resultRepository->pagination($select, $condition, request('pageSize'), [], [], $relation)
            : $this->resultRepository->all($select, $relation);

        return $data;
    }
    public function history()
    {
        $condition = [
            'search' => addslashes(request('search')),
            'searchFields' => ['title'],
            'publish' => request('publish'),
        ];
        $select = ['id', 'score', 'correct', 'duration', 'quizz_id', 'user_id'];

        $relation = ['result_answers', 'quizz', 'user'];

        $data = $this->resultRepository->pagination($select, $condition, request('pageSize'), [], [], $relation);
        return $data;
    }

    public function historyDetail($id)
    {
        $relation = [
            'result_answers' => function ($query) {
                $query->with('question', function ($query) {
                    $query->with('answers');
                });
            }
        ];
        $data = $this->resultRepository->findById($id, ['*'], $relation);

        return $data;
    }

    public function create()
    {
        return $this->executeInTransaction(function () {
            $payload = request()->except('_token, _method');
            $quizz = $this->quizzRepository->create($payload);
            $quizz->questions()->sync($payload['question_ids']);

            return successResponse('Thêm mới thành công.');
        }, 'Thêm mới thất bại.');
    }


    public function update($id)
    {
        DB::beginTransaction();
        try {
            // Lấy ra tất cả các trường và loại bỏ 2 trường bên dưới
            $payload = request()->except('_token', '_method');

            $this->quizzRepository->update($id, $payload);

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


    public function handleMark()
    {
        return $this->executeInTransaction(function () {

            $payload = request()->except('_token', '_method');
            $payload['answers'] = json_decode($payload['answers'], true);
            $payload['user_id'] = auth()->user()->id;

            $answers = Answer::whereIn('id', $payload['answers'])->get();

            $correctCount = 0;
            $payloadResultAnswer = [];
            foreach ($answers as $key => $answer) {
                if ($answer->is_correct) {
                    $correctCount += 1;
                }
                $payloadResultAnswer[] = [
                    'question_id' => $answer->question_id,
                    'answer_id' => $answer->id,
                    'is_correct' => $answer->is_correct
                ];
            }

            $payload['score'] = $correctCount / count($answers) * 10;
            $payload['correct'] = "$correctCount/" . count($answers);

            $result = Result::create($payload);
            $result->result_answers()->createMany($payloadResultAnswer);

            return successResponse('Hoàn thành bài thi thành công.', $result);
        }, 'Hoàn thành bài thi thất bại');
    }


    public function destroy($id)
    {
        return $this->executeInTransaction(function () use ($id) {
            $this->quizzRepository->delete($id);
            return successResponse('Xóa thành công.');
        }, 'Xóa thất bại');
    }
}
