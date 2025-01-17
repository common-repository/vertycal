<?php
/**
 * The template part for displaying single posts content
 *
 * @package VertyCal
 * @subpackage vertycal/templates/single-vertycal_content
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	
	</header>

	<div class="vrctl-entry-content">
		<div class="vrtcl-content">
		<?php /* Post content displays before custom content 
		    */ ?>
			<span class="vrtclcontent">
	
				<?php the_content(); ?>
	
			</span>
		</div>

		<?php 
				   $digitz   = 0;
				   $post_id  = get_the_ID();
		$vertycal_date_time  = get_post_meta(get_the_ID(),'vertycal_date_time_meta',true);
		$vertycal_just_time  = get_post_meta(get_the_ID(),'vertycal_just_time_meta',true);
		$vertycal_date_time  = substr( $vertycal_date_time, $digitz );
		$vertycal_location   = vertycal_get_address( $post_id );
		$vertycal_telephone  = vertycal_get_telephone( $post_id );
		?>

        <div class="single-vrtcl-inner">
            <h3 class="inner-date-time">
            <?php printf( '<span class="vrtcl-daytime"><strong>%s </strong> %s</span>',
                        esc_attr( $vertycal_date_time ),
						esc_attr( $vertycal_just_time ) 
						); ?></h3>
           
                <div class="vrtcl_excerpt vertycal_single">
                        <span class="vrtclcontent">

                            <?php the_excerpt(); ?>
                        
						</span>
                </div>
					
        </div>

	</div><!-- .vrtcl-entry-content -->

	<footer class="entry-footer">
	<address>

		<?php if( $vertycal_location != '' ) : ?>

		<p><a href="http://maps.google.com/?q=<?php print( $vertycal_location ); ?>" 
			  title="<?php print( vertycal_get_address( $post_id ) ); ?>" 
			  target="_blank">
		<span class="maybemap"></span> 
		<?php print( vertycal_get_address($post_id)); ?></a></p>

		<?php endif; ?>

		<?php if( $vertycal_telephone != '' ) : ?>

		<p id="telDial"><a href="tel:<?php print( vertycal_get_telephone($post_id)); ?>"
		   				   title="<?php print( vertycal_get_telephone($post_id) ); ?>" 
						   target="_blank">
					<span class="maybetel"></span> 
					<?php print( vertycal_get_telephone( $post_id )); ?></a></p>
	
		<?php endif; ?>

	</address><div class="vrtclclearfix"></div>

	<div class="vrtcl-footer-markdone">

	<?php //check for mark_done option set 
	if( function_exists( 'vertycal_state_checkbox_markdone' ) ) : 
		$vertycal_markdone = '';
		$vertycal_markdone = vertycal_state_checkbox_markdone();
		if ( true === $vertycal_markdone )
		{ 
		/* 
		 * If title is set and post is submitted ~ send mail */	
		if( isset( $_POST['vmarkdone'] ) ) : 

		    include_once 'vertycal-email-html.php';
		endif;
		?>
		<?php $user_email = get_the_author_meta('user_email');
			  $user_dname = get_the_author_meta('display_name'); ?>

		<form class="mark-done" name="vrtcl_markdone" method="post" action="">
		<input id="vmarkdone"   name="vmarkdone" 
			   type="submit"    
			   title="<?php esc_attr_e( 'Mark complete', 'vertycal' ); ?>"
			   value="<?php esc_attr_e( 'fulfill', 'vertycal' ); ?>">
		<input type="hidden"    name="user_dname" 
			   value="<?php echo esc_attr( $user_dname ); ?>">
		<input type="hidden"    name="vertycal_postid" 
			   value="<?php echo esc_attr($post_id); ?>">
		<input type="hidden"    name="vertycal_from" 
			   value="<?php echo sanitize_email( $user_email ); ?>">

		<?php //$action, $name, $referer, $echo
		wp_nonce_field( 'vertycal_markdone_nonce', 'vertycal-markdone-nonce', true, true ) ?>

		<label for="vertycal_markdone"><input type="checkbox" name="vertycal_markdone" 
				value="" class="vrtcl-checkbox" required aria-required="true"> 
		<?php esc_html_e( 'I Attest to Marking Updated Status.', 'vertycal' ); ?></label>
		</form>

		<?php //ends form being used 
		} 
	endif;
		?>

	</div>
		<p><span class="author-single"><?php the_author_meta( 'display_name' ); ?>
		<span class="vrtcl-returnto"><button onclick="javascript:history.back()" 
			  title="<?php esc_attr_e( 'back one page please', 'vertycal' ); ?>">
		<?php esc_html_e( 'Back to Scheduler', 'vertycal' ); ?></button> </span></span></p>					
		<p><?php 
		edit_post_link( 
			sprintf(
				/* translators: %s: Name of current post */
				__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'vertycal' ),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
		?></p>
		<aside class="single-categories">
			
			<?php echo trim( vertycal_tmplt_single_taxonomy() ); ?>
		
		</aside>

	</footer>
</article>
