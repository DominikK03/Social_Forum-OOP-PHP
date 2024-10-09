$(document).ready(function () {
    $('#postTitle').on('input', function () {
        var title = $(this).val().trim();

        if (title === '') {
            $('#titleError').show();
            $('#postButton').prop('disabled', true);
        } else {
            $('#titleError').hide();
            $('#postButton').prop('disabled', false);
        }
    });

    $('#postForm').on('submit', function (e) {
        e.preventDefault();

        var title = $('#postTitle').val().trim();
        var content = $('#postContent').val().trim();
        var image = $('#postImage')[0].files[0];

        if (title === '') {
            $('#titleError').show();
            return;
        }

        var formData = new FormData();
        formData.append('postTitle', title);
        formData.append('postContent', content);

        if (image) {
            formData.append('image', image);
        }

        $.ajax({
            url: '/postData',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response);
                alert('Post submitted successfully!');
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                alert('An error occurred while submitting the post.');
            }
        });
    });
});
