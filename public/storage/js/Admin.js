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

    $('.delete-icon').click(function () {
        const postId = $(this).data('post-id');

        if (confirm('Czy na pewno chcesz usunąć ten post?')) {
            $.ajax({
                url: '/deletePost',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ post_id: postId }),
                success: function (response) {
                    if (response.success) {
                        alert('Post został usunięty.');
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