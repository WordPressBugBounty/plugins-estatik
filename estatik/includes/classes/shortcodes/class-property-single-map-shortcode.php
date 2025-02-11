<?php

/**
 * Class Es_Search_Form_Shortcode.
 */
class Es_Property_Single_Map_Shortcode extends Es_Shortcode {

	/**
	 * Return search shortcode DOM.
	 *
	 * @return string|void
	 */
	public function get_content() {
		$attr = $this->get_attributes();

		if ( es_is_property( $attr['id'] ) ) {
			$property = es_get_property( $attr['id'] );
			if ( $property->latitude && $property->longitude && ests( 'google_api_key' ) ) {
				$content = "<div class='es-property-map js-es-property-map'
                            data-latitude='" . esc_attr( $property->latitude ) . "'
                            data-longitude='" . esc_attr( $property->longitude ) . "'></div>";

				return apply_filters( 'es_property_single_map_content', $content, $attr );
			}
		}
	}

	/**
	 * Return shortcode default attributes.
	 *
	 * @return array|void
	 */
	public function get_default_attributes() {
		return apply_filters( sprintf( '%s_default_attributes', 'es_property_single_map' ), array(
			'id' => get_the_ID(),
		) );
	}

	/**
	 * @return array
	 */
	public static function get_shortcode_name() {
		return array( 'es_property_single_map', 'property_single_map' );
	}
}
