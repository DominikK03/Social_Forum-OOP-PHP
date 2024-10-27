$(document).ready(function () {
    function getQueryParams() {
        var params = {};
        var queryString = window.location.search.substring(1);
        var queries = queryString.split("&");

        for (var i = 0; i < queries.length; i++) {
            var pair = queries[i].split("=");
            params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || "");
        }

        return params;
    }


    $('#commentInput').on('input', function () {
        let commentInfo = $('#commentInfo');
        let comment = $('#commentInput').val();
        let maxCommentLength = 255;
        let commentLength = comment.length;
        let remainingChars = maxCommentLength - commentLength;

        if (comment !== '') {
            commentInfo.text("Maximum characters: " + remainingChars).show();
            if (remainingChars < 0) {
                commentInfo.text("Too many characters!").addClass('text-danger');
                $('#commentButton').prop('disabled', true);
            } else {
                commentInfo.removeClass('text-danger');
                $('#commentButton').prop('disabled', false);
            }
        } else {
            commentInfo.hide();
        }
    });

    $('#commentForm').on('submit', function (e) {
        e.preventDefault();

        var queryParams = getQueryParams();
        var postID = queryParams['postID'];
        var comment = $('#commentInput').val().trim();
        var formData = new FormData();
        formData.append('comment', comment);



        $.ajax({
            url: '/post/postComment'+'?postID='+postID,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response)
                if (response.success) {
                    location.reload();
                } else {
                    $("#comment-invalid-feedback")
                        .text(response.message)
                        .show()
                        .addClass('text-danger')
                        .delay(3000).fadeOut();
                }
            },
            error: function (xhr, status, error) {
                $("#comment-invalid-feedback")
                    .text("An error occurred while submitting the comment.")
                    .show()
                    .addClass('text-danger');
                console.log(xhr.responseText);
            }
        });
    });
});
