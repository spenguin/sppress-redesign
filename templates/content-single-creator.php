<?php
/**
 * The template for displaying product content in the single-creator.php template
 *
 * @version 0.0.1
 */

defined( 'ABSPATH' ) || exit; ?>

<div id="creator-<?php the_ID(); ?>" class="creator type-creator status-publish first has-post-thumbnail"><!-- [FIX] -->

	<?php
	/**
	 * Hook: before_single_creator_summary.
	 *
	 * @hooked show_creator_image - 20
	 */
	do_action( 'before_single_creator_summary' );
	?>

	<div class="summary entry-summary single-creator_summary">
		<?php 
		/**
		 * Hook: single_creator_summary.
		 *
		 * @hooked single_creator_title - 5
		 * @hooked single_creator_description - 10
		 */
		do_action( 'single_creator_summary' );
		?>
	</div>

	<?php
	/**
	 * Hook: after_single_creator_summary.
	 *
	 * @hooked spp_output_creator_products - 20
	 */
    
	do_action( 'after_single_creator_summary' );
	?>
</div>

<?php //do_action( 'woocommerce_after_single_product' ); ?>