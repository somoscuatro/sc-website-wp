<?php
/**
 * The Single Case Study Template File.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

TimberLibrary::render( 'single-case-study.twig', $context );
