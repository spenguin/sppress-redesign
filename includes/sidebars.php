<?php

namespace Sidebars;

\Sidebars\initialise();

function initialise()
{
    register_sidebar( array(
        'name'          => __( 'Single Creator', 'storevilla' ),
        'description'   => __( 'Sidebar for Single Creator page' ),
        'id'            => 'single-creator',
        'before_widget' => '<aside id="single-creator" class="widget-area" role="complementary">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
 
    register_sidebar( array(
        'name'          => __( 'Single Post', 'storevilla' ),
        'description'   => __( 'Sidebar for Single Post page' ),
        'id'            => 'single-post',
        'before_widget' => '<aside id="single-post" class="widget-area" role="complementary">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}