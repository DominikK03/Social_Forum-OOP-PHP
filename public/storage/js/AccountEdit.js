$(document).ready(function () {
    $('.change-password-btn').click(function () {
        $('#password-form').toggleClass('d-none');
        $('.invalid-feedback, .success-password, .invalid-password').hide();
        $('#newPassword, #confirmPassword').removeClass('is-invalid is-valid');
        $('.save-password-btn').attr('disabled', 'disabled');
    });

    function validatePassword(password) {
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return re.test(password);
    }

    $('#newPassword, #confirmPassword').on('input', function () {
        const newPassword = $('#newPassword').val();
        const confirmPassword = $('#confirmPassword').val();

        if (validatePassword(newPassword)) {
            $('#newPassword').removeClass('is-invalid').addClass('is-valid').next('.invalid-feedback').hide();
        } else {
            $('#newPassword').removeClass('is-valid').addClass('is-invalid').next('.invalid-feedback').show();
        }

        if (newPassword === confirmPassword && validatePassword(newPassword)) {
            $('#confirmPassword').removeClass('is-invalid').addClass('is-valid').next('.invalid-feedback').hide();
            $('.save-password-btn').removeAttr('disabled').addClass('btn-success').removeClass('btn-primary');
        } else {
            $('#confirmPassword').removeClass('is-valid').addClass('is-invalid').next('.invalid-feedback').show();
            $('.save-password-btn').attr('disabled', 'disabled').removeClass('btn-success').addClass('btn-primary');
        }
    });

    $('#avatarImage').on('change', function () {
        const formData = new FormData();
        const file = $('#avatarImage')[0].files[0];

        if (file) {
            formData.append('image', file);
            $.ajax({
                url: '/account/postAvatar',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    location.href = '/account';
                    location.reload(true);
                },
                error: function (xhr, status, error) {
                    alert('Upload failed: ' + error);
                }
            });
        }
    });

    $('.delete-account-btn').click(function () {
        $('#deleteAccountModal').modal('show');
    });

    $('.confirm-delete-account-btn').click(function () {
        var deletePassword = $('#deletePassword').val();

        if (deletePassword === '') {
            $('.invalid-password').text('Please enter your password.').removeAttr('hidden').show();
            return;
        }

        var formData = {
            deletePassword : deletePassword
        };

        $.ajax({
            url: '/account/deleteAccount',
            type: 'POST',
            data: formData,
            success: function (response) {
                console.log(response)
                if (response.success) {
                    location.href = '/login';
                    location.reload();
                } else {
                    $('.invalid-password').text('Invalid password.').removeAttr('hidden').show();
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });

    $('#deleteAccountModal').on('hidden.bs.modal', function () {
        $('#deletePassword').val('');
        $('.invalid-password').hide();
    });



    $('#passwordChangeForm').on('submit', function (e) {
        e.preventDefault();

        const currentPassword = $('#currentPassword').val();
        const newPassword = $('#newPassword').val();
        const confirmPassword = $('#confirmPassword').val();

        if (newPassword !== confirmPassword) {
            $('#confirmPassword').addClass('is-invalid').next('.invalid-feedback').show();
            return;
        }

        const formData = {
            currentPassword: currentPassword,
            newPassword: newPassword,
            confirmPassword: confirmPassword
        };

        $.ajax({
            url: '/account/passwordChange',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    $('#password-form').addClass('d-none');
                    $('.success-password').removeAttr('hidden').show().addClass('text-success').fadeOut(2000);
                } else {
                    if (response.message === 'Invalid password') {
                        $('.invalid-password').text('Invalid password.').show().addClass('text-danger').delay(3000).fadeOut();
                    }
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
});
