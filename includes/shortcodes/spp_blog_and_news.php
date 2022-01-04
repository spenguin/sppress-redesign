<?php
/**
 * Generate the Blog and News posts for the Home Page
 */
function spp_blog_and_news()
{
    $args['posts']  = spp_get_blog();
    ob_start(); 
        get_template_part( 'templates/blog-news', '', $args );
    $o  = ob_get_clean();
    
    
    return $o;
}

function spp_get_blog()
{
    $params = [
        'category_name' => 'blog,news',
        'posts_per_page'=> 5
    ];

    $query  = new WP_Query( $params );
    $o      = [];
    if( $query->have_posts() ): while( $query->have_posts() ): $query->the_post();
        $o[]    = $query->post; 
    endwhile; endif; wp_reset_query();

    return $o;
}