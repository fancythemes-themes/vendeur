<?php
/**
 * Vendeur WooCommerce setups
 *
 * Set up the compatibility with Woocommerce plugin
 *
 * @package Vendeur
 * @since Vendeur 1.0
 */

/*
 * Setup the woocommerce functions
 *
 */
function vendeur_wc_setup() {

	add_filter('woocommerce_breadcrumb_defaults', 'vendeur_wc_breadcrumb_defaults', 10, 1);

	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
	if ( is_singular() ) {
		add_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 5, 0);
	}

	add_theme_support( 'woocommerce' );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );	

}
add_action( 'after_setup_theme', 'vendeur_wc_setup' );

/*
 * Setup the woocommerce functions
 *
 */
function vendeur_wc_scripts() {
	wp_dequeue_style('woocommerce-general');
	wp_dequeue_style('woocommerce-layout');
	// This theme woocommerce stylesheet.
	wp_enqueue_style( 'vendeur-woocommerce-general', get_stylesheet_directory_uri() . '/css/woocommerce.css' );
}
add_action( 'wp_enqueue_scripts', 'vendeur_wc_scripts' );

/**
 * Change the wrapper and delimiter for woocommerce breadcrumbs
 *
 */
function vendeur_wc_breadcrumb_defaults() {
	$args = array(
		'delimiter'   => vendeur_svg_icon('pointer'),
		'wrap_before' => '<nav class="site-breadcrumbs woocommerce-breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	);

	return $args;
}


/**
 * Products widget.
 *
 */
require get_template_directory() . '/inc/widgets/products.php';

/**
 * Product categories widget.
 *
 */
require get_template_directory() . '/inc/widgets/product-categories.php';
	