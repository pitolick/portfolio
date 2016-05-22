<?php
/**
 * Onesie Pro functions and definitions
 *
 * @package Onesie Pro
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 1280; /* pixels */
}

if ( ! function_exists( 'onesie_pro_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function onesie_pro_setup() {

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'onesie_pro' ),
    ) );

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Onesie Pro, use a find and replace
     * to change 'onesie_pro' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'onesie_pro', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Setup the WordPress core custom background feature.
    add_theme_support( 'custom-background', apply_filters( 'onesie_pro_custom_background_args', array(
        'default-color' => '000000',
        'default-image' => get_template_directory_uri() . '/images/background.jpg',
    ) ) );

    add_editor_style();
    add_theme_support( 'post-thumbnails' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /**
     * Enable support for Sell Media
     */
    if ( class_exists( 'SellMedia' ) ) {
        add_theme_support( 'sell_media' );
    }

    // updating thumbnail and image sizes
    update_option( 'thumbnail_size_w', 110, true );
    update_option( 'thumbnail_size_h', 110, true );
    update_option( 'medium_size_w', 600, true );
    update_option( 'medium_size_h', '', true );
    update_option( 'large_size_w', 1280, true );
    update_option( 'large_size_h', '', true );

    add_image_size( 'horizontal', 420, 300, true ); // horizontal images
    add_image_size( 'square', 520, 520, true ); // square images
    add_image_size( 'vertical', 520, 600, true ); // vertical images
    add_image_size( 'sell_media_item', 520, 520, true ); // sell media images
}
endif; // onesie_pro_setup
add_action( 'after_setup_theme', 'onesie_pro_setup' );

/**
 * This function loads all the files and features
 *
 * @since 1.0
 */
function onesie_pro_load_files() {

    require_once( get_template_directory() . '/inc/postnav.php' );
    require_once( get_template_directory() . '/inc/posts.php' );
    require_once( get_template_directory() . '/inc/widgets.php' );
    require_once( get_template_directory() . '/inc/custom-header.php' );
    require_once( get_template_directory() . '/inc/custom-post-types.php' );
    require_once( get_template_directory() . '/inc/custom-taxonomies.php' );
    require_once( get_template_directory() . '/inc/custom-post-meta.php' );

}
add_action( 'onesie_pro_init', 'onesie_pro_load_files' );

/**
 * Run the onesie_pro_init hook
 */
do_action( 'onesie_pro_init' );

/**
 * Enqueue scripts and styles.
 */
function onesie_pro_scripts() {

    wp_enqueue_style( 'onesie-pro-bootstrap', get_template_directory_uri() . '/css/bootstrap.css', '', onesie_pro_get_theme_version() );
    wp_enqueue_style( 'onesie-pro-genericons', get_template_directory_uri() . '/css/genericons/genericons.css', '', onesie_pro_get_theme_version(), 'all' );
    wp_enqueue_style( 'onesie-pro-style', get_stylesheet_uri() );
    wp_enqueue_style( 'onesie-pro-magnific-popup-style', get_template_directory_uri() . '/css/magnific-popup.css', array( 'onesie-pro-style' ), onesie_pro_get_theme_version(), 'all' );
    wp_enqueue_style( 'onesie-pro-flexslider-style', get_template_directory_uri() . '/js/flexslider/flexslider.css', array( 'onesie-pro-style' ), onesie_pro_get_theme_version() );

    wp_enqueue_script( 'onesie-pro-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), onesie_pro_get_theme_version(), true );
    wp_enqueue_script( 'onesie-pro-scripts', get_template_directory_uri() . '/js/onesie-pro.js', array( 'jquery', 'onesie-pro-magnific-popup' ), onesie_pro_get_theme_version(), true );
    wp_enqueue_script( 'onesie-pro-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), onesie_pro_get_theme_version(), true );
    wp_enqueue_script( 'onesie-pro-navigation', get_template_directory_uri() . '/js/navigation.js', array(), onesie_pro_get_theme_version(), true );
    wp_enqueue_script( 'onesie-pro-flexslider', get_template_directory_uri() . '/js/flexslider/jquery.flexslider-min.js', array( 'jquery' ), onesie_pro_get_theme_version() );
    wp_enqueue_script( 'onesie-pro-flex', get_template_directory_uri() . '/js/flexslider/flexslider.js', array( 'jquery' ), onesie_pro_get_theme_version() );
    wp_enqueue_script( 'onesie-pro-sharrre', get_template_directory_uri() . '/js/jquery.sharrre-1.3.4.min.js', array( 'jquery' ), onesie_pro_get_theme_version() );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // AJAX url variable
    wp_localize_script( 'onesie-pro-scripts', 'onesie_pro',
        array(
            'ajaxurl'=>admin_url('admin-ajax.php'),
            'ajaxnonce' => wp_create_nonce('ajax-nonce')
            )
        );

    // Alt CSS Styles
    $options = get_option( gpp_get_current_theme_id() . '_options' );
    if ( isset ( $options['color'] ) && '' != $options['color'] ) {
        $style = get_template_directory_uri() . '/css/' . $options['color'] . '.css';
    } else {
        $style = get_template_directory_uri() . '/css/dark.css';
    }
    wp_enqueue_style( 'gpp-alt-style', $style, array( 'onesie-pro-style' ), onesie_pro_get_theme_version(), 'all' );
		
		// カスタマイズ用CSS追加
    wp_enqueue_style( 'onesie-pro-custom', get_template_directory_uri() . '/css/custom.css', '', onesie_pro_get_theme_version(), 'all' );

}
add_action( 'wp_enqueue_scripts', 'onesie_pro_scripts' );

/**
 * Flush your rewrite rules for custom post type and taxonomies added in theme
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */
function onesie_pro_flush_rewrite_rules() {
    global $pagenow, $wp_rewrite;

    if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) )
        $wp_rewrite->flush_rules();
}
add_action( 'load-themes.php', 'onesie_pro_flush_rewrite_rules' );


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Sell Media integration file.
 */
require get_template_directory() . '/inc/sell-media.php';

/**
 * Load theme options
 */
require get_template_directory() . '/options/options.php';

/**
 * Load theme options
 */
require get_template_directory() . '/theme-options.php';

/**
 * Register Widgets
 */
require_once ( get_template_directory() . '/inc/widgets/sell-media-share.php'); // share media widget
require_once ( get_template_directory() . '/inc/widgets/sell-media-exif.php'); // exif widget


/**
 * phpファイルをインクルードするショートコードを追加
 */
function Include_my_php($params = array()) {
    extract(shortcode_atts(array(
        'file' => 'default'
    ), $params));
    ob_start();
    include(get_theme_root() . '/' . get_template() . "/$file.php");
    return ob_get_clean();
}  

add_shortcode('myphp', 'Include_my_php');


/**
 * 閲覧者用ログインアカウント設定
 */

// 購読者の場合は管理画面にアクセスできないようにする
if(current_user_can('subscriber')){
	add_action( 'admin_init', 'redirect_dashiboard' );
}
function redirect_dashiboard() {

	if(strpos($_SERVER['SCRIPT_NAME'], 'wp-admin') !==false ){
		wp_redirect( home_url() );
		exit();
	}
}

// ツールバーの非表示
if(current_user_can('subscriber')){
	add_action( 'after_setup_theme', 'subscriber_hide_toolbar' );
}
function subscriber_hide_toolbar() {
	show_admin_bar( false );
}


/**
 * ショートコード追加
 */

add_shortcode("hide","hide_shortcode"); 
function hide_shortcode($x,$text=null){
    if(!is_user_logged_in()){ 
        return ""; 
    }else{ 
        return do_shortcode($text); 
    } 
} 

/* [hide]ここに、ログインユーザーにのみ見せるコンテンツを書く[/hide] 
　　非ログインユーザーには設定したテキストを表示する */

/*相対パスショートコード設定*/
add_shortcode( 'tp', 'shortcode_tp' );
function shortcode_tp( $atts, $content = '' ) {
	return get_template_directory_uri().$content;
}// get_template_directory_uri()

add_shortcode( 'ctp', 'shortcode_ctp' );
function shortcode_ctp( $atts, $content = '' ) {
	return get_stylesheet_directory_uri().$content;
}// get_stylesheet_directory_uri()

add_shortcode( 'alink', 'shortcode_alink' );
function shortcode_alink( $atts, $alink = '' ) {
	return home_url().$alink;
}


/**
 * 年齢計算
 */
function age() {
	$now = date("Ymd"); 
	$birth = "19911230"; 
	return floor(($now-$birth)/10000);
}
add_shortcode('age', 'age');
