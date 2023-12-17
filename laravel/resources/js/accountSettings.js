$(function(){


    $('#logoutButton').click(function () {
        $("#logoutModal").css('display', 'flex');
    });

    $('.closeModal, #cancelLogoutButton').click(function () {
        $("#logoutModal").css('display', 'none');
    });


})