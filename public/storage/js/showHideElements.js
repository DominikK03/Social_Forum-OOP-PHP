$(document).ready(function () {
    const userRole = sessionStorage.getItem('userRole');
    if (userRole === 'admin' || userRole === 'master') {
        $('#adminPanelButton').removeClass('d-none');
        $('.delete-post').removeClass('d-none');
        $('.delete-comment').removeClass('d-none');
    }

});