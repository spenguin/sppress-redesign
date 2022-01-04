<?php
/**
 * Bestseller Products
 *
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 
extract( $args ); 

if ( $products ) : ?>

	<section class="bestseller_products">

		<ul class="products columns-4">
			<?php
				foreach( $products as $product )
				{
					setup_postdata( $GLOBALS['post'] =& $product );

					wc_get_template_part( 'content', 'product' );
				}
			?>
		</ul>

	</section>

<?php endif; wp_reset_query();