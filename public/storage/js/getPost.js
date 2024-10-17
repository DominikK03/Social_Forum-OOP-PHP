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
    $('#postContent').on('input', function () {
        let contentInfo = $('#contentInfo');
        let content = $('#postContent').val();
        let maxContentLength = 255;
        let contentLength = content.length;
        let remainingChars = maxContentLength - contentLength;
        if (content !== '') {
            contentInfo.text("Maximum characters: " + remainingChars).show();
            if (remainingChars < 0) {
                contentInfo.replaceWith(contentInfo.text("Too many characters!").addClass('text-danger'));
                $('#postButton').prop('disabled', true);
            }else {
                contentInfo.removeClass('text-danger');
                $('#postButton').prop('disabled', false);
            }
        } else {
            contentInfo.hide();
        }
    });

    $('#postForm').on('submit', function (e) {
        e.preventDefault();

        var title = $('#postTitle').val().trim();
        var content = $('#postContent').val().trim();
        var image = $('#postImage')[0].files[0];
        var link = $('#postLink').val().trim();

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
        if (link) {
            formData.append('postLink', link)
        }

        $.ajax({
            url: '/postData',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                alert('An error occurred while submitting the post.');
            }
        });
    });
});
