<?php

/**
 * Custom Post Meta
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */

/**
 * Create the meta box section, title and assign a callback function
 */
function onesie_pro_project_meta_box( $post_type ) {
    add_meta_box(
                'product_meta_box',
                __('Project Details','onesie_pro'),
                'onesie_pro_project_meta_box_html',
                'portfolio'
            );
}
add_action( 'add_meta_boxes', 'onesie_pro_project_meta_box' );

/**
 * Show our Project Details meta section
 */
function onesie_pro_project_meta_box_html( $fields=null ) {
    global $post; ?>
        <table>
            <tr>
                <td><label><?php _e('Year &amp; time','onesie_pro'); ?></label></td>
                <td><input type="text" name="_onesie_pro_portfolio_year" class="regular-text" id="_onesie_pro_portfolio_year" value="<?php echo esc_attr( get_post_meta( $post->ID, '_onesie_pro_portfolio_year', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e('Client','onesie_pro'); ?></label></td>
                <td><input type="text" name="_onesie_pro_portfolio_client" class="regular-text" id="_onesie_pro_portfolio_client" value="<?php echo esc_attr( get_post_meta( $post->ID, '_onesie_pro_portfolio_client', true ) ); ?>" /></p></td>
            </tr>
            <tr>
                <td><label><?php _e('URL','onesie_pro'); ?></label></td>
                <td><input type="text" name="_onesie_pro_portfolio_url" class="regular-text" id="_onesie_pro_portfolio_url" value="<?php echo esc_attr( get_post_meta( $post->ID, '_onesie_pro_portfolio_url', true ) ); ?>" /></p></td>
            </tr>
        </table>
    <?php
}

/**
 * Save meta fields when post is updated
 */
function onesie_pro_save_portfolio_custom_meta( $post_id ) {

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return $post_id;
    }

    $fields = array(
        // Portfolio posts meta
        '_onesie_pro_portfolio_year',
        '_onesie_pro_portfolio_client',
        '_onesie_pro_portfolio_technology',
        '_onesie_pro_portfolio_url',

        // Team posts meta
        '_onesie_pro_team_position',
        '_onesie_pro_team_facebook',
        '_onesie_pro_team_twitter',
        '_onesie_pro_team_github',
        );

    foreach( $fields as $field ){
        if ( isset( $_POST[ $field ] ) ){
            // For URLs we esc_url them, other wise we use esc_html
            if ( $field == '_onesie_pro_portfolio_url' ){
                update_post_meta( $post_id, '_onesie_pro_portfolio_url', esc_url( $_POST['_onesie_pro_portfolio_url'] ) );
            } else {
                update_post_meta( $post_id, $field, esc_html( $_POST[ $field ] ) );
            }
        }
    }
}
add_action('save_post', 'onesie_pro_save_portfolio_custom_meta');
?>