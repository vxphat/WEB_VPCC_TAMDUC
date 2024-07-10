<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | Register</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style>
        .mt-5 {
            margin-top: 10em;
        }
    </style>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div class="mt-5">
            <div>


            </div>
            <h3>Đổi mật khẩu mới</h3>
            <p>Nhập mật khẩu bạn muốn thay đổi:</p>
            <form class="m-t" role="form" method="POST"
                action="{{ route('password.confirmReset', ['email'=> $email]) }}">
                @csrf
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="rePassword" class="form-control" placeholder="Nhập lại mật khẩu"
                        required="">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Đổi mật khẩu</button>

            </form>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
</body>

</html>
