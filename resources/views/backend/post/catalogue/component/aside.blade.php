<div class="ibox w">
    <div class="ibox-title">
        <h5>Danh mục cha</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notice">*Chọn root nếu không có danh mục cha</span>
                    <select name="parent_id" class="form-control setupSelect2" id="">
                        <option value="0">[Root]</option>
                        @foreach ($dropdown as $key => $val)
                            <option
                                {{ $key == old('parent_id', isset($postCatalogue->parent_id) ? $postCatalogue->parent_id : '') ? 'selected' : '' }}
                                value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
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
