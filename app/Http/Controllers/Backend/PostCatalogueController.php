<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeletePostCatalogueRequest;
use Illuminate\Http\Request;
use App\Services\Interfaces\PostCatalogueServiceInterface as PostCatalogueService;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Http\Requests\StorePostCatalogueRequest;
use App\Http\Requests\UpdatePostCatalogueRequest;

class PostCatalogueController extends Controller
{
    protected $postCatalogueService;
    protected $postCatalogueRepository;
    protected $nestedset;


    public function __construct(
        PostCatalogueService $postCatalogueService,
        PostCatalogueRepository $postCatalogueRepository
    ) {
        $this->postCatalogueService = $postCatalogueService;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->initialize();
    }


    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'post_catalogues',
        ]);
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'post.catalogue.index');
        $postCatalogues = $this->postCatalogueService->paginate($request);
        $config = $this->config();
        $config['model'] = 'PostCatalogue';
        $config['modelCheck'] = 'Post_Catalogue';
        $config['seo'] = config('apps.messages.postCatalogue');
        return view(
            'backend.post.catalogue.index',
            compact(
                'config',
                'postCatalogues',
            )
        );
    }

    public function create()
    {
        // $this->authorize('modules', 'post.catalogue.create');
        $dropdown = $this->nestedset->Dropdown();
        $config = $this->config();
        $config['seo'] = config('apps.messages.postCatalogue');
        $config['method'] = 'create';
        $config['model'] = 'PostCatalogue';
        return view(
            'backend.post.catalogue.create',
            compact(
                'config',
                'dropdown'
            )
        );
    }

    public function store(StorePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->create($request)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'post.catalogue.edit');
        $postCatalogue = $this->postCatalogueRepository->findById($id);
        $dropdown = $this->nestedset->Dropdown();
        $config = $this->config();
        $config['seo'] = config('apps.messages.postCatalogue');
        $config['method'] = 'edit';
        $config['model'] = 'PostCatalogue';
        return view(
            'backend.post.catalogue.create',
            compact(
                'config',
                'postCatalogue',
                'dropdown'
            )
        );
    }

    public function update($id, UpdatePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->update($id, $request)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        // $this->authorize('modules', 'post.catalogue.delete');
        $config['seo'] = config('apps.messages.postCatalogue');
        $postCatalogue = $this->postCatalogueRepository->findById($id);
        return view(
            'backend.post.catalogue.delete',
            compact(
                'postCatalogue',
                'config',
            )
        );
    }

    public function destroy($id, DeletePostCatalogueRequest $request)
    {
        if ($this->postCatalogueService->destroy($id)) {
            return redirect()->route('post.catalogue.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('post.catalogue.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config()
    {
        return [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/library.js',
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]

        ];
    }

}
