<?php
/**
 * WordPress custom navigation functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

/**
 * WordPress custom navigation functionality.
 */
class Navigation {

	/**
	 * WordPress custom navigation functionality initialization.
	 */
	public static function init(): void {
		add_action( 'wp_nav_menu_item_custom_fields', __CLASS__ . '::add_menu_item_custom_fields' );
		add_action( 'wp_update_nav_menu_item', __CLASS__ . '::save_menu_item_custom_fields', 10, 2 );
	}

	/**
	 * Register navigation menus.
	 */
	public static function register(): void {
		register_nav_menu( 'site_header_primary', __( 'Site Header Primary', 'somoscuatro-theme' ) );
	}

	/**
	 * Adds custom fields to the menu item edit screen.
	 *
	 * @param string $item_id   The menu item ID as a numeric string.
	 */
	public static function add_menu_item_custom_fields( string $item_id ): void {
		wp_nonce_field( 'call-to-action-menu-meta-nonce', 'call-to-action-menu-meta-nonce-name' );
		$call_to_action = get_post_meta( $item_id, '_menu-item-call-to-action', true );
		?>
		<p class="field-link-cta description">
			<label for="edit-menu-item-call-to-action-<?php echo esc_attr( $item_id ); ?>">
				<input type="checkbox" id="edit-menu-item-call-to-action-<?php echo esc_attr( $item_id ); ?>" name="menu-item-call-to-action[<?php echo esc_attr( $item_id ); ?>]" <?php echo $call_to_action ? 'checked' : ''; ?>>
				<?php echo esc_html( __( 'Call to Action', 'somoscuatro-theme' ) ); ?>
			</label>
		</p>
		<?php
	}

	/**
	 * Saves menu item custom fields.
	 *
	 * @param integer $menu_id The ID of the updated menu.
	 * @param integer $menu_item_db_id The ID of the updated menu item.
	 */
	public static function save_menu_item_custom_fields( int $menu_id, int $menu_item_db_id ): void {
		if (
			! isset( $_POST['call-to-action-menu-meta-nonce-name'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['call-to-action-menu-meta-nonce-name'] ) ), 'call-to-action-menu-meta-nonce' )
			) {
			return;
		}

		if ( isset( $_POST['menu-item-call-to-action'][ $menu_item_db_id ] ) ) {
			$call_to_action = sanitize_text_field( wp_unslash( $_POST['menu-item-call-to-action'][ $menu_item_db_id ] ) );
			update_post_meta( $menu_item_db_id, '_menu-item-call-to-action', $call_to_action );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu-item-call-to-action' );
		}
	}
}
