$(function(){


    $('.profile-picture').on('click', function(){
        $('.profile-menu').toggle();
    })

    $('#closeNotifications').on('click', function(){
        $('.notifications.window').hide();
    })

    $('.notifications.icon').on('click', function(){
        $('.notifications.window').toggle();
    })

    $('.search.icon').on('click', function(){
        $(this).hide()
        $('#searchInput').show()
    })

    $('#calendar-settings').on('click', function(){
        $('.calendar-settings').toggle();
    })

    $(document).on('click', function(event){
        if(!$(event.target).closest('#searchInput, .search.icon').length) {
            $('#searchInput').hide()
            $('#userSearch').val('')
            $('.search.icon').show()
        }
    })

    $('#searchInput').on('click', function(event){
        event.stopPropagation();
    })
})