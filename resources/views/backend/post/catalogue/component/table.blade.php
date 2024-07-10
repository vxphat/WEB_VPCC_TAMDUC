<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th class="text-center">Hình ảnh </th>
            <th class="text-center">Tên danh mục</th>
            <th class="text-center">Đường dẫn</th>
            <th class="text-center" style="width: 400px">Mô tả </th>
            <th class="text-center" style="">Tùy chọn </th>
        </tr>
    </thead>
    <tbody>
        @if (isset($postCatalogues) && is_object($postCatalogues))
            @foreach ($postCatalogues as $postCatalogue)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $postCatalogue->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td class="text-center">
                        <img src="{{ $postCatalogue->image }}"  style="width: 50px; height: 50px;" alt="">
                    </td>
                    <td>
                        {{ str_repeat('|----', $postCatalogue->level > 0 ? $postCatalogue->level - 1 : 0) . $postCatalogue->name }}
                    </td>
                    <td class="text-center"> 
                        {{ $postCatalogue->canonical }}
                    </td>
                    <td>
                        {{ $postCatalogue->description }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('post.catalogue.edit', $postCatalogue->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <a href="{{ route('post.catalogue.delete', $postCatalogue->id) }}" class="btn btn-danger"><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{ $postCatalogues->links('pagination::bootstrap-4') }}
