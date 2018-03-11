<?php
/**
 * Custom Vendeur template tags
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * 
 * @package Vendeur
 * @since Vendeur 1.0
 */

if ( ! function_exists( 'vendeur_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own vendeur_entry_meta() function to override in a child theme.
 *
 * @since Vendeur 1.0
 */
function vendeur_entry_meta() {


	if ( 'post' === get_post_type() ) {
		$author_avatar_size = apply_filters( 'vendeur_author_avatar_size', 50 );
		printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span> <a class="url fn n" href="%2$s">%3$s</a></span></span>',
			//get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
			esc_html_x( 'Author', 'Used before post author name.', 'vendeur' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		);
	}

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		vendeur_entry_date();
	}

	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( '%1$s<span class="screen-reader-text"> %2$s</span>',
			esc_html__('No comment', 'vendeur'),
			get_the_title() ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'vendeur_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own vendeur_entry_date() function to override in a child theme.
 *
 * @since Vendeur 1.0
 */
function vendeur_entry_date() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		get_the_date(),
		esc_attr( get_the_modified_date( 'c' ) ),
		get_the_modified_date()
	);

	printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
		esc_html_x( 'Posted on', 'Used before publish date.', 'vendeur' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'vendeur_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own vendeur_entry_taxonomies() function to override in a child theme.
 *
 * @since Vendeur 1.0
 */
function vendeur_entry_taxonomies() {
	$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'vendeur' ) );
	if ( $categories_list && vendeur_categorized_blog() ) {
		printf( '<span class="cat-links"><span>%1$s </span>%2$s</span>',
			esc_html_x( 'Categories: ', 'Used before category names.', 'vendeur' ),
			$categories_list
		);
	}

	$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'vendeur' ) );
	if ( $tags_list ) {
		printf( '<span class="tags-links"><span>%1$s </span>%2$s</span>',
			esc_html_x( 'Tags: ', 'Used before tag names.', 'vendeur' ),
			$tags_list
		);
	}
}
endif;

if ( ! function_exists( 'vendeur_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * Create your own vendeur_post_thumbnail() function to override in a child theme.
 *
 * @since Vendeur 1.0
 */
function vendeur_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

	<?php endif; // End is_singular()
}
endif;

if ( ! function_exists( 'vendeur_excerpt' ) ) :
	/**
	 * Displays the optional excerpt.
	 *
	 * Wraps the excerpt in a div element.
	 *
	 * Create your own vendeur_excerpt() function to override in a child theme.
	 *
	 * @since Vendeur 1.0
	 *
	 * @param string $class Optional. Class string of the div element. Defaults to 'entry-summary'.
	 */
	function vendeur_excerpt( $class = 'entry-summary' ) {
		$class = esc_attr( $class );

		if ( has_excerpt() || is_search() ) : ?>
			<div class="<?php echo esc_attr( $class ); ?>">
				<?php the_excerpt(); ?>
			</div>
		<?php endif;
	}
endif;

if ( ! function_exists( 'vendeur_excerpt_more' ) && ! is_admin() ) :
/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * Create your own vendeur_excerpt_more() function to override in a child theme.
 *
 * @since Vendeur 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function vendeur_excerpt_more() {
	$link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( '%1$s<span class="screen-reader-text"> "%2$s"</span>', esc_html__('Read More', 'vendeur'), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'vendeur_excerpt_more' );
endif;

if ( ! function_exists( 'vendeur_excerpt_length' ) && ! is_admin() ) :
/**
 * Change the excerpt number
 *
 * @since Vendeur 1.0
 *
 * @return number Number for excerpt.
 */
function vendeur_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'vendeur_excerpt_length', 999 );
endif;

if ( ! function_exists( 'vendeur_categorized_blog' ) ) :
/**
 * Determines whether blog/site has more than one category.
 *
 * Create your own vendeur_categorized_blog() function to override in a child theme.
 *
 * @since Vendeur 1.0
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function vendeur_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'vendeur_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'vendeur_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so vendeur_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so vendeur_categorized_blog should return false.
		return false;
	}
}
endif;

/**
 * Flushes out the transients used in vendeur_categorized_blog().
 *
 * @since Vendeur 1.0
 */
function vendeur_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'vendeur_categories' );
}
add_action( 'edit_category', 'vendeur_category_transient_flusher' );
add_action( 'save_post',     'vendeur_category_transient_flusher' );

if ( ! function_exists( 'vendeur_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Vendeur 1.0
 */
function vendeur_the_custom_logo() {
	if ( $secondary_logo = get_theme_mod( 'secondary_logo', false ) ) {
		?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="secondary-logo"><img src="<?php echo esc_url( $secondary_logo); ?>" alt="<?php esc_attr( bloginfo( 'name' ) ); ?>" /></a>
		<?php
	}

	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;

/**
 * Print markup for SVG icon.
 *
 * @since Vendeur 1.0
 * @param string $icon keyword for icon name
 */
function vendeur_svg_icon ( $icon ) {
	$symbol = '<svg class="icon icon-' . esc_attr( $icon ) . '"><use xlink:href="' . esc_url( get_template_directory_uri() . '/svg/symbol-defs.svg#icon-' . $icon ) . '"></use></svg>';

	return $symbol;
}

/**
 * Custom function to retrieve the archive title based on the queried object.
 *
 * @since Vendeur 1.0
 *
 * @return string Archive title.
 */
function vendeur_archive_title() {
	if ( is_category() ) {
		$title = sprintf(
			'<div class="archive-title-pre">%1$s</div><h1 class="page-title">%2$s</h1><div class="taxonomy-description">%3$s</div>',
			esc_html__( 'Category:', 'vendeur' ),
			single_cat_title( '', false ),
			term_description()
		);
	} elseif ( is_tag() ) {
		$title = sprintf(
			'<div class="archive-title-pre">%1$s</div><h1 class="page-title">%2$s</h1><div class="taxonomy-description">%3$s</div>',
			esc_html__( 'Tagged As:', 'vendeur' ),
			single_tag_title( '', false ),
			term_description()
		);
	} elseif ( is_author() ) {
		$title = sprintf(
			'<div class="author-avatar">%1$s</div><div class="archive-title-pre">%2$s</div><h1 class="page-title">%3$s</h1><div class="taxonomy-description">%4$s</div>',
			get_avatar( get_the_author_meta( 'user_email' ), 80 ),
			esc_html__( 'Author by:', 'vendeur' ),
			get_the_author(),
			get_the_author_meta( 'description' )
		);
	} elseif ( is_year() ) {
		$title = sprintf(
			'<div class="archive-title-pre">%1$s</div><h1 class="page-title">%2$s</h1>',
			esc_html__( 'Posted in year:', 'vendeur' ),
			get_the_date( _x( 'Y', 'yearly archives date format', 'vendeur' ) )
		);
	} elseif ( is_month() ) {
		$title = sprintf(
			'<div class="archive-title-pre">%1$s</div><h1 class="page-title">%2$s</h1>',
			esc_html__( 'Posted in month:', 'vendeur' ),
			get_the_date( _x( 'F Y', 'monthly archives date format', 'vendeur' ) )
		);
	} elseif ( is_day() ) {
		$title = sprintf(
			'<div class="archive-title-pre">%1$s</div><h1 class="page-title">%2$s</h1>',
			esc_html__( 'Posted in:', 'vendeur' ),
			get_the_date( _x( 'F j, Y', 'daily archives date format', 'vendeur' ) )
		);
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'vendeur' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'vendeur' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s' , 'vendeur'), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'vendeur' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'vendeur' );
	}

	echo apply_filters( 'vendeur_archive_title', $title );
}

/**
 * Breadcrumbs
 *
 * @since Vendeur 1.0
 */
function vendeur_breadcrumbs() { 
	if ( !is_front_page() ) {

		printf( 
			'<div class="site-breadcrumbs" ><span>%1$s</span><a href="%2$s">%3$s</a>',
			esc_html__('', 'vendeur'),
			home_url(),
			esc_html__( 'Home', 'vendeur' )
		);

		echo vendeur_svg_icon('pointer');
	}

	if ( (is_category() || is_single()) && !is_attachment() ) {
		$category = get_the_category();
		if (count($category) > 0){
			$ID = $category[0]->cat_ID;
			if ( $ID ) {
				echo get_category_parents($ID, TRUE, ' ', FALSE );
				echo vendeur_svg_icon('pointer');
			}
		}
	}

	if(is_single() || is_page()) {
		if ( !is_front_page() ){
			echo '<span>';
			the_title();
			echo '</span>';
		}
	}

	if (is_tag()){ echo '<span>' . esc_html__('Tag: ', 'vendeur') . single_tag_title('',FALSE). '</span>'; }
	if (is_404()){ echo '<span>' . esc_html__('404 - Page not Found', 'vendeur') . '</span>'; }
	if (is_search()){ echo '<span>' . esc_html__('Search', 'vendeur'). '</span>'; }
	if (is_year()){ echo '<span>' . get_the_time('Y'). '</span>'; }
	if (is_month()){ echo '<span>' . get_the_time('F Y'). '</span>'; }
	if (is_author()){ echo '<span>' . esc_html__('Posts by ', 'vendeur') . get_the_author(). '</span>'; }


	if ( !is_front_page() ) {
		echo "</div>";	
	}
}

/**
 * Pagination for custom query.
 *
 * @since Vendeur 1.0
 *
 * @param WP_Query $query, the custom query
 * @param Array @args, the same arguments as the_posts_pagination() function 
 * @return string HTML Markup for.
 */
function vendeur_custom_query_pagination( $query, $args = array()) {
	$navigation = '';

	// Don't print empty markup if there's only one page.
	if ( $query->max_num_pages > 1 ) {
		$args = wp_parse_args( $args, array(
				'mid_size'		   => 1,
				'prev_text'		  => esc_html__( 'Previous', 'vendeur' ),
				'next_text'		  => esc_html__( 'Next', 'vendeur' ),
				'screen_reader_text' => esc_html__( 'Posts navigation', 'vendeur' ),
		) );

		// Make sure we get a string back. Plain is the next best thing.
		if ( isset( $args['type'] ) && 'array' == $args['type'] ) {
				$args['type'] = 'plain';
		}

		// Set up paginated links.
		$links = paginate_links( $args );

		if ( $links ) {
				$navigation = _navigation_markup( $links, 'pagination', $args['screen_reader_text'] );
		}
	}

	return $navigation;
}

/**
 * Render the footer credit, print from the footer_credit options, or default.
 *
 * @since Vendeur 1.0
 *
 * @return void
 */
function vendeur_footer_credit( $echo = false ) {

	if ( $footer_credit = get_theme_mod( 'footer_credit', false ) ) {
		$credit = vendeur_sanitize_footer_credit( $footer_credit );
	} else {
		$credit = vendeur_sanitize_footer_credit( sprintf(
			'<a href="%1$s" rel="home">%2$s</a> %3$s <a href="%4$s">%5$s</a>',
			esc_url( home_url('/') ),
			get_bloginfo('name'),
			__('Proudly powered by', 'vendeur'),
			esc_url( __( 'https://wordpress.org/', 'vendeur' ) ),
			__('WordPress', 'vendeur')
		) );
	}
	if ( $echo ) {
		echo $credit;
	}
	return $credit;
}

if ( ! function_exists( 'vendeur_header_wc_nav' ) ) {
	/**
	 * Display Header Woocommerce Menu
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function vendeur_header_wc_nav() {
		?>
		<div class="site-header-wc-nav">
			<?php if ( is_user_logged_in() ) { ?>
				<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="account-link" title="<?php esc_attr_e('My Account','vendeur'); ?>"><?php echo vendeur_svg_icon('account'); esc_html_e('My Account','vendeur'); ?></a>
			<?php } else { ?>
				<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" class="account-link" title="<?php esc_attr_e('Login / Register','vendeur'); ?>"><?php echo vendeur_svg_icon('account'); esc_html_e('Login / Register','vendeur'); ?></a>
			<?php } ?>

			<ul id="site-header-cart" class="site-header-cart menu">

				<li class="cart-summary">
					<a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php esc_attr_e('View   cart', 'vendeur'); ?>"><?php echo vendeur_svg_icon('cart'); echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'vendeur'), WC()->cart->cart_contents_count);?> (<?php echo WC()->cart->get_cart_total(); ?>)</a>
				</li>
				<li>
					<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
				</li>
			</ul>
		</div>
		<?php
	}
}