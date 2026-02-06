<?php

defined( 'ABSPATH' ) || exit;

/**
 * Base abstract class for all custom Gutenberg blocks.
 *
 * Provides:
 * - Unified block name access
 * - Attribute normalization
 * - Safe shortcode building
 *
 */
abstract class Es_Block {

	/**
	 * Returns the Gutenberg block name (namespace/block).
	 *
	 * @return string
	 */
	abstract public function get_block_name(): string;

	/**
	 * Registers the block with WordPress.
	 *
	 * Must be implemented by child classes if needed.
	 *
	 * @return void
	 */
	public function register(): void {}

	/**
	 * Server-side render callback.
	 *
	 * @param array  $attributes Block attributes.
	 * @param string $content    Block content.
	 *
	 * @return string
	 */
	public function render( array $attributes = [], string $content = '' ): string {
		return '';
	}

	/**
	 * Normalize block attributes before rendering.
	 *
	 * - Converts booleans to "1"/"0"
	 * - Removes empty values
	 *
	 * @param array $attributes
	 *
	 * @return array
	 */
	protected function normalize_attributes( array $attributes ): array {

		$normalized = [];

		foreach ( $attributes as $key => $value ) {

			if ( $value === '' || $value === null ) {
				continue;
			}

			if ( is_bool( $value ) ) {
				$value = $value ? '1' : '0';
			}

			$normalized[ $key ] = $value;
		}

		return $normalized;
	}


}

