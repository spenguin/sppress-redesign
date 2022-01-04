<?php
/**
 * Generate a carousel of Featured Creators
 */

function spp_featured_creators()
{
    $creators   = get_featured_creators(); 
    ob_start(); ?>
        <div class="spp_featured_creators">
            <div class="splide" data-splide='{"type":"loop","perPage":1, "autoplay":"false" }'>
                <div class="splide__arrows">
                    <div class="splide__arrow splide__arrow--prev">
                        <!--<i class="fas fa-angle-left"></i>-->
                    </div>
                    <div class="splide__arrow splide__arrow--next">
                        <!--<i class="fas fa-angle-right"></i>-->
                    </div>
                </div>
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                        foreach( $creators as $c ): ?>
                            <li class="splide__slide">
                                <a href="<?php echo site_url(); ?>/creator/<?php echo $c->post_name; ?>">
                                    <?php echo get_the_post_thumbnail( $c->ID, [300, 300] ); ?>
                                    <h3><span>Meet</span> <?php echo $c->post_title; ?></h3>
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
 * Get Featured Creators
 * @return array featured creators
 */
function get_featured_creators()
{
    $args   = array(
        'post_type'     => 'creator',
        'meta_key'      => 'featured_creator',
        'meta_value'    => '1',
        'posts_per_page'=> -1
    );

    $query  = new WP_Query( $args );

    $o  = [];
    if( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
        $o[$query->post->ID]    = $query->post;
    endwhile; endif;

    wp_reset_postdata();

    return $o;
}