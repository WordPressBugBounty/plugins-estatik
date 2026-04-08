<?php


use Elementor\Controls_Manager;


/**
* Class Elementor_Es_Single_Map_Widget.
*/
class Elementor_Es_Single_Property_Map_Widget extends Elementor_Es_Base_Widget  {


   /**
    * Retrieve the widget name.
    *
    * @since 1.0.0
    *
    * @access public
    *
    * @return string Widget name.
    */
   public function get_name() {
       return 'es-single-property-map';
   }


   /**
    * Get widget icon.
    *
    * Retrieve the widget icon.
    *
    * @since 1.0.0
    * @access public
    *
    * @return string Widget icon.
    */
   public function get_icon() {
        return 'eicon-google-maps';
   }


   /**
    * @return array|string[]
    */
   public function get_categories() {
       return array( 'estatik-single-category' );
   }


   /**
    * Retrieve the widget title.
    *
    * @since 1.0.0
    *
    * @access public
    *
    * @return string Widget title.
    */
   public function get_title() {
       return _x( 'Estatik Single Property Map', 'widget name', 'es' );
   }


   /**
    * Register the widget controls.
    *
    * Adds different input fields to allow the user to change and customize the widget settings.
    *
    * @since 1.0.0
    *
    * @access protected
    */
    protected function register_controls() {

        $shortcode = es_get_shortcode_instance( 'es_property_single_map' );

        if ( ! $shortcode ) {
            return;
        }

        $attributes = $shortcode->get_default_attributes();


        $this->start_controls_section(
            'es_section_content',
            array( 'label' => _x( 'Content', 'Elementor widget section', 'es' ), )
        );

        $this->add_control( 'property_id', array(
            'label' => __( 'Property id (optional)', 'es' ),
            'type' => Controls_Manager::TEXT,
            'description' => __( 'By default, the widget uses the current post ID. Specify a custom ID to display data from a different post.', 'es' ),
        ) );

        $this->end_controls_section();

    }


    /**
    * Render the widget output on the frontend.
    *
    * Written in PHP and used to generate the final HTML.
    *
    * @param array $instance
    *
    * @since 1.0.0
    *
    * @access protected
    */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['property_id'] ) ) {
            $settings['id'] = $settings['property_id'];
        }

        $shortcode = es_get_shortcode_instance( 'es_property_single_map', $settings );

        echo $shortcode->get_content();
    }
}
