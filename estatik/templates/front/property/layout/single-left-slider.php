<?php
$heading_tag = empty ( ests( 'heading_tag_posts_title' ) ) ? 'h1' : ests( 'heading_tag_posts_title' );
es_the_title( '<' . esc_html( $heading_tag ) . ' class="property-title heading-font" >', ' </' . esc_html( $heading_tag ) . '>' );
do_action( 'es_single_property_after_title', get_the_ID() ); ?>

<div class="es-single__address-container">
    <?php es_the_address( '<span class="es-address">', '</span>' ); ?>
    <?php es_load_template( 'front/property/partials/property-terms.php' ); ?>
</div>

<div class="es-single__left-slider">
    <?php $instance = es_get_shortcode_instance( 'property_single_gallery' );
    echo $instance->get_content(); ?>
    <div class="es-single__basic">
        <div class="es-singe__basic-inner">
            <?php if ( es_get_the_field( 'price' ) ) : ?>
                <div class="es-price-container">
                    <?php es_the_price(); es_the_field( 'price_note', '<span class="es-badge es-price-badge es-badge--normal">', '</span>' ); ?>
                </div>
            <?php endif;

            es_load_template( 'front/property/partials/property-meta.php', array(
                'use_icons' => true,
            ) ); ?>
        </div>

        <div class="es-control-wrap">
	        <?php do_action( 'es_property_control', array(
		        'show_sharing' => true,
		        'is_full' => false,
		        'icon_size' => 'big'
	        ) ) ; ?>

	        <?php if ( es_is_request_form_active() && ! ests( 'is_request_form_button_disabled' ) ) : ?>
                <a href="#request_form" class="es-btn--request-info es-btn es-btn--primary js-es-scroll-to"><?php _e( 'Request info', 'es' ); ?></a>
	        <?php endif; ?>
        </div>
    </div>
</div>
