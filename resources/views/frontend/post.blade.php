@extends('frontend.layout')

@section('clientContent')
    <div class="py-3"></div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-lg-9   mb-5 mb-lg-0">
                    <article>
                        <div class="post-slider mb-4">
                            <img src="{{ $post->image }}" class="card-img" alt="post-thumb">
                        </div>

                        <p style="font-size: 18px"><em>PHGMNHD NEWS: {{ $post->description}} </em></p>
                        <ul class="card-meta my-3 list-inline">
                            <li class="list-inline-item">
                                <a href="author-single.html" class="card-meta-author">
                                    <img src="images/john-doe.jpg">
                                    <span>{{ $post->user->name }}</span>
                                </a>
                            </li>
                            {{-- <li class="list-inline-item">
                            <i class="ti-timer"></i>2 Min To Read
                        </li> --}}
                            <li class="list-inline-item">
                                <i class="ti-calendar"></i>{{ $post->created_at }}
                            </li>
                            {{-- <li class="list-inline-item">
                            <ul class="card-meta-tag list-inline">
                                <li class="list-inline-item"><a href="tags.html">Color</a></li>
                                <li class="list-inline-item"><a href="tags.html">Recipe</a></li>
                                <li class="list-inline-item"><a href="tags.html">Fish</a></li>
                            </ul>
                        </li> --}}
                        </ul>
                        <div class="content">
                            {!! $post->content !!}
                        </div>
                        <div class="author-bottom text-right">
                            <h4>{{ $post->user->name }}</h4>
                        </div>
                    </article>

                </div>

                @php
                    $dataPost = $post->id ?? null;
                @endphp
                <div class="col-lg-9 col-md-12">
                    <div class="mb-5 border-top mt-4 pt-5">
                        <h3 class="mb-4">Comments</h3>
                        <div class="d-block mb-4 pb-4">
                            <div class="comments-head mb-3">
                                <textarea name="content" data-post="{{ $dataPost }}" data-id="{{ Auth::id() }}" class="form-control custom-area"
                                    placeholder="Bạn nghĩ gì về tin này?" id="" cols="30" rows="5"></textarea>
                            </div>
                            <div class="comments-body mb-4 d-flex justify-content-between">
                                <p class="comment-error"></p>
                                {{-- <p class="">Vui lòng gửi bình luận tiếng Việt có dấu</p> --}}
                                {{-- <button type="submit" class="btn btn-primary sendComment">Gửi bình luận</button> --}}
                            </div>
                            <div class="comments-footer">
                                @if (count($comments))
                                    <div class="media-content">
                                        <h4 class="mb-4">Tất cả bình luận</h4>
                                        <div class="tempComment"></div>
                                        @foreach ($comments as $comment)
                                            @php
                                                $commentId = $comment->id ?? null;
                                            @endphp
                                            <div data-comment="{{ $commentId }}"
                                                class="media commentData d-block d-sm-flex mb-4">
                                                <img src="{{ $comment->user->image }}" width="50px" height="50px"
                                                    class="mr-2 rounded-circle" alt="">
                                                <div class="media-body">
                                                    <p class="h4 d-inline-block mb-3">{{ $comment->user->name }}</p>

                                                    <p>{{ $comment->content }}</p>

                                                    <span
                                                        class="text-black-800 mr-3 font-weight-600">{{ $comment->updated_at }}</span>
                                                    {{-- <a class="text-primary mr-4 font-weight-600 replyComment">Trả lời</a> --}}
                                                    @if ($comment->user_id === Auth::id())
                                                        <a class="text-primary deleteComment font-weight-600">Xóa bình
                                                            luận</a>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="boxReplyComment-{{ $commentId }} d-block mb-4">
                                                
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="comment-empty">
                                        <p><i class="ti-flag-alt"></i></p>
                                        <span>Hiện chưa có bình luận nào, hãy trở thành người đầu tiên bình luận cho bài
                                            viết
                                            này!</span>
                                    </div>
                                @endif

                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
