<?php
/**
 * Template Name: Kit Digital
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

TimberLibrary::render( 'kit-digital.twig', $context );
