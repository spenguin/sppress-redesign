<?php
/**
 * Present the discount countdown title;
 * If one is not designated, present the most recent title
 */

function spp_featured_title()
{
    $title  = get_discount_title();
    if( is_null( $title ) )
    {
        $args   = [
            'post_type'         => 'product',
            'posts_per_page'    => 1,
            'orderby'           => 'date'
        ];
        $query  = new WP_Query( $args );
        $query->the_post();     // We must have at least one product
        ob_start(); ?>
            <div class="spp-featured-title newest">
                <div class="roundel">New!</div>
                <a href="<?php echo esc_url( get_permalink() ); ?>">
                    <?php echo get_the_post_thumbnail( get_the_ID() ); ?>
                    <h3><span>Check out</span> <?php the_title(); ?></h3>
                </a>
            </div>
        <?php 
            wp_reset_query();
            return ob_get_clean();
    }
    else
    {
        // Present countdown template [FIX]
    }
}

/**
 * Get discount title
 * @return object product; else NULL
 */
function get_discount_title()
{
    return NULL;
}


