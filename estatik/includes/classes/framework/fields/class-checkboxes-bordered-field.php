<?php

/**
 * Class Es_Framework_Checkboxes_Bordered_Field.
 */
class Es_Framework_Checkboxes_Bordered_Field extends Es_Framework_Radio_Bordered_Field {

	/**
	 * @return array
	 */
	public function get_default_config() {
		$args = array(
			'attributes' => array(
				'multiple' => true,
			),
		);
		$default = parent::get_default_config();
		return es_parse_args( $args, $default );
	}

	/**
	 * @return string
	 */
	public function get_multi_field_type() {
		return 'checkbox';
	}
}
