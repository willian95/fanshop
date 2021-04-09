// Menú fixed
$(window).scroll(function () {
  if ($(document).scrollTop() > 70 && $(window).width() >= 768) {
    $(".navbar-fixed-js").addClass("fixed");
    $(".nav-link").addClass("fixed-color");
  } else {
    $(".navbar-fixed-js").removeClass("fixed");
    $(".nav-link").removeClass("fixed-color");
  }
});

//navbar
let activeOne = $("#navbarNav").find("a.nav-link.active");

$(window).on("activate.bs.scrollspy", function (e, obj) {
  activeOne = $("#navbarNav").find("a.nav-link.active");
});

$("a.nav-link").hover(
  function () {
    activeOne.removeClass("active");
    $(this).addClass("active");
  },
  function () {
    console.log("hover out");
    $(this).removeClass("active");
    activeOne.addClass("active");
  }
);

// Menú responsive
$(function () {
  $('[data-toggle="offcanvas"]').on("click", function () {
    $(".offcanvas-collapse").toggleClass("open");
    $("body").toggleClasss("offcanvas-expanded");
  });
});

$(".hamburger").on("click", function () {
  $(this).toggleClass("is-active");
});

$(".nav-link").click(function () {
  $(".offcanvas-collapse").removeClass("open");
  $(".hamburger").toggleClass("is-active");
  $("body").removeClass("offcanvas-expanded");
});

// change language
let navLanguage = $(".nav-language").find("a.language");

$(".language").click(function () {
  var $this = $(this);
  if (navLanguage.hasClass("active")) {
    navLanguage.toggleClass("active");
  }
});

// filter productos

// filter items on button click
$(".filter-button-group").on("click", "li", function () {
  var filterValue = $(this).attr("data-filter");
  $(".grid").isotope({ filter: filterValue });
  $(".filter-button-group li").removeClass("active");
  $(this).addClass("active");
});

$(".main-client__content").slick({
  //    infinite: true,
  slidesToShow: 4,
  slidesToScroll: 4,
  dots: true,
  arrows: true,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: true,
      },
    },
    {
      breakpoint: 900,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
      },
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        autoplay: true,
        autoplaySpeed: 1000,
      },
    },
  ],
});

$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
 
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: true,
  autoplay: true,
  centerMode: true,
  focusOnSelect: true
});