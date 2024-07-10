<?php

namespace App\Services;

use App\Services\Interfaces\CommentServiceInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface as CommentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Class CommentService
 * @package App\Services
 */
class CommentService extends BaseService implements CommentServiceInterface
{
    protected $commentRepository;


    public function __construct(
        CommentRepository $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
    }



    // public function paginate($request)
    // {
    //     $condition['keyword'] = addslashes($request->input('keyword'));
    //     $condition['publish'] = $request->integer('publish');
    //     $perPage = ($request->integer('perpage') > 0) ? $request->integer('perpage') : 9;
    //     $users = $this->commentRepository->pagination(
    //         $this->paginateSelect(),
    //         $condition,
    //         $perPage,
    //         ['path' => 'user/index'],
    //     );

    //     return $users;
    // }

    public function send($request)
    {
        DB::beginTransaction();
        try {

            $payload = $request->only($this->payload());
            $comment = $this->commentRepository->create($payload);
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


    public function update($id, $request)
    {
        DB::beginTransaction();
        try {

            $payload = $request->except(['_token', 'send']);
            if ($payload['birthday'] != null) {
                $payload['birthday'] = $this->convertBirthdayDate($payload['birthday']);
            }
            $user = $this->commentRepository->update($id, $payload);
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = $this->commentRepository->delete($id);

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


    private function payload()
    {
        return [
            'content',
            'post_id',
            'user_id',
        ];
    }
    private function paginateSelect()
    {
        return [
            'id',
            'email',
            'phone',
            'address',
            'name',
            'publish',
            'user_catalogue_id'
        ];
    }


}
