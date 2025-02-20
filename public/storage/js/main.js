class Main {
    static init() {
        this.cacheDOM();
        this.bindEvents();
        this.handleUserRoleVisibility();
    }

    static cacheDOM() {
        this.$commentInput = $('#commentInput');
        this.$commentInfo = $('#commentInfo');
        this.$commentButton = $('#commentButton');
        this.$commentForm = $('#commentForm');
        this.$commentInvalidFeedback = $('#comment-invalid-feedback');

        this.$postTitle = $('#postTitle');
        this.$titleError = $('#titleError');
        this.$postContent = $('#postContent');
        this.$contentInfo = $('#contentInfo');
        this.$postLink = $('#postLink');
        this.$invalidPostLink = $('#invalid-postLink');
        this.$postButton = $('#postButton');
        this.$postForm = $('#postForm');

        this.$adminPanelButton = $('#adminPanelButton');
        this.$deletePost = $('.delete-post');
        this.$deleteComment = $('.delete-comment');
    }

    static bindEvents() {
        this.$commentInput.on('input', this.handleCommentInput.bind(this));
        this.$commentForm.on('submit', this.submitComment.bind(this));

        this.$postTitle.on('input', this.handlePostTitleInput.bind(this));
        this.$postContent.on('input', this.handlePostContentInput.bind(this));
        this.$postLink.on('input', this.validatePostLink.bind(this));
        this.$postForm.on('submit', this.submitPost.bind(this));
    }

    static getQueryParams() {
        const params = {};
        const queryString = window.location.search.substring(1);
        const queries = queryString.split("&");

        for (let i = 0; i < queries.length; i++) {
            const pair = queries[i].split("=");
            params[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1] || "");
        }

        return params;
    }

    static handleCommentInput() {
        const comment = this.$commentInput.val();
        const maxCommentLength = 255;
        const remainingChars = maxCommentLength - comment.length;

        if (comment) {
            this.$commentInfo.text(`Maximum characters: ${remainingChars}`).show();
            if (remainingChars < 0) {
                this.$commentInfo.text("Too many characters!").addClass('text-danger');
                this.$commentButton.prop('disabled', true);
            } else {
                this.$commentInfo.removeClass('text-danger');
                this.$commentButton.prop('disabled', false);
            }
        } else {
            this.$commentInfo.hide();
        }
    }

    static submitComment(e) {
        e.preventDefault();

        const queryParams = this.getQueryParams();
        const postID = queryParams['postID'];
        const comment = this.$commentInput.val().trim();
        const formData = new FormData();
        formData.append('comment', comment);

        $.ajax({
            url: `/post/postComment?postID=${postID}`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: (response) => {
                if (response.success) {
                    location.reload();
                } else {
                    this.$commentInvalidFeedback
                        .text(response.message)
                        .show()
                        .addClass('text-danger')
                        .delay(3000).fadeOut();
                }
            },
            error: (xhr) => {
                this.$commentInvalidFeedback
                    .text("An error occurred while submitting the comment.")
                    .show()
                    .addClass('text-danger');
                console.log(xhr.responseText);
            }
        });
    }

    static handlePostTitleInput() {
        const title = this.$postTitle.val().trim();
        if (title === '') {
            this.$titleError.show();
            this.$postButton.prop('disabled', true);
        } else {
            this.$titleError.hide();
            this.$postButton.prop('disabled', false);
        }
    }

    static handlePostContentInput() {
        const content = this.$postContent.val();
        const maxContentLength = 255;
        const remainingChars = maxContentLength - content.length;

        if (content) {
            this.$contentInfo.text(`Maximum characters: ${remainingChars}`).show();
            if (remainingChars < 0) {
                this.$contentInfo.text("Too many characters!").addClass('text-danger');
                this.$postButton.prop('disabled', true);
            } else {
                this.$contentInfo.removeClass('text-danger');
                this.$postButton.prop('disabled', false);
            }
        } else {
            this.$contentInfo.hide();
        }
    }

    static validatePostLink() {
        const postLink = this.$postLink.val();
        const re = /^http(s)?:\/\/(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

        if (re.test(postLink.toLowerCase()) || postLink === '') {
            this.$invalidPostLink.removeClass('text-danger').text('Invalid Link').hide();
            this.$postButton.prop('disabled', false);
        } else {
            this.$invalidPostLink.addClass('text-danger').text('Invalid Link').show();
            this.$postButton.prop('disabled', true);
        }
    }

    static submitPost(e) {
        e.preventDefault();

        const title = this.$postTitle.val().trim();
        const content = this.$postContent.val().trim();
        const image = $('#postImage')[0].files[0];
        const link = this.$postLink.val().trim();

        if (title === '') {
            this.$titleError.show();
            return;
        }

        const formData = new FormData();
        formData.append('postTitle', title);
        formData.append('postContent', content);
        if (image) formData.append('image', image);
        if (link) formData.append('postLink', link);

        $.ajax({
            url: '/postData',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: (response) => console.log(response),
            error: (xhr) => {
                console.log(xhr.responseText);
                alert('An error occurred while submitting the post.');
            }
        });
    }

    static handleUserRoleVisibility() {
        const userRole = sessionStorage.getItem('userRole');
        if (userRole === 'admin' || userRole === 'master') {
            this.$adminPanelButton.removeClass('d-none');
            this.$deletePost.removeClass('d-none');
            this.$deleteComment.removeClass('d-none');
        }
    }
}

$(document).ready(() => Main.init());
