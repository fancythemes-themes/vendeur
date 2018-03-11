<?php
/**
 * Widget API: Vendeur_Widget_Products class
 *
 * @package Vendeur
 * @since 1.0.0
 */

/**
 * Class used to implement a this theme's Products widget.
 * Extends the WC_Widget_Products
 *
 * @since 1.0.0
 *
 * @see WC_Widget_Products
 */
class Vendeur_Widget_Products extends WC_Widget_Products {
	/** constructor */
	public function __construct() {

		$this->widget_cssclass    = 'woocommerce vendeur_widget_products';
		$this->widget_description = __( "A list of your store's products.", 'vendeur' );
		$this->widget_id          = 'vendeur_woocommerce_products';
		$this->widget_name        = __( 'Vendeur - Products', 'vendeur' );

		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Products', 'woocommerce' ),
				'label' => __( 'Title', 'woocommerce' ),
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Number of products to show', 'woocommerce' ),
			),
			'show' => array(
				'type'  => 'select',
				'std'   => '',
				'label' => __( 'Show', 'woocommerce' ),
				'options' => array(
					''         => __( 'All products', 'woocommerce' ),
					'featured' => __( 'Featured products', 'woocommerce' ),
					'onsale'   => __( 'On-sale products', 'woocommerce' ),
				),
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => __( 'Order by', 'woocommerce' ),
				'options' => array(
					'date'   => __( 'Date', 'woocommerce' ),
					'price'  => __( 'Price', 'woocommerce' ),
					'rand'   => __( 'Random', 'woocommerce' ),
					'sales'  => __( 'Sales', 'woocommerce' ),
				),
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'desc',
				'label' => _x( 'Order', 'Sorting order', 'woocommerce' ),
				'options' => array(
					'asc'  => __( 'ASC', 'woocommerce' ),
					'desc' => __( 'DESC', 'woocommerce' ),
				),
			),
			'hide_free' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Hide free products', 'woocommerce' ),
			),
			'show_hidden' => array(
				'type'  => 'checkbox',
				'std'   => 0,
				'label' => __( 'Show hidden products', 'woocommerce' ),
			),
			'display_as' => array(
				'type'  => 'select',
				'std'   => 'columns-4',
				'label' => __( 'Display list as', 'vendeur' ),
				'description' => __('Multi column option will displayed as single column on sidebar', 'vendeur'),
				'options' => array(
					'columns-1'     => __( 'Full width list', 'vendeur' ),
					'columns-2'     => __( '2 Column list', 'vendeur' ),
					'columns-3'     => __( '3 Column list', 'vendeur' ),
					'columns-4'     => __( '4 Column list', 'vendeur' ),
					'columns-1-slider'   => __( 'Full width slider', 'vendeur' ),
					'columns-2-slider'   => __( '2 Column slider', 'vendeur' ),
					'columns-3-slider'   => __( '3 Column slider', 'vendeur' ),
					'columns-4-slider'   => __( '4 Column slider', 'vendeur' ),
					'tiled-auto'        => __( 'Tiled', 'vendeur')
				),
			), 
		);


		WC_Widget::__construct();
	}
	
	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		global $product;

		ob_start();

		if ( ( $products = $this->get_products( $args, $instance ) ) && $products->have_posts() ) {
			$this->widget_start( $args, $instance );

			$wrapper_class = isset( $instance['display_as'] ) ? $instance['display_as'] : 'columns-4';

			$slider_max_item = array(
				'columns-1-slider' => 1,
				'columns-2-slider' => 2,
				'columns-3-slider' => 3,
				'columns-4-slider' => 4,
			);
			
			if ( in_array( $wrapper_class, array('columns-1-slider', 'columns-2-slider', 'columns-3-slider', 'columns-4-slider') ) ) {
				$slider_settings = json_encode( array(
					'maxItems' => $slider_max_item[$wrapper_class],
					'itemMargin' => 40,
					'prevText'	=> sprintf(
						'<span class="screen-reader-text">%1$s</span>%2$s',
						esc_html__('Previous', 'vendeur'),
						vendeur_svg_icon('arrow-left')
					),
					'nextText'	=> sprintf(
						'<span class="screen-reader-text">%1$s</span>%2$s',
						esc_html__('Next', 'vendeur'),
						vendeur_svg_icon('arrow-right')
					),
				) );

				$wrapper_class .= ' product-slider content-slider';
			}


			echo '<div class="' . $wrapper_class . '" data-slider-settings="' . esc_attr($slider_settings) . '" >';
			echo apply_filters( 'woocommerce_before_widget_product_list', '<ul class="products">' );

			while ( $products->have_posts() ) {
				$products->the_post();
				wc_get_template( 'content-product.php', array( 'show_rating' => false ) );
			}

			echo apply_filters( 'woocommerce_after_widget_product_list', '</ul>' );
			echo '</div>';

			$this->widget_end( $args );
		}

		wp_reset_postdata();

		echo $this->cache_widget( $args, ob_get_clean() );
	}

	
}

function vendeur_register_widget_products() {
	register_widget("Vendeur_Widget_Products");
}
add_action('widgets_init', 'vendeur_register_widget_products', 90);