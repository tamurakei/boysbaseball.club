<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EasyMag
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="fb:pages" content="562520193936299" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	 (adsbygoogle = window.adsbygoogle || []).push({
	    google_ad_client: "ca-pub-5054867079497310",
	    enable_page_level_ads: true
	  });
	</script>
</head>

<body <?php body_class(); ?>>
	<div class="dt-body-wrap<?php if ( get_theme_mod( 'easymag_default_layout', 0 ) != 'wide_layout' ) : ?> dt-boxed<?php endif; ?>">

		<?php if ( has_nav_menu( 'top-bar-menu' ) || get_theme_mod( 'easymag_hide_date_setting', 1 ) == '' || is_active_sidebar( 'dt-top-bar-search' ) || is_active_sidebar( 'dt-top-bar-social' ) ) : ?>

			<div class="dt-top-bar">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-8 col-xs-7">
						<div class="dt-bar-left">
							<?php if ( has_nav_menu( 'top-bar-menu' ) ) : ?>
							<nav class="dt-sec-menu transition35">
								<?php wp_nav_menu( array( 'theme_location' => 'top-bar-menu', 'menu_id' => 'top-bar-menu' ) ); ?>
							</nav><!-- .dt-sec-menu .transition35 -->

							<div class="dt-sec-nav">
								<i class="fa fa-bars"></i>
							</div><!-- .dt-sec-nav -->

							<?php endif; ?>

							<?php if ( get_theme_mod( 'easymag_hide_date_setting', 1 ) == '' ) : ?>

							<div class="dt-date">
								<p><?php echo date_i18n('l, j F Y', time()); ?></p>
							</div><!-- .dt-date -->

							<?php endif; ?>
						</div><!-- .dt-bar-left -->
					</div><!-- .col-lg-6 .col-md-6 .col-sm-8 .col-xs-7 -->

					<div class="col-lg-6 col-md-6 col-sm-4 col-xs-5">
						<div class="dt-top-social">
							<?php if ( is_active_sidebar( 'dt-top-bar-search' ) ) : ?>
							<span class="dt-search-icon"><a><i class="fa fa-search transition35"></i></a></span>
							<?php endif; ?>

							<?php if ( is_active_sidebar( 'dt-top-bar-social' ) ) : ?>
							<span class="dt-social-trigger transition35"><i class="fa fa-share-alt transition35"></i> </span>

							<span class="dt-social-icons-lg">
								<?php dynamic_sidebar( 'dt-top-bar-social' ); ?>
							</span>
							<?php endif; ?>
						</div><!-- .dt-top-social -->
					</div><!-- .col-lg-6 .col-md-6 .col-sm-4 .col-xs-5 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .dt-top-bar -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'dt-top-bar-search' ) ) : ?>
			<div class="dt-search-bar transition35">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="dt-search-wrap">
								<?php dynamic_sidebar( 'dt-top-bar-search' ); ?>
							</div><!-- .dt-search-wrap -->
						</div><!-- .col-lg-12 .col-md-12 -->
					</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .dt-search-bar .transition35 -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'dt-top-bar-social' ) ) : ?>
			<div class="dt-top-social dt-social-sticky-bar transition35">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="dt-social-sticky-wrap">
								<?php dynamic_sidebar( 'dt-top-bar-social' ); ?>
							</div><!-- .dt-social-sticky-wrap -->
						</div><!-- .col-lg-12 .col-md-12 -->
					</div><!-- .row -->
				</div><!-- .container -->
			</div><!-- .dt-top-social .dt-social-sticky-bar .transition35 -->
		<?php endif; ?>

		<header class="dt-header">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-md-4">
						<div class="dt-logo">
							<?php
							if ( function_exists( 'get_custom_logo' ) && has_custom_logo() ) :
								the_custom_logo();
							else :
								?>

								<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

								<?php
								$description = get_bloginfo( 'description', 'display' );
								if ( $description || is_customize_preview() ) : ?>
									<p class="site-description"><?php echo $description; ?></p>
								<?php endif; ?>								

							<?php endif; ?>

						</div><!-- .dt-logo -->
					</div><!-- .col-lg-4 .col-md-4 -->

					<div class="col-lg-8 col-md-8">
						<div class="dt-top-ads">
							<?php dynamic_sidebar( 'dt-header-ads728x90' ); ?>
						</div><!-- .dt-top-ads -->
					</div><!-- .col-lg-8 col-md-8 -->

				</div><!-- .row -->
			</div><!-- .container -->
		</header><!-- .dt-header -->

		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) ) { ?>
			<div class="dt-header-image">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<img src="<?php esc_url( header_image()); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="header image" />
				</a>
			</div>
		<?php } ?>

		<nav class="dt-menu-bar<?php if ( get_theme_mod( 'easymag_sticky_menu', 0 ) == 1 ) { ?> dt-sticky<?php } ?>">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="dt-main-menu">
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
						</div><!-- .dt-main-menu -->

						<div class="dt-main-menu-md">
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
									<div class="dt-logo-md">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
									</div><!-- .dt-logo-md -->
								</div><!-- .col-lg-8 .col-md-8 .col-sm-8 .col-xs-8 -->

								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
									<div class="dt-nav-md-trigger">
										<i class="fa fa-bars transition35"></i>
									</div><!-- .transition35 -->
								</div><!-- .col-lg-4 .col-md-4 .col-sm-4. col-xs-4 -->
							</div><!-- .row -->
						</div><!-- .dt-main-menu-md -->
					</div><!-- .col-lg-12 .col-md-12 -->
				</div><!-- .row -->
			</div><!-- .container -->

			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div class="dt-nav-md transition35">
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
						</div><!-- .dt-nav-md .transition35 -->
					</div><!-- .col-lg-12 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</nav><!-- .dt-menu-bar -->

		<?php if( ! is_front_page() && ! is_home() ) : ?>

			<div class="dt-breadcrumbs">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">

							<?php easymag_breadcrumb(); ?>

						</div><!-- .col-lg-12 -->
					</div><!-- .row-->
				</div><!-- .container-->
			</div>

		<?php endif; ?>
