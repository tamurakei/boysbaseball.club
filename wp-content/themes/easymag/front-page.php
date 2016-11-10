<?php
/**
 * Template Name: Front Page
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

	<?php if ( 'page' == get_option( 'show_on_front' ) ) :

		if( is_active_sidebar( 'dt-news-ticker' ) ) : ?>

		<div class="container bt-news-ticker-wrap">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<?php dynamic_sidebar( 'dt-news-ticker' ); ?>
				</div><!-- .col-lg-12 /col-md-12 -->
			</div><!-- .row -->
		</div><!-- .bt-news-ticker-wrap -->

		<?php endif; ?>

		<div class="container">
			<div class="row">
				<?php if( is_active_sidebar( 'dt-featured-news-slider' ) ) : ?>

					<div class="col-lg-6 col-md-6">
						<?php dynamic_sidebar( 'dt-featured-news-slider' ); ?>
					</div><!-- .col-lg-6 .col-md-6 -->

				<?php endif; ?>

				<?php if( is_active_sidebar( 'dt-highlighted-news' ) ) : ?>

					<div class="col-lg-6 col-md-6">
						<?php dynamic_sidebar( 'dt-highlighted-news' ); ?>
					</div><!-- .col-lg-6. col-md-6 -->

				<?php endif; ?>

			</div><!-- .row -->
		</div><!-- .container -->

		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9">
					<div class="dt-news-main">
						<?php if ( is_active_sidebar( 'dt-front-top-section-news' ) ) {
							dynamic_sidebar( 'dt-front-top-section-news' );
						} else { ?>
							<div id="primary" class="content-area">
								<main id="main" class="site-main" role="main">

									<?php if ( have_posts() ) : ?>

										<?php if ( is_home() && ! is_front_page() ) : ?>
											<header>
												<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
											</header>
										<?php endif; ?>

										<?php /* Start the Loop */ ?>
										<?php while ( have_posts() ) : the_post(); ?>

											<?php

											/*
											 * Include the Post-Format-specific template for the content.
											 * If you want to override this in a child theme, then include a file
											 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
											 */
											get_template_part( 'template-parts/content', get_post_format() );
											?>

										<?php endwhile; ?>

										<?php the_posts_navigation(); ?>

									<?php else : ?>

										<?php get_template_part( 'template-parts/content', 'none' ); ?>

									<?php endif; ?>

								</main><!-- #main -->
							</div><!-- #primary -->
						<?php } ?>
					</div><!-- .dt-news-main -->
				</div><!-- .col-lg-9 -->

				<div class="col-lg-3 col-md-3">
					<div style="margin-top: 20px">
						<?php get_sidebar(); ?>
					</div>
				</div><!-- .col-lg-4 -->

			</div><!-- .row -->
		</div><!-- .container -->

	<?php else : ?>

		<div class="container">
			<div class="row">
				<div class="col-lg-9 col-md-9">

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

					<?php
					endwhile;

					endif;
					?>

					<?php wp_reset_postdata(); ?>

					<div class="clearfix"></div>

					<div class="dt-pagination-nav">
						<?php echo the_posts_pagination(); ?>
					</div><!---- .dt-pagination-nav ---->
				</div><!-- .col-lg-8 -->

				<div class="col-lg-3 col-md-3">
					<?php get_sidebar(); ?>
				</div><!-- .col-lg-4 -->
			</div><!-- .row -->
		</div><!-- .container -->

	<?php endif; ?>	

<?php get_footer(); ?>
