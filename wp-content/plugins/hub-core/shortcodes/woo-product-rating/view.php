<?php
	
// check
if( !liquid_helper()->is_woocommerce_active() ) {
	return;
} 
global $product;
$product = wc_get_product();
if ( empty( $product ) ) { return; }
?>
<div class="product product-layout-component lqd-product-rating">
<?php
	woocommerce_template_single_rating(); 
?>
</div>