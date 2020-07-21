<?php
/**
 * _grand-line functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _grand-line
 */

if ( ! function_exists( '_grand_line_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function _grand_line_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _grand-line, use a find and replace
		 * to change '_grand-line' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_grand-line', get_template_directory() . '/languages' );

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
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', '_grand-line' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( '_grand_line_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', '_grand_line_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _grand_line_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( '_grand_line_content_width', 640 );
}
add_action( 'after_setup_theme', '_grand_line_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _grand_line_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_grand-line' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', '_grand-line' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_grand_line_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _grand_line_scripts() {
	wp_enqueue_style( '_grand-line-style', get_stylesheet_uri() );

	wp_enqueue_script( '_grand-line-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( '_grand-line-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_grand_line_scripts' );

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


//Новый виджет
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name' => 'New Sidebar',
        'before_widget' => '<div class="newsidebar">',
        'after_widget' => '</div>',
        'before_title' => '<div class="title">',
        'after_title' => '</div>',
    ));






/**
 * Plugin Name: CF7 Modal Right Answer
 * Plugin URI: https://gist.github.com/campusboy87/a056c288c99feee70058ed24cee805ad
 * Author: Campusboy (wp-plus)
 * Author URI: https://www.youtube.com/wp-plus
 */
add_action( 'wp_enqueue_scripts', 'wpcf7_modal_mailsent_js' );
add_action( 'wp_footer', 'wpcf7_modal_mailsent_js_inline', 999 );
/**
 * Поключает библиотеку sweetalert.js для создания красивых модальных окон.
 *
 * @link https://sweetalert.js.org/
 *
 * @return void
 */
function wpcf7_modal_mailsent_js() {
	wp_enqueue_script( 'sweetalert', 'https://unpkg.com/sweetalert/dist/sweetalert.min.js' );
}
/**
 * Выводит на экран модальное окно при успешной отправки формы.
 *
 * @return void
 */
function wpcf7_modal_mailsent_js_inline() {
	?>
    <script>
		// Ищем блок с формой, имеющий класс wpcf7 (его имеют все div с формой)
		

        // Срабатывает при успешной отправке формы.
        	document.addEventListener('wpcf7mailsent', function (event) {
        	//сообщение отправки формы
        	var url = "https://grandline-diler.ru/form-phone";
        	
        	if ( '5' == event.detail.contactFormId ) {
		        url = "https://grandline-diler.ru/form-list";
		    }
		    if ( '71' == event.detail.contactFormId ) {
		        url = "https://grandline-diler.ru/form-comment";
		    }
		    if ( '46' == event.detail.contactFormId ) {
		        url = "https://grandline-diler.ru/form-photo";
		    }
      
        	$(location).attr('href',url);


        	//подключение CRM
	        var name, phone, email, selected;
	      
	            name = $('.sent input[name="text-name"]').val() || $('.sent input[name="text-name2"]').val() || $('.sent input[name="text-name3"]').val() || $('.sent input[name="text-924"]').val();
		        phone = $('.sent input[name="tel-558"]').val() || $('.sent input[name="tel-559"]').val() || $('.sent input[name="tel-867"]').val() || $('.sent input[name="tel-868"]').val()|| $('.sent input[name="tel-744"]').val();
	       		selected = $('.sent').find('.selected-product').text() || $('.sent').find('textarea[name="textarea-980"]').val() || $('.sent').find('input[name="text-1"]').val();
		        email = $('.sent input[name="email-272"]').val() || $('.sent input[name="email-273"]').val();
		        
		        WBK.sendCrmLead(47568, {'name' : name, 'email' : email, 'phone' : phone, 'comment' : selected});

        }, false);
    </script>

    <style>
        .wpcf7-mail-sent-ok {
            display: none !important;
        }
    </style>
	<?php
}
function characteristic_shortcode( $atts ){
	return '<div class="features-item__list-wr">
		<dl class="features-item__list">
			<dt class="title">' . $atts['title'] . '</dt>
		 	<dd class="value">' . $atts['value'] . '</dd>
		</dl>
	</div>';
}
add_shortcode('characteristic', 'characteristic_shortcode');

