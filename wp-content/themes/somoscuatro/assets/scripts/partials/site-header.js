document.addEventListener('DOMContentLoaded', function () {
	window.addEventListener('scroll', function () {
		if (window.scrollY > 80) {
			document.querySelector('.site-header').classList.add('border-b');
		} else {
			document.querySelector('.site-header').classList.remove('border-b');
		}
	});
});
