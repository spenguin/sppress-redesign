<?php

namespace Post2Post;

initialise();

function initialise()
{
    add_action( 'p2p_init', '\Post2Post\my_connection_types' );
}

function my_connection_types()
{
    p2p_register_connection_type( array(
        'name' => 'event_to_creator',
        'from' => 'tribe_events',
        'to' => 'creator'
    ) );
    p2p_register_connection_type( array(
        'name' => 'product_to_creator',
        'from' => 'product',
        'to' => 'creator'
    ) );  
    /*p2p_register_connection_type( array(
        'name'  => 'flipbook_to_creator',
        'from'  => 'flipbook',
        'to'    => 'creator'
    ) );  */
}

function getBooksByCreator( $postId, $available=TRUE )
{   
    global $wpdb;
    $_sql   = "SELECT * FROM {$wpdb->prefix}posts WHERE ID in (SELECT p2p_from FROM {$wpdb->prefix}p2p WHERE p2p_to = {$postId})"; 
    if( $available ) $_sql .= " AND post_status = 'publish'";
    
    $_res   = $wpdb->get_results( $_sql, OBJECT );
    $o      = array();
    foreach( $_res as $r )
    {
        $custom = get_post_custom( $r->ID ); 
        if( 'outofstock' == $custom['_stock_status'][0] ) continue;
        $o[$r->ID]    = $r;
    } 
    return $o;
}

/**
 *  Get all creators for any given book
 *  @param (int) product Id
 *  @return (array) creators
 */
function getCreatorsByBook( $postId )
{   
    global $wpdb;
    $postId = (array) $postId;

    $_sql   = "SELECT * FROM {$wpdb->prefix}posts WHERE ID in (SELECT p2p_to FROM {$wpdb->prefix}p2p WHERE p2p_from in (" . join( ',', $postId ) . "))"; //var_dump( $_sql );
    $_res   = $wpdb->get_results( $_sql, OBJECT );
    $o      = array();
    foreach( $_res as $r )
    {
        $o[$r->ID]    = $r;
    }
    return $o;    
}

function render_creators( $postId )
{   
    $creators   = \Post2Post\getCreatorsByBook( $postId ); //var_dump( $creators );

    $o          = [];
    foreach( $creators as $c )
    {
        $o[]    = "<a href='" . site_url() . "/creator/{$c->post_name}'>{$c->post_title}</a>";
    }
    
    return join( ', ', $o );
}

/**
 * Get all Books by Creators of provided book
 * @param int $product_id
 * @return array $product_list
 */
function getRelatedBooksByCreators( $product_id )
{
    $creators	= \Post2Post\getCreatorsByBook( $product_id );
    $o  = [];
    foreach( $creators as $c )
    {
        $books  = \Post2Post\getBooksByCreator( $c->ID );
        foreach( $books as $b )
        {
            $o[]    = $b->ID;
        }
    }
    $o  = array_unique( $o );
    $o  = array_diff( $o, [$product_id] );
    return $o;
}