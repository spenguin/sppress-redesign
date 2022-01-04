<?php
/**
 * Generate slider of Hero banners for Home Page
 */
function spp_hero_banners()
{
    $banners   = get_banners(); 
    ob_start(); ?>
        <div class="spp-hero-banners">
            <div class="splide" data-splide='{"type":"loop","perPage":1, "pagination":"true" }'>
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
                        foreach( $banners as $id => $b ): 
                            $link   = get_post_meta( $id, 'banner_link', TRUE );
                            $btn_colour = get_post_meta( $id, 'btn_colour', TRUE );
                            $btn_class  = empty( $btn_colour ) ? "" : "btn-reverse"; 
                        ?>
                            <li class="splide__slide">
                                <?php echo get_the_post_thumbnail( $id, [760, 510] ); ?>
                                <div class="banner_content">
                                    <?php echo $b->post_content; ?>
                                </div>
                                <a class="blog-preview-btn <?php echo $btn_class; ?>" href="<?php  echo $link; ?>"><?php esc_html_e('FIND OUT MORE','storevilla'); ?></a>
                            </li>
                        <?php endforeach; ?>                    
                    </ul>
                    <div class="slider"></div>
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
function get_banners()
{
    $args   = array(
        'post_type'     => 'banner',
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