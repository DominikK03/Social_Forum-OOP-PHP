$(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        const username = $('#name').val();
        const password = $('#password').val();

        var formData = {
            name: username,
            password: password
        };

        $.ajax({
            type: 'POST',
            url: '/login',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    window.location.href = '/';
                } else {
                    $('.invalid-feedback').show();
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText, error);
            }
        });
    });
});
