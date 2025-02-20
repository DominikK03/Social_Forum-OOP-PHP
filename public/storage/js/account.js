class Account {
    static init() {
        this.cacheDOM();
        this.bindEvents();
    }

    static cacheDOM() {
        this.$changePasswordBtn = $('.change-password-btn');
        this.$passwordForm = $('#password-form');
        this.$newPassword = $('#newPassword');
        this.$confirmPassword = $('#confirmPassword');
        this.$savePasswordBtn = $('.save-password-btn');
        this.$avatarImage = $('#avatarImage');
        this.$deleteAccountBtn = $('.delete-account-btn');
        this.$confirmDeleteAccountBtn = $('.confirm-delete-account-btn');
        this.$deleteAccountModal = $('#deleteAccountModal');
        this.$deletePassword = $('#deletePassword');
        this.$invalidPasswordFeedback = $('.invalid-password');
        this.$passwordChangeForm = $('#passwordChangeForm');
        this.$successPasswordFeedback = $('.success-password');
        this.$invalidFeedback = $('.invalid-feedback');
    }

    static bindEvents() {
        $(document).ready(() => {
            this.$changePasswordBtn.click(() => this.togglePasswordForm());
            this.$newPassword.add(this.$confirmPassword).on('input', () => this.handlePasswordValidation());
            this.$avatarImage.on('change', () => this.uploadAvatar());
            this.$deleteAccountBtn.click(() => this.$deleteAccountModal.modal('show'));
            this.$confirmDeleteAccountBtn.click(() => this.confirmDeleteAccount());
            this.$deleteAccountModal.on('hidden.bs.modal', () => this.resetDeleteAccountModal());
            this.$passwordChangeForm.on('submit', (e) => this.submitPasswordChange(e));
        });
    }

    static togglePasswordForm() {
        this.$passwordForm.toggleClass('d-none');
        this.$invalidFeedback.hide();
        this.$successPasswordFeedback.hide();
        this.$invalidPasswordFeedback.hide();
        this.$newPassword.add(this.$confirmPassword).removeClass('is-invalid is-valid');
        this.$savePasswordBtn.attr('disabled', 'disabled');
    }

    static validatePassword(password) {
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return re.test(password);
    }

    static handlePasswordValidation() {
        const newPassword = this.$newPassword.val();
        const confirmPassword = this.$confirmPassword.val();

        if (this.validatePassword(newPassword)) {
            this.$newPassword.removeClass('is-invalid').addClass('is-valid').next('.invalid-feedback').hide();
        } else {
            this.$newPassword.removeClass('is-valid').addClass('is-invalid').next('.invalid-feedback').show();
        }

        if (newPassword === confirmPassword && this.validatePassword(newPassword)) {
            this.$confirmPassword.removeClass('is-invalid').addClass('is-valid').next('.invalid-feedback').hide();
            this.$savePasswordBtn.removeAttr('disabled').addClass('btn-success').removeClass('btn-primary');
        } else {
            this.$confirmPassword.removeClass('is-valid').addClass('is-invalid').next('.invalid-feedback').show();
            this.$savePasswordBtn.attr('disabled', 'disabled').removeClass('btn-success').addClass('btn-primary');
        }
    }

    static uploadAvatar() {
        const formData = new FormData();
        const file = this.$avatarImage[0].files[0];

        if (file) {
            formData.append('image', file);
            $.ajax({
                url: '/account/postAvatar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    console.log(response);
                },
                error: (xhr, status, error) => {
                    alert('Upload failed: ' + error);
                }
            });
        }
    }

    static confirmDeleteAccount() {
        const deletePassword = this.$deletePassword.val();

        if (deletePassword === '') {
            this.$invalidPasswordFeedback.text('Please enter your password.').removeAttr('hidden').show();
            return;
        }

        $.ajax({
            url: '/account/deleteAccount',
            type: 'POST',
            data: { deletePassword },
            success: (response) => {
                if (response.success) {
                    location.href = '/login';
                } else {
                    this.$invalidPasswordFeedback.text('Invalid password.').removeAttr('hidden').show();
                }
            },
            error: (xhr, status, error) => {
                alert('An error occurred: ' + error);
            }
        });
    }

    static resetDeleteAccountModal() {
        this.$deletePassword.val('');
        this.$invalidPasswordFeedback.hide();
    }

    static submitPasswordChange(e) {
        e.preventDefault();

        const currentPassword = $('#currentPassword').val();
        const newPassword = this.$newPassword.val();
        const confirmPassword = this.$confirmPassword.val();

        if (newPassword !== confirmPassword) {
            this.$confirmPassword.addClass('is-invalid').next('.invalid-feedback').show();
            return;
        }

        $.ajax({
            url: '/account/passwordChange',
            type: 'POST',
            data: { currentPassword, newPassword, confirmPassword },
            success: (response) => {
                if (response.success) {
                    this.$passwordForm.addClass('d-none');
                    this.$successPasswordFeedback.removeAttr('hidden').show().addClass('text-success').fadeOut(2000);
                } else if (response.message === 'Invalid password') {
                    this.$invalidPasswordFeedback.text('Invalid password.').show().addClass('text-danger').delay(3000).fadeOut();
                }
            },
            error: (xhr, status, error) => {
                alert('An error occurred: ' + error);
            }
        });
    }
}

$(document).ready(() => Account.init());
