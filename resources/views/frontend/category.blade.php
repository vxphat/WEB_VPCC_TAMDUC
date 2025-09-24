@extends('frontend.layout')

@section('clientContent')
    <div class="py-3"></div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 mb-4">
                    <h1 class="h2 mb-4">
                        <mark>{{ $postCatalogue->name }}</mark>
                    </h1>
                </div>
                @if (count($posts))
                    <div class="col-lg-10">
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
                                        <h3 class="h4 mb-3"><a class="post-title"
                                                href="{{ route('post.show', ['catalogueCanonical' => $postCatalogue->canonical, 'postCanonical' => $post->canonical]) }}">{{ $post->name }}</a>
                                        </h3>
                                        <ul class="card-meta list-inline">
                                            <li class="list-inline-item">
                                                <a href="author-single.html" class="card-meta-author">
                                                    <img src="{{ $post->user->image }}" alt="">
                                                    <span>{{ $post->user->name }}</span>
                                                </a>
                                            </li>
                                            {{-- <li class="list-inline-item">
                                        <i class="ti-timer"></i>3 Min To Read
                                    </li> --}}
                                            <li class="list-inline-item">
                                                <i class="ti-calendar"></i>{{ $post->created_at }}
                                            </li>
                                            {{-- <li class="list-inline-item">
                                        <ul class="card-meta-tag list-inline">
                                            <li class="list-inline-item"><a href="tags.html">Demo</a></li>
                                            <li class="list-inline-item"><a href="tags.html">Elements</a></li>
                                        </ul>
                                    </li> --}}
                                        </ul>
                                        <p><em>{{$post->description}}</em></p>
                                        <a href="{{ route('post.show', ['catalogueCanonical' => $postCatalogue->canonical, 'postCanonical' => $post->canonical]) }}"
                                            class="btn btn-outline-primary">Đọc thêm</a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                        {{-- <div class="pagination justify-content-center">
                            {{ $posts->links('pagination::bootstrap-4') }}
                        </div> --}}
                    </div>
                @else
                    <div class="col-lg-10 text-center">
                        <img class="mb-5" src="frontend/images/no-search-found.svg" alt="">
                        <h3>Không có kết quả</h3>
                    </div>
                @endif
            </div>
        </div>
    </section>

@endsection
