<?php

/**
 * Class Es_Multilingual
 */


class Es_Multilingual {

    protected static $instance;

    protected $domain = 'es';

    /**
     * Get singleton instance of the multilingual service.
     *
     * @return self
     */
    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Translate a string using Polylang, WPML, or default WordPress translation.
     *
     * @param string $string Original string.
     * @param string $name   Optional unique translation key (used for WPML).
     *
     * @return string
     */
    public function translate( $string, $name = '' ) {

        // Polylang
        if ( function_exists( 'pll__' ) ) {
            return pll__( $string );
        }

        // WPML
        if ( function_exists( 'icl_t' ) ) {
            return icl_t( 'Estatik', $name ?: $string, $string );
        }

        return __( $string, $this->domain );
    }

    /**
     * Register a dynamic string for translation in Polylang and WPML.
     *
     * @param string $name  Unique string identifier.
     * @param string $value String value to register.
     *
     * @return void
     */
    public function register( $name, $value ) {

        if ( empty( $value ) ) return;

        // Polylang
        if ( function_exists( 'pll_register_string' ) ) {
            pll_register_string( $name, $value );
        }

        // WPML
        if ( function_exists( 'icl_register_string' ) ) {
            icl_register_string( 'Estatik', $name, $value );
        }
    }
}
