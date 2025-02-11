<?php

/**
 * Class Es_Search_Form_Shortcode.
 */
class Es_Property_Single_Gallery_Shortcode extends Es_Shortcode {

	/**
	 * Return search shortcode DOM.
	 *
	 * @return string|void
	 */
	public function get_content() {
		$atts = $this->get_attributes();
		$layout = $atts['layout'];
		$property_id = $atts['id'];

		if ( es_is_property( $property_id ) ) {
			ob_start();
			switch ( $layout ) {
				case 'single-tiled-gallery':
				case 'gallery':
					es_the_property_gallery( $property_id );
					es_the_mobile_slider( $property_id );
					break;

				case 'single-left-slider':
				case 'single-slider':
				case 'slider':
					es_the_property_slider( $property_id );
					es_the_mobile_slider( $property_id );
					break;
			}

			return apply_filters( 'es_property_single_gallery_content', ob_get_clean(), $atts );
		}
	}

	/**
	 * Return shortcode default attributes.
	 *
	 * @return array|void
	 */
	public function get_default_attributes() {
		return apply_filters( sprintf( '%s_default_attributes', 'property_single_gallery' ), array(
			'id' => get_the_ID(),
			'layout' => ests( 'single_layout' ),
		) );
	}

	/**
	 * @return string[]
	 */
	public static function get_shortcode_name() {
		return array( 'es_property_single_gallery', 'property_single_gallery' );
	}
}
