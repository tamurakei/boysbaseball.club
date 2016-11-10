<?php

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function easymag_widgets_init() {

    // Register Right Sidebar
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'easymag' ),
        'id'            => 'dt-right-sidebar',
        'description'   => __( 'Add widgets to Show widgets at right panel of page', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register sidebar for Top Search
    register_sidebar( array(
        'name'          => __( 'Top Bar Search', 'easymag' ),
        'id'            => 'dt-top-bar-search',
        'description'   => __( 'Top Bar Search Position', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register sidebar for top social icons
    register_sidebar( array(
        'name'          => __( 'Top Bar Social', 'easymag' ),
        'id'            => 'dt-top-bar-social',
        'description'   => __( 'Top Bar Search social icons', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Header Ads 728x90
    register_sidebar( array(
        'name'          => __( 'Header Ads 728x90', 'easymag' ),
        'id'            => 'dt-header-ads728x90',
        'description'   => __( 'Shows Advertisement at header position beside logo', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register News Ticker
    register_sidebar( array(
        'name'          => __( 'News Ticker Position', 'easymag' ),
        'id'            => 'dt-news-ticker',
        'description'   => __( 'Shows News Ticker', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Featured News Slider
    register_sidebar( array(
        'name'          => __( 'Frontpage: News Slider', 'easymag' ),
        'id'            => 'dt-featured-news-slider',
        'description'   => __( 'Add widgets to show at Frontpage featured News slider', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Highlighted News
    register_sidebar( array(
        'name'          => __( 'Front page: Highlighted News', 'easymag' ),
        'id'            => 'dt-highlighted-news',
        'description'   => __( 'Add widgets to show at Frontpage Highlighted News beside the featured News slider', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register News Section
    register_sidebar( array(
        'name'          => __( 'Front page: News Section', 'easymag' ),
        'id'            => 'dt-front-top-section-news',
        'description'   => __( 'Add widgets to show list of news from category at Front page Section', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 1
    register_sidebar( array(
        'name'          => __( 'Footer Position 1', 'easymag' ),
        'id'            => 'dt-footer1',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 1', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 2
    register_sidebar( array(
        'name'          => __( 'Footer Position 2', 'easymag' ),
        'id'            => 'dt-footer2',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 2', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 3
    register_sidebar( array(
        'name'          => __( 'Footer Position 3', 'easymag' ),
        'id'            => 'dt-footer3',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 3', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Register Footer Position 4
    register_sidebar( array(
        'name'          => __( 'Footer Position 4', 'easymag' ),
        'id'            => 'dt-footer4',
        'description'   => __( 'Add widgets to Show widgets at Footer Position 4', 'easymag' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'easymag_widgets_init' );

/**
 * Enqueue Admin Scripts
 */
function easymag_media_script( $hook ) {
    if ( 'widgets.php' != $hook ) {
        return;
    }

    // Color picker Style
    wp_enqueue_style( 'wp-color-picker' );

    // Update CSS within in Admin
    wp_enqueue_style( 'easymag-widgets', get_template_directory_uri() . '/inc/widgets/widgets.css' );

    wp_enqueue_media();
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_script( 'easymag-media-upload-js', get_template_directory_uri() . '/inc/widgets/widgets.js', array( 'jquery' ), '', true );

}
add_action( 'admin_enqueue_scripts', 'easymag_media_script' );

/**
 * Social Icons widget.
 */
class easymag_social_icons extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_social_icons',
            __( 'Daisy: Social Icons', 'easymag' ),
            array(
                'description'   => __( 'Social Icons', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title      = isset( $instance['title'] ) ? $instance['title'] : '';
        $facebook   = isset( $instance['facebook'] ) ? $instance['facebook'] : '';
        $twitter    = isset( $instance['twitter'] ) ? $instance['twitter'] : '';
        $g_plus     = isset( $instance['g-plus' ] ) ? $instance['g-plus'] : '';
        $instagram  = isset( $instance['instagram'] ) ? $instance['instagram'] : '';
        $github     = isset( $instance['github'] ) ? $instance['github'] : '';
        $flickr     = isset( $instance['flickr'] ) ? $instance['flickr'] : '';
        $pinterest  = isset( $instance['pinterest'] ) ? $instance['pinterest'] : '';
        $wordpress  = isset( $instance['wordpress'] ) ? $instance['wordpress'] : '';
        $youtube    = isset( $instance['youtube'] ) ? $instance['youtube'] : '';
        $vimeo      = isset( $instance['vimeo'] ) ? $instance['vimeo'] : '';
        $linkedin   = isset( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $behance    = isset( $instance['behance'] ) ? $instance['behance'] : '';
        $dribbble   = isset( $instance['dribbble'] ) ? $instance['dribbble'] : '';

       ?>

        <div class="dt-social-icons">
            <?php if( ! empty( $title ) ) { ?><h2 class="widget-title"><?php echo esc_attr( $title ); ?></h2><?php } ?>

            <ul>
                <?php if( ! empty( $facebook ) ) { ?>
                    <li><a href="<?php echo esc_url( $facebook ); ?>" target="_blank"><i class="fa fa-facebook transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $twitter ) ) { ?>
                    <li><a href="<?php echo esc_url( $twitter ); ?>" target="_blank"><i class="fa fa-twitter transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $g_plus ) ) { ?>
                    <li><a href="<?php echo esc_url( $g_plus ); ?>" target="_blank"><i class="fa fa-google-plus transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $instagram ) ) { ?>
                    <li><a href="<?php echo esc_url( $instagram ); ?>" target="_blank"><i class="fa fa-instagram transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $github ) ) { ?>
                    <li><a href="<?php echo esc_url( $github ); ?>" target="_blank"><i class="fa fa-github transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $flickr ) ) { ?>
                    <li><a href="<?php echo esc_url( $flickr ); ?>" target="_blank"><i class="fa fa-flickr transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $pinterest ) ) { ?>
                    <li><a href="<?php echo esc_url( $pinterest ); ?>" target="_blank"><i class="fa fa-pinterest transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $wordpress ) ) { ?>
                    <li><a href="<?php echo esc_url( $wordpress ); ?>" target="_blank"><i class="fa fa-wordpress transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $youtube ) ) { ?>
                    <li><a href="<?php echo esc_url( $youtube ); ?>" target="_blank"><i class="fa fa-youtube transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $vimeo ) ) { ?>
                    <li><a href="<?php echo esc_url( $vimeo ); ?>" target="_blank"><i class="fa fa-vimeo transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $linkedin ) ) { ?>
                    <li><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank"><i class="fa fa-linkedin transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $behance ) ) { ?>
                    <li><a href="<?php echo esc_url( $behance ); ?>" target="_blank"><i class="fa fa-behance transition35"></i></a> </li>
                <?php } ?>

                <?php if( ! empty( $dribbble ) ) { ?>
                    <li><a href="<?php echo esc_url( $dribbble ); ?>" target="_blank"><i class="fa fa-dribbble transition35"></i></a> </li>
                <?php } ?>

                <div class="clearfix"></div>
            </ul>
            </div>

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'             => '',
                'facebook'          => '',
                'twitter'           => '',
                'g-plus'            => '',
                'instagram'         => '',
                'github'            => '',
                'flickr'            => '',
                'pinterest'         => '',
                'wordpress'         => '',
                'youtube'           => '',
                'vimeo'             => '',
                'linkedin'          => '',
                'behance'           => '',
                'dribbble'          => ''
            )
        );

        ?>
        <div class="dt-social-icons">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Title', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Facebook', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo esc_attr( $instance['facebook'] ); ?>" placeholder="<?php _e( 'https://www.facebook.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Twitter', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo esc_attr( $instance['twitter'] ); ?>" placeholder="<?php _e( 'https://twitter.com/', 'easymag' ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'g-plus' ); ?>"><?php _e( 'G plus', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'g-plus' ); ?>" name="<?php echo $this->get_field_name( 'g-plus' ); ?>" value="<?php echo esc_attr( $instance['g-plus'] ); ?>" placeholder="<?php _e( 'https://plus.google.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Instagram', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo esc_attr( $instance['instagram'] ); ?>" placeholder="<?php _e( 'https://instagram.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'github' ); ?>"><?php _e( 'Github', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo esc_attr( $instance['github'] ); ?>" placeholder="<?php _e( 'https://github.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'flickr' ); ?>"><?php _e( 'Flickr', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" value="<?php echo esc_attr( $instance['flickr'] ); ?>" placeholder="<?php _e( 'https://www.flickr.com/"', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'pinterest' ); ?>"><?php _e( 'Pinterest', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo esc_attr( $instance['pinterest'] ); ?>" placeholder="<?php _e( 'https://www.pinterest.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'wordpress' ); ?>"><?php _e( 'WordPress', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'wordpress' ); ?>" name="<?php echo $this->get_field_name( 'wordpress' ); ?>" value="<?php echo esc_attr( $instance['wordpress'] ); ?>" placeholder="<?php _e( 'https://wordpress.org/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'YouTube', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo esc_attr( $instance['youtube'] ); ?>" placeholder="<?php _e( 'https://www.youtube.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'vimeo' ); ?>"><?php _e( 'Vimeo', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo esc_attr( $instance['vimeo'] ); ?>" placeholder="<?php _e( 'https://vimeo.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'linkedin' ); ?>"><?php _e( 'Linkedin', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo esc_attr( $instance['linkedin'] ); ?>" placeholder="<?php _e( 'https://linkedin.com', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'behance' ); ?>"><?php _e( 'Behance', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'behance' ); ?>" name="<?php echo $this->get_field_name( 'behance' ); ?>" value="<?php echo esc_attr( $instance['behance'] ); ?>" placeholder="<?php _e( 'https://www.behance.net/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'dribbble' ); ?>"><?php _e( 'Dribbble', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo esc_attr( $instance['dribbble'] ); ?>" placeholder="<?php _e( 'https://dribbble.com/', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-social-icons -->

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                = $old_instance;
        $instance['title']     = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['facebook']  = strip_tags( stripslashes( $new_instance['facebook'] ) );
        $instance['twitter']   = strip_tags( stripslashes( $new_instance['twitter'] ) );
        $instance['g-plus']    = strip_tags( stripslashes( $new_instance['g-plus'] ) );
        $instance['instagram'] = strip_tags( stripslashes( $new_instance['instagram'] ) );
        $instance['github']    = strip_tags( stripslashes( $new_instance['github'] ) );
        $instance['flickr']    = strip_tags( stripslashes( $new_instance['flickr'] ) );
        $instance['pinterest'] = strip_tags( stripslashes( $new_instance['pinterest'] ) );
        $instance['wordpress'] = strip_tags( stripslashes( $new_instance['wordpress'] ) );
        $instance['youtube']   = strip_tags( stripslashes( $new_instance['youtube'] ) );
        $instance['vimeo']     = strip_tags( stripslashes( $new_instance['vimeo'] ) );
        $instance['linkedin']  = strip_tags( stripslashes( $new_instance['linkedin'] ) );
        $instance['behance']   = strip_tags( stripslashes( $new_instance['behance'] ) );
        $instance['dribbble']  = strip_tags( stripslashes( $new_instance['dribbble'] ) );
        return $instance;

    }

}

/**
 * Adds 130x130 widget.
 */
class easymag_ads_130x130 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_ads_130x130',
            __( 'Daisy: Ads 130x130', 'easymag' ),
            array(
                'description'   => __( 'Advertisement with size of 130x130 for sidebar position', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $ads_image_path = isset( $instance['ads_image'] ) ? $instance['ads_image'] : '';
        $ads_link       = isset( $instance['ads_link'] ) ? $instance['ads_link'] : '';
        $ads_link_type  = isset( $instance[ 'ads_link_type' ] ) ? $instance[ 'ads_link_type' ] : '';

        if( empty( $title ) ) {
            $title = __( '130x130 Ads', 'easymag' );
        };

        if( empty( $ads_image_path ) ) {
            $ads_image_path = '';
        };

        if( empty( $ads_link ) ) {
            $ads_link =  esc_url( home_url( '/' ) );
        };

        if( $ads_link_type == 'nofollow' ) {
            $ads_link_type = 'nofollow';

        } else {
            $ads_link_type = 'dofollow';
        }

      ?>

        <a href="<?php echo esc_url( $ads_link ); ?>" title="<?php echo esc_attr( $title ); ?>" rel="<?php echo esc_attr( $ads_link_type ); ?>" target="_blank"><img src="<?php echo esc_url( $ads_image_path ); ?>" alt="<?php echo esc_attr( $title ); ?>"> </a>

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'ads_link'           => '',
                'ads_image'          => '',
                'ads_link_type'      => ''
            )
        );

        ?>

        <div class="dt-ads-130x130">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Advertise Title', 'easymag' )?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link' ); ?>"><?php _e( 'Ads Link', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'ads_link' ); ?>" name="<?php echo $this->get_field_name( 'ads_link' ); ?>" value="<?php echo esc_attr( $instance['ads_link'] ); ?>" placeholder="<?php _e( 'URL', 'easymag' )?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link_type' ); ?>"><?php _e( 'Link Type', 'easymag' ); ?></label>

                <select id="<?php echo $this->get_field_id('ads_link_type'); ?>" name="<?php echo $this->get_field_name('ads_link_type'); ?>">
                    <option value="dofollow" <?php selected( $instance['ads_link_type'], 'dofollow' ); ?>>Do Follow</option>
                    <option value="nofollow" <?php selected( $instance['ads_link_type'], 'nofollow' );?>>No Follow</option>
                </select>
            </div>

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_image' ); ?>"><?php _e( 'Ads Image', 'easymag' ); ?></label>

                <?php $dt_ads_img = $instance['ads_image'];
                if ( ! empty( $dt_ads_img ) ) { ?>
                    <img src="<?php echo $dt_ads_img; ?>" />
                <?php } else { ?>
                    <img src="" />
                <?php } ?>

                <input type="hidden" class="dt-custom-media-image" id="<?php echo $this->get_field_id( 'ads_image' ); ?>" name="<?php echo $this->get_field_name( 'ads_image' ); ?>" value="<?php echo esc_attr( $instance['ads_image'] ); ?>" />
                <input type="button" class="dt-img-upload dt-custom-media-button" id="custom_media_button" name="<?php echo $this->get_field_name( 'ads_image' ); ?>"  value="<?php _e( 'select Image', 'easymag' ); ?>" />
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-ads-130x130 -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
        $instance['title']      = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['ads_link']   = strip_tags( stripslashes( $new_instance['ads_link'] ) );
        $instance['ads_link_type']  = strip_tags( $new_instance['ads_link_type'] );
        $instance['ads_image']  = strip_tags( $new_instance['ads_image'] );
        return $instance;

    }

}

/**
 * Adds 262x220 widget.
 */
class easymag_ads_262x220 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_ads_262x220',
            __( 'Daisy: Ads 262x220', 'easymag' ),
            array(
                'description'   => __( 'Advertisement with size of 262x220 for sidebar position', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $ads_image_path = isset( $instance['ads_image'] ) ? $instance['ads_image'] : '';
        $ads_link       = isset( $instance['ads_link'] ) ? $instance['ads_link'] : '';
        $ads_link_type  = isset( $instance[ 'ads_link_type' ] ) ? $instance[ 'ads_link_type' ] : '';

        if( empty( $title ) ) {
            $title = __( '262x220 Ads', 'easymag' );
        };

        if( empty( $ads_image_path ) ) {
            $ads_image_path = '';
        };

        if( empty( $ads_link ) ) {
            $ads_link = esc_url( home_url( '/' ) );
        };

        if( $ads_link_type == 'nofollow' ) {
            $ads_link_type = 'nofollow';

        } else {
            $ads_link_type = 'dofollow';
        }

      ?>

        <a href="<?php echo esc_url( $ads_link ); ?>" title="<?php echo esc_attr( $title ); ?>" rel="<?php echo esc_attr( $ads_link_type ); ?>" target="_blank"><img style="margin-top: 20px" src="<?php echo esc_url( $ads_image_path ); ?>" alt="<?php echo esc_attr( $title ); ?>"> </a>

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'ads_link'           => '',
                'ads_image'          => '',
                'ads_link_type'      => ''
            )
        );

        ?>

        <div class="ads-262x220">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Ads Title', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link' ); ?>"><?php _e( 'Ads Link', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'ads_link' ); ?>" name="<?php echo $this->get_field_name( 'ads_link' ); ?>" value="<?php echo esc_attr( $instance['ads_link'] ); ?>" placeholder="<?php _e( 'URL', 'easymag' ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link_type' ); ?>"><?php _e( 'Link Type', 'easymag' ); ?></label>

                <select id="<?php echo $this->get_field_id('ads_link_type'); ?>" name="<?php echo $this->get_field_name('ads_link_type'); ?>">
                    <option value="dofollow" <?php selected( $instance['ads_link_type'], 'dofollow' ); ?>>Do Follow</option>
                    <option value="nofollow" <?php selected( $instance['ads_link_type'], 'nofollow' );?>>No Follow</option>
                </select>
            </div>

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_image' ); ?>"><?php _e( 'Ads Image', 'easymag' ); ?></label>

                <?php $dt_ads_img = $instance['ads_image'];
                if ( ! empty( $dt_ads_img ) ) { ?>
                    <img src="<?php echo $dt_ads_img; ?>" />
                <?php } else { ?>
                    <img src="" />
                <?php } ?>

                <input type="hidden" class="dt-custom-media-image" id="<?php echo $this->get_field_id( 'ads_image' ); ?>" name="<?php echo $this->get_field_name( 'ads_image' ); ?>" value="<?php echo esc_attr( $instance['ads_image'] ); ?>" />
                <input type="button" class="dt-img-upload dt-custom-media-button" id="custom_media_button" name="<?php echo $this->get_field_name( 'ads_image' ); ?>"  value="<?php _e( 'select Image', 'easymag' ); ?>" />
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .ads-262x220 -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
        $instance['title']      = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['ads_link']   = strip_tags( stripslashes( $new_instance['ads_link'] ) );
        $instance['ads_link_type']  = strip_tags( $new_instance['ads_link_type'] );
        $instance['ads_image']  = strip_tags( $new_instance['ads_image'] );
        return $instance;

    }

}

/**
 * Adds Header Ads 728x90 widget.
 */
class easymag_ads_728x90 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_ads_728x90',
            __( 'Daisy: Ads 728x90', 'easymag' ),
            array(
                'description'   => __( 'Header Banner Advertise with size of 728x90 for header position beside Logo', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $ads_image_path = isset( $instance['ads_image'] ) ? $instance['ads_image'] : '';
        $ads_link       = isset( $instance['ads_link'] ) ? $instance['ads_link'] : '';
        $ads_link_type  = isset( $instance[ 'ads_link_type' ] ) ? $instance[ 'ads_link_type' ] : '';

        if( empty( $title ) ) {
            $title = __( 'Header Banner Advertisement', 'easymag' );
        };

        if( empty( $ads_image_path ) ) {
            $ads_image_path = '';
        };

        if( empty( $ads_link ) ) {
            $ads_link = esc_url( home_url( '/' ) );
        };

        if( $ads_link_type == 'nofollow' ) {
            $ads_link_type = 'nofollow';

        } else {
            $ads_link_type = 'dofollow';
        }

        ?>

        <a href="<?php echo esc_url( $ads_link ); ?>" title="<?php echo esc_attr( $title ); ?>" rel="<?php echo esc_attr( $ads_link_type ); ?>" target="_blank"><img src="<?php echo esc_url( $ads_image_path ); ?>" alt="<?php echo esc_attr( $title ); ?>"> </a>

        <?php

    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'      => '',
                'ads_link'   => '',
                'ads_image'  => '',
                'ads_link_type'      => ''
            )
        );

        ?>

        <div class="dt-header-ads-728x90">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Header Banner Ads', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link' ); ?>"><?php _e( 'Ads Link', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'ads_link' ); ?>" name="<?php echo $this->get_field_name( 'ads_link' ); ?>" value="<?php echo esc_attr( $instance['ads_link'] ); ?>" placeholder="<?php _e( 'URL', 'easymag' ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link_type' ); ?>"><?php _e( 'Link Type', 'easymag' ); ?></label>

                <select id="<?php echo $this->get_field_id('ads_link_type'); ?>" name="<?php echo $this->get_field_name('ads_link_type'); ?>">
                    <option value="dofollow" <?php selected( $instance['ads_link_type'], 'dofollow' ); ?>>Do Follow</option>
                    <option value="nofollow" <?php selected( $instance['ads_link_type'], 'nofollow' );?>>No Follow</option>
                </select>
            </div>

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_image' ); ?>"><?php _e( 'Ads Image', 'easymag' ); ?></label>

                <?php $dt_ads_img = $instance['ads_image'];
                if ( ! empty( $dt_ads_img ) ) { ?>
                    <img src="<?php echo $dt_ads_img; ?>" />
                <?php } else { ?>
                    <img src="" />
                <?php } ?>

                <input type="hidden" class="dt-custom-media-image" id="<?php echo $this->get_field_id( 'ads_image' ); ?>" name="<?php echo $this->get_field_name( 'ads_image' ); ?>" value="<?php echo esc_attr( $instance['ads_image'] ); ?>" />
                <input type="button" class="dt-img-upload dt-custom-media-button" id="custom_media_button" name="<?php echo $this->get_field_name( 'ads_image' ); ?>"  value="<?php _e( 'select Image', 'easymag' ); ?>" />
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-header-ads-728x90 -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
        $instance['title']      = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['ads_link']   = strip_tags( stripslashes( $new_instance['ads_link'] ) );
        $instance['ads_link_type']  = strip_tags( $new_instance['ads_link_type'] );
        $instance['ads_image']  = strip_tags( stripslashes( $new_instance['ads_image'] ) );
        return $instance;

    }

}

/**
 * Adds 870x150 widget.
 */
class easymag_ads_870x150 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_ads_870x150',
            __( 'Daisy: Ads 870x150', 'easymag' ),
            array(
                'description'   => __( 'Advertisement with size of 870x150 for before and after news section', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title          = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
        $ads_image_path = isset( $instance[ 'ads_image' ] ) ? $instance[ 'ads_image' ] : '';
        $ads_link       = isset( $instance[ 'ads_link' ] ) ? $instance[ 'ads_link' ] : '';
        $ads_link_type  = isset( $instance[ 'ads_link_type' ] ) ? $instance[ 'ads_link_type' ] : '';

        if( empty( $title ) ) {
            $title = __( '870x150 Ads', 'easymag' );
        };

        if( empty( $ads_image_path ) ) {
            $ads_image_path = '';
        };

        if( empty( $ads_link ) ) {
            $ads_link = esc_url( home_url( '/' ) );
        };

        if( $ads_link_type == 'nofollow' ) {
            $ads_link_type = 'nofollow';

        } else {
            $ads_link_type = 'dofollow';
        }

       ?>

        <a href="<?php echo esc_url( $ads_link ); ?>" title="<?php echo esc_attr( $title ); ?>" rel="<?php echo esc_attr( $ads_link_type ); ?>" target="_blank"><img src="<?php echo esc_url( $ads_image_path ); ?>" alt="<?php echo esc_attr( $title ); ?>"> </a>

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'ads_link'           => '',
                'ads_image'          => '',
                'ads_link_type'      => ''
            )
        );

        ?>

        <div class="dt-ads-870x150">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Ads Title', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link' ); ?>"><?php _e( 'Ads Link', 'easymag' ); ?></label>
                <input type="text" id="<?php echo $this->get_field_id( 'ads_link' ); ?>" name="<?php echo $this->get_field_name( 'ads_link' ); ?>" value="<?php echo esc_attr( $instance['ads_link'] ); ?>" placeholder="<?php _e( 'URL', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_link_type' ); ?>"><?php _e( 'Link Type', 'easymag' ); ?></label>

                <select id="<?php echo $this->get_field_id('ads_link_type'); ?>" name="<?php echo $this->get_field_name('ads_link_type'); ?>">
                    <option value="dofollow" <?php selected( $instance['ads_link_type'], 'dofollow' ); ?>>Do Follow</option>
                    <option value="nofollow" <?php selected( $instance['ads_link_type'], 'nofollow' );?>>No Follow</option>
                </select>
            </div>

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'ads_image' ); ?>"><?php _e( 'Ads Image', 'easymag' ); ?></label>

                <?php $dt_ads_img = $instance['ads_image'];
                if ( ! empty( $dt_ads_img ) ) { ?>
                    <img src="<?php echo $dt_ads_img; ?>" />
                <?php } else { ?>
                    <img src="" />
                <?php } ?>

                <input type="hidden" class="dt-custom-media-image" id="<?php echo $this->get_field_id( 'ads_image' ); ?>" name="<?php echo $this->get_field_name( 'ads_image' ); ?>" value="<?php echo esc_attr( $instance['ads_image'] ); ?>" />
                <input type="button" class="dt-img-upload dt-custom-media-button" id="custom_media_button" name="<?php echo $this->get_field_name( 'ads_image' ); ?>"  value="<?php _e( 'select Image', 'easymag' ); ?>" />
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-ads-870x150 -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance               = $old_instance;
        $instance['title']      = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['ads_link']   = strip_tags( stripslashes( $new_instance['ads_link'] ) );
        $instance['ads_link_type']  = strip_tags( $new_instance['ads_link_type'] );
        $instance['ads_image']  = strip_tags( $new_instance['ads_image'] );
        return $instance;

    }

}

/**
 * News Ticker
 */
class easymag_news_ticker extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_news_ticker',
            __( 'Daisy: News Ticker', 'easymag' ),
            array(
                'description'   => __( 'News Ticker', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        $title           = isset( $instance['title'] ) ? $instance['title'] : 'Headlines';
        $show_posts_from = isset( $instance['show_posts_from'] ) ? $instance['show_posts_from'] : 'recent';
        $category        = isset( $instance['category'] ) ? $instance['category'] : '';
        $no_of_posts     = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : '5';

        if( $show_posts_from == 'recent' ) {
            $news_ticker_posts = new WP_Query( array(
                'post_type'             => 'post',
                'category__in'          => '',
                'posts_per_page'        => $no_of_posts,
                'ignore_sticky_posts'   => true
            ) );
        } else {
            $news_ticker_posts = new WP_Query( array(
                'post_type'         => 'post',
                'category__in'      => $category,
                'posts_per_page'    => $no_of_posts
            ) );
        }

        if ( $news_ticker_posts->have_posts() ) : ?>
            <div class="bt-news-ticker">

                <?php if ( ! empty( $title ) ) : ?><div class="bt-news-ticker-tag"><?php echo esc_attr( $title ); ?></div><?php endif; ?>

                <ul class="dt-newsticker">

                    <?php while ( $news_ticker_posts->have_posts() ) : $news_ticker_posts->the_post(); ?>

                        <li><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>"> <?php esc_attr( the_title() ); ?></a> - <?php echo strip_tags( esc_attr( get_the_excerpt() ) ) ?></li>

                    <?php endwhile; ?>

                 </ul><!-- .dt-newsticker -->
            </div><!-- .bt-news-ticker -->
        <?php else : ?>
            <p><?php _e( 'Sorry, no posts matched your criteria.', 'easymag' )?></p>
        <?php endif; ?>

        <?php

    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => 'headlines',
                'show_posts_from'    => 'recent',
                'category'           => '',
                'no_of_posts'        => '5'
            )
        );

        ?>

        <div class="dt-featured-post-slider">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'easymag' ); ?></strong></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>">
            </div>

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'show_posts_from' ); ?>"><strong><?php _e( 'Chose Type', 'easymag' ); ?></strong></label>

                <input type="radio" id="<?php echo $this->get_field_id( 'show_posts_from' ); ?>" name="<?php echo $this->get_field_name( 'show_posts_from' ); ?>" value="<?php _e( 'recent', 'easymag' ); ?>" <?php checked( $instance[ 'show_posts_from' ], 'recent' ); ?> ><?php _e( 'Recent Posts', 'easymag' ); ?>
                <input type="radio" id="<?php echo $this->get_field_id( 'show_posts_from' ); ?>" name="<?php echo $this->get_field_name( 'show_posts_from' ); ?>" value="<?php _e( 'category', 'easymag' ); ?>" <?php checked( $instance[ 'show_posts_from' ], 'category' ); ?> ><?php _e( 'Category', 'easymag' ); ?>

                <br /><br />
            </div>

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Category', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">

                    <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><strong><?php _e( 'No. of Posts', 'easymag' ); ?></strong></label>
                <input type="number" id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo esc_attr( $instance['no_of_posts'] ); ?>">
            </div>
        </div>
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                       = $old_instance;
        $instance[ 'title' ]            = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
        $instance[ 'show_posts_from' ]  = $new_instance[ 'show_posts_from' ];
        $instance[ 'category' ]         = $new_instance[ 'category' ];
        $instance[ 'no_of_posts' ]      = strip_tags( stripslashes( $new_instance[ 'no_of_posts' ]  ) );
        return $instance;

    }

}

/**
 * Featured Post Slider Widget.
 */
class easymag_featured_post_slider extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_featured_post_slider',
            __( 'Daisy: Featured Slider', 'easymag' ),
            array(
                'description'   => __( 'Featured News Image Slider with title and published date', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        global $post;

        $show_posts_from    = isset( $instance['show_posts_from'] ) ? $instance['show_posts_from'] : 'recent';
        $category           = isset( $instance['category'] ) ? $instance['category'] : '';
        $no_of_posts        = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : '5';

        if( $show_posts_from == 'recent' ) {
            $featured_post_slider_posts = new WP_Query( array(
                'post_type'             => 'post',
                'category__in'          => '',
                'posts_per_page'        => $no_of_posts,
                'ignore_sticky_posts'   => true
            ) );
        } else {
            $featured_post_slider_posts = new WP_Query( array(
                'post_type'         => 'post',
                'category__in'      => $category,
                'posts_per_page'    => $no_of_posts
            ) );
        }

    ?>

        <?php

        if ( $featured_post_slider_posts->have_posts() ) : ?>

        <div class="dt-featured-post-slider-wrap">
            <div class="dt-featured-post-slider">
                <div class="swiper-wrapper">

                    <?php while ( $featured_post_slider_posts->have_posts() ) : $featured_post_slider_posts->the_post();
                        if ( has_post_thumbnail() ) : ?>

                        <div class="swiper-slide">
                            <div class="dt-featured-posts-wrap">
                                <figure class="dt-featured-post-img">
                                    <?php

                                        $image = '';
                                        $title_attribute = get_the_title( $post->ID );
                                        $image .= '<a href="'. esc_url( get_permalink() ) . '" title="' . esc_html( the_title( '', '', false ) ) .'">';
                                        $image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                                        echo $image;

                                    ?>
                                </figure><!-- .dt-featured-post-img -->

                                <h2>
                                    <span class="dt-featured-post-date">
                                        <span class="dt-featured-post-month"><?php esc_attr( the_time("M") ); ?><br/><?php esc_attr( the_time("Y") ); ?></span>
                                        <span class="dt-featured-post-day"><?php esc_attr( the_time("d") ); ?></span>
                                    </span>

                                    <a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php esc_attr( the_title() ); ?></a>
                                </h2>
                            </div><!-- .dt-featured-posts-wrap -->
                        </div><!-- .swiper-slide -->

                    <?php

                        endif;
                    endwhile;

                    ?>

                </div><!-- .swiper-wrapper -->

                <!-- Add Arrows -->
                <div class="swiper-button-next transition5"><i class="fa fa-angle-right"></i></div>
                <div class="swiper-button-prev transition5"><i class="fa fa-angle-left"></i></div>
            </div><!-- .dt-featured-post-slider -->
        </div><!-- .dt-featured-post-slider-wrap -->

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>
        <?php endif; ?>

        <?php

    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'show_posts_from'    => 'recent',
                'category'           => '',
                'no_of_posts'        => '5'
            )
        );

        ?>

        <div class="dt-featured-post-slider">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'easymag' ); ?></strong></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Title for Featured Posts', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'show_posts_from' ); ?>"><strong><?php _e( 'Chose Type', 'easymag' ); ?></strong></label>

               <input type="radio" id="<?php echo $this->get_field_id( 'show_posts_from' ); ?>" name="<?php echo $this->get_field_name( 'show_posts_from' ); ?>" value="<?php _e( 'recent', 'easymag' ); ?>" <?php checked( $instance[ 'show_posts_from' ], 'recent' ); ?> ><?php _e( 'Recent Posts', 'easymag' ); ?>
               <input type="radio" id="<?php echo $this->get_field_id( 'show_posts_from' ); ?>" name="<?php echo $this->get_field_name( 'show_posts_from' ); ?>" value="<?php _e( 'category', 'easymag' ); ?>" <?php checked( $instance[ 'show_posts_from' ], 'category' ); ?> ><?php _e( 'Category', 'easymag' ); ?>
                <br /><br />
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Category', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">

                    <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><strong><?php _e( 'No. of Posts', 'easymag' ); ?></strong></label>
                <input type="number" id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo esc_attr( $instance['no_of_posts'] ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-featured-post-slider -->

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                       = $old_instance;
        $instance[ 'title' ]            = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
        $instance[ 'show_posts_from' ]  = $new_instance[ 'show_posts_from' ];
        $instance[ 'category' ]         = $new_instance[ 'category' ];
        $instance[ 'no_of_posts' ]      = strip_tags( stripslashes( $new_instance[ 'no_of_posts' ]  ) );
        return $instance;

    }

}

/**
 * Grid Highlighted news
 */
class easymag_highlighted_news extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_highlighted_news',
            __( 'Daisy: Highlighted News', 'easymag' ),
            array(
                'description'   => __( 'Highlighted grid news post from 4 different category', 'easymag' )
            )
        );

    }

    public function widget( $args, $instance ) {

        global $post;
        $category1      = isset( $instance[ 'category1' ] ) ? $instance[ 'category1' ] : '';
        $category2      = isset( $instance[ 'category2' ] ) ? $instance[ 'category2' ] : '';
        $category3      = isset( $instance[ 'category3' ] ) ? $instance[ 'category3' ] : '';
        $category4      = isset( $instance[ 'category4' ] ) ? $instance[ 'category4' ] : '';
        $title_bg_color = get_theme_mod( 'easymag_primary_color' );
        $rgba           = easymag_hex2rgba( $title_bg_color, 0.75 );

        $highlighted_news1 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category1,
            'posts_per_page'    => '1'
        ) );

        $highlighted_news2 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category2,
            'posts_per_page'    => '1'
        ) );

        $highlighted_news3 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category3,
            'posts_per_page'    => '1'
        ) );

        $highlighted_news4 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category4,
            'posts_per_page'    => '1'
        ) ); ?>

        <div class="dt-highlighted-news">

        <?php

        if ( $highlighted_news1->have_posts() && $category1 != '' ) : ?>

            <?php while ( $highlighted_news1->have_posts() ) : $highlighted_news1->the_post(); ?>
                <div class="dt-highlighted-news-holder">
                    <figure class="dt-highlighted-news-img">
                        <?php

                        if ( has_post_thumbnail() ) :
                            $image = '';
                            $title_attribute = get_the_title( $post->ID );
                            $image .= '<a href="'. esc_url( get_permalink() ) . '" title="' . esc_html( the_title( '', '', false ) ) .'">';
                            $image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                            echo $image;
                        endif;

                        ?>
                    </figure><!-- .dt-highlighted-news-img -->

                    <div class="dt-highlighted-news-desc">
                        <span class="dt-highlighted-news-cat" style="background: <?php echo esc_attr( $rgba ); ?>">
                           <a href="<?php echo esc_url( get_category_link( $category1 ) ) ; ?>" title="<?php echo esc_attr( get_cat_name( $category1 ) ); ?>"><?php echo esc_attr( get_cat_name( $category1 ) ); ?></a>
                        </span>

                        <h2 class="transition5"><a href="<?php esc_attr( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php esc_attr( the_title() ); ?></a></h2>
                    </div><!-- .dt-highlighted-news-desc -->
                </div><!-- .dt-highlighted-news-holder -->

            <?php endwhile; ?>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>
        <?php endif;

        if ( $highlighted_news2->have_posts() && $category2 != '' ) : ?>

            <?php while ( $highlighted_news2->have_posts() ) : $highlighted_news2->the_post(); ?>
                <div class="dt-highlighted-news-holder">
                    <figure class="dt-highlighted-news-img">
                        <?php

                            if ( has_post_thumbnail() ) :
                                $image = '';
                                $title_attribute = get_the_title( $post->ID );
                                $image .= '<a href="'. esc_url( get_permalink() ) . '" title="' . esc_html( the_title( '', '', false ) ) .'">';
                                $image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                                echo $image;
                            endif;

                        ?>
                    </figure><!-- .dt-highlighted-news-img -->

                    <div class="dt-highlighted-news-desc">
                        <span class="dt-highlighted-news-cat" style="background: <?php echo esc_attr( $rgba ); ?>">
                           <a href="<?php echo esc_url( get_category_link( $category2 ) ) ; ?>" title="<?php echo esc_attr( get_cat_name( $category2 ) ); ?>"><?php echo esc_attr( get_cat_name( $category2 ) ); ?></a>
                        </span>

                        <h2 class="transition5"><a href="<?php esc_attr( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php esc_attr( the_title() ); ?></a></h2>
                    </div><!-- .dt-highlighted-news-img -->
                </div><!-- .dt-highlighted-news-holder -->

            <?php endwhile; ?>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>
        <?php endif;

        if ( $highlighted_news3->have_posts() && $category3 != '' ) : ?>

            <?php while ( $highlighted_news3->have_posts() ) : $highlighted_news3->the_post(); ?>
                <div class="dt-highlighted-news-holder">
                    <figure class="dt-highlighted-news-img">
                        <?php

                        if ( has_post_thumbnail() ) :
                            $image = '';
                            $title_attribute = get_the_title( $post->ID );
                            $image .= '<a href="'. esc_url( get_permalink()) . '" title="' . esc_html( the_title( '', '', false ) ) .'">';
                            $image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                            echo $image;
                        endif;

                        ?>
                    </figure><!-- .dt-highlighted-news-img -->

                    <div class="dt-highlighted-news-desc">
                       <span class="dt-highlighted-news-cat" style="background: <?php echo esc_attr( $rgba ); ?>">
                           <a href="<?php echo esc_url( get_category_link( $category3 ) ) ; ?>" title="<?php echo esc_attr( get_cat_name( $category3 ) ); ?>"><?php echo esc_attr( get_cat_name( $category3 ) ); ?></a>
                        </span>

                        <h2 class="transition5"><a href="<?php esc_attr( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php esc_attr( the_title() ); ?></a></h2>
                    </div><!-- .dt-highlighted-news-desc -->
                </div><!-- .dt-highlighted-news-holder -->

            <?php endwhile; ?>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>
        <?php endif;

        if ( $highlighted_news4->have_posts() && $category4 != '' ) : ?>

            <?php while ( $highlighted_news4->have_posts() ) : $highlighted_news4->the_post(); ?>
                <div class="dt-highlighted-news-holder">
                    <figure class="dt-highlighted-news-img">
                        <?php

                        if ( has_post_thumbnail() ) :
                            $image = '';
                            $title_attribute = get_the_title( $post->ID );
                            $image .= '<a href="'. esc_url( get_permalink() ) . '" title="' . esc_html( the_title( '', '', false ) ) .'">';
                            $image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                            echo $image;
                        endif;

                        ?>
                    </figure><!-- .dt-highlighted-news-img -->

                    <div class="dt-highlighted-news-desc">
                        <span class="dt-highlighted-news-cat" style="background: <?php echo esc_attr( $rgba ); ?>">
                           <a href="<?php echo esc_url( get_category_link( $category4 ) ) ; ?>" title="<?php echo esc_attr( get_cat_name( $category4 ) ); ?>"><?php echo esc_attr( get_cat_name( $category4 ) ); ?></a>
                        </span>

                        <h2 class="transition5"><a href="<?php esc_attr( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php esc_attr( the_title() ); ?></a></h2>
                    </div><!-- .dt-highlighted-news-desc -->
                </div><!-- .dt-highlighted-news-holder -->

            <?php endwhile; ?>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>
        <?php endif; ?>

            <div class="clearfix"></div>

        </div>

        <?php

    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'category1'          => '',
                'category2'          => '',
                'category3'          => '',
                'category4'          => '',
                'title_bg_color'     => '#cc2936'
            )
        );
        ?>

        <div class="dt-highlighted-news-grid">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'easymag' ); ?></strong></label>
                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" placeholder="<?php _e( 'Title for Featured Posts', 'easymag' ); ?>">
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category1' ); ?>"><strong><?php _e( 'Category 1', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category1' ); ?>" name="<?php echo $this->get_field_name( 'category1' ); ?>">

                    <?php foreach( get_terms( 'category','parent=0&hide_empty=0' ) as $term) { ?>
                        <option <?php selected( $instance[ 'category1' ], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category2' ); ?>"><strong><?php _e( 'Category 2', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category2' ); ?>" name="<?php echo $this->get_field_name( 'category2' ); ?>">

                    <?php foreach( get_terms( 'category','parent=0&hide_empty=0' ) as $term) { ?>
                        <option <?php selected( $instance[ 'category2' ], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category3' ); ?>"><strong><?php _e( 'Category 3', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category3' ); ?>" name="<?php echo $this->get_field_name( 'category3' ); ?>">

                    <?php foreach( get_terms( 'category','parent=0&hide_empty=0' ) as $term ) { ?>
                        <option <?php selected( $instance[ 'category3' ], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category4' ); ?>"><strong><?php _e( 'Category 4', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category4' ); ?>" name="<?php echo $this->get_field_name( 'category4' ); ?>">

                    <?php foreach( get_terms( 'category','parent=0&hide_empty=0' ) as $term ) { ?>
                        <option <?php selected( $instance['category4'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                </select>
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-highlighted-news-grid -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;
        $instance[ 'title' ]        = strip_tags( stripslashes( $new_instance[ 'title' ] ) );
        $instance[ 'category1' ]    = $new_instance[ 'category1' ];
        $instance[ 'category2' ]    = $new_instance[ 'category2' ];
        $instance[ 'category3' ]    = $new_instance[ 'category3' ];
        $instance[ 'category4' ]    = $new_instance[ 'category4' ];
        return $instance;

    }

}

/**
 * News list Layout 1.
 */
class easymag_news_list1 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_news_list1',
            __( 'Daisy: News Layout 1', 'easymag' ),
            array(
                'description'   => __( 'Posts display layout 1 for recently published post', 'easymag' )
            )
        );
    }

    public function widget( $args, $instance ) {

        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $category       = isset( $instance['category'] ) ? $instance['category'] : '';
        $no_of_posts    = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : '';

        $news_layout1 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category,
            'posts_per_page'    => $no_of_posts
        ) );

        ?>

        <?php
        if ( $news_layout1->have_posts() ) : ?>

            <div class="dt-news-list-1">
                <div class="dt-news-layout-wrap">

                    <?php

                    if ( !empty( $title ) ) { ?>
                        <h2 class="widget-title"><?php echo esc_html( $title ) ?><span><a href="<?php echo esc_url( get_category_link( $category ) ) ?>"><?php _e( '[ View All ]', 'easymag' ); ?></a></span></h2>
                    <?php
                    }

                    ?>

                    <div class="dt-news-layout1">

                        <?php while ( $news_layout1->have_posts() ) : $news_layout1->the_post(); ?>

                            <div class="dt-news-post">
                                <figure class="dt-news-post-img">
                                    <?php
                                        if ( has_post_thumbnail() ) :

                                            the_post_thumbnail( 'dt-featured-post-medium' );

                                        endif;
                                    ?>

                                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><span class="transition35"><i class="fa fa-search transition35"></i></span></a>
                                </figure><!-- .dt-news-post-img -->

                                <div class="dt-news-post-content">
                                    <div class="dt-news-post-meta">
                                        <span class="dt-news-post-date"><i class="fa fa-calendar"></i> <?php the_time ( get_option ( 'date_format' ) ); ?></span>

                                        <span class="dt-news-post-comments"><i class="fa fa-comments"></i> <?php comments_number( 'No Responses', 'one Response', '% Responses' ); ?></span>
                                    </div><!-- .dt-news-post-meta -->

                                    <h3><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">

                                        <?php echo wp_trim_words( get_the_title(), 10, '...' ); ?>

                                    </a></h3>



                                    <div class="dt-news-post-desc">

                                    <?php
                                        $excerpt = get_the_excerpt();
                                        $limit   = "220";
                                        $pad     = "...";

                                        if( strlen( $excerpt ) <= $limit ) {
                                            echo esc_attr( $excerpt );
                                        } else {
                                            $excerpt = substr( $excerpt, 0, $limit ) . $pad;
                                            echo esc_attr( $excerpt );
                                        }
                                    ?>

                                    </div><!-- .dt-news-post-desc -->
                                </div><!-- .dt-news-post-content -->

                                <div class="clearfix"></div>
                            </div><!-- .dt-news-post -->

                        <?php endwhile; ?>

                        <?php wp_reset_postdata(); ?>

                        <div class="clearfix"></div>
                    </div>
                 </div>
            </div>

        <?php else : ?>

            <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>

        <?php
        endif;

    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'category'           => '',
                'no_of_posts'        => '6'
            )
        );

        ?>

        <div class="dt-news-list-1">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'easymag' ); ?></strong></label>

                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Category', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">

                    <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>

                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">

                <label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><strong><?php _e( 'No. of Posts', 'easymag' ); ?></strong></label>

                <input type="number" id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo esc_attr( $instance['no_of_posts'] ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-news-list-1 -->
        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                 = $old_instance;
        $instance['title']        = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['category']     = $new_instance['category'];
        $instance['no_of_posts']  = strip_tags( stripslashes( $new_instance['no_of_posts']  ) );
        return $instance;

    }

}

/**
 * News list Layout 2.
 */
class easymag_news_list2 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_news_list2',
            __( 'Daisy: News Layout 2', 'easymag' ),
            array(
                'description'   => __( 'Posts display layout 2 for recently published post', 'easymag' )
            )
        );
    }

    public function widget( $args, $instance ) {

        global $post;
        $title          = isset( $instance['title'] ) ? $instance['title'] : '';
        $category       = isset( $instance['category'] ) ? $instance['category'] : '';
        $no_of_posts    = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : '';
        $random_posts   = isset( $instance['random_posts'] ) ? $instance['random_posts'] : '';

        if( $random_posts == 'on' ) :
            $random_posts = 'rand';
        endif;

        $news_layout2 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category,
            'posts_per_page'    => $no_of_posts,
            'orderby'           => $random_posts,
        ) );

        if ( $news_layout2->have_posts() ) : ?>

        <div class="dt-news-list-2">
            <div class="dt-news-layout-wrap">

                <?php if ( !empty( $title ) ) { ?>
                    <h2 class="widget-title"><?php echo esc_html( $title ) ?><span><a href="<?php echo esc_url( get_category_link( $category ) ) ?>"><?php _e( '[ View All ]', 'easymag' ); ?></a></span></h2>
                <?php
                    }
                ?>

                <div class="dt-news-layout2">
                    <?php
                    while ( $news_layout2->have_posts() ) : $news_layout2->the_post(); ?>

                        <div class="dt-news-post transition5">
                            <figure class="dt-news-post-img">

                                <?php
                                if ( has_post_thumbnail() ) :
                                    $image = '';
                                    $title_attribute = get_the_title( $post->ID );
                                    $image .= '<a href="'. esc_url( get_permalink()) . '" title="' . esc_html( the_title( '', '', false ) ) .'">';
                                    $image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-medium', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                                    echo $image;

                                endif;
                                ?>

                                <div class="dt-news-post-meta">
                                    <span class="dt-news-post-month"><?php esc_attr( the_time("M") ); ?><br/><?php esc_attr( the_time("Y") ); ?></span>
                                    <span class="dt-news-post-day"><?php esc_attr( the_time("d") ); ?></span>
                                </div><!-- .dt-news-post-meta -->
                            </figure><!-- .dt-news-post-img -->

                            <div class="dt-news-post-content">
                                <h3>
                                    <a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
                                        <?php echo wp_trim_words( get_the_title(), 10, '...' ); ?>
                                    </a>
                                </h3>

                                 <div class="dt-news-post-desc">

                                     <?php echo wp_trim_words( get_the_excerpt(), 24, '...' ); ?>

                                 </div><!-- .dt-news-post-desc -->
                            </div><!-- .dt-news-post-content -->
                        </div><!-- .dt-news-post transition5 -->

                        <?php
                    endwhile; ?>

                </div><!-- .dt-news-layout2 -->
                <div class="clearfix"></div>
            </div><!-- .dt-news-layout-wrap -->

        </div>

        <?php else : ?>
            <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>
        <?php endif; ?>

        <?php

    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'category'           => '',
                'no_of_posts'        => '6',
                'random_posts'       => ''
            )
        );

        ?>

        <div class="dt-news-list-2">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'easymag' ); ?></strong></label>

                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Category', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">

                    <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>

                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">

                <label for="<?php echo $this->get_field_id( 'random_posts' ); ?>"><strong><?php _e( 'Random Posts', 'easymag' ); ?></strong></label>

                <input type="checkbox" <?php checked( $instance[ 'random_posts' ], 'on' ); ?> id="<?php echo $this->get_field_id( 'random_posts' ); ?>" name="<?php echo $this->get_field_name( 'random_posts' ); ?>" />
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">

                <label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><strong><?php _e( 'No. of Posts', 'easymag' ); ?></strong></label>

                <input type="number" id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo esc_attr( $instance['no_of_posts'] ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-news-list-2 -->

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                   = $old_instance;
        $instance['title']          = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['category']       = $new_instance['category'];
        $instance[ 'random_posts' ] = $new_instance[ 'random_posts' ];
        $instance['no_of_posts']    = strip_tags( stripslashes( $new_instance['no_of_posts'] ) );
        return $instance;

    }

}

/**
 * News list Layout 3.
 */
class easymag_news_list3 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_news_list3',
            __( 'Daisy: News Layout 3', 'easymag' ),
            array(
                'description'   => __( 'Posts display layout 3 for recently published post', 'easymag' )
            )
        );
    }

    public function widget( $args, $instance ) {

        $title          = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
        $category       = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
        $no_of_posts    = isset( $instance[ 'no_of_posts' ] ) ? $instance[ 'no_of_posts' ] : '';

        $news_layout3 = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category,
            'posts_per_page'    => $no_of_posts
        ) );

        $title2          = isset( $instance[ 'title2' ] ) ? $instance[ 'title2' ] : '';
        $category2       = isset( $instance[ 'category2' ] ) ? $instance[ 'category2' ] : '';

        $news_layout3a = new WP_Query( array(
            'post_type'         => 'post',
            'category__in'      => $category2,
            'posts_per_page'    => $no_of_posts
        ) );

        ?>

       <div class="dt-news-list-3">
            <div class="dt-news-layout-wrap dt-news-layout-half">

            <?php

            if ( $news_layout3->have_posts() ) : ?>

                <?php if ( ! empty( $title ) ) { ?>

                <h2 class="widget-title"><?php echo esc_html( $title ) ?><span><a href="<?php echo esc_url( get_category_link( $category ) ) ?>"><?php _e( '[ View All ]', 'easymag' ); ?></a></span></h2>

                <?php } ?>

                <div class="dt-news-layout3">

                    <?php

                    while ( $news_layout3->have_posts() ) : $news_layout3->the_post(); ?>

                        <div class="dt-news-post">
                            <figure class="dt-news-post-img">
                                <?php

                                if ( has_post_thumbnail() ) :

                                    the_post_thumbnail( 'dt-featured-post-medium' );

                                endif;

                                ?>

                                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><span class="transition35"><i class="fa fa-search transition35"></i></span></a>
                            </figure><!-- .dt-news-post-img -->

                            <div class="dt-news-post-content">
                                <div class="dt-news-post-meta">
                                    <span class="dt-news-post-date"><i class="fa fa-calendar"></i> <?php the_time ( get_option ( 'date_format' ) ); ?></span>

                                    <span class="dt-news-post-comments"><i class="fa fa-comments"></i> <?php comments_number( 'No Responses', 'one Response', '% Responses' ); ?></span>
                                </div><!-- .dt-news-post-meta -->

                                <h3><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">

                                    <?php echo wp_trim_words( get_the_title(), 10, '...' ); ?>

                                </a></h3>

                                <div class="dt-news-post-desc">

                                    <?php

                                    $excerpt = get_the_excerpt();
                                    $limit   = "220";
                                    $pad     = "...";

                                    if( strlen( $excerpt ) <= $limit ) {
                                        echo esc_html( $excerpt );
                                    } else {
                                    $excerpt = substr( $excerpt, 0, $limit ) . $pad;
                                        echo esc_html( $excerpt );
                                    }

                                    ?>

                                </div><!-- .dt-news-post-desc -->
                            </div><!-- .dt-news-post-content -->

                            <div class="clearfix"></div>
                        </div><!-- .dt-news-post -->

                    <?php endwhile; ?>

                </div><!-- .dt-news-layout3 -->

            <?php else : ?>
                <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>

            <?php endif; ?>

            </div><!-- .dt-news-layout-wrap .dt-news-layout-half -->

            <div class="dt-news-layout-wrap dt-news-layout-half dt-half-last">
                <?php
                if ( $news_layout3a->have_posts() ) : ?>

                <?php if ( ! empty( $title ) ) { ?>

                <h2 class="widget-title"><?php echo esc_html( $title2 ) ?><span><a href="<?php echo esc_url( get_category_link( $category2) ) ?>"><?php _e( '[ View All ]', 'easymag' ); ?></a></span></h2>

                <?php } ?>

                <div class="dt-news-layout3">

                    <?php

                    while ( $news_layout3a->have_posts() ) : $news_layout3a->the_post(); ?>

                        <div class="dt-news-post">
                            <figure class="dt-news-post-img">
                                <?php

                                if ( has_post_thumbnail() ) :

                                    the_post_thumbnail( 'dt-featured-post-medium' );

                                endif;

                                ?>

                                <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><span class="transition35"><i class="fa fa-search transition35"></i></span></a>
                            </figure><!-- .dt-news-post-img -->

                            <div class="dt-news-post-content">
                                <div class="dt-news-post-meta">
                                    <span class="dt-news-post-date"><i class="fa fa-calendar"></i> <?php the_time ( get_option ( 'date_format' ) ); ?></span>

                                    <span class="dt-news-post-comments"><i class="fa fa-comments"></i> <?php comments_number( 'No Responses', 'one Response', '% Responses' ); ?></span>
                                </div><!-- .dt-news-post-meta -->

                                <h3><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">

                                        <?php echo wp_trim_words( get_the_title(), 10, '...' ); ?>

                                </a></h3>

                                <div class="dt-news-post-desc">

                                    <?php

                                    $excerpt = get_the_excerpt();
                                    $limit   = "220";
                                    $pad     = "...";

                                    if( strlen( $excerpt ) <= $limit ) {
                                        echo esc_html( $excerpt );
                                    } else {
                                    $excerpt = substr( $excerpt, 0, $limit ) . $pad;
                                        echo esc_html( $excerpt );
                                    }

                                    ?>

                                </div><!-- .dt-news-post-desc -->
                            </div><!-- .dt-news-post-content -->

                            <div class="clearfix"></div>
                        </div><!-- .dt-news-post -->

                    <?php endwhile; ?>

                </div><!-- .dt-news-layout3 -->

            <?php else : ?>
                <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>

            <?php endif; ?>


            </div>
           <div class="clearfix"></div>
        </div>


    <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => '',
                'category'           => '',
                'no_of_posts'        => '6',
                'title2'             => '',
                'category2'          => ''
            )
        );

        ?>

        <div class="dt-news-list-3">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'easymag' ); ?></strong></label>

                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Category', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">

                    <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>

                </select>
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-news-list-3 -->

        <div class="dt-news-list-3">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title2' ); ?>"><strong><?php _e( 'Title 2', 'easymag' ); ?></strong></label>

                <input type="text" id="<?php echo $this->get_field_id( 'title2' ); ?>" name="<?php echo $this->get_field_name( 'title2' ); ?>" value="<?php echo esc_attr( $instance['title2'] ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category2' ); ?>"><strong><?php _e( 'Category 2', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category2' ); ?>" name="<?php echo $this->get_field_name( 'category2' ); ?>">

                    <?php foreach( get_terms( 'category','parent=0&hide_empty=0' ) as $term) { ?>
                        <option <?php selected( $instance['category2'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>

                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">

                <label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><strong><?php _e( 'No. of Posts', 'easymag' ); ?></strong></label>

                <input type="number" id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo esc_attr( $instance['no_of_posts'] ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-news-list-3 -->

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                = $old_instance;
        $instance['title']       = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['category']    = $new_instance['category'];
        $instance['no_of_posts'] = strip_tags( stripslashes( $new_instance['no_of_posts'] ) );

        $instance['title2']      = strip_tags( stripslashes( $new_instance['title2'] ) );
        $instance['category2']   = $new_instance['category2'];
        return $instance;

    }

}

/**
 * News list Layout 4.
 */
class easymag_news_list4 extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'easymag_news_list4',
            __( 'Daisy: News Layout 4', 'easymag' ),
            array(
                'description'   => __( 'Posts display layout 4 for recently published post', 'easymag' )
            )
        );
    }

    public function widget( $args, $instance ) {

        extract( $args, EXTR_SKIP );

        global $post;
        $title           = isset( $instance['title'] ) ? $instance['title'] : '';
        $show_posts_from = isset( $instance['show_posts_from'] ) ? $instance['show_posts_from'] : '';
        $category        = isset( $instance['category'] ) ? $instance['category'] : '';
        $no_of_posts     = isset( $instance['no_of_posts'] ) ? $instance['no_of_posts'] : '';

        if( $show_posts_from == 'recent' ) {
            $news_layout4 = new WP_Query( array(
                'post_type'             => 'post',
                'category__in'          => '',
                'posts_per_page'        => $no_of_posts,
                'ignore_sticky_posts'   => true
            ) );
        } else {
            $news_layout4 = new WP_Query( array(
                'post_type'         => 'post',
                'category__in'      => $category,
                'posts_per_page'    => $no_of_posts
            ) );
        }

        ?>

        <div class="dt-news-list-4">
            <div class="dt-news-layout-wrap dt-sidebar-news">

                <?php
                if ( $news_layout4->have_posts() ) : ?>

                   <?php if ( !empty( $title ) ) { ?>
                        <h2 class="widget-title"><?php echo esc_html( $title ) ?><?php if ( $show_posts_from != 'recent' ) : ?><span><a href="<?php echo esc_url( get_category_link( $category ) ) ?>"><?php _e( '[ View All ]', 'easymag' ); ?></a></span><?php endif; ?></h2>
                    <?php
                        }
                    ?>

                    <div class="dt-news-layout4">
                        <?php

                        while ( $news_layout4->have_posts() ) : $news_layout4->the_post(); ?>

                            <div class="dt-news-post">
                                <figure class="dt-news-post-img">
                                    <?php
                                    if ( has_post_thumbnail() ) :
                                        $image = '';
                                        $title_attribute = get_the_title( $post->ID );
                                        $image .= '<a href="'. esc_url( get_permalink() ) . '" title="' . esc_html( the_title( '', '', false ) ) .'">';
                                        $image .= get_the_post_thumbnail( $post->ID, 'dt-featured-post-small', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
                                        echo $image;

                                    endif;
                                    ?>

                                    <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><span class="transition35"><i class="fa fa-search transition35"></i></span></a>
                                </figure><!-- .dt-news-post-img -->

                                <div class="dt-news-post-content">
                                    <h3><a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>"><?php esc_html( the_title() ); ?></a></h3>
                                </div><!-- .dt-news-post-content -->
                            </div><!-- .dt-news-post -->

                        <?php endwhile; ?>

                        <div class="clearfix"></div>
                    </div><!-- .dt-news-layout4 -->

                <?php else : ?>
                    <p><?php _e( 'Sorry, no posts found in selected category.', 'easymag' ); ?></p>

                <?php endif; ?>

            </div><!-- .dt-news-layout-wrap .dt-sidebar-news -->
        </div>

        <?php
    }

    public function form( $instance ) {

        $instance = wp_parse_args(
            (array) $instance, array(
                'title'              => __( 'Recent Posts', 'easymag' ),
                'show_posts_from'    => 'recent',
                'category'           => '',
                'no_of_posts'        => '6'
            )
        );

        ?>

        <div class="dt-news-list-4">
            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><strong><?php _e( 'Title', 'easymag' ); ?></strong></label>

                <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'show_posts_from' ); ?>"><strong><?php _e( 'Chose Type', 'easymag' ); ?></strong></label>

                <input type="radio" id="<?php echo $this->get_field_id( 'show_posts_from' ); ?>" name="<?php echo $this->get_field_name( 'show_posts_from' ); ?>" value="recent" <?php checked( $instance[ 'show_posts_from' ], 'recent' ); ?> ><?php _e( 'Recent Posts', 'easymag' ); ?>
                <input type="radio" id="<?php echo $this->get_field_id( 'show_posts_from' ); ?>" name="<?php echo $this->get_field_name( 'show_posts_from' ); ?>" value="category" <?php checked( $instance[ 'show_posts_from' ], 'category' ); ?> ><?php _e( 'Category', 'easymag' ); ?>

                <br ><br >
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">
                <label for="<?php echo $this->get_field_id( 'category' ); ?>"><strong><?php _e( 'Category', 'easymag' ); ?></strong></label>

                <select id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">

                    <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                        <option <?php selected( $instance['category'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                    <?php } ?>

                </select>
            </div><!-- .dt-admin-input-wrap -->

            <div class="dt-admin-input-wrap">

                <label for="<?php echo $this->get_field_id( 'no_of_posts' ); ?>"><strong><?php _e( 'No. of Posts', 'easymag' ); ?></strong></label>

                <input type="number" id="<?php echo $this->get_field_id( 'no_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'no_of_posts' ); ?>" value="<?php echo esc_attr( $instance['no_of_posts'] ); ?>">
            </div><!-- .dt-admin-input-wrap -->
        </div><!-- .dt-news-list-4 -->

        <?php
    }

    public function update( $new_instance, $old_instance ) {

        $instance                       = $old_instance;
        $instance['title']              = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['show_posts_from']    = $new_instance['show_posts_from'];
        $instance['category']           = $new_instance['category'];
        $instance['no_of_posts']        = strip_tags( stripslashes( $new_instance['no_of_posts'] ) );
        return $instance;

    }

}

// Register widgets
function easymag_register_widgets() {

    register_widget( 'easymag_social_icons' );
    register_widget( 'easymag_ads_728x90' );
    register_widget( 'easymag_ads_130x130' );
    register_widget( 'easymag_ads_870x150' );
    register_widget( 'easymag_ads_262x220' );
    register_widget( 'easymag_news_ticker' );
    register_widget( 'easymag_featured_post_slider' );
    register_widget( 'easymag_highlighted_news' );
    register_widget( 'easymag_news_list1' );
    register_widget( 'easymag_news_list2' );
    register_widget( 'easymag_news_list3' );
    register_widget( 'easymag_news_list4' );

}
add_action( 'widgets_init', 'easymag_register_widgets' );
