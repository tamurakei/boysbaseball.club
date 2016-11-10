<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package EasyMag
 */

get_header(); ?>

	<div class="dt-default-single-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<main id="main" class="site-main" role="main">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'template-parts/content-single', 'page' ); ?>

							<?php the_post_navigation(); ?>

							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>

						<?php endwhile; // End of the loop. ?>
					</main><!-- #main -->
				</div><!-- .col-lg-12 -->
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .dt-default-single-page -->

<?php get_footer(); ?>
