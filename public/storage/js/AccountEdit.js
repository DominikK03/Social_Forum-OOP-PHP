$(document).ready(function () {
    $('.change-password-btn').click(function () {
        $('#password-form').toggleClass('d-none');
        $('.invalid-feedback').hide();
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
            url: '/passwordChange',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert('Password updated successfully!');
                    $('#password-form').addClass('d-none');
                } else {
                    alert("Error: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });
    });
});
