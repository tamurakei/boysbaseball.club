<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package EasyMag
 */

get_header(); ?>

	<div class="dt-default-page">
		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9">
					<main id="main" class="site-main" role="main">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php get_template_part( 'template-parts/content', 'page' ); ?>

							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
							?>

						<?php endwhile; // End of the loop. ?>

					</main><!-- #main -->
				</div><!-- .col-lg-9 -->

				<div class="col-lg-3 col-md-3">
					<?php get_sidebar(); ?>
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- .dt-default-page -->

<?php get_footer(); ?>
