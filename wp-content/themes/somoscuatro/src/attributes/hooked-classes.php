<?php
/**
 * List of classes to be hooked.
 *
 * @package somoscuatro-theme
 */

use Somoscuatro\Theme\ACF;
use Somoscuatro\Theme\Asset;
use Somoscuatro\Theme\Custom_Post_Types\Post_Types\Case_Studies;
use Somoscuatro\Theme\Custom_Post_Types\Post_Types\Services;
use Somoscuatro\Theme\Customizer;
use Somoscuatro\Theme\GTM;
use Somoscuatro\Theme\Gutenberg;
use Somoscuatro\Theme\Media;
use Somoscuatro\Theme\Navigation;
use Somoscuatro\Theme\Performance;
use Somoscuatro\Theme\SEO;
use Somoscuatro\Theme\Theme;
use Somoscuatro\Theme\Timber;
use Somoscuatro\Theme\Translation;

/**
 * List of classes with hooks
 */
return array(
	Theme::class,

	ACF::class,
	Asset::class,
	Customizer::class,
	GTM::class,
	Gutenberg::class,
	Media::class,
	Navigation::class,
	Performance::class,
	SEO::class,
	Timber::class,
	Translation::class,

	Case_Studies::class,
	Services::class,
);
