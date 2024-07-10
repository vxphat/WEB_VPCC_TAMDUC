<?php

namespace App\Providers;

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostCatalogueController;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    //Khai Báo Interface và Implementation
    public $bindings = [        
        'App\Services\Interfaces\UserCatalogueServiceInterface' => 'App\Services\UserCatalogueService',
        'App\Repositories\Interfaces\UserCatalogueRepositoryInterface' => 'App\Repositories\UserCatalogueRepository',

        'App\Services\Interfaces\UserServiceInterface' => 'App\Services\UserService',
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\UserRepository',

        'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',
        'App\Repositories\Interfaces\DistrictRepositoryInterface' => 'App\Repositories\DistrictRepository',

        'App\Services\Interfaces\PostCatalogueServiceInterface' => 'App\Services\PostCatalogueService',
        'App\Repositories\Interfaces\PostCatalogueRepositoryInterface' => 'App\Repositories\PostCatalogueRepository',

        'App\Services\Interfaces\PostServiceInterface' => 'App\Services\PostService',
        'App\Repositories\Interfaces\PostRepositoryInterface' => 'App\Repositories\PostRepository',

        'App\Services\Interfaces\CommentServiceInterface' => 'App\Services\CommentService',
        'App\Repositories\Interfaces\CommentRepositoryInterface' => 'App\Repositories\CommentRepository',

        //Việc đăng ký các interface và implementation trong container của Laravel cho phép framework này biết cách tạo ra các instance của các class khi cần thiết.
    ];
    /**
     * Register any application services.
     */
    public function register(): void            //register Method: Đây là nơi đăng ký các bindings trong ứng dụng.
    {
        //Đăng Ký Binding trong Service Provider
        foreach ($this->bindings as $key => $val) {
            $this->app->bind($key, $val);
            //bạn đăng ký các interface và lớp cụ thể của chúng bằng bind, giúp Laravel biết cách cung cấp các instance của lớp cụ thể khi một interface được yêu cầu
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('frontend.layout', function ($view) {      //Đăng ký một view composer cho view frontend.layout
            app(HomeController::class)->compose($view);
            //Sử dụng hàm app() để tạo một instance của HomeController và gọi method compose trên nó, truyền vào đối tượng view hiện tại.
        });


        view()->composer('frontend.search', function ($view) {      //Đăng ký một view composer cho view frontend.layout
            app(PostCatalogueController::class)->compose($view);
            //Sử dụng hàm app() để tạo một instance của HomeController và gọi method compose trên nó, truyền vào đối tượng view hiện tại.
        });

        Schema::defaultStringLength(191);
    }


    /*Tại sao truyền được dữ liệu???
    View Composer: Laravel view composers là một cách mạnh mẽ để tự động truyền dữ liệu vào view mỗi khi nó được render. 
    Bằng cách đăng ký một view composer trong AppServiceProvider, Laravel sẽ gọi function đó mỗi lần view được render.
    */
}
