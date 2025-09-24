<?php

namespace App\Services;

use App\Services\Interfaces\PostServiceInterface;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class LanguageService
 * @package App\Services
 */
class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;

    public function __construct(
        PostRepository $postRepository,
    ) {
        $this->postRepository = $postRepository;
    }

    public function paginate($request)
    {
        $perPage = ($request->integer('perpage') > 0) ? $request->integer('perpage') : 9;
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish') ?? 2
        ];

        // dd($condition);

        $rawQuery = $this->whereRaw($request);

        $extend = [
            'path' => 'post/index',
            'groupBy' => $this->paginateSelect()
        ];

        $joins = [
            ['post_catalogue_post as tb3', 'posts.id', '=', 'tb3.post_id'],
        ];

        $relations = ['post_catalogues'];
        $posts = $this->postRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            $extend,
            ['id', 'DESC'],
            $joins,
            $relations,
            $rawQuery
        );
        return $posts;
    }




    public function create($request)
    {
        DB::beginTransaction();
        try {
            $post = $this->createPost($request);
            if ($post->id > 0) {
                $this->updateCatalogueForPost($post, $request);
            }
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
            $post = $this->postRepository->findById($id);
            if ($this->uploadPost($post, $request)) {
                $this->updateCatalogueForPost($post, $request);
            }
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
            $post = $this->postRepository->forceDelete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e->getMessage());
            // echo $e->getMessage();die();
            return false;
        }
    }

    private function createPost($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $post = $this->postRepository->create($payload);
        return $post;
    }

    private function uploadPost($post, $request)
    {
        $payload = $request->only($this->payload());
        return $this->postRepository->update($post->id, $payload);
    }

    private function updateCatalogueForPost($post, $request)
    {
        $post->post_catalogue_post()->sync($this->catalogue($request));
    }


    private function catalogue($request)
    {
        if ($request->input('catalogue') != null) {
            return array_unique(array_merge($request->input('catalogue'), [$request->post_catalogue_id]));
        }
        return [$request->post_catalogue_id];
    }


    private function whereRaw($request)
    {
        $rawCondition = [];

        if ($request->integer('post_catalogue_id') > 0) {
            $rawCondition['whereRaw'] = [
                [
                    'tb3.post_catalogue_id IN (
                    SELECT id
                    FROM post_catalogues
                    WHERE lft >= (SELECT lft FROM post_catalogues as pc WHERE pc.id = ?)
                    AND rgt <= (SELECT rgt FROM post_catalogues as pc WHERE pc.id = ?)
                )',
                    [$request->integer('post_catalogue_id'), $request->integer('post_catalogue_id')]
                ]
            ];
        }

        return $rawCondition;
    }



    private function paginateSelect()
    {
        return [
            'id',
            'name',
            'image',
            'description',
            'content',
            'canonical',
            'view',
            'publish',
            'user_id',
            'posts.post_catalogue_id',
        ];
    }


    private function payload()
    {
        return [
            'name',
            'description',
            'content',
            'title',
            'canonical',
            'post_catalogue_id',
            'publish',
            'image',
        ];
    }


}
