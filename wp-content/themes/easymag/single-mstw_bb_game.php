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

							<?php //get_template_part( 'template-parts/content-single', 'page' ); ?>
							<h3>第21回高野山旗全国軟式野球大会については下記ページを参照ください</h3>
							<a href="http://www.boysbaseball.club/2016/07/%E7%AC%AC21%E5%9B%9E%E9%AB%98%E9%87%8E%E5%B1%B1%E6%97%97%E5%85%A8%E5%9B%BD%E5%AD%A6%E7%AB%A5%E8%BB%9F%E5%BC%8F%E9%87%8E%E7%90%83%E5%A4%A7%E4%BC%9A1%E5%9B%9E%E6%88%A6%E3%81%AE%E7%B5%84%E3%81%BF/">第21回高野山旗全国軟式野球大会組み合わせ</a>

							<?php //the_meta() ;?>
                                                        <?php //echo do_shortcode('[mstw_tourney_table tourney=21koyasan]');?>

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
