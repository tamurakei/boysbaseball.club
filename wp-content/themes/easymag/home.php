<?php
/**
 * The home template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package EasyMag
 */

get_header(); ?>

	<div class="container">
	<div class="row">
		<div class="col-lg-9 col-md-9">
			<div id="primary" class="dt-archive-wrap">
				<?php if ( have_posts() ) :

					while ( have_posts() ) : the_post(); ?>

						<div <?php post_class( 'dt-archive-post' ); ?>>

							<?php if ( has_post_thumbnail() ) : ?>

								<figure>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'dt-featured-post-medium' ); ?></a>
								</figure>

							<?php endif; ?>

							<article>
								<header class="entry-header">
									<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								</header><!-- .entry-header -->

								<div class="dt-archive-post-content">

									<?php the_excerpt(); ?>

								</div><!-- .dt-archive-post-content -->
							</article>

							<div class="clearfix"></div>
						</div><!-- .dt-archive-post -->

					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

					<div class="clearfix"></div>

					<div class="dt-pagination-nav">
						<?php echo the_posts_pagination(); ?>
					</div><!---- .dt-pagination-nav ---->

				<?php else : ?>

					<p><?php _e( 'Sorry, no posts matched your criteria.', 'easymag' ); ?></p>

				<?php endif; ?>

			</div>
		</div>

		<div class="col-lg-3 col-md-3">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
