<?php

/**
 * @var $images array
 * @var $property_id int
 */

if ( is_array( $images ) && ! empty( $images ) ) : ?>
	<div id="es-mobile-gallery-popup" class="white-popup-block mfp-hide">
		<?php do_action( 'es_property_control', array(
			'show_sharing' => es_is_property( get_the_ID() ),
			'is_full' => true,
			'entity_id' => $property_id,
		) ); ?>
		<?php if ( is_array( $images ) && ! empty( $images ) ) : ?>
			<?php foreach ( $images as $attachment_id ) : ?>
				<?php echo wp_get_attachment_image( $attachment_id, 'medium' ); ?>
			<?php endforeach; ?>
		<?php else : ?>
            <img src="<?php echo es_get_the_featured_image_url( 'full', $property_id ) ; ?>" alt="<?php esc_attr( strip_tags( get_the_title() ) ); ?>"/>
		<?php endif; ?>
        <div style="text-align: center;">
            <a href="#" class="es-btn es-btn--secondary es-btn--small js-es-close-popup"><?php _e( 'Back to the listing', 'es' ); ?></a>
        </div>
	</div>
<?php endif;
