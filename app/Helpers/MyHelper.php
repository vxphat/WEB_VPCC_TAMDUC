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



