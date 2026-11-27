<?php
/**
 * WordPress's emoji support removed: the detection script, its styles and the swap of emoji for
 * pictures in feeds and email.
 *
 * Every current browser shows emoji itself. The detection script starts a worker from a blob:
 * address, which this plugin's Content-Security-Policy refuses; where it decides a browser needs
 * help, it loads emoji pictures from WordPress.org's servers, which sends visitors' addresses
 * there. Feeds and email swap emoji for the same pictures. The hooks are WordPress 7.1's own
 * (wp-includes/default-filters.php, wp-admin/includes/admin-filters.php).
 *
 * @package site-hardening
 */

defined( 'ABSPATH' ) || exit;

/**
 * Removes the emoji detection script and its styles from visitor pages and embeds, and the
 * picture swaps from feeds and email. WordPress adds these hooks before the plugins load, so they
 * can be removed at init.
 */
function sitehardening_remove_emoji_support(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'embed_head', 'print_emoji_detection_script' );

	remove_action( 'wp_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	remove_action( 'enqueue_embed_scripts', 'wp_enqueue_emoji_styles' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}
add_action( 'init', 'sitehardening_remove_emoji_support' );

/**
 * Removes the emoji detection script and its styles from the admin. WordPress adds these hooks
 * only when it loads its admin code (wp-admin/admin.php), after init has run, so removing them at
 * init would come too early and do nothing; admin_init runs after that code is loaded and before
 * an admin page's head is printed.
 */
function sitehardening_remove_admin_emoji_support(): void {
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_enqueue_scripts', 'wp_enqueue_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
}
add_action( 'admin_init', 'sitehardening_remove_admin_emoji_support' );
