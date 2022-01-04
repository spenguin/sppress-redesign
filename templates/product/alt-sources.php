<?php
/**
 * Alternative sources to buy or read the book
 */

defined( 'ABSPATH' ) || exit;

$comixology	= get_post_meta( $post->ID, 'comixology', TRUE );
$comichaus	= get_post_meta( $post->ID, 'comichaus', TRUE );
$inkypen	= get_post_meta( $post->ID, 'inkypen', TRUE );
$kindle		= get_post_meta( $post->ID, 'kindle', TRUE );

?>
<div class="entry-summary_alt-sources">
    <?php if( $comixology || $comichaus || $inkypen || $kindle ): ?>
        <p>If you would prefer digital, <?php echo $post->post_title; ?> is available at the following places:</p>
        <?php if( $comixology ): ?>
            <div class="entry-summary_alt-sources_source">
                <a href="<?php echo $comixology; ?>" target="_blank"><img src="<?php echo CORE_TEMPLATE_URL; ?>/furniture/Comixology-btn.png" /></a>
            </div>
        <?php endif; ?>
        <?php if( $comichaus ): ?>
            <div class="entry-summary_alt-sources_source">
                <a href="<?php echo $comichaus; ?>" target="_blank"><img src="<?php echo CORE_TEMPLATE_URL; ?>/furniture/Comichaus-btn.png" /></a>
            </div>
        <?php endif; ?>   
        <?php if( $inkypen ): ?>
            <div class="entry-summary_alt-sources_source">
                <a href="https://www.inky-pen.com" target="_blank"><img src="<?php echo CORE_TEMPLATE_URL; ?>/furniture/InkyPen-btn.png" /></a>
            </div>
        <?php endif; ?> 
        <?php if( $kindle ): ?>
            <div class="entry-summary_alt-sources_source">
                <a href="<?php echo $kindle; ?>" target="_blank"><img src="<?php echo CORE_TEMPLATE_URL; ?>/furniture/Kindle-btn.png" /></a>
            </div>
        <?php endif; ?>   
    <?php endif; ?>       

</div>