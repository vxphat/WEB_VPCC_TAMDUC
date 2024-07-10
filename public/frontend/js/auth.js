(function ($) {
    "use strict";
    var PMD = {};
    var _token = $('meta[name="csrf-token"]').attr('content');

    PMD.checkLogin = () => {
        $(document).on('click', '.btnLogin', function (e) {
            e.preventDefault();
            let _this = $(this)
            let option = {
                'email': $('input[name=email]').val(),
                'password': $('input[name=password]').val(),
                '_token': _token
            }
            $.ajax({
                url: 'ajax/login/clientLogin',
                type: 'POST',
                data: option,
                dataType: 'json',
                success: function (res) {
                    if (res.code == 0) {
                        $('#myModal').css('display', 'none')
                        $('#myModal').html('')
                        $('body').removeClass('no-scroll');
                        Swal.fire({
                            title: "Good job!",
                            text: res.message,
                            icon: "success"
                        });
                        // Sử dụng setTimeout để đợi 2 giây trước khi tải lại trang
                        setTimeout(function () {
                            location.reload(); // Load lại trang
                        }, 1000); // 2000 milliseconds = 2 giây
                    }

                    if (res.code == 1) {
                        Swal.fire({
                            title: "Good job!",
                            text: res.message,
                            icon: "error"
                        });
                    }
                },
                beforeSend: function () {
                    $('.error-message').html('')
                },
                error: function (jqXHR, textStatus, errorThrown) {

                    if (jqXHR.status == 422) {
                        let errors = jqXHR.responseJSON.errors
                        for (let field in errors) {
                            let errorMessage = errors[field]
                            errorMessage.forEach(function (message) {
                                $('.error-message-' + field).html(message)
                            });
                        }
                    }
                }
            });
        })
    }


    PMD.openModal = () => {
        $(document).on('click', '#openModal', function () {
            $('#myModal').css('display', 'flex')
            $('#myModal').append(PMD.renderFormLogin())
            $('body').addClass('no-scroll');
        })
    }


    PMD.closeModal = () => {
        $(document).on('click', '.close', function () {
            $('#myModal').css('display', 'none')
            $('#myModal').html('')
            $('body').removeClass('no-scroll');
        })
    }

    PMD.loginTab = () => {
        $(document).on('click', '#loginTab', function () {
            $('#loginTab').addClass('active')
            $('#registerTab').removeClass('active')
            $('#loginForm').css('display', 'block')
            $('#registerForm').css('display', 'none')
        })
    }


    PMD.registerTab = () => {
        $(document).on('click', '#registerTab', function () {
            $('#registerTab').addClass('active')
            $('#loginTab').removeClass('active')
            $('#registerForm').css('display', 'block')
            $('#loginForm').css('display', 'none')
        })
    }

    PMD.checkLoginComment = () => {
        $(document).on('click', '.custom-area', function () {
            let _this = $(this)
            let userId = _this.attr('data-id')
            if (userId == '') {
                $('#myModal').css('display', 'flex')
                $('#myModal').append(PMD.renderFormLogin())
                $('body').addClass('no-scroll');
            }
        })
    }

    PMD.forgotPassword = () => {
        $(document).on('click', '.register', function () {
            $('.modal-content').remove()         // Xóa hết các phần tử con trong modal-body
            $('#myModal').append(PMD.renderForgotPassword())
        })
    }


    PMD.conrfirmPassword = () => {
        $(document).on('click', '.btnConfirmPass', function (e) {
            e.preventDefault()
            let option = {
                'email': $('input[name=email]').val(),
                '_token': _token
            }
            console.log(option);
            $('#preloder').css('display', 'block')
            $.ajax({
                url: 'ajax/login/confirmPassword',
                type: 'POST',
                data: option,
                dataType: 'json',
                success: function (res) {
                    $('#preloder').css('display', 'none')
                    if (res.code == 0) {
                        $('.modal-content').remove()
                        $('#myModal').append(PMD.renderFormLogin())
                        Swal.fire({
                            title: "Good job!",
                            text: res.message,
                            icon: "success"
                        });
                    }

                    if (res.code == 1) {
                        Swal.fire({
                            title: "Good job!",
                            text: res.message,
                            icon: "error"
                        });
                    }
                },
                beforeSend: function () {
                    $('.error-message').html('')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#preloder').css('display', 'none')
                    if (jqXHR.status == 422) {
                        let errors = jqXHR.responseJSON.errors
                        for (let field in errors) {
                            let errorMessage = errors[field]
                            errorMessage.forEach(function (message) {
                                $('.error-message-' + field).html(message)
                            });
                        }
                    }
                }
            });
        })
    }

    PMD.checkRegister = () => {
        $(document).on('click', '.btnRegister', function (e) {
            e.preventDefault()
            let option = {
                'email': $('input[name=emailRegister]').val(),
                'name': $('input[name=nameRegister]').val(),
                'password': $('input[name=passwordRegister]').val(),
                '_token': _token
            }
            $('#preloder').css('display', 'block')
            $.ajax({
                url: 'ajax/register/register',
                type: 'POST',
                data: option,
                dataType: 'json',
                success: function (res) {
                    $('#preloder').css('display', 'none')
                    if (res.code == 0) {
                        $('.modal-content').remove()
                        $('#myModal').append(PMD.renderFormLogin())
                        Swal.fire({
                            title: "Good job!",
                            text: res.message,
                            icon: "success"
                        });
                    }

                    if (res.code == 1) {
                        Swal.fire({
                            title: "Good job!",
                            text: res.message,
                            icon: "error"
                        });
                    }
                },
                beforeSend: function () {
                    $('.error-message').html('')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $('#preloder').css('display', 'none')
                    if (jqXHR.status == 422) {
                        let errors = jqXHR.responseJSON.errors
                        for (let field in errors) {
                            let errorMessage = errors[field]
                            errorMessage.forEach(function (message) {
                                $('.error-message-register-' + field).html(message)
                            });
                        }
                    }
                }
            });
        })
    }


    PMD.backLogin = () => {
        $(document).on('click', '.backLogin', function () {
            $('.modal-content').remove()
            $('#myModal').append(PMD.renderFormLogin())

        })
    }


    PMD.renderFormLogin = () => {
        let html = ''
        console.log(3333);
        html = `
            <div class="modal-content">
                <div class="modal-header">
                    <img class="img-fluid" width="100px" src="frontend/images/logo.png"
                        alt="Reader | Hugo Personal Blog Template">
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="tabs row mb-4">
                        <div class="col">
                            <div id="loginTab" class="tab text-center active">Đăng Nhập</div>
                        </div>
                        <div class="col">
                            <div id="registerTab" class="tab text-center">Đăng Ký</div>
                        </div>
                    </div>
                    <form id="loginForm" class="form" method="POST" action="{{ route('client.login') }}">
                        <div class="form-group">
                            <label for="loginUsername">Tên đăng nhập</label>
                            <input type="text" name="email" id="loginUsername" class="form-control"
                                placeholder="Nhập tên đăng nhập">
                                <span class="error-message error-message-email"></span>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Mật khẩu</label>
                            <input type="password" name="password" id="loginPassword" class="form-control"
                                placeholder="Nhập mật khẩu">
                                <span class="error-message error-message-password"></span>
                        </div>
                        <div class="mb-3">
                            <a class="link-auth register">Quên mật khẩu?</a>
                        </div>
                        <button type="submit" class="btn btn-primary btnLogin" style="width: 100%">Đăng nhập</button>
                    </form>
                    <form id="registerForm" class="form" style="display: none;">
                        <div class="form-group">
                            <label for="registerUsername">Họ tên</label>
                            <input type="text" name="nameRegister" class="form-control"
                                placeholder="Nhập họ và tên">
                                <span class="error-message error-message-register-name"></span>
                        </div>
                        <div class="form-group">
                            <label for="registerEmail">Email</label>
                            <input type="text" name="emailRegister" class="form-control"
                                placeholder="Nhập email">
                                <span class="error-message error-message-register-email"></span>
                        </div>
                        <div class="form-group">
                            <label for="registerPassword">Mật khẩu</label>
                            <input type="password" name="passwordRegister" class="form-control"
                                placeholder="Nhập mật khẩu">
                                <span class="error-message error-message-register-password"></span>
                        </div>
                        <p class="mb-2">Bằng cách đăng ký tài khoản, bạn cũng đồng thời chấp nhận mọi điều
                            kiện về qui định
                            và chính sách của chúng tôi</p>
                        <button type="submit" class="btn btn-primary btnRegister" style="width:100%">Đăng Ký</button>
                    </form>
                </div>
        </div>
        `
        return html
    }

    PMD.renderForgotPassword = () => {
        let html = ''
        html += `
        <div class="modal-content">
                <div class="modal-header">
                    <img class="img-fluid" width="100px" src="frontend/images/logo.png"
                        alt="Reader | Hugo Personal Blog Template">
                    <span class="close">&times;</span>
                </div>
        <div class="tabs row mb-5">
            <div class="col">
                <div id="loginTab" class="tab text-center active">Quên Mật Khẩu</div>
            </div>
            <div class="col">
            </div>
        </div>
        <form id="loginForm" class="form" method="POST" action="{{ route('client.forgotPassword') }}">
            <div class="form-group">
                <label for="loginUsername">Nhập email của bạn</label>
                <input type="text" name="email" class="form-control"
                    placeholder="Nhập email của bạn">
                    <span class="error-message error-message-email"></span>
            </div>
            <div class="mb-3">
                <a class="link-auth backLogin">Về trang đăng nhập</a>
            </div>
            <button type="submit" class="btn btn-primary btnConfirmPass" style="width: 100%">Nhận mã xác nhận</button>
        </form>
        </div>
        `
        return html
    }


    $(document).ready(function () {
        PMD.checkLogin();
        PMD.openModal()
        PMD.closeModal()
        PMD.loginTab()
        PMD.registerTab()
        PMD.checkLoginComment()
        PMD.forgotPassword()
        PMD.backLogin()
        PMD.conrfirmPassword()
        PMD.checkRegister()
    });

})(jQuery);

