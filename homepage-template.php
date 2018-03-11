<?php
/**
 * The template for displaying homepages
 *
 * This is the template that full width homepage.
 * Populate Homepage sidebar area to show in this page
 *
 * Template Name: Homepage
 * 
 * @package Vendeur
 * @since Vendeur 1.0
 */

get_header(); ?>

	<?php vendeur_breadcrumbs(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main">
			<?php if ( is_active_sidebar( 'homepage-full-width' )  ) : ?>
				<div id="homepage-content" class="widget-area widget-area-full">
					<?php dynamic_sidebar( 'homepage-full-width' ); ?>
				</aside><!-- .sidebar .widget-area -->
			<?php endif; ?>
		</main><!-- .site-main -->


	</div><!-- .content-area -->

<?php get_footer(); ?>
