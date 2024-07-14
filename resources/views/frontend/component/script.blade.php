<script src="frontend/plugins/jQuery/jquery.min.js"></script>

<script src="frontend/plugins/bootstrap/bootstrap.min.js"></script>
@if (isset($config['js']) && is_array($config['js']))
    @foreach ($config['js'] as $key => $val)
        {!! '<script src="' . $val . '"></script>' !!}
    @endforeach
@endif
<script src="frontend/plugins/slick/slick.min.js"></script>
<script src="frontend/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="frontend/plugins/instafeed/instafeed.min.js"></script>
<script src="frontend/js/auth.js"></script>
<script src="frontend/js/comment.js"></script>
