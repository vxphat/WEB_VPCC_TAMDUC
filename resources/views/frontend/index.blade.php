@extends('frontend.layout')

@section('clientContent')
    <!-- start of banner -->
    <div class="banner text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 mx-auto">
                    <h1 class="mb-5">What Would You <br> Like To Read Today?</h1>
                    <ul class="list-inline widget-list-inline">
                        @foreach ($postCatalogues as $postCatalogue)
                            <li class="list-inline-item"><a
                                    href="{{ $postCatalogue->canonical }}">{{ $postCatalogue->name }}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>


        <svg class="banner-shape-1" width="39" height="40" viewBox="0 0 39 40" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0.965848 20.6397L0.943848 38.3906L18.6947 38.4126L18.7167 20.6617L0.965848 20.6397Z" stroke="#040306"
                stroke-miterlimit="10" />
            <path class="path" d="M10.4966 11.1283L10.4746 28.8792L28.2255 28.9012L28.2475 11.1503L10.4966 11.1283Z" />
            <path d="M20.0078 1.62949L19.9858 19.3804L37.7367 19.4024L37.7587 1.65149L20.0078 1.62949Z" stroke="#040306"
                stroke-miterlimit="10" />
        </svg>

        <svg class="banner-shape-2" width="39" height="39" viewBox="0 0 39 39" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g filter="url(#filter0_d)">
                <path class="path"
                    d="M24.1587 21.5623C30.02 21.3764 34.6209 16.4742 34.435 10.6128C34.2491 4.75147 29.3468 0.1506 23.4855 0.336498C17.6241 0.522396 13.0233 5.42466 13.2092 11.286C13.3951 17.1474 18.2973 21.7482 24.1587 21.5623Z" />
                <path
                    d="M5.64626 20.0297C11.1568 19.9267 15.7407 24.2062 16.0362 29.6855L24.631 29.4616L24.1476 10.8081L5.41797 11.296L5.64626 20.0297Z"
                    stroke="#040306" stroke-miterlimit="10" />
            </g>
            <defs>
                <filter id="filter0_d" x="0.905273" y="0" width="37.8663" height="38.1979" filterUnits="userSpaceOnUse"
                    color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                    <feOffset dy="4" />
                    <feGaussianBlur stdDeviation="2" />
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                </filter>
            </defs>
        </svg>


        <svg class="banner-shape-3" width="39" height="40" viewBox="0 0 39 40" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path d="M0.965848 20.6397L0.943848 38.3906L18.6947 38.4126L18.7167 20.6617L0.965848 20.6397Z" stroke="#040306"
                stroke-miterlimit="10" />
            <path class="path" d="M10.4966 11.1283L10.4746 28.8792L28.2255 28.9012L28.2475 11.1503L10.4966 11.1283Z" />
            <path d="M20.0078 1.62949L19.9858 19.3804L37.7367 19.4024L37.7587 1.65149L20.0078 1.62949Z" stroke="#040306"
                stroke-miterlimit="10" />
        </svg>


        <svg class="banner-border" height="240" viewBox="0 0 2202 240" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M1 123.043C67.2858 167.865 259.022 257.325 549.762 188.784C764.181 125.427 967.75 112.601 1200.42 169.707C1347.76 205.869 1901.91 374.562 2201 1"
                stroke-width="2" />
        </svg>
    </div>
    
    <section class="section-sm">
        <div class="container">
            <div class="row justify-content-center">
                <aside class="col-lg-6 @@sidebar">

                    <!-- categories -->
                    {{-- <div class="widget widget-categories">
                        <h4 class="widget-title"><span>Categories</span></h4>
                        <ul class="list-unstyled widget-list">
                            <li><a href="tags.html" class="d-flex">Creativity <small class="ml-auto">(4)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Demo <small class="ml-auto">(1)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Elements <small class="ml-auto">(1)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Food <small class="ml-auto">(1)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Microwave <small class="ml-auto">(1)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Natural <small class="ml-auto">(3)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Newyork city <small class="ml-auto">(1)</small></a>
                            </li>
                            <li><a href="tags.html" class="d-flex">Nice <small class="ml-auto">(1)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Tech <small class="ml-auto">(2)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Videography <small class="ml-auto">(1)</small></a>
                            </li>
                            <li><a href="tags.html" class="d-flex">Vlog <small class="ml-auto">(1)</small></a></li>
                            <li><a href="tags.html" class="d-flex">Wondarland <small class="ml-auto">(1)</small></a></li>
                        </ul>
                    </div> --}}
                    <!-- tags -->
                    {{-- <div class="widget">
                        <h4 class="widget-title"><span>Tags</span></h4>
                        <ul class="list-inline widget-list-inline widget-card">
                            <li class="list-inline-item"><a href="tags.html">City</a></li>
                            <li class="list-inline-item"><a href="tags.html">Color</a></li>
                            <li class="list-inline-item"><a href="tags.html">Creative</a></li>
                            <li class="list-inline-item"><a href="tags.html">Decorate</a></li>
                            <li class="list-inline-item"><a href="tags.html">Demo</a></li>
                            <li class="list-inline-item"><a href="tags.html">Elements</a></li>
                            <li class="list-inline-item"><a href="tags.html">Fish</a></li>
                            <li class="list-inline-item"><a href="tags.html">Food</a></li>
                            <li class="list-inline-item"><a href="tags.html">Nice</a></li>
                            <li class="list-inline-item"><a href="tags.html">Recipe</a></li>
                            <li class="list-inline-item"><a href="tags.html">Season</a></li>
                            <li class="list-inline-item"><a href="tags.html">Taste</a></li>
                            <li class="list-inline-item"><a href="tags.html">Tasty</a></li>
                            <li class="list-inline-item"><a href="tags.html">Vlog</a></li>
                            <li class="list-inline-item"><a href="tags.html">Wow</a></li>
                        </ul>
                    </div> --}}
                    <!-- recent post -->
                    {{-- <div class="widget">
                        <h4 class="widget-title">Recent Post</h4>

                        <!-- post-item -->
                        <article class="widget-card">
                            <div class="d-flex">
                                <img class="card-img-sm" src="frontend/images/post/post-10.jpg">
                                <div class="ml-3">
                                    <h5><a class="post-title" href="post/elements/">Elements That You Can Use In This
                                            Template.</a></h5>
                                    <ul class="card-meta list-inline mb-0">
                                        <li class="list-inline-item mb-0">
                                            <i class="ti-calendar"></i>15 jan, 2020
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>

                        <article class="widget-card">
                            <div class="d-flex">
                                <img class="card-img-sm" src="frontend/images/post/post-3.jpg">
                                <div class="ml-3">
                                    <h5><a class="post-title" href="post-details.html">Advice From a Twenty Something</a>
                                    </h5>
                                    <ul class="card-meta list-inline mb-0">
                                        <li class="list-inline-item mb-0">
                                            <i class="ti-calendar"></i>14 jan, 2020
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>

                        <article class="widget-card">
                            <div class="d-flex">
                                <img class="card-img-sm" src="frontend/images/post/post-7.jpg">
                                <div class="ml-3">
                                    <h5><a class="post-title" href="post-details.html">Advice From a Twenty Something</a>
                                    </h5>
                                    <ul class="card-meta list-inline mb-0">
                                        <li class="list-inline-item mb-0">
                                            <i class="ti-calendar"></i>14 jan, 2020
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </article>
                    </div> --}}

                    <!-- Social -->
                    {{-- <div class="widget">
                            <h4 class="widget-title"><span>Social Links</span></h4>
                            <ul class="list-inline widget-social">
                                <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ti-linkedin"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="ti-youtube"></i></a></li>
                            </ul>
                        </div> --}}
                </aside>
                <div class="col-lg-12 mb-5 mb-lg-0">
                    <h2 class="h5 section-title">VĂN PHÒNG CÔNG CHỨNG TÂM ĐỨC</h2>
                    @foreach ($posts as $post)
                        <article class="card mb-4">
                            <div class="row card-body">
                                <div class="col-md-4 mb-4 mb-md-0">
                                    <div class="post-slider slider-sm">
                                        <img src="{{ $post->image }}" class="card-img" alt="post-thumb"
                                            style="height:200px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <h3 class="h3 mb-3"><a class="post-title"
                                            href="{{ route('post.show', ['catalogueCanonical' => $postCatalogue->canonical, 'postCanonical' => $post->canonical]) }}">{{ $post->name }}</a>
                                    </h3>
                                    <ul class="card-meta list-inline">
                                        <li class="list-inline-item">
                                            <a href="author-single.html" class="card-meta-author">
                                                <img src="{{ $post->user->image }}" alt="John Doe">
                                                <span>{{ $post->user->name }} </span>
                                            </a>
                                        </li>
                                        {{-- <li class="list-inline-item">
                                            <i class="ti-timer"></i>3 Min To Read
                                        </li> --}}
                                        <li class="list-inline-item">
                                            <i class="ti-calendar"></i>{{ $post->created_at }}
                                        </li>
                                       
                                    </ul>
                                    <p><em>{{ Str::words($post->description, 40, '...') }}</em></p>
                                    <a href="{{ route('post.show', ['catalogueCanonical' => $postCatalogue->canonical, 'postCanonical' => $post->canonical]) }}"
                                        class="btn btn-outline-primary">Xem thêm</a>
                                </div>
                            </div>
                        </article>
                    @endforeach

                    {{-- 
                    <ul class="pagination justify-content-center">
                        <li class="page-item page-item active ">
                            <a href="#!" class="page-link">1</a>
                        </li>
                        <li class="page-item">
                            <a href="#!" class="page-link">2</a>
                        </li>
                        <li class="page-item">
                            <a href="#!" class="page-link">&raquo;</a>
                        </li>
                    </ul> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
