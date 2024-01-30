const defaultTheme = require( 'tailwindcss/defaultTheme' );

import * as tailwindColorPalette from './tailwind.colors.json';
import * as tailwindSafeBgColorPalette from './tailwind.safe-bg-colors.json';

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
		extend: {
			fontFamily: {
				sans: [ 'Jost', ...defaultTheme.fontFamily.sans ],
				syne: [ 'Syne' ],
			},
			colors: tailwindColorPalette,
		},
	},
	plugins: [],
	purge: {
		safelist: [
			...tailwindSafeBgColorPalette.colors,
			'border-anti-flash-white-100',
			'border-anti-flash-white-900',
			'stroke-anti-flash-white-100',
			'stroke-anti-flash-white-900',
		],
	},
};
