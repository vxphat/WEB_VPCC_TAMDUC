<?php

namespace App\Http\Controllers\Backend;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use Illuminate\Http\Request;

use App\Services\Interfaces\PostServiceInterface as PostService;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    protected $postService;
    protected $postRepository;
    protected $postCatalogueRepository;
    protected $nestedset;

    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
        PostCatalogueRepository $postCatalogueRepository
    ) {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
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
        
        // $this->authorize('modules', 'post.index');
        $posts = $this->postService->paginate($request);
        // dd($posts);
        $dropdown = $this->nestedset->Dropdown();
        $config = $this->config();
        $config['model'] = 'Post';
        $config['modelCheck'] = 'Post';
        
        $config['seo'] = config('apps.messages.post');
        return view(
            'backend.post.post.index',
            compact(
                'config',
                'posts',
                'dropdown'
            )
        );
    }

    public function create()
    {
        // $this->authorize('modules', 'post.create');
        $config = $this->config();
        $dropdown = $this->nestedset->Dropdown();
        $config['seo'] = config('apps.messages.post');
        $config['method'] = 'create';
        $config['model'] = 'Post';
        return view(
            'backend.post.post.create',
            compact(
                'config',
                'dropdown'
            )
        );
    }

    public function store(StorePostRequest $request)
    {
        if ($this->postService->create($request)) {
            return redirect()->route('post.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('post.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'post.edit');
        $post = $this->postRepository->findById($id);
        $config = $this->config();
        $config['seo'] = config('apps.messages.post');
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();
        $config['model'] = 'Post';
        return view(
            'backend.post.post.create',
            compact(
                'config',
                'dropdown',
                'post',
            )
        );
    }

    public function update($id, UpdatePostRequest $request)
    {
        if ($this->postService->update($id, $request)) {
            return redirect()->route('post.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('post.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        // $this->authorize('modules', 'post.delete');
        $config['seo'] = config('apps.messages.post');
        $post = $this->postRepository->findById($id);
        return view(
            'backend.post.post.delete',
            compact(
                'post',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->postService->destroy($id)) {
            return redirect()->route('post.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('post.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function config()
    {
        return [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'backend/library/library.js',
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
