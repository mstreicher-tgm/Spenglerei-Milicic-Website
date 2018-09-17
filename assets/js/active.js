$(function() {

  if(($(window).scrollTop() >= 0) && ($(window).scrollTop() <= $('#about').position().top - 70)) {
    $('#navhome').addClass('active');
    $('#sidenavhome').addClass('active');
  } else {
    $('#navhome').removeClass('active');
    $('#sidenavhome').removeClass('active');
  }

  if(($(window).scrollTop() >= $('#about').position().top - 70) && ($(window).scrollTop() <= $('#blog').position().top - 70)) {
    $('#navabout').addClass('active');
    $('#sidenavabout').addClass('active');
  } else {
    $('#navabout').removeClass('active');
    $('#sidenavabout').removeClass('active')
  }

  if(($(window).scrollTop() >= $('#blog').position().top - 70) && ($(window).scrollTop() <= $('#contact').position().top - 70)) {
    $('#navblog').addClass('active');
    $('#sidenavblog').addClass('active');
  } else {
    $('#navblog').removeClass('active');
    $('#sidenavblog').removeClass('active');
  }


  if(($(window).scrollTop() >= $('#contact').position().top - 70)) {
    $('#navcontact').addClass('active');
    $('#sidenavcontact').addClass('active');
  } else {
    $('#navcontact').removeClass('active');
    $('#sidenavcontact').removeClass('active');
  }

  $(document).scroll(function() {
    if(($(window).scrollTop() >= 0) && ($(window).scrollTop() <= $('#about').position().top - 70)) {
      $('#navhome').addClass('active');
      $('#sidenavhome').addClass('active');
    } else {
      $('#navhome').removeClass('active');
      $('#sidenavhome').removeClass('active');
    }

    if(($(window).scrollTop() >= $('#about').position().top - 70) && ($(window).scrollTop() <= $('#blog').position().top - 70)) {
      $('#navabout').addClass('active');
      $('#sidenavabout').addClass('active');
    } else {
      $('#navabout').removeClass('active');
      $('#sidenavabout').removeClass('active')
    }

    if(($(window).scrollTop() >= $('#blog').position().top - 70) && ($(window).scrollTop() <= $('#contact').position().top - 70)) {
      $('#navblog').addClass('active');
      $('#sidenavblog').addClass('active');
    } else {
      $('#navblog').removeClass('active');
      $('#sidenavblog').removeClass('active');
    }

    if(($(window).scrollTop() >= $('#contact').position().top - 70)) {
      $('#navcontact').addClass('active');
      $('#sidenavcontact').addClass('active');
    } else {
      $('#navcontact').removeClass('active');
      $('#sidenavcontact').removeClass('active');
    }
  });
});
