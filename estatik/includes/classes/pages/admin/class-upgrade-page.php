<?php

/**
 * Class Es_Upgrade_Page.
 */
class Es_Upgrade_Page {

    /**
     * Initialize settings page.
     *
     * @return void
     */
    public static function init() {
        // add_action( 'admin_menu', array( 'Es_Upgrade_Page', 'save_settings_handler' ) );

    }


    /**
     * Get product value by product ID.
     *
     * @param array $products
     * @param int   $product_id
     *
     * @return object|null
     */
    public static function get_product_data( $products, $product_id ) {

        if ( empty( $products ) ) {
            return null;
        }
    
        foreach ( $products as $item ) {
    
            if ( (int) $item->product === (int) $product_id ) {
                return $item;
            }
        }
    
        return null;
    }


    public static function es_products_timeout_extend() {
        return 120;
    }

    /**
     * Get estatik.net products
     *
     * @return bool|array
     */
    public static function get_products() {
        add_filter( 'http_request_timeout', array( 'Es_Upgrade_Page', 'es_products_timeout_extend' ) );

        $response = wp_remote_get( 'https://estatik.net/wp-json/wp/v2/pages/33571' );

        remove_filter( 'http_request_timeout', array( 'Es_Upgrade_Page', 'es_products_timeout_extend' ) );

        // Exit if error.
        if ( is_wp_error( $response ) ) {
            return false;
        }

        // Get the body.
        $data = json_decode( wp_remote_retrieve_body( $response ) );

        if ( ! empty( $data->acf ) ) {
            return $data->acf;
        }

        return array();
    }


    /**
     * @return array
     */
    public static function get_links() {
        return apply_filters( 'es_dashboard_get_links', array(
            'my-listings' => array(
                'name' => __( 'My listings', 'es' ),
                'url' => admin_url( 'edit.php?post_type=properties' ),
                'icon' => '<span class="es-icon es-icon_home es-icon--rounded es-icon--green"></span>',
            ),
            'settings' => array(
                'name' => __( 'Settings', 'es' ),
                'url' => admin_url( 'admin.php?page=es_settings' ),
                'icon' => '<span class="es-icon es-icon_settings es-icon--rounded es-icon--green"></span>',
            ),
        ) );
    }

    /**
     * @return array
     */
    public static function get_carousel_items() {
        return array(
            'estatik-native' => array(
                'link' => 'https://estatik.net/product/theme-native/',
                'name' => __( 'Native Theme', 'es' ),
                'demo_link' => 'http://native.estatik.net/',
                'image_url' => ES_PLUGIN_URL . 'admin/images/native.png',
                'free' => true,
            ),
            'estatik-trendy' => array(
                'link' => 'https://estatik.net/product/theme-trendy-estatik-pro/',
                'name' => __( 'Trendy Theme', 'es' ),
                'demo_link' => 'http://trendy.estatik.net/',
                'image_url' => ES_PLUGIN_URL . 'admin/images/portal.png',
            ),
        );
    }

    /**
     * @return array
     */
    public static function get_services() {
        return array(
            array(
                'link' => 'https://estatik.net/estatik-customization/',
                'text' => __( 'We can extend plugin features and customize it to meet your requirements. To get an estimate, just fill out the form and we will get back to you with a quote.', 'es' ),
                'title' => __( 'Custom Development', 'es' ),
            ),
            array(
                'link' => 'https://estatik.net/product/installation-setup/',
                'text' => __( 'If you are limited in time or just don’t feel like setting up the plugin yourself, our team is at your service. We can help set up your WordPress website to look like our plugin or theme demo websites.', 'es' ),
                'title' => __( 'Installation & Setup', 'es' ),
            ),
            array(
                'link' => 'https://estatik.net/product/estatik-premium-setup/',
                'text' => __( 'Installation, connection to MLS, and mapping MLS fields to Estatik for every property type (Residential, Commercial, Multifamily, Lease, LotsAndLand, etc.), setting up automatic import, and launching synchronization.', 'es' ),
                'title' => __( 'Premium MLS Setup (for Premium users only)', 'es' ),
            ),
        );
    }



    /**
     * Render page action.
     *
     * @return void
     */
    public static function render() {
        $f = es_framework_instance();
        $f->load_assets();
        wp_enqueue_script( 'es-slick' );
        wp_enqueue_script( 'es-admin' );


        es_load_template( 'admin/upgrade/index.php', array(
            // 'links' => static::get_links(),
            'data_products' => static::get_products(),
            // 'products' => static::get_carousel_items(),
            // 'services' => static::get_services(),

        ) );
    }
}
Es_Upgrade_Page::init();
