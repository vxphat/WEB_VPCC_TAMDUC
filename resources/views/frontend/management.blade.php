@extends('frontend.layout')

@section('clientContent')
    <div class="py-3"></div>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 mb-4">
                    <h1 class="h2 mb-4">Quản lý tài khoản</h1>
                </div>
                <div class="col-lg-10">
                    <form action="{{ route('post.search') }}" class="widget-search">

                        <div class="row">
                            <input type="hidden" name="publish" value="2">

                            <div class="col-lg-6 mb-4">
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Họ và tên</label>
                                    <input type="text" class="form-control bd-1">
                                </div>
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Ảnh</label>
                                    <input type="text" class="form-control bd-1 upload-image" data-upload="Images">
                                </div>
                                <div class="form-input">
                                    <label for="" class="custom-label">Số điện thoại</label>
                                    <input type="text" class="form-control bd-1">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Email</label>
                                    <input type="text" class="form-control bd-1">
                                </div>
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Ngày sinh</label>
                                    <input type="date" class="form-control bd-1">
                                </div>
                                <div class="form-input">
                                    <label for="" class="custom-label">Ghi chú</label>
                                    <input type="text" class="form-control bd-1">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" style="">Search</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection
