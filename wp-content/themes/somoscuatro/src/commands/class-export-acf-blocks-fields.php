<?php
/**
 * WP CLI Command to export ACF Fields Blocks to JSON file.
 *
 * @package somoscuatro-theme
 */

namespace Somoscuatro\Theme\Commands;

use Somoscuatro\Theme\Helpers\Setup;

/**
 * WP CLI Command to export ACF Fields Blocks to JSON file.
 */
class Export_Acf_Blocks_Fields extends \WP_CLI_Command {

	use Setup;

	/**
	 * The Gutenberg Blocks base path.
	 *
	 * @var string
	 */
	private static $blocks_base_path;

	/**
	 * Exports ACF Fields for Gutenberg Blocks.
	 *
	 * ## OPTIONS:
	 *
	 * [<blocks-name-list>]
	 * : Exports the ACF Fields for the Gutenberg Blocks, given their names as a comma separated list.
	 *
	 * [--all]
	 * : Exports ACF Fields for all existing Gutenberg Blocks.
	 * ---
	 * default: ''
	 * ---
	 *
	 * ## EXAMPLES
	 *
	 *     wp export-acf-blocks-fields hero,cta
	 *     wp export-acf-blocks-fields --all
	 *
	 * @param array $args The CLI Command arguments.
	 * @param array $options The CLI Command options.
	 */
	public function __invoke( array $args, array $options ): void {
		self::$blocks_base_path = self::get_base_path() . '/src/blocks/';

		$options = wp_parse_args( $options, array( 'all' => '' ) );
		if ( $options['all'] ) {
			$blocks_dirs = glob( self::$blocks_base_path . '*', GLOB_ONLYDIR );
			foreach ( $blocks_dirs as $block_dir ) {
				self::export_acf_fields( basename( $block_dir ) );
			}
		} elseif ( isset( $args[0] ) ) {
			$blocks = explode( ',', trim( $args[0], ',' ) );

			foreach ( $blocks as $block ) {
				self::export_acf_fields( $block );
			}
		}
	}

	/**
	 * Exports the ACF Fields for the specified Gutenberg Block to JSON format.
	 *
	 * @param string $block The Gutenberg Block name.
	 */
	public static function export_acf_fields( string $block ): void {
		$block_class            = str_replace( '-', '_', ucfirst( $block ) );
		$namespaced_block_class = '\\Somoscuatro\\Theme\\Blocks\\' . $block_class . '\\' . $block_class;

		if ( ! class_exists( $namespaced_block_class, false ) || ! method_exists( $namespaced_block_class, 'get_acf_fields' ) ) {
			return;
		}

		$method = 'get_acf_fields';
		$json   = wp_json_encode( $namespaced_block_class::$method() );

		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents,WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents
		file_put_contents( self::$blocks_base_path . $block . '/fields.json', $json );
	}
}
