<?php
/**
 * Flaunt functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Flaunt
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function flaunt_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Flaunt, use a find and replace
		* to change 'flaunt' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'flaunt', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'flaunt' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'flaunt_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 100,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'flaunt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function flaunt_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'flaunt_content_width', 640 );
}
add_action( 'after_setup_theme', 'flaunt_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function flaunt_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'flaunt' ),
			'id'            => 'sidebar-1',
			'description'   => 'Add widgets here',
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => ''
		)
	);

	register_sidebar( 
		array(
			'name' => 'Navbar Social Media Widget',
            'id' => 'navbar-social',
            'description' => 'Navbar Widget Area specifically for Social Media Icons',
            'before_title' => '',
            'after_title' => '',
            'before_widget' => '',
            'after_widget' => '',
		) 
		);
}
add_action( 'widgets_init', 'flaunt_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function flaunt_scripts() {
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'flaunt-style', get_stylesheet_uri(), array(), $version, 'all' );
	wp_enqueue_style('flaunt-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css', array(), '5.13.0', 'all');
	wp_style_add_data( 'flaunt-style', 'rtl', 'replace' );

	wp_enqueue_script( 'flaunt-script', get_template_directory_uri() . "/js/script.js", array(), $version, true);	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'flaunt_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


/**
 * Add nav sidebar settings
 */

add_action( 'customize_register', 'flaunt_customize_sidebar' );

function flaunt_customize_sidebar( $wp_customize ) {
	//Add Sidebar admin section
	$wp_customize->add_section( 'flaunt_sidebar' , array(
		'title' => 'Sidebar Settings',
		'description' => 'Edit the sidebar settings',
		'priority' => 999999,
	) );

	$wp_customize->add_setting( 'avatar' , array(
		// 'default' => '#fff',
		'transport' => 'refresh',
		'type' => 'theme_mod',
		'sanitize_callback' => 'absint'
		
	) );

	$wp_customize->add_control( new WP_Customize_Cropped_Image_Control( $wp_customize, 'avatar', array(
		'section'    => 'flaunt_sidebar',
		'label'      => 'Add Avatar image',
		// 'settings'   => 'background_color',
		'width' => 150,
		'height' => 150
	) ) );
}

function echo_sidebar_avatar() {
	$id = get_theme_mod('avatar');

	if ($id != 0) {
		
		$url = wp_get_attachment_url($id);
		echo '<div class="flaunt-sidebar-avatar">';
        echo '<img src="' . $url . '" alt="" />';
        echo '</div>';
	}
}

function flaunt_menus(){

    $locations = array(
        //key is location, value is title
        'primary' => 'Primary Left Sidebar',
        'footer' => 'Footer Menu Items'
    );

    register_nav_menus($locations);
}

add_action('init', 'flaunt_menus');
