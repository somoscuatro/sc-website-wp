<?php
/**
 * Template Name: Legal
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

TimberLibrary::render( 'legal.twig', $context );
