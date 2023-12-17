$(function() {
  $(".settings-content").not("#settings-index").hide();

  $(".settings-menu button").click(function() {
    $(".settings-menu button").removeClass("active");

    $(this).addClass("active");

    var targetDivId = $(this).data("target");
    $(".settings-content").hide();
    $("#" + targetDivId).show();
  });
});