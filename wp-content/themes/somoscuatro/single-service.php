<?php
/**
 * The index template file.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

TimberLibrary::render( 'index.twig', $context );
