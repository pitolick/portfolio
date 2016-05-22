<?php
/**
 * Define the Tabs appearing on the Theme Options page
 * Tabs contains sections
 * Options are assigned to both Tabs and Sections
 * See README.md for a full list of option types
 */

$general_settings_tab = array(
    "name" => "general_tab",
    "title" => __( "General", "gpp" ),
    "sections" => array(
        "general_section_1" => array(
            "name" => "general_section_1",
            "title" => __( "General", "gpp" ),
            "description" => __( "General Settings", "gpp" )
        )
    )
);

gpp_register_theme_option_tab( $general_settings_tab );

$colors_tab = array(
    "name" => "colors_tab",
    "title" => __( "Colors", "gpp" ),
    "sections" => array(
        "colors_section_1" => array(
            "name" => "colors_section_1",
            "title" => __( "Colors", "gpp" ),
            "description" => __( "Colors Settings", "gpp" )
        )
    )
);

gpp_register_theme_option_tab( $colors_tab );


// Default order of the sections in the particular tab
$block_order = explode( ",", '1,2,3,4,5');
$block_array = array(

    1 => array(
        "order" => "1",
        "title" => "Portfolio",
        "icon" => "grid"
        ),
    2 => array(
        "order" => "2",
        "title" => "About",
        "icon" => "text"
        ),
    3 => array(
        "order" => "3",
        "title" => "Contact",
        "icon" => "text"
        ),
    4 => array(
        "order" => "4",
        "title" => "Blog",
        "icon" => "gridh"
        ),
    5 => array(
        "order" => "5",
        "title" => "Sell Media",
        "icon" => "grid"
        )
);

// Get the order from the database
$theme_options = get_option( gpp_get_current_theme_id() . "_options" );
if ( ! empty( $theme_options['section_order'] ) ) {
    $block_order =  explode( ",", $theme_options['section_order'] );
}

/**
 * Home page tab
 */
$section_array = array(
	"homepage_section_0" => array(
		"name" => "homepage_section_0",
		"title" => __( "Sortable Sections", "gpp" ),
		"description" => ""
		)
		);

// Arrange the sections according to saved order
foreach ( $block_order as $value ) {

    $section_array[ "homepage_section_" . ( $value ) ] = array(
        "name" => "homepage_section_" . ( $block_array[$value]['order'] ),
        "title" => $block_array[$value]['title'],
        "description" => "",
        "icon" => $block_array[$value]['icon']
    );
}

$homepage_tab = array(
    "name" => "homepage_tab",
    "title" => __( "Homepage", "gpp" ),
    "sections" => $section_array
);

gpp_register_theme_option_tab( $homepage_tab );


 /**
 * The following example shows you how to register theme options and assign them to tabs and sections:
*/
$options = array(
    'logo' => array(
        "tab" => "general_tab",
        "name" => "logo",
        "title" => __( "Logo", "gpp" ),
        "description" => __( "Use a transparent png or jpg image", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "image",
        "default" => ""
    ),
    'favicon' => array(
        "tab" => "general_tab",
        "name" => "favicon",
        "title" => __( "Favicon", "gpp" ),
        "description" => __( "Use a transparent png or ico image", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "image",
        "default" => ""
    ),
    'font' => array(
        "tab" => "general_tab",
        "name" => "font",
        "title" => __( "Headline Font", "gpp" ),
        "description" => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=header&height=600&width=640" class="thickbox">Preview and choose a font</a>', "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "select",
        "default" => "Oswald:400,300,700italic",
        "valid_options" => gpp_font_array()
    ),
    'font_alt' => array(
        "tab" => "general_tab",
        "name" => "font_alt",
        "title" => __( "Body Font", "gpp" ),
        "description" => __( '<a href="' . get_option('siteurl') . '/wp-admin/admin-ajax.php?action=fonts&font=body&height=600&width=640" class="thickbox">Preview and choose a font</a>', "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "select",
        "default" => "Raleway:400,200,300,100",
        "valid_options" => gpp_font_array()
    ),
    'message' => array(
        "tab" => "general_tab",
        "name" => "message",
        "title" => __( "Message", "gpp" ),
        "description" => __( "Add a welcome message below your site title.", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "textarea",
        "sanitize" => "html",
        "default" => ""
    ),
    'button_link' => array(
        "tab" => "general_tab",
        "name" => "button_link",
        "title" => __( "Button Link", "gpp" ),
        "description" => __( "The url where your button links to.", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "text",
        "sanitize" => "nohtml",
        "default" => site_url()
    ),
    'button_text' => array(
        "tab" => "general_tab",
        "name" => "button_text",
        "title" => __( "Button Text", "gpp" ),
        "description" => __( "The text appearing on your button.", "gpp" ),
        "section" => "general_section_1",
        "since" => "1.0",
        "id" => "general_section_1",
        "type" => "text",
        "sanitize" => "nohtml",
        "default" => ""
    ),

	"onesie_pro_orientation" => array(
	    "tab" => "general_tab",
	    "name" => "onesie_pro_orientation",
	    "title" => "Thumbnail Orientation",
	    "description" => __( "Select an image orientation layout.", "gpp" ),
	    "section" => "general_section_1",
	    "since" => "1.0",
	    "id" => "general_section_1",
	    "type" => "select",
	    "default" => "horizontal",
		"valid_options" => array(
	        "horizontal" => array(
	            "name" => "horizontal",
	            "title" => __( "Horizontal", "gpp" )
	        ),
	        "square" => array(
	            "name" => "square",
	            "title" => __( "Square", "gpp" )
	        ),
			"vertical" => array(
	            "name" => "vertical",
	            "title" => __( "Vertical", "gpp" )
	        )
	   )
	),

    'section_order' => array(
            "tab" => "homepage_tab",
            "name" => "section_order",
            "title" => __( "section order setting", "gpp" ),
            "description" => __( 'Stores the order of the sections', "gpp" ),
            "section" => "homepage_section_0",
            "since" => "1.0",
            "id" => "homepage_section_0",
            "type" => "hidden",
            "default" => "1,2,3,4,5",
            "sanitize" => "html"
        ),

	"portfolio_section" => array(
	    "tab" => "homepage_tab",
	    "name" => "portfolio_section",
	    "title" => __( "Portfolio", "gpp" ),
	    "description" => __( "Show Portfolio posts on homepage", "gpp" ),
	    "section" => "homepage_section_1",
	    "since" => "1.0",
	    "id" => "homepage_section_1",
	    "type" => "select",
		"default" => "yes",
		"valid_options" => array(
			"yes" => array(
				"name" => "yes",
				"title" => __( "yes", "gpp" )
		        ),
			"no" => array(
				"name" => "no",
				"title" => __( "no", "gpp" )
		        )
		    )
	),

	"blog_cat" => array(
	    "tab" => "homepage_tab",
	    "name" => "blog_cat",
	    "title" => __( "Blog", "gpp" ),
	    "description" => __( "Select Blog Category", "gpp" ),
	    "section" => "homepage_section_4",
	    "since" => "1.0",
	    "id" => "homepage_section_4",
	    "type" => "select",
	    "default" => "",
	    "valid_options" => gpp_get_taxonomy_list( 'category', true )
	),

    "about" => array(
        "tab" => "homepage_tab",
        "name" => "about",
        "title" => __( "About", "gpp" ),
        "description" => __( "Select the About page template", "gpp" ),
        "section" => "homepage_section_2",
        "since" => "1.0",
        "id" => "homepage_section_2",
        "type" => "select",
        "sanitize" => "nohtml",
        "default" => "",
		"valid_options" => onesie_pro_get_pages()
    ),
    'contact' => array(
        "tab" => "homepage_tab",
        "name" => "contact",
        "title" => __( "Contact", "gpp" ),
        "description" => __( "Select Contact page template", "gpp" ),
        "section" => "homepage_section_3",
        "since" => "1.0",
        "id" => "homepage_section_3",
        "type" => "select",
        "sanitize" => "nohtml",
        "default" => "",
		"valid_options" => onesie_pro_get_pages()
    ),

	'sellmedia_section' => array(
        "tab" => "homepage_tab",
        "name" => "sellmedia_section",
        "title" => __( "Sell Media", "gpp" ),
        "description" => __( "Show Sell Media items on homepage", "gpp" ),
        "section" => "homepage_section_5",
        "since" => "1.0",
        "id" => "homepage_section_5",
        "type" => "select",
        "default" => "yes",
        "valid_options" => array(
            "yes" => array(
                "name" => "yes",
                "title" => __( "yes", "gpp" )
            ),
            "no" => array(
                "name" => "no",
                "title" => __( "no", "gpp" )
            )
        )
    ),
    'sellmedia_orderby' => array(
        "tab" => "homepage_tab",
        "name" => "sellmedia_orderby",
        "title" => __( "Items Order By", "gpp" ),
        "description" => __( "Choose the order-by of items", "gpp" ),
        "section" => "homepage_section_5",
        "since" => "1.0",
        "id" => "homepage_section_5",
        "type" => "select",
        "default" => "title",
        "valid_options" => array(
            "title" => array(
                "name" => "title",
                "title" => __( "Title", "gpp" )
            ),
            "date" => array(
                "name" => "date",
                "title" => __( "Date", "gpp" )
            ),
            "ID" => array(
                "name" => "ID",
                "title" => __( "ID", "gpp" )
            )
        )
    ),
    'sellmedia_order' => array(
	    "tab" => "homepage_tab",
	    "name" => "sellmedia_order",
	    "title" => __( "Items Order", "gpp" ),
	    "description" => __( "Choose the order of items", "gpp" ),
	    "section" => "homepage_section_5",
	    "since" => "1.0",
	    "id" => "homepage_section_5",
	    "type" => "select",
	    "default" => "asc",
	    "valid_options" => array(
	        "asc" => array(
	            "name" => "asc",
	            "title" => __( "ASC", "gpp" )
	        ),
	        "desc" => array(
	            "name" => "desc",
	            "title" => __( "DESC", "gpp" )
	        )
	    )
	),

    'color' => array(
        "tab" => "colors_tab",
        "name" => "color",
        "title" => __( "Color", "gpp" ),
        "description" => __( "Select a color palette", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "select",
        "default" => "dark",
        "valid_options" => array(
            "light" => array(
                "name" => "light",
                "title" => __( "Light", "gpp" )
            ),
            "dark" => array(
                "name" => "dark",
                "title" => __( "Dark", "gpp" )
            )
        )
    ),
    "css" => array(
        "tab" => "colors_tab",
        "name" => "css",
        "title" => __( "Custom CSS", "gpp" ),
        "description" => __( "Add some custom CSS to your theme.", "gpp" ),
        "section" => "colors_section_1",
        "since" => "1.0",
        "id" => "colors_section_1",
        "type" => "textarea",
        "sanitize" => "html",
        "default" => ""
    )
);

gpp_register_theme_options( $options );

?>