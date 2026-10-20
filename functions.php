<?php

if ( ! function_exists( 'pcwc_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various
	 * WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme
	 * hook, which runs before the init hook. The init hook is too late
	 * for some features, such as indicating support post thumbnails.
	 */
	function pcwc_setup() {

		/**
		 * Add default posts and comments RSS feed links to <head>.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Enable support for post thumbnails and featured images.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add support for two custom navigation menus.
		 */
		register_nav_menus( array(
			'header' => __( 'Header', 'Menu that appears at the top of every page.' ),
			'footer' => __( 'Footer', 'Menu that appears at the bottom of every page.' ),
			'home' => __( 'Call to Action', 'Put one link here to appear on the Home page.' ),
		) );

		/**
		 * Enable support for the following post formats:
		 * aside, gallery, quote, image, and video
		 */
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'quote', 'image', 'video' ) );

	}
endif; // pcwc
//_setup
add_action( 'after_setup_theme', 'pcwc_setup' );

// add custom css
function pcwc_enqueue() {
    // wp_enqueue_style('bootstrap_css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script(
		'dropdown_support', 
		get_template_directory_uri() . "/dropdown.js",
		array(),
		'1.0.0',
		array('strategy' => 'defer')
	);
	wp_enqueue_style('pcwc_style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'pcwc_enqueue');

function custom_comment_form_text( $defaults ) {
    // Change the "Leave a Reply" heading text
    $defaults['title_reply'] = __( 'Contact Us', 'textdomain' );
    
    // Change the Submit button text
    $defaults['label_submit'] = __( 'Send', 'textdomain' );
    
    // Change the note displayed before the comment text box
    $defaults['comment_notes_before'] = '<p class="comment-notes">Feedback</p>';

    return $defaults;
}
add_filter( 'comment_form_defaults', 'custom_comment_form_text' );

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'pcwc_register_required_plugins' );

function pcwc_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'WP Carousel',
            'slug'      => 'wp-carousel-free',
            'required'  => true,
        ),
		array(
            'name'      => 'Yoast SEO',
            'slug'      => 'wordpress-seo',
            'required'  => false,
        ),
    );

    $config = array(
        'id'           => 'pcwc-tgmpa',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'is_automatic' => false,
    );

    tgmpa( $plugins, $config );
}