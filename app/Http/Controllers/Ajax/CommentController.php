<?php

namespace App\Http\Controllers\Ajax;

use App\Classes\Nestedsetbie;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface as CommentRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\CommentServiceInterface as CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    protected $commentService;
    protected $commentRepository;
    protected $userRepository;
    protected $nestedset;
    // 

    public function __construct(
        CommentService $commentService,
        CommentRepository $commentRepository,
        UserRepository $userRepository

    ) {
        $this->commentService = $commentService;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->initialize();
    }


    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'comments',
        ]);
    }

    public function send(Request $request)
    {
        $option = $request->all();
        $comment = $this->commentService->send($request);

        $params = ['table' => 'comments'];  // Đảm bảo bảng 'comments' tồn tại trong cơ sở dữ liệu của bạn
        $nestedSet = new Nestedsetbie($params);
        $data = $nestedSet->GetCommentFirst();

        if ($comment !== FALSE) {
            return response()->json([
                'code' => 0,
                'data' => $data
            ]);
        }
        return response()->json([

            'code' => 1,
            'message' => 'Có vấn đề xảy ra, hãy thử lại!',
        ]);
    }


    public function delete(Request $request)
    {
        $option = $request->all();
        $params = ['table' => 'comments'];  // Đảm bảo bảng 'comments' tồn tại trong cơ sở dữ liệu của bạn
        $nestedSet = new Nestedsetbie($params);
        $listCommentDelete = $this->nestedset->getCommentIdsAndDescendantIds($option['comment_id']);
        $deleted = Comment::whereIn('id', $listCommentDelete)->delete();
        if ($deleted !== FALSE) {
            return response()->json([
                'code' => 0,
                'message' => 'Xóa thành công bình luận!'
            ]);
        }
        return response()->json([

            'code' => 1,
            'message' => 'Có vấn đề xảy ra, hãy thử lại!',
        ]);
    }
}
