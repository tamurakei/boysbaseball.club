<?php
/**
 * MSTW League Manager single tournament template.
 *
 * NOTE: Plugin users/site admins may have to modify this template to fit their 
 * individual themes. This template has been tested in the WordPress 
 * Twenty Eleven and Twenty Twelve themes. 
 *
 */
 ?>

<?php get_header(); ?>

<div id="primary">
 <div id="content" role="main">
 
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php echo do_shortcode( '[mstw_tourney_bracket tourney="test-tournament"]' )?>
	 
		
	</article> <!-- #post-<?php the_ID(); ?> -->



 </div><!-- #content -->
</div><!-- #primary -->

<?php get_footer();?>