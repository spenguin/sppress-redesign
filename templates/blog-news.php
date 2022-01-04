<?php
/**
 * Blog and News Posts
 *
 *
 * @version     0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} 
extract( $args ); 

?>

	<section class="blog-and-news-posts">
        <?php 
            $first  = TRUE;
            foreach( $posts as $post ): 
                $image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large', true);
            ?>
                <div class="blog-preview-item">
                
                    <?php if( has_post_thumbnail() ){ ?>
                    
                        <div class="entry-thumb">
                            <a href="<?php the_permalink(); ?>">
                                <img alt="<?php the_title_attribute() ?>" title="<?php the_title( ); ?>" src="<?php echo esc_url( $image[0] ); ?>">
                            </a>
                        </div>
                            
                    <?php } ?>
                
                    <div class="blog-preview-info">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php if( $first ) { ?>
                            <div class="blog-preview_desc">
                                <?php echo esc_html(wp_trim_words( $post->post_content, 80)); ?>
                            </div>
                        <?php } ?>
                        <a class="blog-preview-btn" href="<?php the_permalink(); ?>"><?php esc_html_e('READ MORE','storevilla'); ?></a>
                    </div>
                    
                </div>
                
            <?php $first = FALSE; endforeach; ?>

	</section>