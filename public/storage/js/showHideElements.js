$(document).ready(function () {
    const userRole = sessionStorage.getItem('userRole');
    if (userRole === 'admin' || userRole === 'master') {
        $('#adminPanelButton').removeClass('d-none');
    }
    if (userRole === 'admin' || userRole === 'master') {
        $('.delete-icon').removeClass('d-none');
    }

});