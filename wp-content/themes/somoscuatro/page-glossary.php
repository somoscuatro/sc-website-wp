<?php
/**
 * The Glossary Page Template File.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

$context['index_letters'] = range( 'A', 'Z' );

TimberLibrary::render( 'page-glossary.twig', $context );
