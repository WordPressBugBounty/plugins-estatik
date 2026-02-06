<?php
/**
 * @var $energy_class
 * @var $field
 */
?>
<div class="es-epc-ges-light es-epc-ges-light--<?php esc_attr_e( $field ); ?>">
	<?php foreach ( es_get_dpe_options() as $key => $_class ) : ?>
		<div class="es-epc-ges-light__item es-epc-ges-light__item--<?php echo esc_attr( $key );
        es_active_class( $_class, $energy_class, 'es-epc-ges-light__item--active' ); ?>">
            <?php esc_html_e( $_class ); ?>
        </div>
	<?php endforeach; ?>
</div>
