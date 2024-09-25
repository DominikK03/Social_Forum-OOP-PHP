$(document).ready(function () {

    function validateEmail(email) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(String(email).toLowerCase());
    }

    function validatePassword(password) {
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return re.test(password);
    }

    function confirmPassword(password, confirmPassword) {
        return password === confirmPassword;
    }

    function checkFormValidity() {
        const emailValid = validateEmail($('#email').val());
        const passwordValid = validatePassword($('#password').val());
        const confirmPasswordValid = confirmPassword($('#password').val(), $('#confirmPassword').val());


        if (emailValid && passwordValid && confirmPasswordValid) {
            $('.register-btn').removeAttr('disabled');
        } else {
            $('.register-btn').attr('disabled', 'disabled');
        }
    }

    $('#email').on('input', function () {
        const email = $(this).val();
        if (validateEmail(email)) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').hide();
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $(this).next('.invalid-feedback').show();
        }
        checkFormValidity();
    });

    $('#password').on('input', function () {
        const password = $(this).val();
        if (validatePassword(password)) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').hide();
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $(this).next('.invalid-feedback').show();
        }
        checkFormValidity();
    });

    $('#confirmPassword').on('input', function () {
        const password = $('#password').val();
        const confirmPasswordVal = $(this).val();
        if (confirmPassword(password, confirmPasswordVal)) {
            $(this).removeClass('is-invalid').addClass('is-valid');
            $(this).next('.invalid-feedback').hide();
        } else {
            $(this).removeClass('is-valid').addClass('is-invalid');
            $(this).next('.invalid-feedback').show();
        }
        checkFormValidity();
    });

    $('#registrationForm').on('submit', function (e) {
        e.preventDefault();

        const email = $('#email').val();
        const password = $('#password').val();
        const confirmPasswordVal = $('#confirmPassword').val();

        let isFormValid = true;

        if (!validateEmail(email)) {
            $('#email').addClass('is-invalid');
            isFormValid = false;
        }

        if (!validatePassword(password)) {
            $('#password').addClass('is-invalid');
            isFormValid = false;
        }

        if (!confirmPassword(password, confirmPasswordVal)) {
            $('#confirmPassword').addClass('is-invalid');
            isFormValid = false;
        }

        if (isFormValid) {
            var formData = {
                name: $('#name').val(),
                email: email,
                password: password,
                confirmPassword: confirmPasswordVal
            };

            $.ajax({
                type: 'POST',
                url: '/register',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        window.location.href = '/login';
                    } else {
                        alert('Błąd: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText, error);
                }
            });
        }
    });
});
