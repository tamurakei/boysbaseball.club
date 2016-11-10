<?php
/**
 * EasyMag functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package EasyMag
 */

if ( ! function_exists( 'easymag_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function easymag_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on EasyMag, use a find and replace
	 * to change 'easymag' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'easymag', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Custom Image Crop
	add_image_size( 'dt-highlighted-post', 414, 279, true );
	add_image_size( 'dt-featured-image', 556, 380, true );
	add_image_size( 'dt-featured-post-large', 870, 600, true );
	add_image_size( 'dt-featured-post-medium', 410, 260, true );
	add_image_size( 'dt-featured-post-medium-small', 230, 150, true );
	add_image_size( 'dt-featured-post-small', 230, 184, true );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/**
	 * Add Custom Logo Support
	 */
	add_theme_support( 'custom-logo' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'easymag' ),
		'top-bar-menu' => esc_html__( 'Top-bar Menu', 'easymag' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'easymag_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	/**
	 * Add editor style
	 */
	add_editor_style( 'css/custom-editor-style.css' );
}
endif; // easymag_setup
add_action( 'after_setup_theme', 'easymag_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function easymag_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'easymag_content_width', 640 );
}
add_action( 'after_setup_theme', 'easymag_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function easymag_scripts() {

	// Enqueue Bootstrap Grid
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.5', '' );

	// Enqueue FontAwesome
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.4.0', '' );

	// Enqueue Swiper.css
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/css/swiper.min.css', array(), '3.2.5', '' );

	// Enqueue Google fonts
	wp_enqueue_style( 'easymag-roboto', '//fonts.googleapis.com/css?family=Roboto:400,300,500,700,900' );

	// Stylesheet
	wp_enqueue_style( 'easymag-style', get_stylesheet_uri() );

	// Enqueue Swiper
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper.jquery.min.js', array( 'jquery' ), '3.2.5', '' );

	//News Ticker
	wp_enqueue_script( 'newsticker', get_template_directory_uri() . '/js/jquery.newsticker.min.js', array( 'jquery' ), '', true );

	// Custom JS
	wp_enqueue_script( 'easymag-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'easymag_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Widgets file
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Filter the except length to 40 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function easyblog_archive_excerpt_length( $length ) {
	return ( is_front_page() ) ? 50 : 40;
}
add_filter( 'excerpt_length', 'easyblog_archive_excerpt_length', 999 );

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function easyblog_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'easyblog_excerpt_more' );

/**
 *
 * Breadcrumbs
 */
function easymag_breadcrumb() {
	global $post;
	echo '<ul id="dt_breadcrumbs">';
	if ( !is_home() ) {
		echo '<li><a href="';
		echo esc_url( home_url() );
		echo '">';
		echo __( 'Home', 'easymag' );
		echo '</a></li><li class="separator"> / </li>';
		if ( is_category() || is_single() ) {
			echo '<li>';
			the_category( ' </li><li class="separator"> / </li><li> ' );
			if ( is_single() ) {
				echo '</li><li class="separator"> / </li><li>';
				the_title();
				echo '</li>';
			}
		} elseif ( is_page() ) {
			if ( $post->post_parent ){
				$anc = get_post_ancestors( $post->ID );
				$title = get_the_title();
				foreach ( $anc as $ancestor ) {
					$output = '<li><a href="'. esc_url( get_permalink( $ancestor ) ) .'" title="'. esc_attr( get_the_title( $ancestor ) ) .'">'. esc_attr( get_the_title( $ancestor ) ) .'</a></li> <li class="separator"> / </li>';

//					$output = '<li><a href="'. esc_url( get_permalink( $ancestor ) ) .'" title="'. esc_attr( get_the_title( $ancestor ) ) .'">'. esc_attr( get_the_title( $ancestor ) ) .'</a></li> <li class="separator"> / </li>';
//					$output = '<li><a href="'. esc_url( get_permalink( $ancestor ) ) .'" title="'. esc_attr( get_the_title( $ancestor ) ) .'">'. esc_attr( get_the_title( $ancestor ) ) .'</a></li> <li class="separator"> / </li>' . $output;
				}
				echo $output;
				echo esc_attr( $title );
			} else {
				echo '<li>'. the_title_attribute() .'</li>';
			}
		}
	} elseif ( is_tag() ) {
		single_tag_title();
	} elseif ( is_day() ) {
		echo"<li>" . __( 'Archive for', 'easymag' ); the_time( 'F jS, Y' ); echo'</li>';
	} elseif ( is_month() ) {
		echo"<li>" . __( 'Archive for', 'easymag' ); the_time( 'F, Y' ); echo'</li>';
	} elseif ( is_year() ) {
		echo"<li>" . __( 'Archive for', 'easymag' ); the_time( 'Y' ); echo'</li>';
	} elseif ( is_author( ) ) {
		echo"<li>" . __( 'Author Archive', 'easymag' ); echo'</li>';
	} elseif ( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) {
		echo "<li>" . __( 'Blog Archive', 'easymag' ); echo'</li>';
	} elseif ( is_search() ) {
		echo"<li>" . __( 'Search Results', 'easymag' ); echo'</li>';
	}
	echo '</ul>';
}

/**
 * Convert hexdec color string to rgb(a) string
 */
function easymag_hex2rgba( $color, $opacity = false ) {

	$default = 'rgb(0,0,0)';

	//Return default if no color provided
	if( empty( $color ) )
		return $default;

	//Sanitize $color if "#" is provided
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}

	//Check if color has 6 or 3 characters and get values
	if ( strlen( $color ) == 6 ) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}

	//Convert hexadec to rgb
	$rgb =  array_map( 'hexdec', $hex );

	//Check if opacity is set(rgba or rgb)
	if( $opacity ){
		if( abs( $opacity ) > 1 )
			$opacity = 1.0;
			$output = 'rgba( '.implode( ",",$rgb ).','.$opacity.' )';
		} else {
			$output = 'rgb( '.implode( ",",$rgb ).' )';
	}

	//Return rgb(a) color string
	return $output;
}

/**
 * Get First Image from Post
 */
function easymag_post_img( $num ) {
	global $more;
	$more		= 1;
	$link 		= esc_url( get_permalink() );
	$content 	= esc_attr( get_the_content() );
	$count 		= substr_count( $content, '<img' );
	$start 		= 0;
	for( $i=1; $i<=$count; $i++ ) {
		$imgBeg 	= strpos( $content, '<img', $start );
		$post 		= substr( $content, $imgBeg );
		$imgEnd 	= strpos( $post, '>' );
		$postOutput = substr( $post, 0, $imgEnd+1 );
		$postOutput = preg_replace( '/width="([0-9]*)" height="([0-9]*)"/', '', $postOutput );
		$image[$i] 	= $postOutput;
		$start		= $imgEnd+1;
	}
	if( $count!='' ) {
		if( stristr( $image[$num],'<img' ) ) { echo '<a href="'.$link.'">'.$image[$num]."</a>"; }
		$more = 0;
	} else {
		//display default static image
		echo '<img src="' . get_template_directory_uri() . '/images/no-image.png" alt="No Image"/>';
	}
}
