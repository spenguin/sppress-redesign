<?php
/**
 * Generate a carousel of Events
 */
function spp_events_carousel()
{
    require_once CORE_INC . 'calendar-functions.php';
    $events = \Calendar\get_events();
    //$events = spp_get_events();
    ob_start(); ?>
        <div class="spp_events">
            <div class="splide" data-splide='{"type":"loop","perPage":3,"perMove":1}'>
                <div class="splide__arrows">
                    <div class="splide__arrow splide__arrow--prev">
                        <i class="fas fa-angle-left"></i>
                    </div>
                    <div class="splide__arrow splide__arrow--next">
                        <i class="fas fa-angle-right"></i>
                    </div>
                </div>
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php
                        if( $events->have_posts() ): while( $events->have_posts() ): $events->the_post(); 
                            $start  = substr( get_post_meta( get_the_ID(), '_EventStartDate',TRUE ), 0, 10 );
                            $end    = substr( get_post_meta( get_the_ID(), '_EventEndDate',TRUE ), 0, 10 );
                        ?>
                            <li class="splide__slide">
                                <a href="<?php echo site_url(); ?>/event/<?php echo $events->post->post_name; ?>">
                                    <div class="sp_event_list-event">
                                        <div class="sp_event_list-event-date">
                                            <span><?php echo \Calendar\dateStr( $start, $end ); ?></span>
                                            <div class="sp_event_list-event-date_short"><?php echo \Calendar\dateStrShort( $start, $end ); ?></div>
                                        </div>
                                        <div class="sp_event_list-event-text">
                                            <h3><?php the_title(); ?></h3>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endwhile; endif; ?>                    
                    </ul>
                </div>
            </div>
        </div>
    <?php
    $o  = ob_get_clean();

    return $o;    

    
    return 'SPP Events Carousel';
}


/**
 * Get Events
 * @return array events
 */
function spp_get_events()
{
    $args   = [
        'post_type' => 'tribe_events',
    ];

    $query  = new WP_Query( $args );
    //$o      = [];
    if( $query->have_posts() )
    {
        return $query;
    }
        


    wp_reset_query();
}