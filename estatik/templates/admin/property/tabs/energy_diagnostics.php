<style>
    .es-field__ghg_emission_class, .es-field__epc {
        margin-bottom: 0 !important;
    }
</style>

<h3><?php _e( 'Energy Performance Certificate (EPC)', 'es' ); ?></h3>

<?php

/**
 * @var $id integer Section ID.
 * @var $this Es_Property_Fields_Meta_Box
 */

$fields_builder = es_get_fields_builder_instance();

es_property_field_render( 'epc_class' ); ?>

<h3><?php _e( 'Greenhouse Gas Emissions (GES)', 'es' ); ?></h3>

<?php
es_property_field_render( 'ges_class' );

if ( $fields = $fields_builder::get_tab_fields( $id ) ) : ?>
    <div class="es-field-row">
		<?php foreach ( $fields as $field_key => $field_config ) :
			if ( ! in_array( $field_key, Es_Property_Fields_Meta_Box::$static_fields ) ) : ?>
                <?php es_property_field_render( $field_key, $field_config ); ?>
			<?php endif; ?>
		<?php endforeach; ?>
    </div>
<?php endif;