<?php
/**
 * Single Creator Image
 *
 * @version 0.0.1
 */

defined( 'ABSPATH' ) || exit;

$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
?>

<div class="single-creator_image"> 
	<figure class="creator-gallery__wrapper">
		<?php
		if ( $post_thumbnail_id ) { 
			$html = get_the_post_thumbnail( $post->ID ); //wc_get_gallery_image_html( $post_thumbnail_id, true );
		} else {
			$html  = '<div class="creator-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting creator image', 'storevilla' ) );
			$html .= '</div>';
		}
		echo $html;
		?>
	</figure>
</div>

<?php
return;

$columns           = apply_filters( 'creator_thumbnails_columns', 4 );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$wrapper_classes   = apply_filters(
	'single_creator_image_gallery_classes',
	array(
		'creator-gallery',
		'creator-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'creator-gallery--columns-' . absint( $columns ),
		'images',
	)
); 
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" > <!-- previous style code: style="opacity: 0; transition: opacity .25s ease-in-out;"> -->
	<figure class="creator-gallery__wrapper">
		<?php
		if ( $post_thumbnail_id ) { 
			$html = get_the_post_thumbnail( $post->ID ); //wc_get_gallery_image_html( $post_thumbnail_id, true );
		} else {
			$html  = '<div class="creator-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting creator image', 'storevilla' ) );
			$html .= '</div>';
		}
		echo $html;
		//echo apply_filters( 'single_creator_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

		//do_action( 'woocommerce_product_thumbnails' );
		?>
	</figure>
</div>

<style>
	.single-creator #content div.creator div.images, 
	.single-creator div.creator div.images, 
	.single-creator #content div.creator div.images, 
	.single-creator div.creator div.images 
	{
		/*float: left;*/
		width: 48%;
		margin-bottom: 2em;
	}
	.single-creator div.creator {
		margin-bottom: 0;
		position: relative;
		display: flex;
		justify-content: space-between;
	}
	.single-creator div.creator div {
		width: 48%;
	}
	.creator-gallery {
		opacity: 1;
	}
	.creator-gallery__wrapper {
		margin: 0;
	}
	.creator .entry-summary {
		margin-top: 0;
		margin-bottom: 2em;
		h1 {
			margin-bottom: 3px;
			color: #6a6a6a;
			text-transform: uppercase;
			font-size: 26px;
			font-family: Open Sans;
			font-weight: 400;
		}
	}
</style>
