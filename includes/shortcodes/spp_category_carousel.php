<?php
/**
 * Generate a carousel of Product categories
 */

function spp_category_carousel()
{
    $cats   = get_product_categories(); 
    ob_start(); ?>
        <div class="spp_product_categories">
            <div class="splide" data-splide='{"type":"loop","perPage":4,"perMove":1}'>
                <div class="splide__arrows">
                    <div class="splide__arrow splide__arrow--prev">
                        <i class="fas fa-angle-left"></i>
                    </div>
                    <div class="splide__arrow splide__arrow--next">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                        foreach( $cats as $c ): ?>
                            <li class="splide__slide">
                                <a href="<?php echo site_url(); ?>/product-category/<?php echo $c->slug; ?>">
                                    <img src="<?php echo $c->thumb_img; ?>" />
                                    <h3><?php echo $c->name; ?></h3>
                                </a>
                            </li>
                        <?php endforeach; ?>                    
                    </ul>
                </div>
            </div>
        </div>
    <?php
    $o  = ob_get_clean();

    return $o;
}


/**
 * Get Product Categories data
 * @return array 
 */
function get_product_categories()
{
    // Collect Product Categories
    $cats   = get_terms( array(
        'taxonomy' => 'product_cat',
        'hide_empty' => false,
        ) );
    $o  = [];
    foreach( $cats as $c )
    {
        if( "uncategorized" == $c->slug ) continue;
        $thumb_id = get_woocommerce_term_meta( $c->term_id, 'thumbnail_id', true );
        if( empty( $thumb_id ) ) continue;
        $c->thumb_img   = wp_get_attachment_url( $thumb_id );
        $o[$c->term_id] = $c;
    }
    wp_reset_query();

    return $o;
}