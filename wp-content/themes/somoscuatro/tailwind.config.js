import * as tailwindColorPalette from './tailwind.colors.json';
import * as tailwindSafeBgColorPalette from './tailwind.bg-colors-safelist.json';

module.exports = {
	content: [
		'./src/**/*.{php,twig}',
		'./templates/**/*.twig',
		'./assets/**/*.js',
	],
	theme: {
		container: {
			center: true,
			screens: {
				sm: '640px',
				md: '768px',
				lg: '1024px',
				xl: '1280px',
			},
			padding: {
				DEFAULT: '1rem',
				'2xl': '0',
			},
		},
		extend: {
			fontFamily: {
				sans: ['Jost', 'Helvetica Neue', 'Arial', 'sans-serif'],
				syne: ['Syne', 'Helvetica Neue', 'Arial', 'sans-serif'],
			},
			colors: tailwindColorPalette,
		},
	},
	plugins: [require('tailwindcss-animated')],
	safelist: [
		...tailwindSafeBgColorPalette.colors,
		'border-anti-flash-white-100',
		'border-anti-flash-white-900',
		'stroke-anti-flash-white-100',
		'stroke-anti-flash-white-900',
	],
};
