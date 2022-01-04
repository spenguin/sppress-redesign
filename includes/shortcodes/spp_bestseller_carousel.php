<?php
/**
 * Generate a carousel of Bestsellers
 */
function spp_bestseller_carousel()
{
    $args['products']   = get_bestsellers();
    ob_start(); 
        get_template_part( 'templates/bestsellers', '', $args );
    $o  = ob_get_clean();

    return $o;
}

/**
 * Get Bestsellers data
 * @return array 
 */
function get_bestsellers()
{
    $args = [
        'post_type'     => 'product',
        'meta_key'      => 'total_sales',
        'orderby'       => 'meta_value_num',
        'posts_per_page'=> 4,
        'meta_query'    => [
                [
                    'key'   => '_stock_status',
                    'value' => 'outofstock',
                    'compare' => 'NOT LIKE'
                ]
        ],
        'tax_query'     => [
                [
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => 'bundles',
                    'operator'  => 'NOT IN'
                ],
        ]
    ];
    $loop   = new WP_Query( $args ); //exit( $loop->request );
    $o      = [];
    while ( $loop->have_posts() ) : $loop->the_post(); 
        if( !has_post_thumbnail( $loop->post->ID ) ) continue;
        $loop->post->thumb_img  = get_woocommerce_term_meta( $loop->post->ID, 'thumbnail_id', true );
        $o[$loop->post->ID] = $loop->post;
    endwhile; wp_reset_query(); 

    return $o;
}