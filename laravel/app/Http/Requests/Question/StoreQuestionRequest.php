<?php

namespace App\Http\Requests\Question;

use App\Enums\ResponseEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'content' => 'required',
            'type' => 'required',
            'topic_id' => 'required',
            'answers' => 'required|array',
        ];

        if ($this->has('answers')) {
            $answers = $this->input('answers');

            $hasCorrectAnswer = collect($answers)->contains(function ($answer) {
                return isset($answer['is_correct']) && $answer['is_correct'] == 'true';
            });

            if (!$hasCorrectAnswer) {
                $rules['is_correct'] = 'required';
            }
        }

        return $rules;
    }


    public function attributes()
    {
        return [
            'content' => 'Tên chủ đề',
            'type' => 'Chủ đề câu hỏi',
            'topic_id' => 'Chủ đề câu hỏi',
            'answers' => 'Câu trả lời',
        ];
    }

    public function messages()
    {
        return __('request.messages') + [
            'is_correct.required' => 'Bạn phải chọn ít nhất có 1 câu trả lời chính xác.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'messages' => $validator->errors(),
        ], ResponseEnum::UNPROCESSABLE_ENTITY));
    }
}
