<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostCatalogueController extends Controller
{
    protected $postRepository;
    protected $postCatalogueRepository;
    public function __construct(
        PostCatalogueRepository $postCatalogueRepository
    ) {
        $this->postCatalogueRepository = $postCatalogueRepository;
    }

    public function show($canonical)
    {
        $agrument = [
            'condition' => [
                ['canonical', 'like', $canonical]
            ],
            'flag' => true,
            'orderBy' => ['id', 'DESC'],
            'relation' => ['posts']
        ];
        $postCatalogue = $this->postCatalogueRepository->findByCondition(...$agrument)->firstOrFail();
        // dd($postCatalogue);
        $titleClient = $postCatalogue->name;
        $posts = $postCatalogue->posts()->where([
            ['publish', '=', 2]
        ])->get();
        return view('frontend.category', compact('posts', 'postCatalogue', 'titleClient'));
    }

    public function compose(View $view)
    {
        $postCatalogues = $this->postCatalogueRepository->all();
        //Lấy ra danh sách danh mục
        $view->with('postCatalogues', $postCatalogues);
        //Sử dụng ViewCompose để chia sẻ view với frontend.layout
    }

}
