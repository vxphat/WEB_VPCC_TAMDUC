<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class LanguageService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{

    public function __construct(
        // Nestedsetbie $nestedset
    ) {
    }

    // public function updateStatus($post = [])
    // {

    //     DB::beginTransaction();
    //     try {
    //         $checkModel = lcfirst($post['model']);
    //         $checkCatalogue = $post['modelCheck'];
    //         $parts = explode('_', $checkCatalogue);
    //         if (isset($parts[1])) {
    //             echo 1; die;
    //             $model = $checkModel . 'Repository';       //lcfirst(): Chuyển ký tự đầu tiên của chuỗi sang chữ thường
    //             $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
    //             //Cập nhật lại giá trị publish tương ứng 
    //             $language = $this->{$model}->update($post['modelId'], $payload);
    //             //Update id theo giá trị publish được thay đổi
    //         } else {
    //             $object = $this->{$checkModel . 'Repository'}->findById($post['modelId'], ['*'], ['' . $checkModel . '_catalogues']);
    //             if ($object->{$checkModel . '_catalogues'}->publish == 2) {

    //                 $model = $checkModel . 'Repository';        //lcfirst(): Chuyển ký tự đầu tiên của chuỗi sang chữ thường
    //                 $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
    //                 //Cập nhật lại giá trị publish tương ứng 
    //                 dd($payload[$post['field']]);
    //                 $language = $this->{$model}->update($post['modelId'], $payload);
    //                 //Update id theo giá trị publish được thay đổi
    //             }
    //         }
    //         ;


    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error($e->getMessage());
    //         echo $e->getMessage();
    //         die();
    //         return false;
    //     }
    // }


    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $model = lcfirst($post['model']) . 'Repository';
            $payload[$post['field']] = (($post['value'] == 1) ? 2 : 1);
            $language = $this->{$model}->update($post['modelId'], $payload);
            // $this->changeUserStatus($post, $payload[$post['field']]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    public function updateStatusAll($post)
    {
        DB::beginTransaction();
        try {
            $model = lcfirst($post['model']) . 'Repository';
            $payload[$post['field']] = $post['value'];
            $flag = $this->{$model}->updateByWhereIn('id', $post['id'], $payload);
            //Sử dụng updateByWhereIn và cập nhật toàn bộ dữ liệu 

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            echo $e->getMessage();
            die();
            return false;
        }
    }


    public function nestedset()
    {
        $this->nestedset->Get('level ASC, order ASC');
        $this->nestedset->Recursive(0, $this->nestedset->Set());
        $this->nestedset->Action();

    }

}
