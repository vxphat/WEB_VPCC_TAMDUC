<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Người bình luận </th>
            <th class="text-center">Nội dung</th>
            <th class="text-center">Bài viết</th>
            <th class="text-center" style="">Tùy chọn </th>
        </tr>
    </thead>
    <tbody>
        @if (isset($comments) && is_object($comments))
            @foreach ($comments as $comment)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $comment->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td class="text-center">
                        {{ $comment->user->name }}
                    </td>
                    <td>
                        {{ $comment->content }}
                    </td>
                    <td class="text-center">
                        {{ $comment->post->name }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('comment.delete', $comment->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $comments->links('pagination::bootstrap-4') }}
