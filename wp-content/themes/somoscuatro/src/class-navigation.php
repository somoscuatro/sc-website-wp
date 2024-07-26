<?php
/**
 * Contains Somoscuatro\Theme\Navigation Class.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Action;

/**
 * WordPress Custom Navigation Functionality.
 */
class Navigation {

	/**
	 * Registers Navigation Menus.
	 */
	#[Action( 'after_setup_theme' )]
	public function register_nav_menus(): void {
		register_nav_menu( 'site_header_primary', __( 'Site Header Primary', 'somoscuatro-theme' ) );
		register_nav_menu( 'site_footer_primary', __( 'Site Footer Primary', 'somoscuatro-theme' ) );
		register_nav_menu( 'site_footer_legals', __( 'Site Footer Legals', 'somoscuatro-theme' ) );
	}

	/**
	 * Adds Custom Fields to the Menu Item Edit Screen.
	 *
	 * @param string $item_id The Menu Item ID as a Numeric String.
	 */
	#[Action( 'wp_nav_menu_item_custom_fields' )]
	public static function add_menu_item_custom_fields( string $item_id ): void {
		wp_nonce_field( 'custom-fields-nonce', 'custom-fields-nonce-name' );
		$call_to_action = get_post_meta( $item_id, '_menu-item-call-to-action', true );
		?>
		<p class="field-link-cta description">
			<label for="edit-menu-item-call-to-action-<?php echo esc_attr( $item_id ); ?>">
				<input type="checkbox" id="edit-menu-item-call-to-action-<?php echo esc_attr( $item_id ); ?>" name="menu-item-call-to-action[<?php echo esc_attr( $item_id ); ?>]" <?php echo $call_to_action ? 'checked' : ''; ?>>
				<?php echo esc_html( __( 'Call to Action', 'somoscuatro-theme' ) ); ?>
			</label>
		</p>
		<?php
		$call_to_action = get_post_meta( $item_id, '_menu-item-show-bottom', true );
		?>
		<p class="field-link-show-bottom description">
			<label for="edit-menu-item-show-bottom-<?php echo esc_attr( $item_id ); ?>">
				<input type="checkbox" id="edit-menu-item-show-bottom-<?php echo esc_attr( $item_id ); ?>" name="menu-item-show-bottom[<?php echo esc_attr( $item_id ); ?>]" <?php echo $call_to_action ? 'checked' : ''; ?>>
				<?php echo esc_html( __( 'Show at the Bottom', 'somoscuatro-theme' ) ); ?>
			</label>
		</p>
		<?php
	}

	/**
	 * Saves Menu Item Custom Fields.
	 *
	 * @param integer $menu_id         The ID of the Updated Menu.
	 * @param integer $menu_item_db_id The ID of the Updated Menu Item.
	 */
	#[Action( 'wp_update_nav_menu_item', accepted_args: 2 )]
	public static function save_menu_item_custom_fields( int $menu_id, int $menu_item_db_id ): void {
		if (
			! isset( $_POST['custom-fields-nonce-name'] ) &&
			wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom-fields-nonce-name'] ) ), 'custom-fields-nonce' )
			) {
			return;
		}

		if ( isset( $_POST['menu-item-call-to-action'][ $menu_item_db_id ] ) ) {
			$call_to_action = sanitize_text_field( wp_unslash( $_POST['menu-item-call-to-action'][ $menu_item_db_id ] ) );
			update_post_meta( $menu_item_db_id, '_menu-item-call-to-action', $call_to_action );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu-item-call-to-action' );
		}

		if ( isset( $_POST['menu-item-show-bottom'][ $menu_item_db_id ] ) ) {
			$show_bottom = sanitize_text_field( wp_unslash( $_POST['menu-item-show-bottom'][ $menu_item_db_id ] ) );
			update_post_meta( $menu_item_db_id, '_menu-item-show-bottom', $show_bottom );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu-item-show-bottom' );
		}
	}
}
