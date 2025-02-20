$(document).ready(function () {
    AdminPage.init();
});

class AdminPage {
    static init() {
        this.cacheDOM();
        this.bindEvents();
    }
    static cacheDOM() {
        this.$roleChangeForm = $('#roleChangeForm');
        this.$usernameInput = $('#username');
        this.$roleInput = $('#role');
        this.$successRoleChange = $('.success-role-change');
        this.$errorRoleChange = $('.error-role-change');

        this.$deletePostButtons = $('.delete-post');
        this.$deleteCommentButtons = $('.delete-comment');
    }

    static bindEvents() {
        this.$roleChangeForm.on('submit', (e) => this.handleRoleChange(e));
        this.$deletePostButtons.on('click', (e) => this.handlePostDeletion(e));
        this.$deleteCommentButtons.on('click', (e) => this.handleCommentDeletion(e));
    }

    static handleRoleChange(event) {
        event.preventDefault();

        const username = this.$usernameInput.val();
        const role = this.$roleInput.val().toLowerCase();

        // Reset feedback messages
        this.$successRoleChange.hide();
        this.$errorRoleChange.hide();

        $.ajax({
            type: 'POST',
            url: '/admin/changeRole',
            data: {username: username, role: role},
            success: (response) => {
                if (response.success) {
                    this.$successRoleChange.show().delay(3000).fadeOut();
                } else {
                    this.$errorRoleChange.text(response.message).show().delay(3000).fadeOut();
                }
            },
            error: () => {
                this.$errorRoleChange.text('An error occurred while changing the role.').show().delay(3000).fadeOut();
            }
        });
    }

    static handlePostDeletion(event) {
        const $button = $(event.currentTarget);
        const postId = $button.data('post-id');

        if (confirm('Czy na pewno chcesz usunąć ten post?')) {
            $.ajax({
                url: '/deletePost',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({post_id: postId}),
                success: (response) => {
                    if (response.success) {
                        alert('Post został usunięty.');
                        location.reload();
                    } else {
                        alert('Błąd: ' + response.message);
                    }
                },
                error: () => {
                    alert('Błąd podczas usuwania posta.');
                }
            });
        }
    }

    static handleCommentDeletion(event) {
        const $button = $(event.currentTarget);
        const commentId = $button.data('comment-id');

        if (confirm('Czy na pewno chcesz usunąć ten komentarz?')) {
            $.ajax({
                url: '/post/deleteComment',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({comment_id: commentId}),
                success: (response) => {
                    if (response.success) {
                        alert('Komentarz został usunięty.');
                        location.reload();
                    } else {
                        alert('Błąd: ' + response.message);
                    }
                },
                error: () => {
                    alert('Błąd podczas usuwania komentarza.');
                }
            });
        }
    }
}
