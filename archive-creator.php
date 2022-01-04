<?php
/**
 * The Template for displaying all single creators
 * @version 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'creators' ); ?>

	<?php
		/**
		 * creator_before_main_content hook.
		 *
		 * @hooked spp_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked spp_breadcrumb - 20
		 */
		do_action( 'creator_before_main_content' );
	?>
	<div class="creators-list">
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			
			<?php get_template_part( 'templates/listing', 'creator' ); ?>

		<?php endwhile; // end of the loop. ?>
	</div>

	<?php
		/**
		 * creator_after_main_content hook.
		 *
		 * @hooked spp_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'creator_after_main_content' );
	?>


<?php
get_footer( 'creator' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */	