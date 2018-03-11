<?php
/**
 * The template part for displaying content
 *
 * 
 * @package Vendeur
 * @since Vendeur 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<span class="sticky-post"><span class="screen-reader-text"><?php esc_html_e( 'Sticky', 'vendeur' ); ?></span><?php echo vendeur_svg_icon('pin'); ?></span>
		<?php endif; ?>

		<div class="entry-meta">
			<?php
				$format = get_post_format();
				if ( current_theme_supports( 'post-formats', $format ) ) {
					printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s<span class="screen-reader-text">%4$s</span></a></span>',
						sprintf( '<span class="screen-reader-text">%s </span>',
							esc_html_x( 'Format', 'Used before post format.', 'vendeur' )
						),
						esc_url( get_post_format_link( $format ) ),
						vendeur_svg_icon( $format ),
						get_post_format_string( $format )
					);
				}

			?>
			<?php vendeur_entry_meta(); ?>
			<?php
				edit_post_link(
					sprintf(
						'%1$s<span class="screen-reader-text"> "%2$s"</span>',
						esc_html__( 'Edit', 'vendeur' ),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		</div><!-- .entry-meta -->

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header><!-- .entry-header -->

	<?php vendeur_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
				'%1$s<span class="screen-reader-text"> "%2$s"</span>',
				esc_html__('Read More', 'vendeur'),
				get_the_title()
			) );

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'vendeur' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'vendeur' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php
		if ( function_exists( 'sharing_display' ) ) {
			sharing_display( '', true );
		}
		?>

		<div class="entry-meta">
			<?php 
			vendeur_entry_taxonomies();
			?>
		</div>

		<?php
		if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
			echo do_shortcode( '[jetpack-related-posts]' );
		}		
		?>
	</footer>

</article><!-- #post-## -->
