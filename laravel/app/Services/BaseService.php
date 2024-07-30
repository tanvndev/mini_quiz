<?php

namespace App\Services;

use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class BaseService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    public function __construct()
    {
    }

    protected  function convertToCode($str)
    {
        $newStr = Str::slug($str);
        $newStr = strtoupper(str_replace('-', '', $newStr));
        $newStr .= rand(0, 1000);
        return $newStr;
    }


    protected function formatJson($payload, $inputName)
    {
        // Lấy ra payload từ form
        if (isset($payload[$inputName]) && !empty($payload[$inputName])) {
            $payload[$inputName] = json_encode($payload[$inputName]);
        }
        return $payload;
    }

    public function updateStatus()
    {
        DB::beginTransaction();
        try {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';

            $payload[request('field')] = request('value');
            $this->{$repositoryName}->update(request('modelId'), $payload);

            DB::commit();
            return successResponse('Cập nhập trạng thái thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return errorResponse('Cập nhập trạng thái thất bại.');
        }
    }

    public function updateStatusMultiple()
    {
        DB::beginTransaction();
        try {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';

            $payload[request('field')] = request('value');
            $this->{$repositoryName}->updateByWhereIn('id', request('modelIds'), $payload);

            DB::commit();
            return successResponse('Cập nhập trạng thái thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return errorResponse('Cập nhập trạng thái thất bại.');
        }
    }

    public function deleteMultiple()
    {
        DB::beginTransaction();
        try {
            $repositoryName = lcfirst(request('modelName')) . 'Repository';
            $this->{$repositoryName}->deleteByWhereIn('id', request('modelIds'));

            DB::commit();
            return successResponse('Xoá thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return errorResponse('Xóa thất bại.');
        }
    }
}
