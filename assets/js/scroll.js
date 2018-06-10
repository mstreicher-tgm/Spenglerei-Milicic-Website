$(function() {
  $(document).on('click', 'a.page-scroll', function(event) {
    var $anchor = $(this);
    var action = $($anchor.attr('href')).offset().top - $('nav').height();
    $('html, body').stop().animate({
      scrollTop: action
    }, 1500, 'easeInOutExpo');
    event.preventDefault();
  });
});
