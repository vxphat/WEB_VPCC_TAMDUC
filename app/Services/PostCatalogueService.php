<?php

namespace App\Services;

use App\Services\Interfaces\PostCatalogueServiceInterface;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Repositories\Interfaces\RouterRepositoryInterface as RouterRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Classes\Nestedsetbie;

/**
 * Class LanguageService
 * @package App\Services
 */
class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;

    public function __construct(
        PostCatalogueRepository $postCatalogueRepository,
    ) {
        $this->postCatalogueRepository = $postCatalogueRepository;
    }



    public function paginate($request)
    {
        $perPage = ($request->integer('perpage') > 0) ? $request->integer('perpage') : 9;
        $condition = [
            'keyword' => addslashes($request->input('keyword')),
            'publish' => $request->integer('publish'),
        ];
        // dd($condition, $perPage);
        $postCatalogues = $this->postCatalogueRepository->pagination(
            $this->paginateSelect(),
            $condition,
            $perPage,
            ['path' => 'post/catalogue/index'],
            ['lft', 'ASC'],
        );
        return $postCatalogues;
    }



    public function create($request)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->createCatalogue($request);
            if ($postCatalogue->id > 0) {
                $this->nestedset = new Nestedsetbie([
                    'table' => 'post_catalogues',
                ]);

                $this->nestedset();
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
            $postCatalogue = $this->postCatalogueRepository->findById($id);
            $flag = $this->updateCatalogue($postCatalogue, $request);
            if ($flag == TRUE) {
                $this->nestedset = new Nestedsetbie([
                    'table' => 'post_catalogues'
                ]);
                $this->nestedset();
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
            $postCatalogue = $this->postCatalogueRepository->forceDelete($id);
            $this->nestedset = new Nestedsetbie([
                'table' => 'post_catalogues'
            ]);
            $this->nestedset();
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


    private function createCatalogue($request)
    {
        $payload = $request->only($this->payload());
        $postCatalogue = $this->postCatalogueRepository->create($payload);
        return $postCatalogue;
    }


    private function updateCatalogue($postCatalogue, $request)
    {
        $payload = $request->only($this->payload());
        $flag = $this->postCatalogueRepository->update($postCatalogue->id, $payload);
        return $flag;
    }


    private function paginateSelect()
    {
        return [
            'id',
            'name',
            'description',
            'canonical',
            'level',
            'order',
            'parent_id',
            'image',
        ];
    }

    private function payload()
    {
        return [
            'name',
            'description',
            'canonical',
            'parent_id',
            'image',
        ];
    }

}
