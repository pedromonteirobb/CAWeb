<?php
/**
 * Loads CAWeb <header> tag.
 *
 * @package CAWeb
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $post;
$caweb_version      = caweb_template_version();
$caweb_deprecating  = '5.5' === $caweb_version;
$caweb_loaded       = isset( $args['loaded'] ) && $args['loaded'];
$caweb_fixed_header = $caweb_deprecating && ! $caweb_loaded && get_option( 'ca_sticky_navigation', false ) ? ' fixed' : '';
$caweb_color        = get_option( 'ca_site_color_scheme', 'oceanside' );
$caweb_schemes      = caweb_color_schemes( $caweb_version, 'filename' );
$caweb_colorscheme  = isset( $caweb_schemes[ $caweb_color ] ) ? $caweb_color : 'oceanside';


/* Search */
$caweb_google_search_id         = get_option( 'ca_google_search_id', '' );
$caweb_frontpage_search_enabled = get_option( 'ca_frontpage_search_enabled' );

/* Google Translate */
$caweb_google_trans_enabled = get_option( 'ca_google_trans_enabled' );
$caweb_google_trans_page    = get_option( 'ca_google_trans_page', '' );
$caweb_google_trans_icon    = get_option( 'ca_google_trans_icon', '' );

/* Google Tag Manager */
$caweb_google_tag_manager_id = get_option( 'ca_google_tag_manager_id', '' );

if ( ! empty( $caweb_google_tag_manager_id ) ) :
	$caweb_google_tag_src = sprintf( 'https://www.googletagmanager.com/ns.html?id=%1$s', $caweb_google_tag_manager_id );

	?>
<!-- Google Tag Manager (noscript) -->
<noscript>
	<iframe src="<?php print esc_url( $caweb_google_tag_src ); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>

<?php endif; ?>

<header id="header" class="global-header<?php print esc_attr( $caweb_fixed_header ); ?>">
	<div id="skip-to-content"><a href="#main-content">Skip to Main Content</a></div>
	<div id="caweb_alerts"></div>
	<?php

	/* Include Utility Header */
	require_once 'utility-header.php';

	if ( $caweb_deprecating ) {
		/* Include Location Bar */
		require_once 'bar-location.php';
	}

	/* Include Settings Bar */
	require_once 'bar-settings.php';

	/* Include Branding */
	require_once 'branding.php';

	/* Include Mobile Controls */
	require_once 'mobile-controls.php';

	if ( $caweb_deprecating ) :
		?>
	<div class="navigation-search">

	<!-- Include Navigation -->
		<?php
		wp_nav_menu(
			array(
				'theme_location'               => 'header-menu',
				'style'                        => get_option( 'ca_default_navigation_menu', 'singlelevel' ),
				'home_link'                    => ( ! is_front_page() && get_option( 'ca_home_nav_link', true ) ? true : false ),
			)
		);

		$caweb_search_class  = is_front_page() && $caweb_frontpage_search_enabled ? ' featured-search fade ' : '';
		$caweb_search_class .= empty( $caweb_google_search_id ) ? ' hidden ' : '';
		?>
		<div id="head-search" class="search-container hidden-print<?php print esc_attr( $caweb_search_class ); ?>" role="region" aria-label="Search Expanded">
			<?php
			if ( 'page-templates/searchpage.php' !== get_page_template_slug( get_the_ID() ) ) {
				require_once 'search-form.php';
			}
			?>
		</div>
	</div>
	<?php else : ?>

	<div class="navigation-search full-width-nav container">
		<?php if ( ! empty( $caweb_google_search_id ) && 'page-templates/searchpage.php' !== get_page_template_slug( get_the_ID() ) ) : ?>
		<div id="head-search" class="search-container hidden-print featured-search">
			<?php require_once 'search-form.php'; ?>
		</div>
		<?php endif; ?>
		<!-- Include Navigation -->
		<?php

		wp_nav_menu(
			array(
				'theme_location'               => 'header-menu',
				'style'                        => get_option( 'ca_default_navigation_menu', 'singlelevel' ),
				'home_link'                    => ( ! is_front_page() && get_option( 'ca_home_nav_link', true ) ? true : false ),
			)
		);

		?>

	</div>
	<?php endif; ?>
</header>
