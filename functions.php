<?php
/**
 * Twenty Sixteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentysixteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own twentysixteen_setup() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'twentysixteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );

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
	 * Enable support for custom logo.
	 *
	 *  @since Twenty Sixteen 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'twentysixteen' ),
		'social'  => __( 'Social Links Menu', 'twentysixteen' ),
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
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', twentysixteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentysixteen_setup
add_action( 'after_setup_theme', 'twentysixteen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 840 );
}
add_action( 'after_setup_theme', 'twentysixteen_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentysixteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 1', 'twentysixteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Content Bottom 2', 'twentysixteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears at the bottom of the content on posts and pages.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentysixteen_widgets_init' );

if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Sixteen.
 *
 * Create your own twentysixteen_fonts_url() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentysixteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Inconsolata:400';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'twentysixteen-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160412' );
	}

	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160412', true );

	wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'twentysixteen' ),
		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'twentysixteen_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args' );

$tDir = get_template_directory_uri();
$url  = get_bloginfo('url');

function tt($image, $w, $h, $zc=1, $ex=''){ 
   global $tDir, $url;
        if(!isset($image) || empty($image)){
            $image = get_stylesheet_directory_uri().'/img/384X351.jpg';
        }
   $extra = (!empty($ex)) ? '&'.$ex : '';
   return $tDir . '/timthumb.php?src='.trim($image).'&w='.$w.'&h='.$h.'&zc='.$zc.$extra;
 }

/**
 * Call descriptions to menu items
 */
function nutresa_nav_description( $item_output, $item, $depth, $args ) {

    if ( 'primary' == $args->theme_location && $item->description ) {
        $item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
    }

    return $item_output;

}

add_filter( 'walker_nav_menu_start_el', 'nutresa_nav_description', 10, 4 );

/*--------NUESTRAS MÁQUINAS---------*/

wp_localize_script( 'nutresa-script', 'ajax_posts', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'noposts' => __('No older posts found', 'nutresa'),
));

function more_post_ajax(){
    //print_r($_POST);exit;
    //=== START: FETCH INITIAL RECORDS ===//
    $ppp = (!empty($_POST['ppp']) && $_POST['ppp']>0) ? $_POST["ppp"] : 5;
    $tmp_page = (!empty($_POST['pageNumber']) && $_POST['pageNumber']>0) ? $_POST['pageNumber'] : 0;
    $page = $tmp_page*$ppp;
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $ppp,
        'cat' => 3, // category => NUESTRAS MÁQUINAS
        'offset'    => $page,
        'post_status' => 'publish'
    );
    $loop = new WP_Query($args);
    $display_records = count($loop->posts);
    //echo "<pre>";print_r($loop);
    //=== END: FETCH INITIAL RECORDS =====//
    
    $device_type = $_POST['device_type'];
    $fetch_maq_record = 1;   // true
    $fetched_record_cnt = count($loop->posts);
    //=== START: FETCH NEXT RECORDS TO CHECK WEATHER NEXT CALL IS REQUIRED OR NOT ===//
    if(!empty($fetched_record_cnt) && $fetched_record_cnt>0 && (($device_type == 'desktop' && $fetched_record_cnt==5) || ($device_type == 'mobile' && $fetched_record_cnt==3))){
        // fetch next records and count based on returned record weather we have to set another call for new records or not using LOAD MORE.
        $tmp_page++;
        $next_page = $tmp_page*$ppp;
        $next_args = array(
            'post_type' => 'post',
            'posts_per_page' => $ppp,
            'cat' => 3, // category => NUESTRAS MÁQUINAS
            'offset'    => $next_page,
            'post_status' => 'publish'
        );
        $next_records = new WP_Query($next_args);
        $remaining_records = 0;
        if(!empty($next_records->posts) && count($next_records->posts)>0){
            $remaining_records = count($next_records->posts);
            if($remaining_records == 1){
                //echo "<pre>";print_r($next_records->posts);exit;
                // push this record in main array to make it 6 instead of 5 records.. and display those 6 records in 3*3 format
                
                //echo "<pre>";print_r($loop->posts);
                //echo "<pre>";print_r($next_records->posts[0]);
                array_push($loop->posts, $next_records->posts[0]);
                $display_records = $display_records+1;
                $loop->post_count = $display_records;
                $fetch_maq_record = 0;   // flase, no need to display button to fetch more records from Database as there is no more records
            }
        }else{
            $fetch_maq_record = 0;   // flase, no need to display button to fetch more records from Database as there is no more records
        }
    }else{
        $fetch_maq_record = 0;   // flase, no need to display button to fetch more records from Database as there is no more records
    }
    //echo "<pre>";print_r($loop);exit;
    //=== END: FETCH NEXT RECORDS TO CHECK WEATHER NEXT CALL IS REQUIRED OR NOT =====//

    
    $out = '';
    $tmp = 1;
    header("Content-Type: text/html");
    if ($loop -> have_posts()) :  
        while ($loop -> have_posts()) : $loop -> the_post();
            $class_name = "col-1-3";
            $img_width = 640;
            $img_height = 396;
            if($tmp <=2 ){
                $class_name = "half";
                $img_width = 960;
                $img_height = 396;
            }

            if($display_records == 2 || $display_records == 4){
                $class_name = "half";
                $img_width = 960;
                $img_height = 396;
            }else if ($display_records == 3) {
                $class_name = "col-1-3";
                $img_width = 640;
                $img_height = 396;
            }else if($display_records == 6){
                $class_name = "col-1-3";
                $img_width = 640;
                $img_height = 396;
            }
            
            $out .= '<div class="'.$class_name.'">';
            if(wp_get_attachment_url( get_post_thumbnail_id($post->ID) )){
                $maquinasimg = tt( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ), $img_width, $img_height, 1);
            }  else {
                $maquinasimg = tt(get_stylesheet_directory_uri().'/img/384X351.jpg', $img_width, $img_height, 1);
            }
            $out .= '<img src="'. $maquinasimg .'" alt="">'.
                    '<div class="plus"></div><div class="postContent">'.
                    '<h3>'. substr( get_the_title($before = '', $after = '', FALSE), 0, 40) .'</h3>';
                    /*if ( has_excerpt( $post->ID ) ) {
            $out .= '<p>'. substr( get_the_excerpt($before = '', $after = '', FALSE), 0, 231).'</p>';
                     }*/
            $out .= '<a href="'. get_the_permalink() .'" class="btn">'. ot_get_option( 'ver_mas_button_text' ) .'</a></div><div class="overlay"></div>'.
                    '</div>';
            $tmp++;       
        endwhile;
        $out .= "$$$$$".$fetch_maq_record;
    endif;
    wp_reset_postdata();
    die($out);
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');


/*--------NUESTRAS RUTINAS---------*/

/*wp_localize_script( 'nutresa-script', 'ajax_posts', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'noposts' => __('No older posts found', 'nutresa'),
));*/

function more_post_ajax_rutinas(){
    /*echo '<pre>';
    print_r($_POST);*/
    $ppp_rutinas = (!empty($_POST['ppp_rutinas']) && $_POST['ppp_rutinas']>0) ? $_POST["ppp_rutinas"] : 5;
    $tmp_page_rutinas = (!empty($_POST['pageNumber_rutinas']) && $_POST['pageNumber_rutinas']>0) ? $_POST['pageNumber_rutinas'] : 0;
    $page_rutinas = $tmp_page_rutinas*$ppp_rutinas;

    $args_rutinas = array(
        'post_type' => 'post',
        'posts_per_page' => $ppp_rutinas,
        'cat' => 9,
        'offset'    => $page_rutinas,
        'post_status' => 'publish'
    );
    $loop_rutinas = new WP_Query($args_rutinas);
    $display_rutinas_records = count($loop_rutinas->posts);
    $fetched_rutinas_record_cnt = count($loop_rutinas->posts);
    
	$device_type = $_POST['device_type'];
    $fetch_new_record = 1;   // true
    if(!empty($fetched_rutinas_record_cnt) && $fetched_rutinas_record_cnt>0 && (($device_type == 'desktop' && $fetched_rutinas_record_cnt==5) || ($device_type == 'mobile' && $fetched_rutinas_record_cnt==3))){
        // fetch next records and count based on returned record weather we have to set another call for new records or not using LOAD MORE.
        $tmp_page_rutinas++;
        $next_rutinas_page = $tmp_page_rutinas*$ppp_rutinas;
        $next_rutinas_args = array(
            'post_type' => 'post',
            'posts_per_page' => $ppp_rutinas,
            'cat' => 9, // category => NUESTRAS Rutinas
            'offset'    => $next_rutinas_page,
            'post_status' => 'publish'
        );
        $next_rutinas_records = new WP_Query($next_rutinas_args);
        $remaining_rutinas_records = 0;
        if(!empty($next_rutinas_records->posts) && count($next_rutinas_records->posts)>0){
            $remaining_rutinas_records = count($next_rutinas_records->posts);
            if($remaining_rutinas_records == 1){
                array_push($loop_rutinas->posts, $next_rutinas_records->posts[0]);
                $display_rutinas_records = $display_rutinas_records+1;
                $loop_rutinas->post_count = $display_rutinas_records;
                $fetch_new_record = 0;   // flase, no need to display button to fetch more records from Database as there is no more records
            }
        }else{
            $fetch_new_record = 0;   // flase, no need to display button to fetch more records from Database as there is no more records
        }
    }else{
        $fetch_new_record = 0;   // flase, no need to display button to fetch more records from Database as there is no more records
    }
    
    $out_rutinas = '';
    $tmp_rutinas = 1;
    header("Content-Type: text/html");
    if ($loop_rutinas -> have_posts()) :  
        while ($loop_rutinas -> have_posts()) : $loop_rutinas -> the_post();
            $class_name_rutinas = "half";
            $img_width = 670;
            $img_height = 496;
            if($tmp_rutinas <=3 ){
                $class_name_rutinas = "col-1-3";
                $img_width = 480;
                $img_height = 496;
            }
            
            if($display_rutinas_records == 2 || $display_rutinas_records == 4){
                $class_name_rutinas = "half";
                $img_width = 670;
                $img_height = 496;
            }else if ($display_rutinas_records == 3) {
                $class_name_rutinas = "col-1-3";
                $img_width = 480;
                $img_height = 496;
            }else if($display_rutinas_records == 6){
                $class_name_rutinas = "col-1-3";
                $img_width = 480;
                $img_height = 496;
            }
            
        $out_rutinas .= '<div class="'. $class_name_rutinas .'">';
        if(wp_get_attachment_url( get_post_thumbnail_id($post->ID) )){
                $rutinasimg = tt( wp_get_attachment_url( get_post_thumbnail_id($post->ID) ), $img_width, $img_height, 1);
            }  else {
                $rutinasimg = tt(get_stylesheet_directory_uri().'/img/384X351.jpg', $img_width, $img_height, 1);
            }
        $out_rutinas .='<img src="'. $rutinasimg .'" alt="">'.
                '<div class="plus"></div><div class="postContent">'.
                '<h3>'. substr( get_the_title($before = '', $after = '', FALSE), 0, 40) .'</h3>';
                /*if ( has_excerpt( $post->ID ) ) {
        $out_rutinas .= '<p>'. substr( get_the_excerpt($before = '', $after = '', FALSE), 0, 182) .'</p>';
                }*/
        $out_rutinas .= '<a href="'. get_the_permalink() .'" class="btn">'. ot_get_option( 'ver_mas_button_text' ).'</a></div><div class="overlay"></div>'.
                '</div>';
        $tmp_rutinas++;
    endwhile;
    
    $out_rutinas .= "$$$$$".$fetch_new_record;
    endif;
    wp_reset_postdata();
    die($out_rutinas);
}

add_action('wp_ajax_nopriv_more_post_ajax_rutinas', 'more_post_ajax_rutinas');
add_action('wp_ajax_more_post_ajax_rutinas', 'more_post_ajax_rutinas');


//=== START: TIENDA PRODUCT LIST ===//
function more_post_ajax_products(){
	//echo "inside fucntion";exit;
    //echo '<pre>';print_r($_POST);exit;
    $ppp_product = (!empty($_POST['ppp_product']) && $_POST['ppp_product']>0) ? $_POST["ppp_product"] : 6;
    $tmp_page_products = (!empty($_POST['pageNumber_product']) && $_POST['pageNumber_product']>0) ? $_POST['pageNumber_product'] : 0;
    $page_products = $tmp_page_products*$ppp_product;

    $args_product = array(
        'post_type' => 'post',
        'posts_per_page' => $ppp_product,
        'cat' => 19,
        'offset'    => $page_products,
        'post_status' => 'publish'
    );
    $loop_product = new WP_Query($args_product);
    $display_product_records = count($loop_product->posts);
    $fetched_product_record_cnt = count($loop_product->posts);

    $fetch_new_record = 1;   // true
    $out_product = '';
    $out_product .= '<div class="row clearfix">';
    header("Content-Type: text/html");
    if ($loop_product -> have_posts()) :  
        while ($loop_product -> have_posts()) : $loop_product -> the_post();

        $out_product .= '<div class="col-1-4">';
        $out_product .= '<a class="postbox" href="'. get_permalink() .'">';
		$out_product .= '<div class="postimg">';
                    $feat_image2 = get_field('tienda_landing_page');
                            if($feat_image2==""){ 
                                 $feat_image2 = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()));
                $out_product .= $feat_image2;
                             }
                            if(isset($feat_image2) && !empty($feat_image2)){
                $out_product .= '<img src="'.tt($feat_image2, 240, 180, 0).'" alt="">';
                            } else { 
                $out_product .= '<img src="' . get_stylesheet_directory_uri() . '"/img/240X180.jpg" alt="">';
                            } 
		$out_product .= '</div><div class="postdetail">';
		$out_product .= '<h5>'. substr( get_the_title($before = '', $after = '', FALSE), 0, 35) .'</h5>';
			$tienda_excerpt = get_the_excerpt();
			$getdes = strlen($tienda_excerpt) > 89 ? substr($tienda_excerpt,0,89)." ..." : $tienda_excerpt;
		$out_product .= '<p>'. $getdes .'</p></div>';
		$out_product .= '<div class="greenbar clearfix">';
		$out_product .= '<span class="date">'. get_field('product_date', get_the_ID()) .'</span>';
		$out_product .= '<span class="ref_no">REF:'. substr( get_field('reference_code', get_the_ID()) , 0, 4 ).'</span>';
        $out_product .= '</div></a></div>';
        
        $tmp_product++;
    endwhile;
    $out_product .= '</div><div class="clearfix"></div>';
    $out_product .= "$$$$$".$fetch_new_record;
    endif;
    wp_reset_postdata();
    die($out_product);
}

add_action('wp_ajax_nopriv_more_post_ajax_products', 'more_post_ajax_products');
add_action('wp_ajax_more_post_ajax_products', 'more_post_ajax_products');
//=== END: TIENDA PRODUCT LIST ===//
















class Menu_With_Description extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

remove_filter('term_description','wpautop');

//function recent_posts($no_posts = 3, $excerpts = true) {
//
//   global $wpdb;
//
//   $request = "SELECT ID, post_title, post_excerpt FROM $wpdb->posts WHERE post_status = 'publish' AND post_type='post' ORDER BY post_date DESC LIMIT $no_posts";
//
//   $posts = $wpdb->get_results($request);
//
//   if($posts) {
//
//               foreach ($posts as $posts) {
//                       $post_title = stripslashes($posts->post_title);
//                       $permalink = get_permalink($posts->ID);
//                      // $images=get_post_thumbnail_id($posts->ID);
//                       $tem_value="Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
//                       $image = wp_get_attachment_image_src(get_post_thumbnail_id($posts->ID), 'single-post-thumbnail' ); 
//                        
//                       $output .= '<div class="rltPost">
//                           <img src="'.$image[0].'" alt="">   
//                          <div class="rltPostTxt">
//                              <h4>'.$post_title.'</h4>
//                                <p>'.substr($tem_value, 0,30)."....".'</p>
//                          </div>
//                           <a href="'.$permalink.'" class="btn">'. ot_get_option( 'ver_mas_button_text' ).'</a>   
//                       </div>';
////                       if($excerpts) {
////                               $output.= '' . stripslashes($posts->post_excerpt);
////                       }
//
//                       $output .= '';
//               }
//
//       } else {
//               $output .= '<li>No posts found</li>';
//       }
//
//   echo $output;
//}

add_filter('edit_category_form_fields', 'cat_description');
function cat_description($tag)
{
    ?>
        <table class="form-table">
            <tr class="form-field">
                <th scope="row" valign="top"><label for="description"><?php _ex('Description', 'Taxonomy Description'); ?></label></th>
                <td>
                <?php
                    $settings = array('wpautop' => true, 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => '15', 'textarea_name' => 'description' );
                    wp_editor(wp_kses_post($tag->description , ENT_QUOTES, 'UTF-8'), 'cat_description', $settings);
                ?>
                <br />
                <span class="description"><?php _e('The description is not prominent by default; however, some themes may show it.'); ?></span>
                </td>
            </tr>
        </table>
    <?php
}

add_action('admin_head', 'remove_default_category_description');
function remove_default_category_description()
{
    global $current_screen;
    if ( $current_screen->id == 'edit-category' )
    {
    ?>
        <script type="text/javascript">
        jQuery(function($) {
            $('textarea#description').closest('tr.form-field').remove();
        });
        </script>
    <?php
    }
}

// remove the html filtering
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );


/* Unidos Timeline Post */

function date_month_spanish($custom_date){
     $month_array = array(
    'January'   => 'ENERO',
    'February'  => 'FEBREEO',
    'March'     => 'MARZO',
    'April'     => 'ABRIL',
    'May'       => 'MAYO',
    'June'      => 'JUNIO',
    'July'      => 'JULIO',
    'August'    => 'AGOSTO',
    'September' => 'SEPTIEMBRE',
    'October'   => 'OCTUBURE',
    'November'  => 'NOVIEMBRE',
    'December'  => 'DICIEMBRE');
    
    $dateex = explode(' ', $custom_date);
    //print_r($dateex);
    $dateString = explode('/', $dateex[1]);
    //print_r($dateString);
    /*$month = $month_array[$dateString[0]];
    $newdate = str_replace($dateString[0], $month, $innercustom_date);*/
    //$finaldate = $dateex[0]." DE ".$dateex[1]." DE ".$dateex[2];
    $month_title = $dateString[0];
	if(in_array($dateString[0], $month_array)){
		//$month = $month_array[$dateString[0]];
		echo $month_title = $month_array[$dateString[0]];
	}
    $newdate = str_replace($dateString[0], $month_title, $custom_date);
    $datechanged = explode(' ',$newdate);
    $finaldate = $datechanged[0]. '/' .$datechanged[1]; 
    //echo $finaldate;
    return $finaldate;
    
}

function more_post_ajax_unidos_timeline(){
    //echo '<pre>';print_r($_POST);exit;
    $ppp_unidos = (!empty($_POST['ppp_unidos']) && $_POST['ppp_unidos']>0) ? $_POST["ppp_unidos"] : 5;
    $tmp_page_unidos = (!empty($_POST['pageNumber_unidos']) && $_POST['pageNumber_unidos']>0) ? $_POST['pageNumber_unidos'] : 0;
    $page_unidos = $tmp_page_unidos*$ppp_unidos;
    
    $category = get_category_by_slug( 'timeline' );

    $args = array(
    'type'                     => 'post',
    'child_of'                 => $category->term_id,
    'orderby'                  => 'name',
    'order'                    => 'ASC',
    'hide_empty'               => FALSE,
    'hierarchical'             => 1,
    'taxonomy'                 => 'category',
    ); 
    $child_categories = get_categories($args );
    $category_list = array();
    //$category_list[] = $category->term_id;
    if ( !empty ( $child_categories ) ){
        foreach ( $child_categories as $child_category ){
            $category_list[] = $child_category->term_id;
        }
    }
    
    $unidos_cat = $category_list;
    if(!empty($_REQUEST['cat']) && $_REQUEST['cat'] > 0 ){
        $unidos_cat = array($_REQUEST['cat']);
    }  
    
    $args_unidos = array(
        'posts_per_page'   => 5,
        'offset'           => $page_unidos,
        'category__in'     => $unidos_cat,
        'orderby'          => 'meta_value',
        'meta_key'         => 'grupos_post_date',
        'order'            => 'desc',
        'post_type'        => 'post',
        'post_status'      => array('publish' ),
    );
    $my_query = null;
    $my_query = new WP_Query($args_unidos);

	$args_unidos_all = array(
		'posts_per_page'   => -1,
        'category__in'     => $unidos_cat,
        'orderby'          => 'meta_value',
        'meta_key'         => 'grupos_post_date',
        'order'            => 'desc',
        'post_type'        => 'post',
        'post_status'      => array('publish'),
    );
    $my_query_all = null;
    $unidos_records_all = 0;
    $unidos_records_all_remaining = 0;
    $my_query_all = new WP_Query($args_unidos_all);
    if(!empty($my_query_all->posts)){
    	$unidos_records_all = count($my_query_all->posts);

    	$current_offset = $tmp_page_unidos + 1;
    	$unidos_records_all_remaining = $unidos_records_all - ($current_offset*5);
    }

    header("Content-Type: text/html");
    $loop_unidos = new WP_Query($args_unidos);
    //echo '<pre>'; print_r($loop_unidos);exit;
    $out_unidos = '';
    if ($loop_unidos -> have_posts()) :  
        while ($loop_unidos -> have_posts()) : $loop_unidos -> the_post();
            $out_unidos .= '<div class="timeline-half">';
            $post_cat = implode(',',wp_get_object_terms( get_the_ID(), 'category',array('fields' => 'ids')));
            
                if( get_field('image_or_slider', get_the_ID()) == "image"){ 
                $out_unidos .= '<div class="media-section"><img src="' . tt( get_field('grupos_post_image',  get_the_ID()),540 , 436 ,1 ) . '" alt="">
                                </div>';
                }
                else if( get_field('image_or_slider', get_the_ID()) == "slider"){
                    if( have_rows('grupos_slider') ) {
                $out_unidos .= '<div class="media-section">
                                    <div class="timeLineSlider">';
                                        while( have_rows('grupos_slider') ): the_row();
                                          $out_unidos .=  '<img src="' . tt( get_sub_field('grupos_post_slides'),540 , 295 , 1 ) .'" alt="">';
                                        endwhile;
                                    $out_unidos .= '</div></div>';
                    }
                }
                else if( get_field('image_or_slider', get_the_ID()) == "gif" ) {
                $out_unidos .= '<div class="media-section video-overlay">
                                    <img src="'. tt( get_field('gif_image', get_the_ID()),296 ,400 , 1 ) .'" alt="">
                                    <span class="gificon" data-tag="GIF"></span>
                                </div>'; 
                }
                else if( get_field('image_or_slider', get_the_ID()) == "video" ) {
                $out_unidos .= '<div class="media-section">';
                $out_unidos .= get_field('unidos_post_video', get_the_ID());
                $out_unidos .= '</div>';
                }

            $last_child_category_ids = array();
            $parent_cat_array = array();
            $categories = get_the_category( $post->id );
            foreach($categories as $category_data){
                if($category_data->category_parent>0 && !in_array($category_data->term_id, $parent_cat_array)){
                    array_push($parent_cat_array, $category_data->category_parent);
                    $last_child_category_ids[] = $category_data->term_id;
                }
            }
            
            $out_unidos .= '<div class="post-txt-section">';
            if(!empty($last_child_category_ids) && count($last_child_category_ids)>0){
                for($k=0; $k<count($last_child_category_ids); $k++){
                    $catimg_src = category_image_src( array('term_id' => $last_child_category_ids[$k]) );
                    if(isset($catimg_src)){
                        $out_unidos .='<img class="posticon" src="'. tt($catimg_src, 23, 23, 1) .'">';
                    }
                }
            }
            //$out_unidos .='<img src="'. tt($catimg_src, 23, 23, 1) .'">';
            $out_unidos .= '<h2>'. substr( get_the_title($post->ID), 0, 35) .'</h2>';
                            if( has_excerpt(get_the_ID() )) {
            $out_unidos .= '<p>'. substr(get_the_excerpt($post->ID),0,290) .'</p>';
                            }
            $out_unidos .= '<div class="clearfix">
                                <a href="'. get_the_permalink($post->ID) .'" class="btn">'. ot_get_option( 'ver_mas_button_text' ) .'</a>';
                                $unidos_post_date = date_month_spanish( get_field('grupos_post_date',  get_the_ID()) );
                                $out_unidos .= '<span class="date">'. $unidos_post_date.'</span>
                            </div>
                        </div>
                    </div>';
        endwhile;
    endif;
    wp_reset_postdata();
    die($unidos_records_all_remaining."$$$$$".$out_unidos);
}

add_action('wp_ajax_nopriv_more_post_ajax_unidos_timeline', 'more_post_ajax_unidos_timeline');
add_action('wp_ajax_more_post_ajax_unidos_timeline', 'more_post_ajax_unidos_timeline');



add_filter('upload_mimes', 'custom_upload_mimes');

function custom_upload_mimes ( $existing_mimes=array() ) {

	// add the file extension to the array

	$existing_mimes['svg'] = 'mime/type';

        // call the modified list of extensions

	return $existing_mimes;

}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class($classes, $item){
     if( in_array('current-menu-item', $classes) ){
             $classes[] = 'active ';
     }
     return $classes;
}

/* Auto complete Search Module */

function search_function(){
    //print_r($_POST);exit;
    global $wpdb;
    if(isset($_POST['search_field']) && !empty($_POST['search_field']) ){
        $search_field_keyword = $_POST['search_field'];
    }
    if(isset($search_field_keyword))
    {
        $search_keyword = $search_field_keyword;
        
        $tax_query =  array(
                 'taxonomy' => 'category',
                 'field'    => 'slug',
              );
        $args = array(
            'post_type' => array('post','page'),
            'tax_query' => $tax_query,
            's' => $search_keyword,
            'post_status' => 'publish',
            'orderby'     => 'title', 
            'order'       => 'ASC'        
        );
        $search_wp_query = new WP_Query($args);
        $out_search = '';
        $hover_search_data = '';
        $no_data = '';
        if ($search_wp_query -> have_posts() > 0 ) {  
            $hover_search_data .= '<div class="search-block search-block2">';
            $out_search .= '<div class="search-block search-block1">'
                    . '<h4>Quizás quisiste decir: <a href="#">'.$search_keyword.'</a></h4><div class="data_adjust"><ul class="result-nav">';
            while ($search_wp_query -> have_posts()) : $search_wp_query -> the_post();
                //$out_search .= '<li><a id="'.get_the_ID().'"class="post-data" title="'.get_the_title().'" href="'.  get_the_permalink() .'">'.get_the_title().'</a></li>';
                $out_search .= '<li><a id="'.get_the_ID().'"class="post-data" title="'.get_the_title().'" href="javascript:void(0);">'.get_the_title().'</a></li>';
                
                $hover_search_data .='<div id="hover_data_'.get_the_ID().'" class="hover_post_detail" style="display: none;">
                                <p>Articulos relacionados de <a href="'.get_the_permalink().'">“'. get_the_title() .'”</a></p>
                                <div class="img-contianer">';
                                //print_r($_POST);
                                $feat_image = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
                                $hover_search_data .= '<img src="'.  tt($feat_image,120,120,1) .'" alt="RUTINAS">';
                                $hover_search_data .= '</div>
                                <p class="big">'. get_the_title() .'</p>
                                <a href="'.get_the_permalink().'" class="btn btn-green">ver más</a>
                            </div>';
            endwhile;
            $out_search .= '</ul></div></div>';
            $hover_search_data .= '</div>';
        }else{
            $no_data = '$$$$$nodata';
            $out_search .= '<div class="inner-block no-results"><p>LO SENTIMOS, NO ENCONTRAMOS RESULTADOS RELACIONADOS CON: <a href="#">'.$search_keyword.'</a></p></div>'; 	
        }
    }
    $response_string = $out_search.$hover_search_data.$no_data;
    die($response_string);
}

add_action('wp_ajax_nopriv_search_function', 'search_function');
add_action('wp_ajax_search_function', 'search_function');


/* Post Like System Start */
add_action( 'wp_enqueue_scripts', 'sl_enqueue_scripts' );
function sl_enqueue_scripts() {
	wp_enqueue_script( 'simple-likes-public-js', get_template_directory_uri() . '/js/simple-likes-public.js', array( 'jquery' ), '0.5', false );
	wp_localize_script( 'simple-likes-public-js', 'simpleLikes', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'like' => __( 'Like', 'YourThemeTextDomain' ),
		'unlike' => __( 'Unlike', 'YourThemeTextDomain' )
	) ); 
}
/**
 * Processes like/unlike
 * @since    0.5
 */
add_action( 'wp_ajax_nopriv_process_simple_like', 'process_simple_like' );
add_action( 'wp_ajax_process_simple_like', 'process_simple_like' );
function process_simple_like() {
	// Security
    //echo "<pre>";
    //print_r($_REQUEST);
	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
	if ( !wp_verify_nonce( $nonce, 'simple-likes-nonce' ) ) {
		exit( __( 'Not permitted', 'YourThemeTextDomain' ) );
	}
	// Test if javascript is disabled
	$disabled = ( isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] == true ) ? true : false;
	// Test if this is a comment
	$is_comment = ( isset( $_REQUEST['is_comment'] ) && $_REQUEST['is_comment'] == 1 ) ? 1 : 0;
	// Base variables
	$post_id = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';
	$result = array();
	$post_users = NULL;
	$like_count = 0;
	// Get plugin options
	if ( $post_id != '' ) {
		$count = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_comment_like_count", true ) : get_post_meta( $post_id, "_post_like_count", true ); // like count
		$count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
		if ( !already_liked( $post_id, $is_comment ) ) { // Like the post
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id();
				$post_users = post_user_likes( $user_id, $post_id, $is_comment );
				if ( $is_comment == 1 ) {
					// Update User & Comment
					$user_like_count = get_user_option( "_comment_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					update_user_option( $user_id, "_comment_like_count", ++$user_like_count );
					if ( $post_users ) {
						update_comment_meta( $post_id, "_user_comment_liked", $post_users );
					}
				} else {
					// Update User & Post
					$user_like_count = get_user_option( "_user_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					update_user_option( $user_id, "_user_like_count", ++$user_like_count );
					if ( $post_users ) {
						update_post_meta( $post_id, "_user_liked", $post_users );
					}
				}
			} else { // user is anonymous
                            //echo "sadsadasdasd";exit;
				$user_ip = sl_get_session();
				$post_users = post_ip_likes( $user_ip, $post_id, $is_comment );
				// Update Post
				if ( $post_users ) {
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_IP", $post_users );
					} else { 
						update_post_meta( $post_id, "_user_IP", $post_users );
					}
				}
			}
			$like_count = ++$count;
			$response['status'] = "liked";
			$response['icon'] = get_liked_icon();
                        //echo "<pre>";print_r($response);exit;
		} else { // Unlike the post
			if ( is_user_logged_in() ) { // user is logged in
				$user_id = get_current_user_id();
				$post_users = post_user_likes( $user_id, $post_id, $is_comment );
				// Update User
				if ( $is_comment == 1 ) {
					$user_like_count = get_user_option( "_comment_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					if ( $user_like_count > 0 ) {
						update_user_option( $user_id, "_comment_like_count", --$user_like_count );
					}
				} else {
					$user_like_count = get_user_option( "_user_like_count", $user_id );
					$user_like_count =  ( isset( $user_like_count ) && is_numeric( $user_like_count ) ) ? $user_like_count : 0;
					if ( $user_like_count > 0 ) {
						update_user_option( $user_id, '_user_like_count', --$user_like_count );
					}
				}
				// Update Post
				if ( $post_users ) {	
					$uid_key = array_search( $user_id, $post_users );
					unset( $post_users[$uid_key] );
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_liked", $post_users );
					} else { 
						update_post_meta( $post_id, "_user_liked", $post_users );
					}
				}
			} else { // user is anonymous
				$user_ip = sl_get_session();
				$post_users = post_ip_likes( $user_ip, $post_id, $is_comment );
				// Update Post
				if ( $post_users ) {
					$uip_key = array_search( $user_ip, $post_users );
					unset( $post_users[$uip_key] );
					if ( $is_comment == 1 ) {
						update_comment_meta( $post_id, "_user_comment_IP", $post_users );
					} else { 
						update_post_meta( $post_id, "_user_IP", $post_users );
					}
				}
			}
			$like_count = ( $count > 0 ) ? --$count : 0; // Prevent negative number
			$response['status'] = "unliked";
			$response['icon'] = get_unliked_icon();
		}
		if ( $is_comment == 1 ) {
			update_comment_meta( $post_id, "_comment_like_count", $like_count );
			update_comment_meta( $post_id, "_comment_like_modified", date( 'Y-m-d H:i:s' ) );
		} else { 
			update_post_meta( $post_id, "_post_like_count", $like_count );
			update_post_meta( $post_id, "_post_like_modified", date( 'Y-m-d H:i:s' ) );
		}
		$response['count'] = get_like_count( $like_count );
		$response['testing'] = $is_comment;
		if ( $disabled == true ) {
			if ( $is_comment == 1 ) {
				wp_redirect( get_permalink( get_the_ID() ) );
				exit();
			} else {
				wp_redirect( get_permalink( $post_id ) );
				exit();
			}
		} else {
			wp_send_json( $response );
		}
	}
}
/**
 * Utility to test if the post is already liked
 * @since    0.5
 */
function already_liked( $post_id, $is_comment ) {
	$post_users = NULL;
	$user_id = NULL;
	if ( is_user_logged_in() ) { // user is logged in
		$user_id = get_current_user_id();
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
		if ( count( $post_meta_users ) != 0 ) {
			$post_users = $post_meta_users[0];
		}
	} else { // user is anonymous
            //echo "asdfasddasddasdas";exit;
		$user_id = sl_get_session();
		$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" ); 
		if ( count( $post_meta_users ) != 0 ) { // meta exists, set up values
			$post_users = $post_meta_users[0];
		}
	}
	if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
		return true;
	} else {
		return false;
	}
} // already_liked()
/**
 * Output the like button
 * @since    0.5
 */
function get_simple_likes_button( $post_id, $is_comment = NULL ) {
	$is_comment = ( NULL == $is_comment ) ? 0 : 1;
	$output = '';
	$nonce = wp_create_nonce( 'simple-likes-nonce' ); // Security
	if ( $is_comment == 1 ) {
		$post_id_class = esc_attr( ' sl-comment-button-' . $post_id );
		$comment_class = esc_attr( ' sl-comment' );
		$like_count = get_comment_meta( $post_id, "_comment_like_count", true );
		$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
	} else {
		$post_id_class = esc_attr( ' sl-button-' . $post_id );
		$comment_class = esc_attr( '' );
		$like_count = get_post_meta( $post_id, "_post_like_count", true );
		$like_count = ( isset( $like_count ) && is_numeric( $like_count ) ) ? $like_count : 0;
	}
	$count = get_like_count( $like_count );
	$icon_empty = get_unliked_icon();
	$icon_full = get_liked_icon();
	// Loader
	$loader = '<span id="sl-loader"></span>';
	// Liked/Unliked Variables
	if ( already_liked( $post_id, $is_comment ) ) {
		$class = esc_attr( ' liked' );
		$title = __( 'Unlike', 'YourThemeTextDomain' );
		$icon = $icon_full;
	} else {
		$class = '';
		$title = __( 'Like', 'YourThemeTextDomain' );
		$icon = $icon_empty;
	}
        $tdc = get_the_category();
        $catid = $tdc[0]->term_id;
	$output = '<span class="sl-wrapper"><a href="' . admin_url( 'admin-ajax.php?action=process_simple_like' . '&post_id=' . $post_id . '&term_id=' . $catid . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true' ) . '" class="sl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '"data-term-id="' . $catid . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</span>';
	return $output;
} // get_simple_likes_button()
/**
 * Processes shortcode to manually add the button to posts
 * @since    0.5
 */
add_shortcode( 'postlike', 'sl_shortcode' );
function sl_shortcode() {
	return get_simple_likes_button( get_the_ID(), 0 );
} // shortcode()
/**
 * Utility retrieves post meta user likes (user id array), 
 * then adds new user id to retrieved array
 * @since    0.5
 */
function post_user_likes( $user_id, $post_id, $is_comment ) {
	$post_users = '';
	$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_liked" ) : get_post_meta( $post_id, "_user_liked" );
	if ( count( $post_meta_users ) != 0 ) {
		$post_users = $post_meta_users[0];
	}
	if ( !is_array( $post_users ) ) {
		$post_users = array();
	}
	if ( !in_array( $user_id, $post_users ) ) {
		$post_users['user-' . $user_id] = $user_id;
	}
	return $post_users;
} // post_user_likes()
/**
 * Utility retrieves post meta ip likes (ip array), 
 * then adds new ip to retrieved array
 * @since    0.5
 */
function post_ip_likes( $user_ip, $post_id, $is_comment ) {
	$post_users = '';
	$post_meta_users = ( $is_comment == 1 ) ? get_comment_meta( $post_id, "_user_comment_IP" ) : get_post_meta( $post_id, "_user_IP" );
	// Retrieve post information
	if ( count( $post_meta_users ) != 0 ) {
		$post_users = $post_meta_users[0];
	}
	if ( !is_array( $post_users ) ) {
		$post_users = array();
	}
	if ( !in_array( $user_ip, $post_users ) ) {
		$post_users[$user_ip] = $user_ip;
	}
	return $post_users;
} // post_ip_likes()
/**
 * Utility to retrieve IP address
 * @since    0.5
 */
function sl_get_session() {
        @session_start();
	$session_id = session_id();
        //echo "session ID : ". $session_id; exit;
	return $session_id;
} // sl_get_session()
/**
 * Utility returns the button icon for "like" action
 * @since    0.5
 */
function get_liked_icon() {
	/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart"></i> */
        $cuidad_categories = array(1,3,4,5,6,7,8,9); 
        $tienda_categories = array(11,12,13,14,19);
        $unidos_categories = array(21,22,23,24,25);
        $tdc = get_the_category();
        //echo $tdc[0]->term_id."---";
        //echo "<pre>";
        //print_r($tdc);
        //echo $tdc[0]->term_id;exit;
        //echo "<pre>";
        //print_r($_POST);
        if(null!=$_REQUEST['term_id']){
            $ajcatid = $_REQUEST['term_id'];
        }else{
            $ajcatid = $tdc[0]->term_id;
        }
        if( (in_array($ajcatid, $cuidad_categories)) ){
            //echo $tdc[0]->term_id;
            $icon = '<img src="'.get_stylesheet_directory_uri().'/img/heart_green-small.png">';
            //echo $tdc[0]->term_id."===".$icon."===";
        }
        else if((in_array($ajcatid, $tienda_categories))){
            $icon = '<img src="'.get_stylesheet_directory_uri().'/img/tinda_heart_green-small.png">';
        }
        else if((in_array($ajcatid, $unidos_categories))){
            $icon = '<img src="'.get_stylesheet_directory_uri().'/img/unidos_heart_green-small.png">';
        }
	return $icon;
} // get_liked_icon()
/**
 * Utility returns the button icon for "unlike" action
 * @since    0.5
 */
function get_unliked_icon() {
	/* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart-o"></i> */
        $cuidad_categories = array(1,3,4,5,6,7,8,9); 
        $tienda_categories = array(11,12,13,14,19);
        $unidos_categories = array(21,22,23,24,25);
        $tdc = get_the_category();
        if(null!=$_REQUEST['term_id']){
            $ajcatid = $_REQUEST['term_id'];
        }else{
            $ajcatid = $tdc[0]->term_id;
        }
	if( (in_array($ajcatid, $cuidad_categories)) ){
            //echo $tdc[0]->term_id;
            $icon = '<img src="'.get_stylesheet_directory_uri().'/img/heart-white-small.png">';
            //echo $tdc[0]->term_id."===".$icon."===";
        }
        else if((in_array($ajcatid, $tienda_categories))){
            $icon = '<img src="'.get_stylesheet_directory_uri().'/img/tinda_heart-white-small.png">';
        }
        else if((in_array($ajcatid, $unidos_categories))){
            $icon = '<img src="'.get_stylesheet_directory_uri().'/img/unidos_heart-white-small.png">';
        }
	return $icon;
} // get_unliked_icon()
/**
 * Utility function to format the button count,
 * appending "K" if one thousand or greater,
 * "M" if one million or greater,
 * and "B" if one billion or greater (unlikely).
 * $precision = how many decimal points to display (1.25K)
 * @since    0.5
 */
function sl_format_count( $number ) {
	$precision = 2;
	if ( $number >= 1000 && $number < 1000000 ) {
		$formatted = number_format( $number/1000, $precision ).'K';
	} else if ( $number >= 1000000 && $number < 1000000000 ) {
		$formatted = number_format( $number/1000000, $precision ).'M';
	} else if ( $number >= 1000000000 ) {
		$formatted = number_format( $number/1000000000, $precision ).'B';
	} else {
		$formatted = $number; // Number is less than 1000
	}
	$formatted = str_replace( '.00', '', $formatted );
	return $formatted;
} // sl_format_count()
/**
 * Utility retrieves count plus count options, 
 * returns appropriate format based on options
 * @since    0.5
 */
function get_like_count( $like_count ) {
	$like_text = __( 'Like', 'YourThemeTextDomain' );
	if ( is_numeric( $like_count ) && $like_count > 0 ) { 
		$number = sl_format_count( $like_count );
	} else {
		$number = $like_text;
	}
	$count = '<span class="counter">&nbsp;&nbsp;' . $number . '</span>';
	return $count;
} // get_like_count()
// User Profile List
add_action( 'show_user_profile', 'show_user_likes' );
add_action( 'edit_user_profile', 'show_user_likes' );
function show_user_likes( $user ) { ?>        
	<table class="form-table">
		<tr>
			<th><label for="user_likes"><?php _e( 'You Like:', 'YourThemeTextDomain' ); ?></label></th>
			<td>
			<?php
			$types = get_post_types( array( 'public' => true ) );
			$args = array(
			  'numberposts' => -1,
			  'post_type' => $types,
			  'meta_query' => array (
				array (
				  'key' => '_user_liked',
				  'value' => $user->ID,
				  'compare' => 'LIKE'
				)
			  ) );		
			$sep = '';
			$like_query = new WP_Query( $args );
			if ( $like_query->have_posts() ) : ?>
			<p>
			<?php while ( $like_query->have_posts() ) : $like_query->the_post(); 
			echo $sep; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
			<?php
			$sep = ' &middot; ';
			endwhile; 
			?>
			</p>
			<?php else : ?>
			<p><?php _e( 'You do not like anything yet.', 'YourThemeTextDomain' ); ?></p>
			<?php 
			endif; 
			wp_reset_postdata(); 
			?>
			</td>
		</tr>
	</table>
<?php } // show_user_likes()

/* Post Like System End */

/*add_action( 'wp_enqueue_scripts', 'star_enqueue_scripts' );
function star_enqueue_scripts() {
	wp_enqueue_script( 'rating-js', get_template_directory_uri() . '/js/rating.js', array( 'jquery' ), '0.5', false );
	wp_localize_script( 'rating-js', 'rating', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	) ); 
}*/

function star_rating(){
     
    global $wpdb;
    @session_start();
    $vote_session_id = session_id();
    //echo $_POST['post_id'];
    //print_r($_POST);exit;
    //exit;
    //echo $p_id;
    
    if(isset($_POST['post_id']) && !empty($_POST['post_id']) ){
        $postID = $_POST['post_id'];
        $ratingPoints = $_POST['vote_rate'];
        //Check the rating row with same post ID
        $prevRatingQuery = "SELECT * FROM wp_post_rating WHERE post_id = ".$postID." and session_id='".$vote_session_id."'";
        //echo $prevRatingQuery;exit;
        $prevRatingResult = $wpdb->get_results($prevRatingQuery);
        $totalRows_Break = count($prevRatingResult);
        if($totalRows_Break > 0){
            foreach( $prevRatingResult as $row ) {
            //echo "aasdasdasdasdasdasd";exit;
                //print_r($prevRatingRow);exit;
                $ratingPoints = $row['total_points'] + $ratingPoints;
               
            }
        }else{
            //Insert rating data into the database
            $query = "INSERT INTO wp_post_rating (post_id,session_id,total_points,created,modified) VALUES(".$postID.",'".$vote_session_id."','".$ratingPoints."','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')";
            $insert = $wpdb->query($query);
        }

        //Fetch rating deatails from database
        $query2 = "SELECT ROUND(sum(total_points)/count(post_id),1) as average_rating, count(post_id) as totalvotes FROM wp_post_rating WHERE post_id = ".$postID." AND status = 1";
        $result = $wpdb->get_results($query2);
        //print_r($result);exit;
        
            $avg_rating = round($result[0]->average_rating * 2) / 2;
            $totalvote = $result[0]->totalvotes;
            $response_string = $avg_rating.','.$totalvote;
            
            die($response_string);
    }
}
add_action('wp_ajax_nopriv_star_rating', 'star_rating');
add_action('wp_ajax_star_rating', 'star_rating');

/* Get page ID By slug */
function get_id_by_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
} 


/* Single Page Date For Post Details Page */
function innerpage_date($innercustom_date){
    
    $month_array = array(
    'January'   => 'ENERO',
    'February'  => 'FEBREEO',
    'March'     => 'MARZO',
    'April'     => 'ABRIL',
    'May'       => 'MAYO',
    'June'      => 'JUNIO',
    'July'      => 'JULIO',
    'August'    => 'AGOSTO',
    'September' => 'SEPTIEMBRE',
    'October'   => 'OCTUBURE',
    'November'  => 'NOVIEMBRE',
    'December'  => 'DICIEMBRE');
    
    $dateex = explode(' ', $innercustom_date);
    //print_r($dateex);
    $dateString = explode('/', $dateex[1]);
    /*print_r($dateString);
    $month = $month_array[$dateString[0]];
    $newdate = str_replace($dateString[0], $month, $innercustom_date);*/
    //$finaldate = $dateex[0]." DE ".$dateex[1]." DE ".$dateex[2];
    $month_title = $dateString[0];
	if(in_array($dateString[0], $month_array)){
		//$month = $month_array[$dateString[0]];
		$month_title = $month_array[$dateString[0]];
	}
    $newdate = str_replace($dateString[0], $month_title, $innercustom_date);
    $datechanged = explode(' ',$newdate);
    $finaldate = $datechanged[0]. ' DE ' .$datechanged[1].' DE '.$datechanged[2]; 
    //echo $finaldate;
    return $finaldate;
    
}
/* Wordpress Default Filter start */

function my_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/logo_color.png);
            background-size: auto; background-position: center; height: 85px; width: 100%;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function loginpage_custom_link() {
	return home_url();
}
add_filter('login_headerurl','loginpage_custom_link');

function remove_wordpress_org_link() {
    global $wp_admin_bar;
         $wp_admin_bar->remove_menu('wp-logo');
}

add_action( 'wp_before_admin_bar_render', 'remove_wordpress_org_link' );

add_action( 'admin_init', 'remove_update_page' );
function remove_update_page() {
    remove_submenu_page( 'index.php', 'update-core.php' );
}

function hide_help() {
    echo '<style type="text/css">
           #contextual-help-link-wrap { display: none !important; }
         </style>';
}
add_action('admin_head', 'hide_help');

/* Wordpress Default Filter End */  
