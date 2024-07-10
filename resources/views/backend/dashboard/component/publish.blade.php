<div class="ibox w">
    <div class="ibox-title">
        <h5>Thêm ảnh đại diện </h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="image img-cover image-target"><img
                            src="{{ old('image', $model->image ?? '') ? old('image', $model->image ?? '') : 'backend/img/not-found.png' }}"
                            alt=""></span>
                    <input type="hidden" name="image" value="{{ old('image', $model->image ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>Chọn tình trạng</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <div class="mb15">
                        <select name="publish" class="form-control setupSelect2" id="">
                            @foreach (config('apps.setup.publish') as $key => $val)
                                <option
                                    {{ $key == old('publish', isset($model->publish) ? $model->publish : '') ? 'selected' : '' }}
                                    value="{{ $key }}">{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
