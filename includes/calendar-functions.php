<?php
/**
 * Extends functionality for Event Calendar
 */
/**
 * Get Events in order
 */
namespace Calendar;


/**
 * Gets Events from CPT tribe_events
 * Where only 1 event is required, assumes this is for the Banner 
 * and checks if there's Featured event first
 * @param (int) qty - max number of events required
 * @return (object) res 
 * @todo make function more efficient
 */
function get_events( $qty = -1 )
{
    $meta_query[]   = [
        'key'       => '_EventEndDate',
        'value'     => date( 'Y-m-d H:i:s' ),
        'compare'   => '>='
    ];

    if( 1 == $qty )     // Single Event for Banner
    {
        $meta_query[] = [
            'key'   => '_tribe_featured',
            'value' => 1
        ];
    }
    
    $args   = [
        'post_type'         => 'tribe_events',
        'posts_per_page'    => $qty,
        'meta_query'        => $meta_query,
        'meta_key'          => '_EventStartDate',
        'orderby' => 'meta_value',
        'order' => 'ASC'
    ];

    $res    = new \WP_Query( $args );
    
    if( $res->found_posts  > 0 ) return $res;
    
    $meta_query = reset( $meta_query );
    
    $args   = [
        'post_type'         => 'tribe_events',
        'posts_per_page'    => $qty,
        'meta_query'        => $meta_query,
        'meta_key'          => '_EventStartDate',
        'orderby' => 'meta_value',
        'order' => 'ASC'
    ];
    
    return new \WP_Query( $args );    
}

function dateStr( $start, $end )
{
    $o  = date( 'j M Y', strtotime( $start ) );
    if( $end !== $start ) $o .= '<span> to </span>' . date( 'j M Y', strtotime( $end ) );
    return $o;
}

function dateStrShort( $start, $end )
{
    $o  = date( 'd-m-y', strtotime( $start ) );
    if( $end !== $start ) $o .= ' <span>-</span> ' . date( 'd-m-y', strtotime( $end ) );
    return $o;
}