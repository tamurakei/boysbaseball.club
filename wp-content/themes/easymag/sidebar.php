<?php
/**
 * The sidebar containing the error widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EasyMag
 */

if ( ! is_active_sidebar( 'dt-right-sidebar' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area dt-sidebar" role="complementary">
	<?php dynamic_sidebar( 'dt-right-sidebar' ); ?>
</div><!-- #secondary -->

