/* global glossary */
document.addEventListener( 'alpine:init', () => {
	const { Alpine } = window;

	Alpine.data( 'manageGlossary', () => ( {
		glossaryTerms: glossary.terms,
		availableLetters: glossary.letters,
		activeLetter: '',
		search: '',
		get filteredTerms() {
			if ( this.search === '' ) {
				return this.glossaryTerms;
			}
			return this.glossaryTerms.filter( ( term ) => {
				return term.post_title
					.replace( / /g, '' )
					.toLowerCase()
					.includes( this.search.replace( / /g, '' ).toLowerCase() );
			} );
		},
		showAllTerms() {
			this.search = '';
			this.activeLetter = '';
		},
	} ) );
} );
