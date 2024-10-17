$(document).ready(function(){
    $('#avatarImage').on('change', function(){
        var formData = new FormData();
        var file = $('#avatarImage')[0].files[0];

        if (file) {
            formData.append('image', file);

            $.ajax({
                url: '/setAvatarImage',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    location.href = '/account'
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('Upload failed: ' + error);
                }
            });
        }
    });
});
