<?php
/**
 * The template for displaying creator image and name for Creators page
 *
 * @version 0.0.1
 */

defined( 'ABSPATH' ) || exit; ?>

<?php 
    $talents	= get_the_terms( get_the_ID(), 'creator_talent' ); 
    $featured   = get_post_meta( get_the_ID(), 'featured_creator', TRUE ); 
    ?>
        <div class="archive-creator--creator-detail">
            <?php
                if( $featured ): ?>
                    <div class="roundel">Featured</div>
            <?php endif; ?>
             <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( [300, 300] ); ?></a>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <?php if( count( $talents ) > 0 ): ?>
                <h3>
                    <?php 
                        foreach( $talents as $talent )
                        {
                            echo $talent->name . ' ';
                        }
                    ?>
                </h3>
                    <?php endif; ?>
        </div>