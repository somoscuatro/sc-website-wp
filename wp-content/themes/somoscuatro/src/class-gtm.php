<?php
/**
 * Google Tag Manager custom functionality.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

/**
 * Google Tag Manager custom functionality.
 */
class GTM {

	/**
	 * The Google Tag Manager ID.
	 *
	 * @var string
	 */
	private const GTM_ID = 'GTM-P5S4MNT';

	/**
	 * Initializes Google Tag Manager custom functionality.
	 */
	public static function init(): void {
		add_action( 'wp_head', __CLASS__ . '::google_tag_manager_head' );
		add_action( 'wp_body_open', __CLASS__ . '::google_tag_manager_body' );
	}

	/**
	 * Adds Google Tag Manager head script.
	 */
	public static function google_tag_manager_head(): void {
		?>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_attr( self::GTM_ID ); ?>');</script>
		<?php
	}

	/**
	 * Adds Google Tag Manager body script.
	 */
	public static function google_tag_manager_body(): void {
		?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( self::GTM_ID ); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<?php
	}
}
