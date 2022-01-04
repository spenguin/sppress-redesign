<?php

namespace WCExtension;

\WCExtension\initialise();

function initialise()
{
    /*remove_action( 'woocommerce_shop_loop_item_title', 'aurum_shop_loop_item_title', 5 );
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
    add_action( 'woocommerce_shop_loop_item_title', '\WCExtension\sp_aurum_shop_loop_item_title', 5 );*/
    //add_action( 'woocommerce_single_product_summary', '\WCExtension\woocommerce_template_single_creators', 5 );

    add_action( 'woocommerce_shop_loop_item_title', '\WCExtension\spp_shop_loop_item_creators', 20 );
    add_action( 'woocommerce_shop_loop_item_title', '\WCExtension\spp_shop_loop_item_categories', 30 );
    add_action( 'woocommerce_single_product_summary', '\WCExtension\spp_shop_loop_item_creators', 30 );
    add_action( 'woocommerce_single_product_summary', '\WCExtension\spp_single_product_alt_sources', 40 );
    add_action( 'woocommerce_after_single_product_summary', '\WCExtension\spp_output_related_products', 20 );

    //add_action( 'transition_post_status', '\WCExtension\spp_vat_process', 10 ); [FIX]

    // MailChimp email test for coupon
    //add_action( 'woocommerce_checkout_process', '\WCExtension\spp_guest_email_checker', 20 );

    //add_action( 'sp_after_single_creator', '\WCExtension\sp_woocommerce_single_creator_wrapper_end', 1000 );
    //add_action( 'widgets_init', '\WCExtension\sp_single_creator_sidebar_init' );
}

/**
 * Add Creators listing to all items on the Shop page
 */
function spp_shop_loop_item_creators()
{ 
	global $product; 
    $creator_str    = \WCExtension\render_creator_str( $product->get_id() );
    echo '<h3 class="' . esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__creators' ) ) . '">' . $creator_str . '</h3>'; 
    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Render the string of creator names based on the product ID
 * @param (int) $productId
 * @return (str) creator string
 */
function render_creator_str( $productId )
{   
    $creators   = \Post2Post\getCreatorsByBook( $productId );
    $o          = [];
    foreach( $creators as $c )
    {
        $o[]    = '<a href="' . site_url() . '/creator/' . $c->post_name . '">' . $c->post_title . '</a>';
    }
    return 'By ' . join( ', ', $o );
}

/**
 * Add categories for each item
 */
function spp_shop_loop_item_categories()
{
    global $product;
    $terms  = get_the_terms( $product->get_id(), 'product_cat' );
    $o      = [];
    foreach( $terms as $t )
    {
        $o[]    = '<a href="' . site_url() . '/product-category/'. $t->slug . '">' . $t->name . '</a>';
    }

    echo '<h4>' . join( ', ', $o ) . '</h4>';
}

/**
 * Output the related products.
 *
 * @param array $args Provided arguments.
 */
function spp_output_related_products( $args = [] )
{
    global $product;

    if ( ! $product ) {
        return;
    }

    $defaults = array(
        'posts_per_page' => 3,
        'columns'        => 3,
        'orderby'        => 'rand', // @codingStandardsIgnoreLine.
        'order'          => 'desc',
    );

    $args = wp_parse_args( $args, $defaults );

    // Get upsell products
    $related_products   = $product->get_upsell_ids(); 

    // Get other products by same Creator(s)
    $related_products   = $related_products + \Post2Post\getRelatedBooksByCreators( $product->get_id() ); 

    // If not enough products, get other products in same Product Category that's not Graphic Novels
    
    // Clean results
    $related_products   = array_unique( $related_products ); 
    $related_products   = array_slice( $related_products, 0, $args['posts_per_page'] );

    // Get visible related products then sort them at random.
    //$args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $related_products ) ), 'wc_products_array_filter_visible' );
    $args['related_products'] = array_filter( array_map( 'wc_get_product', $related_products ), 'wc_products_array_filter_visible' );

    // Handle orderby.
    $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

   

    // Set global loop values.
    wc_set_loop_prop( 'name', 'related' );
    wc_set_loop_prop( 'columns', apply_filters( 'woocommerce_related_products_columns', $args['columns'] ) );

    wc_get_template( 'single-product/related.php', $args );    
}

/**
 * Output Creator products.
 *
 * @param array $args Provided arguments.
 */
function spp_output_creator_products( $args = [] )
{

    global $post;

    $defaults = array(
        'posts_per_page' => -1,
        'columns'        => 3,
        'orderby'        => 'name', // @codingStandardsIgnoreLine.
        'order'          => 'desc',
    );

    $args = wp_parse_args( $args, $defaults );

    // Get Products by Creator Id
    $args['products']   = \Post2Post\getBooksByCreator( $post->ID );

    get_template_part( 'templates/single-creator/related', '', $args );

}

/**
 * Display alternative sources to read the book, including Kindle, Comixology, Comichaus
 * 
 */
function spp_single_product_alt_sources()
{
    global $post;

    $args   = [
        
    ];

    get_template_part( 'templates/product/alt-sources', '', $args );

}

/**
 * Process for sending and confirming VAT payment for EU orders
 * Process is:
 * - determine if order is going to the EU and,
 * - that Status is changing to Processing;
 * - initialise connection with Taxamo;
 * - store order;
 * - confirm order
 * [FIX] - add Refunds
 */
function spp_vat_process()
{
    if( 'shop_order' == $_POST['post_type'] && $_POST['original_post_status'] <> $_POST['order_status'] && $_POST['_shipping_country'] )
    {
        switch ( $_POST['order_status'] )
        {
            case 'wc-processing':
                // include Taxamo class
                include_once( CORE_INC . 'taxamo.class.php' );
                $taxamo = new \Taxamo;
                $taxamo->store();


                //exit( print_r( $_POST ) );
                break;
            case 'wc-refunded': //[FIX]

                break;
        }
    }
}

/**
 * Check Coupon against subcribed email address
 * 
 */
function spp_guest_email_checker()
{
    global $woocommerce;

    $list_id = '09555efb9c';

    // Check checkout email address against MC list, if exists proceed
    if ( \WCExtension\emailExistsMc( $_POST['billing_email'], $list_id ) ) 
    {

    } 
    else 
    {
      $woocommerce->add_error( __('This coupon is not valid') );
    }

}

/**
 * Retrieve emails on MC List
 * @param str billing email
 * @param str list id
 * @return bool 
 */
function emailExistsMc( $billing_email, $list_id )
{
    include CORE_VENDOR . 'mailchimp-api-master/src/MailChimp.php'; 
    //use \DrewM\MailChimp\MailChimp;
    $MailChimp = new MailChimp( MAILCHIMP_API_KEY );

    $subscriber_hash    = $MailChimp->subscriberHash( $billing_email );
    $result             = $MailChimp->get("lists/$list_id/members/$subscriber_hash");
    if( $result['status'] == 'subscribed' ) 
    {
        return TRUE;
    } 
    else 
    {
        return FALSE;
    }    
}