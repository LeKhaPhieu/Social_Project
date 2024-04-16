const modal = document.getElementById('overlayMobile');
const btnShowSidebar = document.getElementById('btnShowSidebar');
const boxSidebar = document.getElementById('sidebarMobile');
const closeBoxSidebar = document.getElementsByClassName('close')[0];

btnShowSidebar.onclick = function () {
    modal.style.display = "block";
    boxSidebar.style.display = "block";
}

closeBoxSidebar.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.category-box');
    const checkboxesMobile = document.querySelectorAll('.category-box-mobile');

    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            document.getElementById('categoryForm').submit();
        });
    });

    checkboxesMobile.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            document.getElementById('categoryFormMobile').submit();
        });
    });
});

const swiper = new Swiper(".mySwiper", {
    pagination: {
        el: ".swiper-pagination",
    },
});

$('#likeForm').on('submit', function (event) {
    if ($(this).data('user')) {
        event.preventDefault();
        const form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (data) {
                const heartIcon = $('#heartIcon');
                if (data.liked) {
                    heartIcon.removeClass('fa-regular').addClass('fa-solid');
                } else {
                    heartIcon.removeClass('fa-solid').addClass('fa-regular');
                }
                $('.info-blog.heart-create').text(data.likesCount);
            },
            error: function (xhr, status, error) {
                console.log(error)
            },
        });
    };
});

function listComments() {
    const commentAction = $("#data").data("comment_action");
    $.ajax({
        type: "GET",
        url: commentAction,
        success: function (data) {
            $("#comments").html(data.comments);
        },
        error: function (xhr, status, error) {
            console.log(error)
        },
    });
}

$(document).on("click", "#btnComment", function (event) {
    event.preventDefault();
    const commentForm = $(this).closest("form");
    const content = commentForm.find('input[name="content"]').val();
    $.ajax({
        method: 'POST',
        url: commentForm.attr('action'),
        data: {
            'content': content,
        },
        success: function (data) {
            data.status ? listComments() : alert(data.message);
            commentForm[0].reset();
        },
        error: function (xhr, status, error) {
            console.log(error)
        },
    });
});

$(document).on('submit', '[id^="likeFormComment"]', function (event) {
    if ($(this).data('user')) {
        event.preventDefault();
        const form = $(this);
        const commentId = form.attr('id').replace('likeFormComment', '');
        const heartIcon = $('#heartIconComment' + commentId);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function (data) {
                if (data.liked) {
                    heartIcon.removeClass('fa-regular').addClass('fa-solid');
                } else {
                    heartIcon.removeClass('fa-solid').addClass('fa-regular');
                }
                $('#totalCommentLike' + commentId).text(data.likesCount);
            },
            error: function (xhr, status, error) {
                console.log(error)
            },
        });
    };
});

$(document).on('click', '.btn-show-edit-comment', function () {
    const commentId = $(this).data('comment-id');
    $('#boxEditComment' + commentId).toggle();
    $('[id^="closeBoxEdit"]').click(function () {
        $(this).closest('.form-delete.update-comment').hide();
    });
});

$(document).on('click', '.btn-update-comment', function (event) {
    event.preventDefault();
    const form = $(this).closest('form');
    const formData = form.serialize();
    $.ajax({
        url: form.attr('action'),
        method: 'POST',
        data: formData,
        success: function (data) {
            data.status ? listComments() : alert(data.message);
            form.closest('.form-delete.update-comment').hide();
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});

$(document).on('click', '.btn-show-delete-comment', function () {
    const commentId = $(this).data('comment-id');
    $('#boxDeleteComment' + commentId).toggle();
    $('[id^="closeBoxDelete"]').click(function () {
        $(this).closest('.form-delete').hide();
    });
});

$(document).on('click', '.btn-delete-comment', function (event) {
    event.preventDefault();
    const form = $(this).closest('form');
    $.ajax({
        type: 'DELETE',
        url: form.attr('action'),
        success: function (data) {
            data.status ? listComments() : alert(data.message);
            form.closest('.form-delete').hide();
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
});

$(document).ready(function () {
    $(document).on('click', '.show-input-reply-comment', function () {
        const commentId = $(this).data('comment-id');
        const user = $(this).data('user');
        if (!user) {
            window.location.href = "/auth/login"; 
        } else {
            $('.form-reply-comment').hide();
            $('.form-reply' + commentId).toggle();
        }
    });
});

$(document).on("click", ".btn-send-comment-reply", function (event) {
    event.preventDefault();
    const formReply = $(this).closest('form');
    const commentId = formReply.data('id');
    const content = formReply.find('.commentContentReply').val();
    const formAction = formReply.attr('action');
    $.ajax({
        method: 'POST',
        url: formAction,
        data: {
            content,
            parent_id: commentId,
        },
        success: function (data) {
            data.status ? listComments() : alert(data.message);
            formReply[0].reset();
        },
        error: function (xhr, status, error) {
            console.log(error)
        },
    });
});
