$(document).ready(function () {
	$(".single-item").slick({
		autoplay: true,
		autoplaySpeed: 3000,
		speed: 500,
		infinite: true,
		cssEase: "linear",
		fade: true,
		arrows: false,
		dots: true,
		responsive: [
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					arrows: false,
				},
			},
		],
	});

	$(".team-carousel").slick({
		infinite: true,
		slidesToShow: 4,
		slidesToScroll: 1,
		dots: true,
		arrows: false,
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

	// $(".producto-carousel").slick({
	// 	infinite: true,
	// 	slidesToShow: 3,
	// 	slidesToScroll: 1,
	// 	rows: 2,
	// 	dots: false,
	// 	arrows: false,
	// 	responsive: [
	// 		{
	// 			breakpoint: 1200,
	// 			settings: {
	// 				slidesToShow: 3,
	// 				slidesToScroll: 3,
	// 				infinite: true,
	// 				dots: true,
	// 			},
	// 		},
	// 		{
	// 			breakpoint: 900,
	// 			settings: {
	// 				slidesToShow: 2,
	// 				slidesToScroll: 2,
	// 			},
	// 		},
	// 		{
	// 			breakpoint: 600,
	// 			settings: {
	// 				slidesToShow: 1,
	// 				slidesToScroll: 1,
	// 				dots: false,
	// 				autoplay: true,
	// 				autoplaySpeed: 1000,
	// 			},
	// 		},
	// 	],
	// });
});
