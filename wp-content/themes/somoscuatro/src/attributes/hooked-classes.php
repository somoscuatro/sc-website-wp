<?php
/**
 * List of classes to be hooked.
 *
 * @package somoscuatro-theme
 */

use Somoscuatro\Theme\ACF;
use Somoscuatro\Theme\Asset;
use Somoscuatro\Theme\Media;
use Somoscuatro\Theme\Timber;
/**
 * List of classes with hooks
 */
return array(
	ACF::class,
	Asset::class,
	Media::class,
	Timber::class,
);
