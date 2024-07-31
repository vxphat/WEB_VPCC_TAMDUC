<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CommentRepositoryInterface as CommentRepository;
use App\Services\Interfaces\CommentServiceInterface as CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $commentService;
    protected $commentRepository;

    public function __construct(
        CommentRepository $commentRepository,
        CommentService $commentService
    ) {
        $this->commentRepository = $commentRepository;
        $this->commentService = $commentService;

    }

    public function index(Request $request)
    {
        $comments = $this->commentService->paginate($request);
        $config = $this->config();
        $config['model'] = 'Comment';

        $config['seo'] = config('apps.messages.comment');
        return view(
            'backend.comment.index',
            compact(
                'config',
                'comments',
            )
        );
    }


    public function delete($id)
    {
        $config['seo'] = config('apps.messages.comment');
        $comment = $this->commentRepository->findById($id);
        return view(
            'backend.comment.delete',
            compact(
                'comment',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->commentService->destroy($id)) {
            return redirect()->route('comment.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('comment.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
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
