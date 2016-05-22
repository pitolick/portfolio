<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses onesie_pro_header_style()
 * @uses onesie_pro_admin_header_style()
 * @uses onesie_pro_admin_header_image()
 *
 */
function onesie_pro_custom_header_setup() {
    $hargs = array(
        'default-text-color'        => '111',
        'default-image'             => '', // %s is the theme folder
        'width'                     => 1050,
        'height'                    => 500,
        'flex-height'               => true,
        'admin-head-callback'       => 'onesie_pro_admin_header_style',
        'admin-preview-callback'    => 'onesie_pro_admin_header_image',
        'wp-head-callback'          => 'onesie_pro_header_style'
    );

    $hargs = apply_filters( 'onesie_pro_custom_header_args', $hargs );

    add_theme_support( 'custom-header', $hargs );

    register_default_headers( array(
        'wheel' => array(
            'url' => '%s/images/header.jpg',
            'thumbnail_url' => '%s/images/header-thumb.jpg',
            'description' => __( 'New York', 'onesie_pro' )
        )
    ) );

}
add_action( 'after_setup_theme', 'onesie_pro_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

if ( ! function_exists( 'get_custom_header' ) ) {
    function get_custom_header() {
        return ( object ) array(
            'url'           => get_header_image(),
            'thumbnail_url' => get_header_image(),
            'width'         => HEADER_IMAGE_WIDTH,
            'height'        => HEADER_IMAGE_HEIGHT,
        );
    }
}


if ( ! function_exists( 'onesie_pro_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see onesie_pro_custom_header_setup().
 *
 * @since Onesie Pro 1.0
 */
function onesie_pro_admin_header_style() {
?>
    <style type="text/css">
    .appearance_page_custom-header #headimg {
        border: none;
    }
    #headimg #site-title, #headimg #desc {
        font-family: "Oswald", "Helvetica Neue", Helvetica, sans-serif;
    }
    #headimg img {
        border: none;
    }
    #headimg hgroup {
        width: 200px;
    }
    #headimg img.site-logo {
        max-width: 100%;
        height: auto;
        margin: .5em 0 0;
    }
    #headimg #site-title {
        font-size: 30px;
        font-weight: 700;
        line-height: 1.5; /* 48px */
        margin: .5em 0 .25em;
        text-transform: uppercase;
        word-wrap: break-word;
    }
    #headimg #site-title a {
        text-decoration: none;
    }
    #headimg #desc {
        font-size: 18px;
        font-weight: 300;
        line-height: 1.5em;
        margin: 0 0 1em;
        word-wrap: break-word;
    }
    </style>
<?php
}
endif; // onesie_pro_admin_header_style

if ( ! function_exists( 'onesie_pro_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see onesie_pro_custom_header_setup().
 *
 * @since Onesie Pro 1.0
 */
function onesie_pro_admin_header_image() { ?>
    <?php $options = get_option( gpp_get_current_theme_id() . '_options' ); ?>
    <div id="headimg">
        <?php
        if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
            $style = ' style="display:none;"';
        else
            $style = ' style="color:#' . get_header_textcolor() . ';"';
        ?>
        <?php $header_image = get_header_image();
        if ( ! empty( $header_image ) ) : ?>
            <img src="<?php echo esc_url( $header_image ); ?>" alt="" />
        <?php endif; ?>
        <hgroup>
            <?php if ( ! empty( $options['logo'] ) ) { ?>
                    <img class="site-logo" src="<?php echo esc_url( $options['logo'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
            <?php } ?>
            <h1 id="site-title"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
            <h2 id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
        </hgroup>
    </div>
<?php }
endif; // onesie_pro_admin_header_image


if ( ! function_exists( 'onesie_pro_header_style' ) ) :

function onesie_pro_header_style() {
    $text_color = get_header_textcolor();

    // If no custom options for text are set, let's bail.
    if ( $text_color == HEADER_TEXTCOLOR )
        return;

    // If we get this far, we have custom styles. Let's do this.
    ?>
    <style type="text/css">
    <?php
        // Has the text been hidden?
        if ( 'blank' == $text_color ) :
    ?>
        #site-title,
        #site-description {
            position: absolute !important;
            clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
            clip: rect(1px, 1px, 1px, 1px);
        }
    <?php
        // If the user has set a custom color for the text use that
        else :
    ?>
        #site-title a,
        #site-description {
            color: #<?php echo $text_color; ?> !important;
        }
    <?php endif; ?>
    </style>
    <?php
}
endif; // onesie_pro_header_style