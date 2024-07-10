(function ($) {
    "use strict";
    var PMD = {};
    var _token = $('meta[name="csrf-token"]').attr('content');


    var isValid = true;
    var isCheckButton = true;

    PMD.checkKeyUp = () => {
        $(document).on('keyup', '.custom-area', function () {

            let _this = $(this)
            if (isCheckButton == true) {
                $('.comments-body').append('<button type="submit" id="checkButtonComment" class="btn btn-primary">Gửi bình luận</button>')
                isCheckButton = false
            }
            // if(isCheckButton == 3){
            //     $('.sendComment').remove()
            //     isCheckButton = false
            // }
            if (_this.val().length > 10) {
                $('.comment-error').html('Vui lòng bình luận ngắn hơn!')
                isValid = false
                $('#checkButtonComment').removeClass('sendComment')
                // isCheckButton = 3
            } else {
                $('.comment-error').html('')
                isValid = true
                if (!$('#checkButtonComment').hasClass('sendComment')) {
                    $('#checkButtonComment').addClass('sendComment')
                }
                // isCheckButton = 1
            }
        })
    }

    PMD.checkLogin = () => {
        $(document).on('click', '.sendComment', function (e) {
            e.preventDefault();
            if (isValid) {
                let _this = $('.custom-area')
                let option = {
                    'user_id': _this.attr('data-id'),
                    'post_id': _this.attr('data-post'),
                    'content': _this.val(),
                    '_token': _token
                }

                $.ajax({
                    url: 'ajax/comment/sendComment',
                    type: 'POST',
                    data: option,
                    dataType: 'json',
                    success: function (res) {
                        if (res.code == 0) {
                            Swal.fire({
                                title: "Đăng bình luận thành công!",
                                text: "You clicked the button!",
                                icon: "success"
                            });
                        }
                        _this.val('')
                        $('.comment-empty').remove()
                        if ($('.comments-footer').find('.media-content').length === 0) {
                            $('.comments-footer').append(PMD.unHiddenComment(res.data))

                        } else {
                            $('.tempComment').append(PMD.renderComments(res.data))
                        }

                        $('.sendComment').remove()
                        isCheckButton = true
                    },
                    beforeSend: function () {
                    },
                    error: function (jqXHR, textStatus, errorThrown) {


                    }
                });
            }

        })
    }


    PMD.deleteComment = () => {
        $(document).on('click', '.deleteComment', function (e) {
            e.preventDefault()
            let _this = $(this)
            let option = {
                'comment_id': _this.closest('.media-body').closest('.commentData').attr('data-comment'),
                '_token': _token
            }
            $.ajax({
                url: 'ajax/comment/deleteComment',
                type: 'POST',
                data: option,
                dataType: 'json',
                success: function (res) {
                    if (res.code == 0) {
                        if (res.code == 0) {
                            Swal.fire({
                                title: "Xóa bình luận thành công!",
                                text: "You clicked the button!",
                                icon: "success"
                            });
                            $('[data-comment="' + option['comment_id'] + '"]').remove();
                            PMD.renderEmptyComment()
                        }
                    }
                },
                beforeSend: function () {
                },
                error: function (jqXHR, textStatus, errorThrown) {


                }
            });
        })
    }

    PMD.renderBoxReplyComment = () => {
        $(document).on('click', '.replyComment', function () {
            let parent_id = $('.commentData').attr('data-comment')
            console.log(parent_id);
            let html = `
            <div class="reply-comment-head mb-3">
                <textarea name="content" data-post="" data-id=""
                    class="form-control custom-area" placeholder="Bạn nghĩ gì về tin này?" id="" cols="30" rows="5"></textarea>
            </div>
            <div class="reply-comments-body mb-4 d-flex justify-content-between">
                <p class="reply-comment-error"></p>
            </div>
            `
            $('.boxReplyComment-' + parent_id).append(html)
        })
    }


    PMD.replyComment = () => {
        $(document).on('click', '.replyComment', function (e) {
            e.preventDefault()
            let _this = $(this)
            let option = {
                'parent_id': _this.closest('.media-body').closest('.commentData').attr('data-comment'),
                '_token': _token
            }
            $.ajax({
                url: 'ajax/comment/deleteComment',
                type: 'POST',
                data: option,
                dataType: 'json',
                success: function (res) {
                    if (res.code == 0) {
                        if (res.code == 0) {
                            Swal.fire({
                                title: "Xóa bình luận thành công!",
                                text: "You clicked the button!",
                                icon: "success"
                            });
                            $('[data-comment="' + option['comment_id'] + '"]').remove();
                            PMD.renderEmptyComment()
                        }
                    }
                },
                beforeSend: function () {
                },
                error: function (jqXHR, textStatus, errorThrown) {


                }
            });
        })
    }

    PMD.unHiddenComment = (data) => {
        let html = ''

        html += '<div class="media-content">'
        html += '<h4 class="mb-4">Tất cả bình luận</h4>'
        html += '<div class="tempComment">'
        html += PMD.renderComments(data)
        html += '</div>'
        html += '</div>'
        return html
    }

    PMD.renderComments = (data) => {
        let html = ''
        html += `
            <div data-comment="${data.id}" class="media commentData d-block d-sm-flex mb-4">
                <img src="${data.image}" width="50px" height="50px"
                    class="mr-2 rounded-circle" alt="">
                    <div class="media-body">
                        <p class="h4 d-inline-block mb-3">${data.name}</p>

                        <p>${data.content}</p>

                        <span
                            class="text-black-800 mr-3 font-weight-600">${data.updated_at}</span>
                        <a class="text-primary mr-4 font-weight-600 replyComment">Trả lời</a>
                        <a class="text-primary deleteComment font-weight-600">Xóa bình luận</a>
                    </div>
            </div>
            `
        return html
    }

    PMD.renderEmptyComment = () => {
        if ($('.media-content').find('.commentData').length === 0) {
            $('.media-content').remove()
            let html = `
            <div class="comment-empty">
                <p><i class="ti-flag-alt"></i></p>
                <span>Hiện chưa có bình luận nào, hãy trở thành người đầu tiên bình luận cho bài
                    viết
                    này!</span>
            </div>
            `
            $('.comments-footer').append(html)
        }
    }

    $(document).ready(function () {
        PMD.checkLogin()
        PMD.checkKeyUp()
        PMD.deleteComment()
        PMD.renderBoxReplyComment()
    });

})(jQuery);

