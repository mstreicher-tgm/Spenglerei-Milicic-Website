$(document).ready(function () {
  $('#underslider').css('margin-top', $('.slider').height() - $('nav').height());
 /**
  $(function() {
    var colored = false;
    if($(window).scrollTop() >= $('.slider').height() - 65) {
      colored = true;
      $("nav").css('backgroundColor', 'rgba(255,0,0,1) !important');
    }
    if($(window).scrollTop() <= $('.slider').height() - 65) {
      colored = false;
      $("nav").css('backgroundColor', 'rgba(0,0,0,0.6) !important');
    }
    $(document).scroll(function() {
      if(($(window).scrollTop() >= $('.slider').height() - 65) && colored == false) {
        colored = true;
        $("nav").stop().animate({backgroundColor: 'rgba(255,0,0,1) !important'}, 550);
      }

      if(($(window).scrollTop() <= $('.slider').height() - 66) && colored == true) {
        colored = false;
        $("nav").stop().animate({backgroundColor: 'rgba(0,0,0,0.6) !important'}, 550);
      }
    });
  });
  **/
});
