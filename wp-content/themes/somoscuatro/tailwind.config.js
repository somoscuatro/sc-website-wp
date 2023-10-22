module.exports = {
	content: [ './src/**/*.{php,twig}', './templates/**/*.twig', './assets/**/*.js' ],
	theme: {
		container: {
			center: true,
			screens: {
				sm: '640px',
				md: '768px',
				lg: '1024px',
				xl: '1280px',
			},
		},
	},
	plugins: [],
};
