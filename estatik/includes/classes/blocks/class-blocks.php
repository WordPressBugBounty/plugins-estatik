<?php

defined( 'ABSPATH' ) || exit;

/**
 * Handles discovery, instantiation, and registration of Gutenberg blocks.
 *
 * This class is responsible for:
 * - Loading block class files
 * - Instantiating non-abstract block classes
 * - Registering blocks at the appropriate WordPress lifecycle stage
 * - Enqueuing shared editor and frontend assets
 *
 * Acts as a single entry point for all custom blocks.
 */
final class Es_Blocks_List {

    /**
     * Holds instantiated block objects.
     *
     * @var Es_Block[]
     */
    private static array $blocks = [];

    /**
     * Bootstrap the blocks system.
     *
     * @return void
     */
    public static function init(): void {

        static::load_blocks();
        static::register_hooks();
    }

    /**
     * Register WordPress hooks related to blocks.
     *
     * @return void
     */
    private static function register_hooks(): void {

        // Shared styles (editor + frontend).
        add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_shared_styles' ] );
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_shared_styles' ] );

        // Editor-only assets.
        add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_editor_scripts' ] );
        add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_editor_assets' ], 50 );
    }

    /**
     * Load block class files, instantiate blocks, and schedule their registration.
     *
     * - Allows filtering the block list via 'es_blocks_list_files'
     * - Ensures files are included only once
     * - Prevents instantiation of abstract classes
     * - Automatically hooks block registration into 'init'
     *
     * @return void
     */
    private static function load_blocks(): void {

        $base_path = ES_PLUGIN_CLASSES . 'blocks';

        $blocks = apply_filters( 'es_blocks_list_files', [
            'Es_Block' => $base_path . '/default-block/class-es-block.php',
            'Es_My_Listing_Block' => $base_path . '/my-listing-block/class-my-listing-block.php',
        ] );

        foreach ( $blocks as $class_name => $file_path ) {

            if ( ! file_exists( $file_path ) ) {
                continue;
            }

            if ( ! class_exists( $class_name ) ) {
                require_once $file_path;
            }

            if ( ! class_exists( $class_name ) ) {
                continue;
            }

            $reflection = new ReflectionClass( $class_name );

            if ( $reflection->isAbstract() ) {
                continue;
            }

            $instance = new $class_name();

            self::$blocks[ $class_name ] = $instance;

            if ( method_exists( $instance, 'register' ) ) {
                add_action( 'init', [ $instance, 'register' ] );
            }
        }
    }

    /**
     * Enqueue shared styles used by all custom blocks.
     *
     * These styles are loaded both in the editor and on the frontend.
     *
     * @return void
     */
    public static function enqueue_shared_styles(): void {
        // Reserved for future shared block styles.
    }

    /**
     * Enqueue editor-only styles and assets for custom blocks.
     *
     * @return void
     */
    public static function enqueue_editor_assets(): void {
        // Reserved for editor-only block assets.
    }

    /**
     * Enqueue shared editor scripts used across multiple blocks.
     *
     * @return void
     */
    public static function enqueue_editor_scripts(): void {
    }
}

Es_Blocks_List::init();