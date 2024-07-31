<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAccountRequest;
use App\Mail\SendMail;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface as PostCatalogueRepository;
use App\Repositories\Interfaces\PostRepositoryInterface as PostRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;
use App\Services\Interfaces\UserServiceInterface as UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class HomeController extends Controller
{
    protected $postRepository;
    protected $postCatalogueRepository;
    protected $userRepository;
    protected $userService;
    public function __construct(
        PostRepository $postRepository,
        PostCatalogueRepository $postCatalogueRepository,
        UserRepository $userRepository,
        UserService $userService
    ) {
        $this->postRepository = $postRepository;
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function index()
    {
        // dd(Auth::id());
        $posts = $this->postRepository->findByCondition(...$this->agrumentPost());
        //lấy thông danh sách bài viết
        $users = $this->userRepository->findByCondition(...$this->agrumentUsers());
        //Lấy danh sách User, có role là cộng tác viên bài viết
        $perpage = 10;
        $postCatalogues = $this->postCatalogueRepository->paginate($perpage);
        //Lấy ra 10 danh mục
        return view('frontend.index', compact('posts', 'postCatalogues', 'users'));
    }


    public function compose(View $view)
    {
        $postCatalogues = $this->postCatalogueRepository->all();
        $listMenu = recursive($postCatalogues);         //Convert lại mảng danh mục lấy được
        $html = frontend_recursive_menu($listMenu);     //Tạo html từ mảng đã convert
        $view->with('html', $html);                     //Trả ra view
    }

    public function successMail(Request $request)
    {
        $data = [];
        $to = $request->input('email');     //Lấy địa chỉ Email người dùng nhập vào
        Mail::to($to)->send(new SendMail($data));       //Gọi đến send Mail
        return redirect()->route('home.index')->with('success', 'Gửi email nhận thông tin thành công!');
    }


    public function managerAccount($name, $id)
    {
        $user = $this->userRepository->findByCondition(...$this->agrumentUserDetail($id));
        $config = $this->config();
        return view('frontend.management', compact('config', 'user'));
    }

    public function updateAccount($id, UpdateAccountRequest $request)
    {
        if ($this->userService->update($id, $request)) {
            return redirect()->route('home.index')->with('success', 'Cập nhật tài khoản thành công');
        }
        return redirect()->route('home.index')->with('error', 'Cập nhật tài khoản không thành công. Hãy thử lại');
    }


    private function agrumentPost()
    {
        return [
            'condition' => [
                ['publish', '=', 2]
            ],
            'flag' => true,
            'orderBy' => ['id', 'DESC'],
            'param' => [
                'perpage' => 10
            ]
        ];
    }

    private function agrumentUsers()
    {
        return [
            'condition' => [
                ['user_catalogue_id', '=', 3]
            ],
            'flag' => true,
            'orderBy' => ['id', 'DESC'],
        ];
    }

    private function agrumentUserDetail($id)
    {
        return [
            'condition' => [
                ['id', '=', $id]
            ],
            'flag' => false,
        ];
    }



    private function config()
    {
        return [

            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/library.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/location.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
        ];
    }
}
