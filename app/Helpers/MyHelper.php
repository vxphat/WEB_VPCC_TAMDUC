<?php

/*khai báo helper trong phần "files" của composer.json giúp các helper functions được tự động nạp khi ứng dụng khởi động */

if (!function_exists('recursive')) {        //Đảm bảo rằng hàm không bị định nghĩa lại nếu tệp được nạp nhiều lần
    function recursive($data, $parentId = 0)            //Định nghĩa một hàm trợ giúp có thể được sử dụng ở bất kỳ đâu trong ứng dụng
    {
        $temp = [];
        if (!is_null($data) && count($data)) {
            foreach ($data as $key => $val) {
                if ($val->parent_id == $parentId) {
                    $temp[] = [
                        'item' => $val,
                        'children' => recursive($data, $val->id)
                    ];
                }
            }
        }
        return $temp;
    }
}


if (!function_exists('frontend_recursive_menu')) {
    function frontend_recursive_menu($data, $type = 'html')
    {
        // dd($data);
        $html = '';
        if (count($data)) {
            if ($type == 'html') {
                $html = '<ul class="navbar-nav mx-auto">';
                foreach ($data as $key => $val) {
                    if ($val['children'] == []) {
                        $html .=
                            '<li class="nav-item">
                            <a class="nav-link" href="' . $val['item']->canonical . '">' . $val['item']->name . '</a>';
                    }
                    if ($val['children'] != []) {
                        $html .= '<li class="nav-item dropdown">
                        <a class="nav-link" href="' . $val['item']->canonical . '" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">' . $val['item']->name . '<i class="ti-angle-down ml-1"></i>
                        </a>';
                        $html .= frontend_recursive_children($val['children'], $type);
                    }
                    $html .= '</li>';
                }
                $html .= '</ul>';
                return $html;
            }
        }
        return $data;
    }
}

if (!function_exists('frontend_recursive_children')) {
    function frontend_recursive_children($data, $type = 'html')
    {
        // dd($data);
        $html = '';
        $html .= '
        <div class="dropdown-menu">
        ';
        foreach ($data as $key => $val) {
            $html .=
                '
                    <a class="dropdown-item" href="' . $val['item']->canonical . '">' . $val['item']->name . '</a>
                ';
        }
        $html .= '
        </div>';
        return $html;
    }
}

if (!function_exists('createSlug')) {
    function createSlug($string)
    {
        // Chuyển đổi chuỗi sang chữ thường
        $string = strtolower($string);

        // Chuyển đổi các ký tự có dấu thành không dấu
        $unwantedArray = dataConvert();
        $string = strtr($string, $unwantedArray);

        // Loại bỏ các ký tự đặc biệt và thay thế khoảng trắng bằng dấu gạch ngang
        $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
        $string = preg_replace('/\s+/', '-', $string);
        $string = trim($string, '-');

        return $string;
    }
}

if (!function_exists('dataConvert')) {
    function dataConvert()
    {
        return [
            'à' => 'a',
            'á' => 'a',
            'ả' => 'a',
            'ã' => 'a',
            'ạ' => 'a',
            'ă' => 'a',
            'ằ' => 'a',
            'ắ' => 'a',
            'ẳ' => 'a',
            'ẵ' => 'a',
            'ặ' => 'a',
            'â' => 'a',
            'ầ' => 'a',
            'ấ' => 'a',
            'ẩ' => 'a',
            'ẫ' => 'a',
            'ậ' => 'a',
            'è' => 'e',
            'é' => 'e',
            'ẻ' => 'e',
            'ẽ' => 'e',
            'ẹ' => 'e',
            'ê' => 'e',
            'ề' => 'e',
            'ế' => 'e',
            'ể' => 'e',
            'ễ' => 'e',
            'ệ' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',
            'ị' => 'i',
            'ò' => 'o',
            'ó' => 'o',
            'ỏ' => 'o',
            'õ' => 'o',
            'ọ' => 'o',
            'ô' => 'o',
            'ồ' => 'o',
            'ố' => 'o',
            'ổ' => 'o',
            'ỗ' => 'o',
            'ộ' => 'o',
            'ơ' => 'o',
            'ờ' => 'o',
            'ớ' => 'o',
            'ở' => 'o',
            'ỡ' => 'o',
            'ợ' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'ủ' => 'u',
            'ũ' => 'u',
            'ụ' => 'u',
            'ư' => 'u',
            'ừ' => 'u',
            'ứ' => 'u',
            'ử' => 'u',
            'ữ' => 'u',
            'ự' => 'u',
            'ỳ' => 'y',
            'ý' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',
            'ỵ' => 'y',
            'đ' => 'd',
            'À' => 'a',
            'Á' => 'a',
            'Ả' => 'a',
            'Ã' => 'a',
            'Ạ' => 'a',
            'Ă' => 'a',
            'Ằ' => 'a',
            'Ắ' => 'a',
            'Ẳ' => 'a',
            'Ẵ' => 'a',
            'Ặ' => 'a',
            'Â' => 'a',
            'Ầ' => 'a',
            'Ấ' => 'a',
            'Ẩ' => 'a',
            'Ẫ' => 'a',
            'Ậ' => 'a',
            'È' => 'e',
            'É' => 'e',
            'Ẻ' => 'e',
            'Ẽ' => 'e',
            'Ẹ' => 'e',
            'Ê' => 'e',
            'Ề' => 'e',
            'Ế' => 'e',
            'Ể' => 'e',
            'Ễ' => 'e',
            'Ệ' => 'e',
            'Ì' => 'i',
            'Í' => 'i',
            'Ỉ' => 'i',
            'Ĩ' => 'i',
            'Ị' => 'i',
            'Ò' => 'o',
            'Ó' => 'o',
            'Ỏ' => 'o',
            'Õ' => 'o',
            'Ọ' => 'o',
            'Ô' => 'o',
            'Ồ' => 'o',
            'Ố' => 'o',
            'Ổ' => 'o',
            'Ỗ' => 'o',
            'Ộ' => 'o',
            'Ơ' => 'o',
            'Ờ' => 'o',
            'Ớ' => 'o',
            'Ở' => 'o',
            'Ỡ' => 'o',
            'Ợ' => 'o',
            'Ù' => 'u',
            'Ú' => 'u',
            'Ủ' => 'u',
            'Ũ' => 'u',
            'Ụ' => 'u',
            'Ư' => 'u',
            'Ừ' => 'u',
            'Ứ' => 'u',
            'Ử' => 'u',
            'Ữ' => 'u',
            'Ự' => 'u',
            'Ỳ' => 'y',
            'Ý' => 'y',
            'Ỷ' => 'y',
            'Ỹ' => 'y',
            'Ỵ' => 'y',
            'Đ' => 'd'
        ];
    }
}


