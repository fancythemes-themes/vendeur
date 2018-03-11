<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * 
 * @package Vendeur
 * @since Vendeur 1.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-shop' )  ) : ?>
	<aside id="secondary" class="sidebar widget-area">
		<?php dynamic_sidebar( 'sidebar-shop' ); ?>
	</aside><!-- .sidebar .widget-area -->
<?php endif; ?>
