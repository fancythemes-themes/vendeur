<?php
/**
 * The template part for displaying content
 *
 * 
 * @package Vendeur
 * @since Vendeur 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( ); ?>>


	<header class="entry-header">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" class="post-thumbnail"><?php the_post_thumbnail('thumbnail'); ?></a>
		<?php endif; ?>

		<div class="entry-meta">
			<?php vendeur_entry_meta(); ?>
		</div><!-- .entry-meta -->

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	</header><!-- .entry-header -->

	<?php //vendeur_excerpt(); ?>

	<div class="entry-content">
		<?php
			/* translators: %s: Name of current post */
			the_excerpt();
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
