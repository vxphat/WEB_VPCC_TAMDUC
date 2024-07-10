@if (!isset($offTitle))
    <div class="row mb15">
        <div class="col-lg-12">
            <div class="form-row">
                <label for="" class="control-label text-left">{{ $config['seo']['messages']['title'] }}<span
                        class="text-danger">(*)</span></label>
                <input type="text" name="name" value="{{ old('name', $model->name ?? '') }}" class="form-control"
                    placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
            </div>
        </div>
    </div>
@endif
<div class="row mb30">
    <div class="col-lg-12">
        <div class="form-row">
            <label for=""
                class="control-label text-left">{{ $config['seo']['messages']['description'] }}</label>
            <textarea name="description" class="custom-area form-control" {{ isset($disabled) ? 'disabled' : '' }}
                data-height="100">{{ old('description', $model->description ?? '') }}</textarea>
        </div>
    </div>
</div>
@if (!isset($offContent))
    <div class="row">
        <div class="col-lg-12">
            <div class="form-row">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <label for=""
                        class="control-label text-left">{{ $config['seo']['messages']['content'] }}<span
                            class="text-danger">(*)</span> </label>
                </div>
                <textarea name="content" class="form-control ck-editor" placeholder="" autocomplete="off" id="ckContent"
                    data-height="500" {{ isset($disabled) ? 'disabled' : '' }}>{{ old('content', $model->content ?? '') }}</textarea>
            </div>
        </div>
    </div>
@endif
@if (!isset($offCanonical))
    <div class="row">
        <div class="col-lg-12">
            <div class="form-row">
                <label for="" class="control-label text-left">{{ $config['seo']['messages']['canonical'] }}<span
                        class="text-danger">(*)</span></label>
                <input type="text" name="canonical" value="{{ old('canonical', $model->canonical ?? '') }}"
                    class="form-control inputCanonical" placeholder="" autocomplete="off" {{ isset($disabled) ? 'disabled' : '' }}>
            </div>
        </div>
    </div>
@endif
