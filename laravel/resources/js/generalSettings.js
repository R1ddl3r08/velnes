$(function(){


    $("#deleteAccountButton").click(function() {
        $("#deleteAccountModal").css("display", "flex");
    });
  
    $("#closeDeleteAccountModalButton, #cancelDeleteAccountButton").click(function() {
        $("#deleteAccountModal").hide();
    });


})