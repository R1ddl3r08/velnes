$(document).ready(function() {
    let activeButton = $('#btnAppointment');

    $('.options button').click(function() {
        activeButton.removeClass('active');

        $('.create-appointment, .create-absence, .create-chore, .create-note').hide();

        var buttonId = $(this).attr('id');

        $('#create' + buttonId.replace('btn', '')).show();

        activeButton = $(this);

        activeButton.addClass('active');
    });
});