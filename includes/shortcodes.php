<?php

namespace Shortcodes;


\Shortcodes\initialize();

function initialize()
{
    require_once CORE_SHORTCODE . 'spp_category_carousel.php';
    add_shortcode( 'spp_category_carousel', '\spp_category_carousel' );
    add_action( 'wp_enqueue_scripts', '\Shortcodes\add_scripts' );
    add_action( 'wp_enqueue_scripts', '\Shortcodes\add_styles' );

    require_once CORE_SHORTCODE . 'spp_bestseller_carousel.php';
    add_shortcode( 'spp_bestseller_carousel', '\spp_bestseller_carousel' );

    require_once CORE_SHORTCODE  . 'spp_blog_and_news.php';
    add_shortcode( 'spp-blog-and-news', '\spp_blog_and_news' );

    require_once CORE_SHORTCODE . 'spp_featured_creators.php';
    add_shortcode( 'spp-featured-creators', '\spp_featured_creators' );

    require_once CORE_SHORTCODE . 'spp_featured_title.php';
    add_shortcode( 'spp-featured-title', '\spp_featured_title' );

    require_once CORE_SHORTCODE . 'spp_events_carousel.php';
    add_shortcode( 'spp-events-carousel', '\spp_events_carousel' );

    require_once CORE_SHORTCODE . 'spp_hero_banners.php';
    add_shortcode( 'spp-hero-banners', '\spp_hero_banners' );    
}


function add_scripts() 
{
    wp_register_script( 'splide', CORE_TEMPLATE_URL . '/vendor/splide/dist/js/splide.js' );
    wp_enqueue_script( 'splide' );
}

function add_styles()
{
    wp_enqueue_style( 'splide-min',  CORE_TEMPLATE_URL . '/vendor/splide/dist/css/splide-core.min.css' ); 
}