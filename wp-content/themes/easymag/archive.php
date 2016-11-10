<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package EasyMag
 */

get_header(); ?>

	<div class="container">
		<div class="row">

			<div class="col-lg-9 col-md-9">
				<div class="dt-category-wrap">
					<div id="primary" class="content-area">
						<main id="main" class="site-main" role="main">

							<?php if ( have_posts() ) : ?>
								
								<header class="page-header">
									<?php
									the_archive_title( '<h1 class="page-title">', '</h1>' );
									the_archive_description( '<div class="taxonomy-description">', '</div>' );
									?>
								</header><!-- .page-header -->

								<?php /* Start the Loop */ ?>

								<div class="dt-category-posts">
									<?php
									$count = 1;
									 while ( have_posts() ) : the_post(); ?>

										<?php if( $count == 1 ) { $img_size = 'dt-featured-post-medium'; } else { $img_size = 'dt-featured-post-small'; } ?>
										<?php if( $count == 1 ) { echo '<div class="dt-news-post-highlighted">'; } elseif ( $count == 2 ) { echo '<div class="dt-news-post-list">'; } ?>

										<div class="dt-news-post">
											<figure class="dt-news-post-img">
												<?php
												if ( has_post_thumbnail() ) :
													$image = '';
													$title_attribute = get_the_title( $post->ID );
													$image .= '<a href="'. esc_url( get_permalink() ) . '" title="' . the_title( '', '', false ) .'">';

													if( $count == 1 ) :
														$image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-large', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
													else :
														$image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
													endif;

													echo $image;

												else :
													easymag_post_img( '1' );

												endif;
												?>

												<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><span class="transition35"> <i class="fa fa-search transition35"></i></span></a>
											</figure><!-- .dt-news-post-img -->

											<div class="dt-news-post-content">
												<div class="dt-news-post-meta">
													<span class="dt-news-post-date"><i class="fa fa-calendar"></i> <?php the_time ( get_option ( 'date_format' ) ); ?></span>

													<span class="dt-news-post-comments"><i class="fa fa-comments"></i> <?php comments_number( 'No Responses', 'one Response', '% Responses' ); ?></span>
												</div><!-- .dt-news-post-meta -->

												<h3><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

												<?php if( $count == 1 ) : ?>

												<div class="dt-news-post-desc">
													<?php
													$excerpt = get_the_excerpt();
													$limit   = "350";
													$pad     = "...";

													if( strlen( $excerpt ) <= $limit ) {
														echo esc_html( $excerpt );
													} else {
														$excerpt = substr( $excerpt, 0, $limit ) . $pad;
														echo esc_html( $excerpt );
													}
													?>
												</div><!-- .dt-news-post-desc -->

												<?php else : ?>

													<div class="dt-news-post-desc">
														<?php
														$excerpt = get_the_excerpt();
														$limit   = "260";
														$pad     = "...";

														if( strlen( $excerpt ) <= $limit ) {
															echo esc_html( $excerpt );
														} else {
															$excerpt = substr( $excerpt, 0, $limit ) . $pad;
															echo esc_html( $excerpt );
														}
														?>
													</div><!-- .dt-news-post-desc -->

												<?php endif; ?>

											</div><!-- .dt-news-post-content -->

											<div class="dt-category-post-readmore">
												<a class="transition35" href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'read more', 'easymag' ); ?></></a>
											</div><!-- .dt-category-post-readmore -->

										</div><!-- .dt-news-post -->

										<?php if( $count == 1 ) { echo '</div>'; } ?>

										<?php
										$count++;

									endwhile; ?>

									<?php wp_reset_postdata(); ?>
								</div><!-- .dt-category-posts -->

								<div class="clearfix"></div>

								<div class="dt-pagination-nav">
									<?php echo paginate_links(); ?>
								</div><!---- .jw-pagination-nav ---->

							<?php else : ?>
								<p><?php _e( 'Sorry, no posts matched your criteria.', 'easymag' ); ?></p>
							<?php endif; ?>

						</main><!-- #main -->
					</div><!-- #primary -->
				</div><!-- .dt-category-wrap -->
			</div><!-- .col-lg-9-->

			<div class="col-lg-3 col-md-3">
				<?php get_sidebar(); ?>
			</div>

		</div><!-- .row -->
	</div><!-- .container -->

<?php get_footer(); ?>
