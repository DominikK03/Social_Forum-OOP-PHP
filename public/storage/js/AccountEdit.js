$(document).ready(function () {
    $('.change-password-btn').click(function () {
        $('#password-form').toggleClass('d-none');
        $('.invalid-feedback').hide();
        $('.success-password').hide();
        $('.invalid-password').hide();
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
            $('#newPassword').removeClass('is-invalid').addClass('is-valid');
            $('#newPassword').next('.invalid-feedback').hide();
        } else {
            $('#newPassword').removeClass('is-valid').addClass('is-invalid');
            $('#newPassword').next('.invalid-feedback').show();
        }

        if (newPassword === confirmPassword && validatePassword(newPassword)) {
            $('#confirmPassword').removeClass('is-invalid').addClass('is-valid');
            $('#confirmPassword').next('.invalid-feedback').hide();
            $('.save-password-btn').removeAttr('disabled');
        } else {
            $('#confirmPassword').removeClass('is-valid').addClass('is-invalid');
            $('#confirmPassword').next('.invalid-feedback').show();
            $('.save-password-btn').attr('disabled', 'disabled');
        }
    });
    $('#avatarImage').on('change', function () {
        var formData = new FormData();
        var file = $('#avatarImage')[0].files[0];

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
                    location.href = '/account'
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
        $('#confirmPassword').addClass('is-invalid');
        $('#confirmPassword').next('.invalid-feedback').show();
        return;
    }

    var formData = {
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
                $(".success-password").removeAttr('hidden').show().addClass('text-success');

            } else {
                if (response.message === "Invalid password") {
                    $(".invalid-password").text("Invalid password.").show().addClass('text-danger');
                }
            }
        },
        error: function (xhr, status, error) {
            alert('An error occurred: ' + error);
        }
    });
});
})
;
