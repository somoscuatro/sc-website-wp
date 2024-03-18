<?php
/**
 * The single glossary template file.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

$context['breadcrumbs'] = array(
	'homepage'      => array(
		'title' => 'Home',
		'url'   => get_bloginfo( 'url' ),
	),
	'glossary_page' => array(
		'title' => 'Glossary',
		'url'   => get_permalink( get_theme_mod( 'glossary_page' ) ),
	),
);

TimberLibrary::render( 'single-glossary-term.twig', $context );
