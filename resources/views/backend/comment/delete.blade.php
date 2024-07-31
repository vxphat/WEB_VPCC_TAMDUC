@extends('backend.dashboard.layout')
@section('adminContent')
    @include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['delete']['title']])
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="box">
        @csrf
        @method('DELETE')
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel-head">
                        <div class="panel-title">Thông tin chung</div>
                        <div class="panel-description">
                            <p>Bạn đang muốn xóa bình luận của<span class="text-danger">{{ $comment->user->name }}</span></p>
                            <p>Sau khi xóa sẽ không thể khôi phục lại</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row mb15">
                                <div class="col-lg-12">
                                    <div class="form-row">
                                        <label for="" class="control-label text-left">Tên bản ghi
                                            <span class="text-danger">(*)</span></label>
                                        <input type="text" name="content" value="{{ old('name', $comment->content ?? '') }}"
                                            class="form-control" placeholder="" autocomplete="off" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right mb15">
                <button class="btn btn-danger" type="submit" name="send" value="send">Xóa dữ liệu</button>
            </div>
        </div>

    </form>

@endsection
