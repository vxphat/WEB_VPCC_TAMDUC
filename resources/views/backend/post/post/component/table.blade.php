<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Tên bài viết</th>

            <th class="text-center" style="">Đường dẫn</th>
            <th class="text-center" style="width:100px;">View</th>
            <th class="text-center" style="">Người viết</th>
            <th class="text-center" style="width:100px;">Trạng thái</th>
            <th class="text-center" style="width:100px;">Tùy chọn</th>

        </tr>
    </thead>
    <tbody>
        @if (isset($posts) && is_object($posts))
            @foreach ($posts as $post)
                <tr id="{{ $post->id }}">
                    <td>
                        <input type="checkbox" value="{{ $post->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        <div class="uk-flex uk-flex-middle">
                            <div class="image mr5">
                                <div class="img-cover image-post"><img src="{{ $post->image }}" alt=""></div>
                            </div>
                            <div class="main-info">
                                <div class="name"><span class="maintitle">{{ $post->name }}</span></div>
                                <div class="catalogue">
                                    <span class="text-danger">Nhóm hiển thị: </span>
                                    @foreach ($post->post_catalogue_post as $val)
                                        <a href="{{ route('post.index', ['post_catalogue_id' => $val->id]) }}"
                                            title="">{{ $val->name }}</a>
                                    @endforeach
                                </div>

                            </div>
                        </div>
                    </td>
                    <td>
                        {{ $post->canonical }}
                    </td>
                    <td>
                        {{ $post->view }} views
                    </td>
                    <td>
                        {{ $post->user->name }}
                    </td>
                    <td class="text-center js-switch-{{ $post->id }}">
                        <input type="checkbox" value="{{ $post->publish }}" class="js-switch status "
                            data-field="publish" data-model="{{ $config['model'] }}" data-check="{{ $config['modelCheck'] }}"
                            {{ $post->publish == 2 ? 'checked' : '' }} data-modelId="{{ $post->id }}" />
                    </td>
                    <td class="text-center">
                        <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('post.delete', $post->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $posts->links('pagination::bootstrap-4') }}
