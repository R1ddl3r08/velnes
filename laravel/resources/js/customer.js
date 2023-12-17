$(function(){

    let activeButton = $('#customerOverviewButton') 

    $('.customer-nav button').click(function () {
        activeButton.removeClass('active');

        $('.customer-overview, .customer-appointments, .customer-feedback').hide();

        let buttonId = $(this).attr('id');

        if (buttonId === 'customerOverviewButton') {
            $('.customer-overview').show();
        } else if (buttonId === 'customerAppointmentsButton') {
            $('.customer-appointments').show();
        } else if (buttonId === 'customerFeedbackButton') {
            $('.customer-feedback').css('display', 'flex');
        }

        activeButton = $(this);

        activeButton.addClass('active');
    });

    $(".feedback").click(function () {
        $(".feedback").removeClass("active");

        $(this).addClass("active");

        $(".feedback-full").hide();

        let feedbackId = $(this).attr("id");
        $("#" + feedbackId + "-full").show();
    });

    $(document).on('click', '.appointmentCrudModalButton', function () {
        var index = $('.appointmentCrudModalButton').index(this);

        $('.appointmentCrudModal').eq(index).toggle();
    });


})