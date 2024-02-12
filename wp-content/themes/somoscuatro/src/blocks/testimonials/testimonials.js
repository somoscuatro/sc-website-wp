/* global Glider */
document.addEventListener( 'DOMContentLoaded', function() {
	new Glider( document.querySelector( '.glider' ), {
		slidesToShow: 1,
		slideToScroll: 1,
		draggable: true,
		arrows: {
			prev: '.glider-prev',
			next: '.glider-next',
		},
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
					slideToScroll: 1,
					draggable: false,
				},
			},
		],
	} );
} );
