$(document).ready(function () {
    function validateLink(postLink) {
        const re = /^http(s)?:\/\/(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
        return re.test(String(postLink).toLowerCase());
    }

    $('#postTitle').on('input', function () {
        const title = $(this).val().trim();
        if (title === '') {
            $('#titleError').show();
            $('#postButton').prop('disabled', true);
        } else {
            $('#titleError').hide();
            $('#postButton').prop('disabled', false);
        }
    });

    $('#postContent').on('input', function () {
        const contentInfo = $('#contentInfo');
        const content = $(this).val();
        const maxContentLength = 255;
        const contentLength = content.length;
        const remainingChars = maxContentLength - contentLength;

        if (content !== '') {
            contentInfo.text("Maximum characters: " + remainingChars).show();
            if (remainingChars < 0) {
                contentInfo.text("Too many characters!").addClass('text-danger');
                $('#postButton').prop('disabled', true);
            } else {
                contentInfo.removeClass('text-danger');
                $('#postButton').prop('disabled', false);
            }
        } else {
            contentInfo.hide();
        }
    });

    $('#postLink').on('input', function () {
        const postLink = $(this).val();
        const invalidLink = $('#invalid-postLink');

        if (validateLink(postLink) || postLink === '') {
            invalidLink.removeClass('text-danger').text('Invalid Link').hide();
            $('#postButton').prop('disabled', false);
        } else {
            invalidLink.addClass('text-danger').text('Invalid Link').show();
            $('#postButton').prop('disabled', true);
        }
    });

    $('#postForm').on('submit', function (e) {
        e.preventDefault();
        const title = $('#postTitle').val().trim();
        const content = $('#postContent').val().trim();
        const image = $('#postImage')[0].files[0];
        const link = $('#postLink').val().trim();

        if (title === '') {
            $('#titleError').show();
            return;
        }

        const formData = new FormData();
        formData.append('postTitle', title);
        formData.append('postContent', content);
        if (image) {
            formData.append('image', image);
        }
        if (link) {
            formData.append('postLink', link);
        }

        $.ajax({
            url: '/postData',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                window.location.reload();
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                alert('An error occurred while submitting the post.');
            }
        });
    });
});
