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
                    <form action="{{ route('client.update', $user->id) }}" method="POST" class="widget-search">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-4">
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Họ và tên</label>
                                    <input type="text" class="form-control bd-1" name="name"
                                        value="{{ $user->name }}">
                                </div>
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Ảnh</label>
                                    <input type="text" class="form-control bd-1 upload-image" data-upload="Images"
                                        name="image" value="{{ $user->image }}">
                                </div>
                                <div class="form-input">
                                    <label for="" class="custom-label">Số điện thoại</label>
                                    <input type="text" class="form-control bd-1" name="phone"
                                        value="{{ $user->phone }}">
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Email</label>
                                    <input type="text" class="form-control bd-1" name="email"
                                        value="{{ $user->email }}">
                                </div>
                                <div class="form-input mb-4">
                                    <label for="" class="custom-label">Ngày sinh</label>
                                    <input type="date" class="form-control bd-1" name="birthday"
                                        value="{{ date('Y-m-d', strtotime($user->birthday)) }}">
                                </div>
                                <div class="form-input">
                                    <label for="" class="custom-label">Ghi chú</label>
                                    <input type="text" class="form-control bd-1" name="description"
                                        value="{{ $user->description }}">
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
