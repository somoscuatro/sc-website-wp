const fs = require( 'fs' );
const mix = require( 'laravel-mix' );

mix.setPublicPath( 'dist' );
mix.setResourceRoot( '../' );

const discover = ( dirs, type, excludedDirs = [] ) => {
	let files = [];

	dirs.forEach( ( dir ) => {
		if ( excludedDirs.indexOf( dir ) === -1 ) {
			fs.readdirSync( dir ).forEach( ( node ) => {
				const nodePath = `${ dir }/${ node }`;
				if ( fs.statSync( nodePath ).isFile() ) {
					if ( nodePath.endsWith( type ) && ! node.startsWith( '.' ) && ! node.startsWith( '_' ) ) {
						files.push( nodePath );
					}
				} else {
					files = files.concat( discover( [ nodePath ], type ) );
				}
			} );
		}
	} );

	return files;
};

discover( [ 'assets/styles' ], '.css' ).forEach( ( file ) => {
	mix.postCss( file, 'styles', [
		require( 'tailwindcss/nesting' ),
		require( 'tailwindcss' ),
	] );
} );
