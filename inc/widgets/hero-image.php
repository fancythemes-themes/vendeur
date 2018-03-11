<?php
/**
 * Widget API: WP_Widget_Media_Image class
 *
 * @package Kapkids
 * @since 1.0
 */

/**
 * Class that implements an hero image widget.
 *
 * @since 1.0
 *
 * @see WP_Widget
 */
class Vendeur_Hero_Image extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @since  4.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array('classname' => 'widget-hero-image', 'description' => esc_html__( 'Hero Image', 'vendeur') );
		parent::__construct('vendeur-hero-image', esc_html__('Vendeur - Hero Image', 'vendeur'), $widget_ops);
		$this->alt_option_name = 'widget_hero_image';
	}


	/**
	 * Render the media on the frontend.
	 *
	 * @since  4.8.0
	 * @access public
	 *
	 * @param array $instance Widget instance props.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		extract($args);
		$default = array ( 
			'widget_title' => '',
			'hero_image_url' => '',
			'hero_image_caption' => '',
			'hero_image_button_label' => '',
			'hero_image_button_url' => ''
		);
		$image = '';
		if ( isset( $instance['hero_image_url']) ) {
			$image = sprintf( '<img class="%1$s" src="%2$s" alt="%3$s" />',
				'hero-image',
				esc_url( $instance['hero_image_url'] ),
				esc_attr( $instance['hero_image_caption'] )
			);
		}					
		echo $before_widget;
		echo '<div class="hero-image-wrapper"> ';
		if ( $image ) {
			echo '<a href="' . esc_url( $instance['hero_image_button_url'] ) . '" class="hero-image-thumb" >';
			echo $image;
			echo '</a>';
		}
		echo '<div>';
		echo '<h2 class="hero-title">' . $instance['hero_image_caption'] . '</h2>';
		echo '<a class="button hero-button" href="' . esc_url( $instance['hero_image_button_url'] ) . '">';
		echo $instance['hero_image_button_label'];
		echo '</a>';
		echo '</div>';
		echo '</div>';
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = sanitize_text_field( $new_instance['widget_title'] );
		$instance['hero_image_url'] = esc_url( $new_instance['hero_image_url'] );
		$instance['hero_image_caption'] = sanitize_text_field($new_instance['hero_image_caption']);
		$instance['hero_image_button_label'] = sanitize_text_field($new_instance['hero_image_button_label']);
		$instance['hero_image_button_url'] = sanitize_text_field($new_instance['hero_image_button_url']);

		return $instance;
	}

	function form( $instance ) {	
		$default = array ( 
			'widget_title' => '',
			'hero_image_url' => '',
			'hero_image_caption' => '',
			'hero_image_button_label' => '',
			'hero_image_button_url' => ''
		);
		$instance = wp_parse_args($instance, $default);			
	?>
		<!-- <p>
			<?php esc_html_e( 'Widget title:', 'vendeur'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo esc_attr($instance['widget_title']); ?>" />
		</p> -->
		<p>
			<?php esc_html_e( 'Image URL', 'vendeur'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('hero_image_url'); ?>" value="<?php echo esc_url($instance['hero_image_url']) ; ?>" />
		</p>
		<p>
			<?php esc_html_e( 'Caption', 'vendeur'); ?>
			<textarea class="widefat" type="text" name="<?php echo $this->get_field_name('hero_image_caption'); ?>" ><?php echo esc_html($instance['hero_image_caption']) ; ?>"</textarea>
		</p>
		<p>
			<?php esc_html_e( 'Button Label', 'vendeur'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('hero_image_button_label'); ?>" value="<?php echo esc_attr($instance['hero_image_button_label']) ; ?>" />
		</p>
		<p>
			<?php esc_html_e( 'Button link URL', 'vendeur'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('hero_image_button_url'); ?>" value="<?php echo esc_url($instance['hero_image_button_url']) ; ?>" />
		</p>

	<?php
	}


}


function vendeur_register_hero_image() {
	return register_widget("Vendeur_Hero_Image");	
}
add_action('widgets_init', 'vendeur_register_hero_image');