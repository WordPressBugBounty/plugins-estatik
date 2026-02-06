<?php

defined( 'ABSPATH' ) || exit;

class Es_My_Listing_Block extends Es_Block {

    /**
     * Gutenberg block name.
     *
     * @return string
     */
    public function get_block_name(): string {
        return 'es/my-listing';
    }

    /**
     * Retrieve default attributes from shortcode.
     *
     * @return array
     */
    protected function get_default_data() {
        $instance = es_get_shortcode_instance( 'es_my_listing' );

        return $instance ? (array) $instance->get_default_attributes() : [];
    }

    protected function get_block_attributes(): array {
        $attributes = [
            // Layout / appearance
            'layout' => [
                'type' => 'string',
                'default' => 'grid-3',
            ],
            'padding' => [
                'type' => 'string',
                'default' => '',
            ],

            // Address search
            'address_placeholder' => [
                'type' => 'string',
                'default' => '',
            ],
            'is_address_search_enabled' => [
                'type' => 'boolean',
                'default' => true,
            ],

            // Search settings
            'enable_search' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'search_type' => [
                'type' => 'string',
                'default' => 'simple',
            ],
            'search_page_id' => [
                'type' => 'string',
                'default' => '',
            ],

            // Filters
            'is_main_filter_enabled' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'is_collapsed_filter_enabled' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'main_fields' => [
                'type' => 'string',
                'default' => 'price,es_type,bedrooms,bathrooms',
            ],
            'collapsed_fields' => [
                'type' => 'string',
                'default' => 'half_baths,es_amenity,area,lot_size,floors',
            ],
            'fields' => [
                'type' => 'string',
                'default' => 'price,es_category,es_type,es_rent_period,bedrooms,bathrooms,half_baths,es_amenity,es_feature,area,lot_size,floors',
            ],

            // AJAX / saved search
            'enable_ajax' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'enable_saved_search' => [
                'type' => 'boolean',
                'default' => true,
            ],

            // Listing UI
            'posts_per_page' => [
                'type' => 'string',
                'default' => 40,
            ],
            'disable_navbar' => [
                'type' => 'boolean',
                'default' => false,
            ],
            'show_sort' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'show_total' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'show_page_title' => [
                'type' => 'boolean',
                'default' => true,
            ],
            'show_layouts' => [
                'type' => 'boolean',
                'default' => true,
            ],

            // Map
            'map_show' => [
                'type' => 'boolean',
                'default' => true,
            ],

            // Pagination / meta
            'limit' => [
                'type' => 'string',
                'default' => '',
            ],
            'page_num' => [
                'type' => 'string',
                'default' => '',
            ],
            'page_title' => [
                'type' => 'string',
                'default' => '',
            ],

            'query_atts' => [
                'type' => 'object',
                'default' => [],
            ],

            'active_query_key' => [
                'type' => 'string',
                'default' => '',
            ],

        ];

        return apply_filters( 'es_block_my_listing_attributes', $attributes );
    }


    /**
     * Register block assets and block type.
     *
     * @return void
     */
    public function register(): void {
        $base_url = plugin_dir_url( __FILE__ );

        wp_register_script(
            'es-block-my-listing',
            $base_url . 'block.js',
            [ 'wp-blocks', 'wp-block-editor', 'wp-element', 'wp-components' ],
            '1.0.0',
            true
        );

        wp_localize_script(
            'es-block-my-listing',
            'ES_BLOCK_MY_LISTING',
            [
                'attributes' => $this->get_block_attributes(),
                'fields' => es_get_available_search_fields(),
                'taxonomies' => es_get_taxonomies_list(),
                'blockName' => $this->get_block_name(),
            ]
        );

        wp_register_style(
            'es-block-my-listing-editor',
            $base_url . 'editor.css',
            [],
            '1.0.0'
        );

        register_block_type(
            $this->get_block_name(),
            [
                'attributes' => $this->get_block_attributes(),
                'editor_script' => 'es-block-my-listing',
                'editor_style' => 'es-block-my-listing-editor',
                'render_callback' => [ $this, 'render' ],
            ]
        );
    }

    /**
     * Server-side render callback.
     *
     * Receives block attributes as-is.
     * Shortcode rendering will be implemented later.
     *
     * @param array $attributes
     * @return string
     */
    public function render( array $attributes = [], string $content = '' ): string {

        /** @var Es_My_Listing_Shortcode */

        // Normalize attributes
        $attributes = is_array( $attributes ) ? $attributes : [];

        // Lift query_atts to root level
        if ( ! empty( $attributes['query_atts'] ) && is_array( $attributes['query_atts'] ) ) {
            $attributes = array_replace( $attributes, $attributes['query_atts'] );

            unset( $attributes['query_atts'] );
        }

        $attributes = array_filter( $attributes, static fn ( $value ) => $value !== '' );

        $attributes = array_replace( $this->get_default_data(), $attributes );
        $shortcode = es_get_shortcode_instance( 'es_my_listing', $attributes );

        if ( ! $shortcode ) {
            return '';
        }

        return (string) $shortcode->get_content();
    }
}
