<?php
/**
 * Contains Somoscuatro\Theme\Translation Class.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;
use Somoscuatro\Theme\Helpers\Filesystem;

/**
 * Translations Management Class.
 */
class Translation {

	use Filesystem;

	/**
	 * Loads the Theme Translation Domain.
	 */
	#[Action( 'after_setup_theme' )]
	public function load_text_domain(): void {
		load_theme_textdomain( 'somoscuatro-theme', $this->get_base_path() . '/languages' );
	}
}
