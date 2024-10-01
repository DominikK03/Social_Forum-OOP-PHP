$(document).ready(function () {

    var formData = {
        name: $('#name').val(),
        password: $('#password').val()
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
                alert('Błąd: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText, error);
        }
    });
});