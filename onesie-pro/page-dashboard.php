<?php
/*
 Template Name: Dashboard
 *
 * @package Onesie Pro
 * @since Onesie Pro 1.0
 */


get_header(); ?>

<div id="primary" class="content-area account-template">
    <div id="content" class="site-content" role="main">

        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header><!-- .entry-header -->

        <?php if ( current_theme_supports( 'sell_media' ) ) : ?>

            <?php if ( is_user_logged_in() ) : ?>
                <div id="customer-info">
                    <h3><?php _e('Your Information: ', 'onesie_pro'); ?><?php wp_get_current_user(); echo $current_user->user_firstname; ?> <?php echo $current_user->user_lastname; ?></h3>

                    <ul class="customer-details">
                        <?php
                        echo '<li>' . __('Username: ', 'onesie_pro') . $current_user->user_login . '</li>';
                        echo '<li>' . __('Email: ', 'onesie_pro') . $current_user->user_email . '</li>';
                        echo '<li>' . __('First Name: ', 'onesie_pro') . $current_user->user_firstname . '</li>';
                        echo '<li>' . __('Last Name: ', 'onesie_pro') . $current_user->user_lastname . '</li>';
                        ?>
                    </ul>
                </div><!-- #customer-info -->

                <div id="purchase-history">
                    <h3><?php _e('Purchase History: ', 'onesie_pro'); ?></h3>
                    <?php echo do_shortcode('[sell_media_download_list]'); ?>
                </div><!-- #purchase-history -->

                <?php else : ?>
                    <p><?php _e( 'You must be logged into the view this page.', 'onesie_pro' ); ?></p>
                    <?php wp_login_form(); ?>
                    <p><a href="<?php echo site_url( 'wp-login.php?action=lostpassword' ); ?>"><?php _e( 'Lost your password?', 'onesie_pro' ); ?></a></p>
                <?php endif; ?>
                <?php edit_post_link( __( 'Edit', 'onesie_pro' ), '<p class="edit-link">', '</p>' ); ?>
        <?php else : ?>
                <?php _e('Please activate Sell Media plugin to use this page.', 'onesie_pro'); ?>
        <?php endif; ?>
    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->
<?php get_footer(); ?>