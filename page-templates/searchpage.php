<?php
/**
 * Template Name: Search Results Page
 *
 * This is the template for Search Results Page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-page
 *
 * @package CAWeb
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$caweb_content_dir = caweb_design_system_enabled() ? 'design-system' : 'content';
$caweb_keyword         = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';

?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'primary' ); ?>>
	<?php
		/**
		 * Loads header
		 */
		get_header();
	?>

	<div id="page-container" class="<?php print esc_attr( apply_filters( 'caweb_ds_suffix', 'page-container' ) ); ?>">
		<div id="et-main-area">
			<div id="main-content" class="<?php print esc_attr( apply_filters( 'caweb_ds_suffix', 'main-content' ) ); ?>" tabindex="-1">
				<main class="main-primary">
					<!--Search result section-->
					<div class="section section-default search-container active px-0">
						<?php
						require_once dirname( __DIR__ ) . "/partials/$caweb_content_dir/search-form.php";
						?>
					</div>
					<div class="section">
						<div class="<?php print esc_attr( ! caweb_design_system_enabled() ? 'container' : '' ) ?>">
							<h1>Search Results for: <?php print esc_attr( $caweb_keyword ); ?></h1>
							<gcse:searchresults-only></gcse:searchresults-only>
						</div>
					</div>
					<span class="return-top hidden-print"></span>
				</main>
			</div>

		</div>
	</div>

	<?php
		/**
		 * Loads footer
		 */
		get_footer();
	?>

</body>
</html>
