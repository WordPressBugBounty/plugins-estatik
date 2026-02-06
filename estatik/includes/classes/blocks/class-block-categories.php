<?php

defined( 'ABSPATH' ) || exit;

/**
 * Registers a custom Gutenberg block category for Estatik blocks.
 *
 * This class is responsible solely for adding a new block category
 * to the Gutenberg editor. 
 * 
 */

final class Es_Block_Categories {

    /**
     * Bootstraps the block category registration.
     *
     * Hooks into 'block_categories_all', which is the canonical filter
     * for modifying Gutenberg block categories
     *
     * Should be called exactly once during plugin initialization.
     *
     * @return void
     */
    public static function register(): void {
        add_filter(
            'block_categories_all',
            [ __CLASS__, 'add_category' ],
            10,
            2
        );
    }

    /**
     * Adds the "Estatik Blocks" category to the list of block categories.
     *
     * The method first extracts all existing category slugs and performs
     * a strict check to avoid duplicate registration.
     *
     * @param array $categories List of registered block categories.
     * @param mixed $post       Current post being edited (can be null).
     *
     * @return array Modified list of block categories.
     */
    public static function add_category( array $categories, $post ): array {

        $slugs = wp_list_pluck( $categories, 'slug' );

        if ( in_array( 'es-blocks', $slugs, true ) ) {
            return $categories;
        }

        array_unshift( $categories, [
            'slug' => 'es-blocks',
            'title' => __( 'Estatik Blocks', 'es' ),
            'icon' => null,
        ] );

        return $categories;
    }
}

Es_Block_Categories::register();
