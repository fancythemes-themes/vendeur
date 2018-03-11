<?php
/**
 * Product Categories Widget
 *
 * @package  Vendeur
 * @version  1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product categories widget class.
 *
 * @extends WC_Widget
 */
class Vendeur_Widget_Product_Categories extends WC_Widget {

	/**
	 * Category ancestors.
	 *
	 * @var array
	 */
	public $cat_ancestors;

	/**
	 * Current Category.
	 *
	 * @var bool
	 */
	public $current_cat;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'woocommerce widget-product-categories';
		$this->widget_description = __( 'A list of product categories presented with image.', 'vendeur' );
		$this->widget_id          = 'widget-product-categories';
		$this->widget_name        = __( 'Vendeur - Product Categories', 'vendeur' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Product categories', 'vendeur' ),
				'label' => __( 'Title', 'vendeur' ),
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 5,
				'label' => __( 'Max number of products to show', 'woocommerce' ),
			),
			'columns' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => 4,
				'std'   => 2,
				'label' => __( 'Number of column to present', 'woocommerce' ),
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'name',
				'label' => __( 'Order by', 'vendeur' ),
				'options' => array(
					'order' => __( 'Category order', 'vendeur' ),
					'name'  => __( 'Name', 'vendeur' ),
				),
			),
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 * @param array $args     Widget arguments.
	 * @param array $instance Widget instance.
	 */
	public function widget( $args, $instance ) {
		global $wp_query, $post;

		$number  = isset( $instance['number'] ) ? $instance['number'] : $this->settings['number']['std'];
		$columns = isset( $instance['columns'] ) ? $instance['columns'] : $this->settings['columns']['std'];
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : $this->settings['orderby']['std'];

        $shortcode_content = vendeur_do_shortcode( 'product_categories', array(
            'number'  => intval( $number ),
            'columns' => intval( $columns ),
            'orderby' => esc_attr( $orderby ),
            'parent'  => 0,
        ) );

        if ( false !== strpos( $shortcode_content, 'product-category' ) ) {
            $this->widget_start( $args, $instance );

            echo $shortcode_content;
            $this->widget_end( $args );
        }
	}
}

function vendeur_register_widget_product_categories() {
	register_widget("Vendeur_Widget_Product_Categories");
}
add_action('widgets_init', 'vendeur_register_widget_product_categories', 90);
