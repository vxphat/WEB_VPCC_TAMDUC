<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentRepositoryInterface as CommentRepository;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use Illuminate\Http\Request;

use App\Services\Interfaces\PostServiceInterface as PostService;

class PostController extends Controller
{
    protected $postService;

    protected $postRepository;
    protected $commentRepository;

    public function __construct(
        PostService $postService,
        PostRepository $postRepository,
        CommentRepository $commentRepository
    ) {
        $this->postService = $postService;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;

    }

    public function show($catalogueCanonical, $postCanonical)
    {
        $agrument = [
            'condition' => [
                ['canonical', 'like', $postCanonical],
                ['publish', '=', 2]
            ],
            'flag' => true
        ];
        $post = $this->postRepository->findByCondition(...$agrument)->firstOrFail();
        $titleClient = $post->name;
        $comments = $this->commentRepository->findByCondition(...$this->agrumentComment($post->id));
        return view('frontend.post', compact('post', 'comments', 'titleClient'));
    }


    public function searchResult(Request $request)
    {
        $posts = $this->postService->paginate($request);
        //Tìm kiếm kết quả dựa trên keyword người dùng đã nhập vào
        return view(
            'frontend.search',
            compact(
                'posts',
            )
        );
    }

    public function agrumentComment($id)
    {
        return [
            'condition' => [
                ['post_id', '=', $id]
            ],
            'flag' => true
        ];
    }
}
