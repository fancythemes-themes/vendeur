<?php
/**
 * Product Loop Start
 *
 * This template override the plugin template here /woocommerce/template/loop/loop-start.php.
 *
 *
 * @package 	Vendeur
 * @version     2.0.0
 */
?>

<?php
$column = get_theme_mod( 'shop_column', 3 );
?>
<div class="shop-columns columns-<?php echo esc_attr($column); ?>" >
	<ul class="products">
