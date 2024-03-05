document.addEventListener( 'DOMContentLoaded', () => {
	const mainMobileMenu = document.getElementById( 'nav-site-header-primary-mobile' );

	const mobileNavHamburger = document.getElementById( 'mobile-nav-hamburger' );

	mobileNavHamburger?.addEventListener( 'click', () => {
		mobileNavHamburger.classList.toggle( 'open' );
		mainMobileMenu.classList.toggle( 'hidden' );
	} );

	window.addEventListener( 'orientationchange', () => {
		mobileNavHamburger.classList.remove( 'open' );
		mainMobileMenu.classList.add( 'hidden' );
	} );
} );
