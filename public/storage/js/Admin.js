$(document).ready(function() {
    $('#roleChangeForm').on('submit', function(e) {
        e.preventDefault();

        var username = $('#username').val();
        var role = $('#role').val().toLowerCase();

        $.ajax({
            type: 'POST',
            url: '/admin/changeRole',
            data: { username: username, role: role },
            success: function(response) {
                console.log(response)
                if(response.success) {
                    $('.success-role-change').show().delay(3000).fadeOut();
                } else {
                    $('.error-role-change').text(response.message).show().delay(3000).fadeOut();
                }
            },
            error: function() {
                $('.error-role-change').show().delay(3000).fadeOut();
            }
        });
    });

    $('.delete-post').click(function () {
        const postId = $(this).data('post-id');

        if (confirm('Czy na pewno chcesz usunąć ten post?')) {
            $.ajax({
                url: '/deletePost',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ post_id: postId }),
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        alert('Post został usunięty.');
                        location.reload();
                        location.href = '/';
                    } else {
                        alert('Błąd: ' + response.message);
                    }
                },
                error: function () {
                    alert('Błąd podczas usuwania posta.');
                }
            });
        }
    });
    $('.delete-comment').click(function () {
        const commentId = $(this).data('comment-id');

        if (confirm('Czy na pewno chcesz usunąć ten komentarz?')) {
            $.ajax({
                url: '/post/deleteComment',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ comment_id: commentId }),
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        alert('Komentarz został usunięty.');
                        location.reload();
                    } else {
                        alert('Błąd: ' + response.message);
                    }
                },
                error: function () {
                    alert('Błąd podczas usuwania posta.');
                }
            });
        }
    });
});