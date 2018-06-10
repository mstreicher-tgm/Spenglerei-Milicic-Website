$(function() {
  var visible = false;

  if($(window).scrollTop() < $('.navbar-fixed').height()) {
    $(".fixed-action-btn").addClass('scale-out');
    visible = false;
  } else {
    $(".fixed-action-btn").addClass('scale-in');
    visible = true;
  }


  $(document).scroll(function() {
    if($(window).scrollTop() < $('.navbar-fixed').height() && visible != false) {
      visible = false;
      $(".fixed-action-btn").removeClass('scale-in');
      $(".fixed-action-btn").addClass('scale-out');
    }
    if($(window).scrollTop() > $('.navbar-fixed').height() && visible != true) {
      visible = true;
      $(".fixed-action-btn").removeClass('scale-out');
      $(".fixed-action-btn").addClass('scale-in');
    }
  });
});
