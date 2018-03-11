<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * 
 * @package Vendeur
 * @since Vendeur 1.0
 */
?>

<article class="no-results not-found">
	<header class="page-header-no-result">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'vendeur' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( '%1$s<a href="%2$s">%3$s</a>.', 
						esc_html__( 'Ready to publish your first post?', 'vendeur') ,
						esc_url( admin_url( 'post-new.php' ) ),
						esc_html_x( 'Get started here', 'anchor text for link to create post', 'vendeur' )
					 ); 
			?>
			</p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vendeur' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'vendeur' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .page-content -->
</article><!-- .no-results -->
