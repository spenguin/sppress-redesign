<?php
/**
 * Creators-specific functions and hooks
 */
namespace Creators;

\Creators\initialise();

function initialise()
{
    add_action( 'creator_before_main_content', 'Creators\spp_output_content_wrapper', 10 );
    add_action( 'creator_before_main_content', 'Creators\spp_breadcrumb', 20 );

    add_action( 'before_single_creator_summary', '\Creators\show_creator_image', 20 );

    add_action( 'single_creator_summary', '\Creators\single_creator_title', 5 );
    add_action( 'single_creator_summary', '\Creators\single_creator_description', 10 );

    add_action( 'after_single_creator_summary', 'Creators\output_related_products', 10 );


    add_action( 'creator_after_main_content', '\Creators\spp_output_content_wrapper_end', 10 );

    add_action( 'spp_sidebar', '\Creators\spp_get_sidebar', 10 );

    add_action( 'pre_get_posts', '\Creators\my_change_sort_order' );
}

/**
 * Output opening wrapper code
 */
function spp_output_content_wrapper()
{
    get_template_part( 'templates/global/wrapper-start' );
}

/**
 * Output the WooCommerce Breadcrumb with SPP controls.
 *
 * @param array $args Arguments.
 */
function spp_breadcrumb( $args = array() ) {
    $args = wp_parse_args(
        $args,
        apply_filters(
            'woocommerce_breadcrumb_defaults',
            array(
                'delimiter'   => '&nbsp;&#47;&nbsp;',
                'wrap_before' => '<nav class="spp-breadcrumb">',
                'wrap_after'  => '</nav>',
                'before'      => '',
                'after'       => '',
                'home'        => _x( 'Home', 'breadcrumb', 'storevilla' ),
            )
        )
    );

    $breadcrumbs = new \WC_Breadcrumb();

    if ( ! empty( $args['home'] ) ) {
        $breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
    }

    $args['breadcrumb'] = $breadcrumbs->generate();

    /**
     * WooCommerce Breadcrumb hook
     *
     * @hooked WC_Structured_Data::generate_breadcrumblist_data() - 10
     */
    do_action( 'woocommerce_breadcrumb', $breadcrumbs, $args );

    wc_get_template( 'global/breadcrumb.php', $args );
}


/**
 * Output the creator image before the single creator summary.
 */
function show_creator_image() 
{   
    get_template_part( 'templates/single-creator/creator-image' );
}

/**
 * Output the Creator title
 */
function single_creator_title()
{   
    get_template_part( 'templates/single-creator/title' );
}

/**
 * Output the Creator biography
 */
function single_creator_description()
{
    get_template_part( 'templates/single-creator/creator-description' );
}

/**
 * Output products by Creator
 */
function output_related_products()
{   
    \WCExtension\spp_output_creator_products();
}

/**
 * Output closing wrapper code
 */
function spp_output_content_wrapper_end()
{
    get_template_part( 'templates/global/wrapper-end' );
}

/**
 * Determine which sidebar to display
 */
function spp_get_sidebar()
{
    get_template_part( 'templates/global/sidebar' );
}

/**
 * Change the sort order for the Creators listing page
 */
function my_change_sort_order( $query )
{
    if( is_post_type_archive( 'creator' ) )
    {
        //Set the order ASC or DESC
        $query->set( 'order', 'ASC' );
        //Set the orderby
        $query->set( 'orderby', 'title' );
        // Get all posts
        $query->set( 'posts_per_page', -1 );
    }
}
