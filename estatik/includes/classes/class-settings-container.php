<?php

/**
 * Class Es_Settings_Container.
 *
 * @property string $language
 * @property string $country
 * @property string $country_icons
 * @property string $currency
 * @property string $currency_sign
 * @property string $currency_sup
 * @property string $currency_dec
 * @property string $currency_position
 * @property string $lot_size_unit
 * @property string $area_unit
 * @property string $date_format
 * @property string $main_color
 * @property string $map_cluster_color
 * @property integer $property_item_carousel_images_num
 * @property string $secondary_color
 * @property string $default_label_color
 * @property string $headings_font
 * @property string $content_font
 * @property string $excerpt_length
 * @property string $time_format
 * @property string $google_api_key
 * @property string $recaptcha_site_key
 * @property string $recaptcha_secret_key
 * @property string $recaptcha_version
 * @property string $post_type_name
 * @property string $single_layout
 * @property string $listings_layout
 * @property string $properties_default_sorting_option
 * @property string $title_mode
 * @property string $login_title
 * @property string $login_subtitle
 * @property string $buyer_register_title
 * @property string $buyer_register_subtitle
 * @property string $min_prices_list
 * @property string $max_prices_list
 * @property string $search_half_baths_list
 * @property string $search_bedrooms_list
 * @property string $search_bathrooms_list
 * @property string $search_min_bedrooms_list
 * @property string $search_max_bedrooms_list
 * @property string $search_max_bathrooms_list
 * @property string $search_min_bathrooms_list
 * @property string $property_slug
 * @property string $category_slug
 * @property string $type_slug
 * @property string $city_slug
 * @property string $state_slug
 * @property string $tag_slug
 * @property string $facebook_app_id
 * @property string $facebook_app_secret
 * @property string $google_client_key
 * @property string $google_client_secret
 * @property string $terms_input_type
 * @property string $map_cluster_icon
 * @property string $map_marker_icon
 * @property string $map_marker_type
 * @property string $map_marker_color
 * @property string $term_icon_type
 * @property string $default_lat_lng
 * @property string $dynamic_content
 *
 * @property string $search_es_category_field_mode
 * @property string $search_es_type_field_mode
 * @property string $search_es_status_field_mode
 * @property string $search_es_rent_period_field_mode
 * @property string $search_min_area_list
 * @property string $search_max_area_list
 * @property string $search_min_lot_size_list
 * @property string $search_max_lot_size_list
 *
 * @property string $new_user_info_email_content
 * @property string $new_user_info_email_subject
 *
 * @property integer $default_property_image_id
 * @property integer $is_address_components_clickable
 * @property integer $is_clusters_enabled
 * @property integer $is_layout_switcher_enabled
 * @property integer $is_while_label_enabled
 * @property integer $is_properties_sorting_enabled
 * @property integer $is_price_enabled
 * @property integer $is_properties_wishlist_enabled
 * @property integer $is_listing_address_enabled
 * @property integer $is_labels_enabled
 * @property integer $is_properties_sharing_enabled
 * @property integer $is_single_listing_map_enabled
 * @property integer $is_date_added_enabled
 * @property integer $is_login_form_enabled
 * @property integer $is_login_facebook_enabled
 * @property integer $is_login_google_enabled
 * @property integer $is_update_search_results_enabled
 * @property integer $is_locations_autocomplete_enabled
 * @property integer $is_properties_archive_enabled
 * @property integer $is_search_bathrooms_range_enabled
 * @property integer $is_search_bedrooms_range_enabled
 * @property integer $is_amenities_collapse_enabled
 * @property integer $is_features_collapse_enabled
 * @property integer $is_social_sharing_enabled
 * @property integer $is_link_sharing_enabled
 * @property integer $is_pdf_enabled
 * @property integer is_single_agent_block_enabled
 * @property integer $is_agent_listings_quantity_views_enabled
 * @property integer $is_agent_listings_quantity_savings_enabled
 * @property integer $is_buyers_register_enabled
 * @property integer $is_agents_register_enabled
 * @property integer $is_geolocation_search_enabled
 * @property integer $is_same_price_for_categories_enabled
 * @property integer $is_single_map_marker_enabled
 * @property integer $is_terms_icons_enabled
 * @property integer $is_auto_tags_enabled
 * @property integer $is_clickable_tags_enabled
 * @property integer $is_dynamic_content_enabled
 * @property integer $is_lightbox_disabled
 * @property integer $is_download_font
 * @property integer $is_default_archive_template_enabled
 * @property integer $is_property_carousel_enabled
 *
 * @property integer $map_zoom
 * @property integer $properties_per_page
 * @property integer $wishlist_properties_per_page
 * @property integer $login_page_id
 * @property integer $profile_page_id
 * @property integer $map_search_page_id
 * @property integer $search_results_page_id
 * @property integer $reset_password_page_id
 * @property integer $buyer_register_page_id
 * @property integer $agent_register_page_id
 * @property integer $terms_conditions_page_id
 * @property integer $privacy_policy_page_id
 * @property integer $logo_attachment_id
 * @property integer $search_min_floor
 * @property integer $search_max_floor
 * @property integer search_min_floor_level
 * @property integer search_max_floor_level
 * @property integer $listings_offset_corrector
 *
 * @property array $map_markers_list
 * @property array $properties_sorting_options
 * @property array $custom_prices_list
 * @property array $social_networks
 * @property array $fb_property_deleted_fields
 * @property array $fb_property_deleted_sections
 * @property array $recaptcha_forms
 * @property array $responsive_breakpoints
 * @property array $terms_forms
 */
class Es_Settings_Container
{
	/**
	 * Prefix for settings. Example {SETTING_PREFIX}powered_by_link.
	 */
	const OPTIONS_CONTAINER_NAME = 'es_options';
	const FORCE_SETTINGS = true;

	/**
	 * @var array $options
	 */
	public static $options = array();

	/**
	 * @var array
	 */
	public static $settings_list;

	/**
	 * Es_Settings_Container constructor.
	 *
	 * @param bool $force_load
	 */
	public function __construct( $force_load = false ) {
		if ( empty( static::$options ) || $force_load ) {
			$this->load_options();
		}
	}

	/**
	 * @param $name
	 *
	 * @return mixed|void
	 */
	public function get_selected_options( $name ) {
		$options = $this->{$name};
		$result = array();

		if ( ! empty( $options ) && is_array( $options ) ) {
			$labels = $this::get_available_values( $name );

			foreach ( $options as $option ) {
				if ( ! empty( $labels[ $option ] ) ) {
					$result[ $option ] = $labels[ $option ];
				}
			}
		}

		return apply_filters( 'es_settings_selected_options', $result, $name );
	}

	/**
	 * Load options.
	 */
	public function load_options() {
		static::$options = get_option( static::OPTIONS_CONTAINER_NAME, array() );
	}

	/**
	 * Return list of available settings.
	 *
	 * @return array|mixed
	 */
	public static function get_available_settings( $force = false ) {

		$dimensions = apply_filters( 'es_settings_dimensions', array(
			'sq_ft'    => __( 'sq ft', 'es' ),
			'sq_m'     => __( 'm²', 'es' ),
			'acres'    => __( 'acres', 'es' ),
			'hectares' => __( 'hectares', 'es' ),
			'm3'       => __( 'm³', 'es' ),
		) );

		$sorting_options = apply_filters( 'es_settings_sorting_options', array(
			'newest' => __( 'Newest', 'es' ),
			'lowest_price' => __( 'Lowest price', 'es' ),
			'highest_price' => __( 'Highest price', 'es' ),
			'largest_sq_ft' => __( 'Largest sq ft', 'es' ),
			'lowest_sq_ft' => __( 'Lowest sq ft', 'es' ), 
			'bedrooms' => __( 'Bedrooms', 'es' ),
			'bathrooms' => __( 'Bathrooms', 'es' ),
			'oldest' => __( 'Oldest', 'es' ),
		) );

		$default_sorting_options = $sorting_options;
		unset( $default_sorting_options['oldest'] );

		if ( ! static::$settings_list || $force ) {
			static::$settings_list = array(

				'address_search_placeholder' => array(
					'default_value' => __( 'Address, City, ZIP', 'es' ),
				),

				'country' => array(
					'default_value' => 'US',
					'values' => array(
						'US' => __( 'USA', 'es' ),
						'CA' => __( 'Canada', 'es' ),
						'FR' => __( 'France', 'es' ),
						'DE' => __( 'Germany', 'es' ),
						'GB' => __( 'Great Britain', 'es' ),
						'ES' => __( 'Spain', 'es' ),
						'AU' => __( 'Australia', 'es' ),
						'AT' => __( 'Austria', 'es' ),
						'BE' => __( 'Belgium', 'es' ),
						'CL' => __( 'Chile', 'es' ),
						'CY' => __( 'Cyprus', 'es' ),
						'CZ' => __( 'Czech Republic', 'es' ),
						'DK' => __( 'Denmark', 'es' ),
						'EG' => __( 'Egypt', 'es' ),
						'FI' => __( 'Finland', 'es' ),
						'GE' => __( 'Georgia', 'es' ),
						'GR' => __( 'Greece', 'es' ),
						'IL' => __( 'Israel', 'es' ),
						'LV' => __( 'Latvia', 'es' ),
						'LT' => __( 'Lithuania', 'es' ),
						'MC' => __( 'Monaco', 'es' ),
						'NL' => __( 'Netherlands', 'es' ),
						'PH' => __( 'Philippines', 'es' ),
						'PL' => __( 'Poland', 'es' ),
						'PT' => __( 'Portugal', 'es' ),
						'SE' => __( 'Sweden', 'es' ),
						'IT' => __( 'Italy', 'es' ),
						'ZA' => __( 'South Africa', 'es' ),

						'' => __( 'Other', 'es' ),
					),
				),

				'country_icons' => array(
					'default_value' => 'US',
					'values' => array(
						'US' => ES_PLUGIN_URL . '/public/img/flags/united-states-of-america-flag.svg',
						'CA' => ES_PLUGIN_URL . '/public/img/flags/canada-flag.svg',
						'GB' => ES_PLUGIN_URL . '/public/img/flags/united-kingdom-flag.svg',
						'PL' => ES_PLUGIN_URL . '/public/img/flags/poland-flag.svg',
						'DE' => ES_PLUGIN_URL . '/public/img/flags/germany-flag.svg',
						'ES' => ES_PLUGIN_URL . '/public/img/flags/spain-flag.svg',
						'FR' => ES_PLUGIN_URL . '/public/img/flags/france-flag.svg',
						//new
						'AU' => ES_PLUGIN_URL . '/public/img/flags/australia-flag.svg',
						'AT' => ES_PLUGIN_URL . '/public/img/flags/austria-flag.svg',
						'BE' => ES_PLUGIN_URL . '/public/img/flags/belgium-flag.svg',
						'CL' => ES_PLUGIN_URL . '/public/img/flags/chile-flag.svg',
						'CY' => ES_PLUGIN_URL . '/public/img/flags/cyprus-flag.svg',
						'CZ' => ES_PLUGIN_URL . '/public/img/flags/czech-republic-flag.svg',
						'DK' => ES_PLUGIN_URL . '/public/img/flags/denmark-flag.svg',
						'EG' => ES_PLUGIN_URL . '/public/img/flags/egypt-flag.svg',
						'FI' => ES_PLUGIN_URL . '/public/img/flags/finland-flag.svg',
						'GE' => ES_PLUGIN_URL . '/public/img/flags/georgia-flag.svg',
						'GR' => ES_PLUGIN_URL . '/public/img/flags/greece-flag.svg',
						'IL' => ES_PLUGIN_URL . '/public/img/flags/israel-flag.svg',
						'LV' => ES_PLUGIN_URL . '/public/img/flags/latvia-flag.svg',
						'LT' => ES_PLUGIN_URL . '/public/img/flags/lithuania-flag.svg',
						'MC' => ES_PLUGIN_URL . '/public/img/flags/monaco-flag.svg',
						'NL' => ES_PLUGIN_URL . '/public/img/flags/netherlands-flag.svg',
						'PH' => ES_PLUGIN_URL . '/public/img/flags/philippines-flag.svg',
						'PT' => ES_PLUGIN_URL . '/public/img/flags/portugal-flag.svg',
						'SE' => ES_PLUGIN_URL . '/public/img/flags/sweden-flag.svg',
						'IT' => ES_PLUGIN_URL . '/public/img/flags/italy-flag.svg',
						'ZA' => ES_PLUGIN_URL . '/public/img/flags/south-africa-flag.svg', 
					),
				),

				'phone_codes' => array(
					'default_value' => 'US',
					'values' => array(
						'US' => '+1',
						'CA' => '+1',
						'GB' => '+44',
						'PL' => '+48',
						'DE' => '+49',
						'ES' => '+34',
						'FR' => '+33',
						//new
						'AU' => '+61',
						'AT' => '+43',
						'BE' => '+32',
						'CL' => '+56',
						'CY' => '+357',
						'CZ' => '+420',
						'DK' => '+45',
						'EG' => '+20',
						'GE' => '+995',
						'GR' => '+30',															
						'IL' => '+972',
						'LV' => '+371',
						'LT' => '+370',
						'MC' => '+377',
						'NL' => '+31',
						'PH' => '+63',
						'PT' => '+351',
						'SE' => '+46',
						'IT' => '+39',
						'ZA' => '+27',
						'' => '',
					),
				),

				'fb_property_deleted_fields' => array(
					'default_value' => array(),
				),

				'fb_property_deleted_sections' => array(
					'default_value' => array(),
				),

				'language' => array(
					'default_value' => get_locale(),
				),

				'country_settings' => array(
					'values' => array(
						'US' => array(
							'language' => 'en_US',
							'language_label' => __( 'English (USA)', 'es' ),
							'date_format' => 'm/d/y',
							'area_unit' => 'sq_ft',
							'lot_size_unit' => 'sq_ft',
							'currency' => 'USD',
							'currency_sign' => 'USD',
							'currency_sup' => ',',
							'currency_dec' => '.',
						),

						'CA' => array(
							'language' => 'en_CA',
							'language_label' => __( 'English (CAD)', 'es' ),
							'date_format' => 'm/d/y',
							'area_unit' => 'sq_ft',
							'lot_size_unit' => 'sq_ft',
							'currency' => 'CAD',
							'currency_sign' => 'CAD',
							'currency_sup' => ',',
							'currency_dec' => '.',
						),

						'GB' => array(
							'language' => 'en_GB',
							'language_label' => __( 'English (GB)', 'es' ),
							'date_format' => 'd/m/y',
							'area_unit' => 'sq_ft',
							'lot_size_unit' => 'sq_ft',
							'currency' => 'GBP',
							'currency_sign' => 'GBP',
							'currency_sup' => ',',
							'currency_dec' => '',
						),

						'DE' => array(
							'language' => 'de_DE',
							'language_label' => __( 'German', 'es' ),
							'date_format' => 'd/m/y',
							'area_unit' => 'sq_m',
							'lot_size_unit' => 'hectares',
							'currency' => 'EUR',
							'currency_sign' => 'EUR',
							'currency_sup' => '.',
							'currency_dec' => ',',
						),

						'ES' => array(
							'language' => 'es_ES',
							'language_label' => __( 'Spanish', 'es' ),
							'date_format' => 'd/m/y',
							'area_unit' => 'sq_m',
							'lot_size_unit' => 'sq_m',
							'currency' => 'EUR',
							'currency_sign' => 'EUR',
							'currency_sup' => ',',
							'currency_dec' => '.',
						),

						'FR' => array(
							'language_label' => __( 'French (France)', 'es' ),
							'language' => 'fr_FR',
							'date_format' => 'd/m/y',
							'area_unit' => 'sq_m',
							'lot_size_unit' => 'sq_m',
							'currency' => 'EUR',
							'currency_sign' => 'EUR',
							'currency_sup' => ',',
							'currency_dec' => '.',
						),
					)
				),

				'area_unit' => array(
					'default_value' => 'sq_ft',
					'values' => $dimensions,
				),

				'lot_size_unit' => array(
					'default_value' => 'sq_ft',
					'values' => $dimensions,
				),

				'login_page_id' => array(),
				'profile_page_id' => array(),
				'map_search_page_id' => array(),
				'reset_password_page_id' => array(),
				'buyer_register_page_id' => array(),
				'agent_register_page_id' => array(),
				'search_results_page_id' => array(),

				'terms_conditions_page_id' => array(),
				'privacy_policy_page_id' => array(),

				'buyer_register_title' => array(
					'default_value' => __( 'Get started with your account', 'es' ),
				),

				'buyer_register_subtitle' => array(
					'default_value' => __( 'to save your favourite homes and more', 'es' ),
				),

				'headings_font' => array(
					'default_value' => 'Lato',
				),

				'content_font' => array(
					'default_value' => 'Open Sans',
				),

				'agent_register_title' => array(
					'default_value' => __( 'Create an agent account', 'es' ),
				),

				'agent_register_subtitle' => array(
					'default_value' => __( 'Manage your listings, profile and more', 'es' ),
				),

				'login_title' => array(
					'default_value' => __( 'Sign in or register', 'es' ),
				),

				'property_slug' => array(
					'default_value' => 'property',
				),

				'facebook_app_id' => array(),
				'facebook_app_secret' => array(),

				'google_client_key' => array(),
				'google_client_secret' => array(),

				'category_slug' => array(
					'default_value' => 'property-category',
				),

				'tag_slug' => array(
					'default_value' => 'property-tag',
				),

				'type_slug' => array(
					'default_value' => 'property-type',
				),

				'label_slug' => array(
					'default_value' => 'es_label',
				),

				'amenity_slug' => array(
					'default_value' => 'es_amenity',
				),

				'basement_slug' => array(
					'default_value' => 'es_basement',
				),

				'rent_period_slug' => array(
					'default_value' => 'rent-period',
				),

				'parking_slug' => array(
					'default_value' => 'parking',
				),

				'roof_slug' => array(
					'default_value' => 'roof',
				),

				'exterior_material_slug' => array(
					'default_value' => 'exterior-material',
				),

				'feature_slug' => array(
					'default_value' => 'es_feature',
				),

				'floor_covering_slug' => array(
					'default_value' => 'floor-covering',
				),

				'status_slug' => array(
					'default_value' => 'es_status',
				),

				'neighborhood_slug' => array(
					'default_value' => 'es_neighborhood',
				),

				'city_slug' => array(
					'default_value' => 'property-city',
				),

				'state_slug' => array(
					'default_value' => 'property-state',
				),

				'property_item_image_size' => array(
					'default_value' => 'large',
				),

				'login_subtitle' => array(
					'default_value' => __( 'to save your favourite homes and more', 'es' ),
				),

				'term_icon_type' => array(
					'default_value' => 'check',
					'values' => array(
						'check' => __( 'Check marks', 'es' ),
						'icon' => __( 'Icons', 'es' ),
					),
				),

				'map_marker_type' => array(
					'default_value' => 'icon',
					'values' => array(
						'icon' => __( 'Icon', 'es' ),
						'price' => __( 'Price', 'es' ),
					),
				),

				'currency_sign' => array(
					'default_value' => 'USD',
					'values' => array(
						'AFN' => '؋',
						'ALL' => 'L',
						'GBP' => '£',
						'DZD' => 'د.ج',
						'AOA' => 'Kz',
						'XCD' => '$',
						'ARS' => '$',
						'AMD' => '֏',
						'AWG' => 'ƒ',
						'SHP' => '£',
						'AUD' => '$',
						'AZN' => '₼',
						'BSD' => '$',
						'BHD' => '.د.ب',
						'BDT' => '৳',
						'BBD' => '$',
						'BYN' => 'Br',
						'BZD' => '$',
						'BMD' => '$',
						'BTN' => 'Nu.',
						'INR' => '₹',
						'BOB' => 'Bs.',
						'USD' => '$',
						'BAM' => 'KM',
						'BWP' => 'P',
						'BRL' => 'R$',
						'BND' => '$',
						'SGD' => '$',
						'BGN' => 'лв.',
						'BIF' => 'Fr',
						'KHR' => '៛',
						'CAD' => '$',
						'CVE' => '$',
						'KYD' => '$',
						'XAF' => 'Fr',
						'CLP' => '$',
						'CNY' => '¥',
						'COP' => '$',
						'KMF' => 'Fr',
						'CDF' => 'Fr',
						'CKD' => '$',
						'NZD' => '$',
						'CRC' => '₡',
						'XOF' => 'Fr',
						'HRK' => 'kn',
						'CUP' => '$',
						'CUC' => '$',
						'ANG' => 'ƒ',
						'CZK' => 'Kč',
						'DKK' => 'kr',
						'DJF' => 'Fr',
						'DOP' => 'RD$',
						'EGP' => 'ج.م',
						'ERN' => 'Nfk',
						'SZL' => 'L',
						'ZAR' => 'R',
						'ETB' => 'Br',
						'FKP' => '£',
						'FJD' => '$',
						'EUR' => '€',
						'XPF' => '₣',
						'GMD' => 'D',
						'GEL' => '₾',
						'GHS' => '₵',
						'GIP' => '£',
						'GTQ' => 'Q',
						'GNF' => 'Fr',
						'GYD' => '$',
						'HTG' => 'G',
						'HNL' => 'L',
						'HKD' => '$',
						'HUF' => 'Ft',
						'ISK' => 'kr',
						'IDR' => 'Rp',
						'IRR' => '﷼',
						'IQD' => 'ع.د',
						'ILS' => '₪',
						'JMD' => '$',
						'JPY' => '¥',
						'KZT' => '₸',
						'KES' => 'Sh',
						'KPW' => '₩',
						'KRW' => '₩',
						'KWD' => 'د.ك',
						'KGS' => 'с',
						'LAK' => '₭',
						'LBP' => 'ل.ل',
						'LSL' => 'L',
						'LRD' => '$',
						'LYD' => 'ل.د',
						'MOP' => 'MOP$',
						'MGA' => 'Ar',
						'MWK' => 'MK',
						'MYR' => 'RM',
						'MVR' => '.ރ',
						'MRU' => 'UM',
						'MUR' => '₨',
						'MXN' => '$',
						'MDL' => 'L',
						'MNT' => '₮',
						'MAD' => 'د.م.',
						'MZN' => 'MT',
						'MMK' => 'Ks',
						'NAD' => '$',
						'NPR' => 'रू',
						'NIO' => 'C$',
						'NGN' => '₦',
						'MKD' => 'ден',
						'NOK' => 'kr',
						'OMR' => 'ر.ع.',
						'PKR' => '₨',
						'JOD' => 'د.ا',
						'PAB' => 'B/.',
						'PGK' => 'K',
						'PYG' => '₲',
						'PEN' => 'S/.',
						'PHP' => '₱',
						'PLN' => 'zł',
						'QAR' => 'ر.ق',
						'RON' => 'lei',
						'RUB' => '₽',
						'RWF' => 'Fr',
						'WST' => 'T',
						'STN' => 'Db',
						'SAR' => '﷼',
						'RSD' => 'din.',
						'SCR' => '₨',
						'SLL' => 'Le',
						'SBD' => '$',
						'SOS' => 'Sh',
						'SSP' => '£',
						'LKR' => 'Rs, රු',
						'SDG' => 'ج.س.',
						'SRD' => '$',
						'SEK' => 'kr',
						'CHF' => 'Fr.',
						'SYP' => 'ل.س',
						'TWD' => '$',
						'TJS' => 'ЅМ',
						'TZS' => 'Sh',
						'THB' => '฿',
						'TOP' => 'T$',
						'TTD' => '$',
						'TND' => 'د.ت',
						'TRY' => '₺',
						'TMT' => 'm',
						'UGX' => 'Sh',
						'UAH' => '₴',
						'AED' => 'د.إ',
						'UYU' => '$',
						'UZS' => 'сўм',
						'VUV' => 'Vt',
						'VES' => 'Bs.',
						'VND' => '₫',
						'YER' => 'ر.ي',
						'ZMW' => 'ZK',
					),
				),

				'currency_position' => array(
					'default_value' => 'before',
				),

				'currency' => array(
					'default_value' => 'USD',
					'values' => array(
						'USD' => __( 'USD - United States dollar', 'es' ),
						'EUR' => __( 'EUR - Euro', 'es' ),
						'GBP' => __( 'GBP - Pound Sterling', 'es' ),
						'CAD' => __( 'CAD - Canadian Dollar', 'es' ),
						'CNY' => __( 'CNY - Yuan Renminbi', 'es' ),
						'PLN' => __( 'PLN - Poland Zloty', 'es' ),
						'AUD' => __( 'AUD - Australian Dollar', 'es' ),
						'BGN' => __( 'BGN - Bulgarian Lev', 'es' ),

						'AFN' => __( 'AFN - Afghani', 'es' ),
						'ALL' => __( 'ALL - Albanian Lek', 'es' ),
						'DZD' => __( 'DZD - Algerian Dinar', 'es' ),
						'AOA' => __( 'AOA - Kwanza', 'es' ),
						'XCD' => __( 'XCD - East Caribbean Dollar', 'es' ),
						'ARS' => __( 'ARS - Argentine Peso', 'es' ),
						'AMD' => __( 'AMD - Armenian Dram', 'es' ),
						'AWG' => __( 'AWG - Aruban Florin', 'es' ),
						'AZN' => __( 'AZN - Azerbaijanian Manat', 'es' ),
						'BSD' => __( 'BSD - Bahamian Dollar', 'es' ),
						'BHD' => __( 'BHD - Bahraini Dinar', 'es' ),
						'BDT' => __( 'BDT - Bangladesh taka', 'es' ),
						'BBD' => __( 'BBD - Barbados Dollar', 'es' ),
						'BYN' => __( 'BYN - Belarussian Ruble', 'es' ),
						'BZD' => __( 'BZD - Belize Dollar', 'es' ),
						'XOF' => __( 'XOF - CFA Franc BCEAO', 'es' ),
						'BMD' => __( 'BMD - Bermudian Dollar', 'es' ),
						'BTN' => __( 'BTN - Ngultrum', 'es' ),
						'INR' => __( 'INR - Indian Rupee', 'es' ),
						'BOB' => __( 'BOB - Boliviano', 'es' ),
						'BOV' => __( 'BOV - Mvdol', 'es' ),
						'BAM' => __( 'BAM - Convertible Mark', 'es' ),
						'BWP' => __( 'BWP - Pula', 'es' ),
						'NOK' => __( 'NOK - Norwegian Krone', 'es' ),
						'BRL' => __( 'BRL - Brazilian Real', 'es' ),
						'BND' => __( 'BND - Brunei Dollar', 'es' ),
						'BIF' => __( 'BIF - Burundi Franc', 'es' ),
						'CVE' => __( 'CVE - Cabo Verde Escudo', 'es' ),
						'KHR' => __( 'KHR - Riel', 'es' ),
						'XAF' => __( 'XAF - CFA Franc BEAC', 'es' ),
						'KYD' => __( 'KYD - Cayman Islands Dollar', 'es' ),
						'CLF' => __( 'CLF - Unidad de Fomento', 'es' ),
						'CLP' => __( 'CLP - Chilean Peso', 'es' ),
						'COP' => __( 'COP - Colombian Peso', 'es' ),
						'COU' => __( 'COU - Unidad de Valor Real', 'es' ),
						'KMF' => __( 'KMF - Comoro Franc', 'es' ),
						'CDF' => __( 'CDF - Congolese Franc', 'es' ),
						'NZD' => __( 'NZD - New Zealand Dollar', 'es' ),
						'CRC' => __( 'CRC - Costa Rican Colon', 'es' ),
						'HRK' => __( 'HRK - Kuna', 'es' ),
						'CUC' => __( 'CUC - Peso Convertible', 'es' ),
						'CUP' => __( 'CUP - Cuban Peso', 'es' ),
						'ANG' => __( 'ANG - Netherlands Antillean Guilder', 'es' ),
						'CZK' => __( 'CZK - Czech Koruna', 'es' ),
						'DKK' => __( 'DKK - Danish Krone', 'es' ),
						'DJF' => __( 'DJF - Djibouti Franc', 'es' ),
						'DOP' => __( 'DOP - Dominican Peso', 'es' ),
						'EGP' => __( 'EGP - Egyptian Pound', 'es' ),
						'SVC' => __( 'SVC - El Salvador Colon', 'es' ),
						'ERN' => __( 'ERN - Nakfa', 'es' ),
						'ETB' => __( 'ETB - Ethiopian Birr', 'es' ),
						'FKP' => __( 'FKP - Falkland Islands Pound', 'es' ),
						'FJD' => __( 'FJD - Fiji Dollar', 'es' ),
						'XPF' => __( 'XPF - CFP Franc', 'es' ),
						'GMD' => __( 'GMD - Dalasi', 'es' ),
						'GEL' => __( 'GEL - Lari', 'es' ),
						'GHS' => __( 'GHS - Ghana Cedi', 'es' ),
						'GIP' => __( 'GIP - Gibraltar Pound', 'es' ),
						'GTQ' => __( 'GTQ - Quetzal', 'es' ),
						'GNF' => __( 'GNF - Guinea Franc', 'es' ),
						'GYD' => __( 'GYD - Guyana Dollar', 'es' ),
						'HTG' => __( 'HTG - Gourde', 'es' ),
						'HNL' => __( 'HNL - Lempira', 'es' ),
						'HKD' => __( 'HKD - Hong Kong Dollar', 'es' ),
						'HUF' => __( 'HUF - Forint', 'es' ),
						'ISK' => __( 'ISK - Iceland Krona', 'es' ),
						'IDR' => __( 'IDR - Rupiah', 'es' ),
						'XDR' => __( 'XDR - SDR (Special Drawing Right)', 'es' ),
						'IRR' => __( 'IRR - Iranian Rial', 'es' ),
						'IQD' => __( 'IQD - Iraqi Dinar', 'es' ),
						'ILS' => __( 'ILS - New Israeli Sheqel', 'es' ),
						'JMD' => __( 'JMD - Jamaican Dollar', 'es' ),
						'JPY' => __( 'JPY - Yen', 'es' ),
						'JOD' => __( 'JOD - Jordanian Dinar', 'es' ),
						'KZT' => __( 'KZT - Tenge', 'es' ),
						'KES' => __( 'KES - Kenyan Shilling', 'es' ),
						'KPW' => __( 'KPW - North Korean Won', 'es' ),
						'KRW' => __( 'KRW - Won', 'es' ),
						'KWD' => __( 'KWD - Kuwaiti Dinar', 'es' ),
						'KGS' => __( 'KGS - Som', 'es' ),
						'LAK' => __( 'LAK - Kip', 'es' ),
						'LBP' => __( 'LBP - Lebanese Pound', 'es' ),
						'LSL' => __( 'LSL - Loti', 'es' ),
						'ZAR' => __( 'ZAR - Rand', 'es' ),
						'LRD' => __( 'LRD - Liberian Dollar', 'es' ),
						'LYD' => __( 'LYD - Libyan Dinar', 'es' ),
						'CHF' => __( 'CHF - Swiss Franc', 'es' ),
						'MOP' => __( 'MOP - Pataca', 'es' ),
						'MGA' => __( 'MGA - Malagasy Ariary', 'es' ),
						'MWK' => __( 'MWK - Kwacha', 'es' ),
						'MYR' => __( 'MYR - Malaysian Ringgit', 'es' ),
						'MVR' => __( 'MVR - Rufiyaa', 'es' ),
						'MRU' => __( 'MRU - Ouguiya', 'es' ),
						'MUR' => __( 'MUR - Mauritius Rupee', 'es' ),
						'XUA' => __( 'XUA - ADB Unit of Account', 'es' ),
						'MXN' => __( 'MXN - Mexican Peso', 'es' ),
						'MXV' => __( 'MXV - Mexican Unidad de Inversion (UDI)', 'es' ),
						'MDL' => __( 'MDL - Moldovan Leu', 'es' ),
						'MNT' => __( 'MNT - Tugrik', 'es' ),
						'MAD' => __( 'MAD - Moroccan Dirham', 'es' ),
						'MZN' => __( 'MZN - Mozambique Metical', 'es' ),
						'MMK' => __( 'MMK - Kyat', 'es' ),
						'NAD' => __( 'NAD - Namibia Dollar', 'es' ),
						'NPR' => __( 'NPR - Nepalese Rupee', 'es' ),
						'NIO' => __( 'NIO - Cordoba Oro', 'es' ),
						'NGN' => __( 'NGN - Naira', 'es' ),
						'OMR' => __( 'OMR - Rial Omani', 'es' ),
						'PKR' => __( 'PKR - Pakistan Rupee', 'es' ),
						'PAB' => __( 'PAB - Balboa', 'es' ),
						'PGK' => __( 'PGK - Kina', 'es' ),
						'PYG' => __( 'PYG - Guarani', 'es' ),
						'PEN' => __( 'PEN - Nuevo Sol', 'es' ),
						'PHP' => __( 'PHP - Philippine Peso', 'es' ),
						'QAR' => __( 'QAR - Qatari Rial', 'es' ),
						'MKD' => __( 'MKD - Denar', 'es' ),
						'RON' => __( 'RON - Romanian Leu', 'es' ),
						'RWF' => __( 'RWF - Rwanda Franc', 'es' ),
						'SHP' => __( 'SHP - Saint Helena Pound', 'es' ),
						'WST' => __( 'WST - Tala', 'es' ),
						'STN' => __( 'STN - Dobra', 'es' ),
						'SAR' => __( 'SAR - Saudi Riyal', 'es' ),
						'RSD' => __( 'RSD - Serbian Dinar', 'es' ),
						'SCR' => __( 'SCR - Seychelles Rupee', 'es' ),
						'SLL' => __( 'SLL - Leone', 'es' ),
						'SGD' => __( 'SGD - Singapore Dollar', 'es' ),
						'XSU' => __( 'XSU - Sucre', 'es' ),
						'SBD' => __( 'SBD - Solomon Islands Dollar', 'es' ),
						'SOS' => __( 'SOS - Somali Shilling', 'es' ),
						'SSP' => __( 'SSP - South Sudanese Pound', 'es' ),
						'LKR' => __( 'LKR - Sri Lanka Rupee', 'es' ),
						'SDG' => __( 'SDG - Sudanese Pound', 'es' ),
						'SRD' => __( 'SRD - Surinam Dollar', 'es' ),
						'SZL' => __( 'SZL - Lilangeni', 'es' ),
						'SEK' => __( 'SEK - Swedish Krona', 'es' ),
						'CHE' => __( 'CHE - WIR Euro', 'es' ),
						'CHW' => __( 'CHW - WIR Franc', 'es' ),
						'SYP' => __( 'SYP - Syrian Pound', 'es' ),
						'TWD' => __( 'TWD - New Taiwan Dollar', 'es' ),
						'TJS' => __( 'TJS - Somoni', 'es' ),
						'TZS' => __( 'TZS - Tanzanian Shilling', 'es' ),
						'THB' => __( 'THB - Baht', 'es' ),
						'TOP' => __( 'TOP - Pa’anga', 'es' ),
						'TTD' => __( 'TTD - Trinidad and Tobago Dollar', 'es' ),
						'TND' => __( 'TND - Tunisian Dinar', 'es' ),
						'TRY' => __( 'TRY - Turkish Lira', 'es' ),
						'TMT' => __( 'TMT - Turkmenistan New Manat', 'es' ),
						'UGX' => __( 'UGX - Uganda Shilling', 'es' ),
						'UAH' => __( 'UAH - Hryvnia', 'es' ),
						'AED' => __( 'AED - UAE Dirham', 'es' ),
						'USN' => __( 'USN - US Dollar (Next day)', 'es' ),
						'UYI' => __( 'UYI - Uruguay Peso en Unidades Indexadas (URUIURUI)', 'es' ),
						'UYU' => __( 'UYU - Peso Uruguayo', 'es' ),
						'UZS' => __( 'UZS - Uzbekistan Sum', 'es' ),
						'VUV' => __( 'VUV - Vatu', 'es' ),
						'VEF' => __( 'VEF - Bolivar', 'es' ),
						'VND' => __( 'VND - Dong', 'es' ),
						'YER' => __( 'YER - Yemeni Rial', 'es' ),
						'ZMW' => __( 'ZMW - Zambian Kwacha', 'es' ),
						'ZWL' => __( 'ZWL - Zimbabwe Dollar', 'es' ),
					)
				),

				'currency_sup' => array(
					'default_value' => ','
				),

				'currency_dec' => array(
					'default_value' => '.'
				),

				'currency_dec_num' => array(
					'default_value' => '',
				),

				'listings_layout' => array(
					'default_value' => 'list',
					'values' => array(
						'grid-3' => __( 'Grid layout', 'es' ),
						'grid-2' => __( 'Large grid layout', 'es' ),
						'list' => __( 'List layout', 'es' ),
					),
				),

				'custom_prices_list' => array(),

				'social_networks' => array(
					'default_value' => array( 'linkedin', 'facebook', 'twitter', 'pinterest' ),
					'values' => array(
						'linkedin' => __( 'Linkedin', 'es' ),
						'facebook' => __( 'Facebook', 'es' ),
						'twitter' => __( 'Twitter', 'es' ),
						'pinterest' => __( 'Pinterest', 'es' ),
					),
				),

				'single_layout' => array(
					'default_value' => 'single-tiled-gallery',
					'values' => array(
						'single-slider' => __( 'Single listing with slider', 'es' ),
//						'single-full-width-slider' => __( 'With full-width slider', 'es' ),
						'single-tiled-gallery' => __( 'With tiled gallery', 'es' ),
//						'single-full-width-tiled' => __( 'With full-width tiled gallery', 'es' ),
						'single-left-slider' => __( 'With left slider', 'es' ),
					),
				),

				'is_auto_tags_enabled' => array(
					'default_value' => 1,
				),

				'is_clickable_tags_enabled' => array(
					'default_value' => 1,
				),

				'is_dynamic_content_enabled' => array(
					'default_value' => false,
				),

				'heading_tag_posts_title' => array(
					'default_value' => 'h1',
				),

				'dynamic_content' => array(
					'default_value' => 'This [es_property_field name="es_type"] style property is located in [es_property_field name="city"] is currently [es_property_field name="es_category"] and has been listed on {blog_name}. This property is listed at [es_property_field name="price"]. It has [es_property_field name="bedrooms"] bedrooms, [es_property_field name="bathrooms"] bathrooms, and is [es_property_field name="area"]. The property was built in [es_property_field name="year_built"] year.',
				),

				'is_rest_support_enabled' => array(
					'default_value' => 0,
				),

				'is_properties_sorting_enabled' => array(
					'default_value' => 1,
				),

				'is_request_form_button_disabled' => array(
					'default_value' => 0,
				),

				'is_listing_address_enabled' => array(
					'default_value' => 1,
				),

				'is_saved_search_enabled' => array(
					'default_value' => 1,
				),

				'is_link_sharing_enabled' => array(
					'default_value' => 1,
				),

				'is_single_map_marker_enabled' => array(
					'default_value' => 1,
				),

				'is_agents_register_enabled' => array(
					'default_value' => 0,
				),

				'is_collapsed_description_enabled' => array(
					'default_value' => 1,
				),

				'is_single_agent_block_enabled' => array(
					'default_value' => 0,
				),

				'is_agent_listings_quantity_views_enabled' => array(
					'default_value' => 0,
				),

				'is_agent_listings_quantity_savings_enabled' => array(
					'default_value' => 0,
				),

				'is_price_enabled' => array(
					'default_value' => 1,
				),

				'is_social_sharing_enabled' => array(
					'default_value' => 1,
				),

				'is_properties_wishlist_enabled' => array(
					'default_value' => 1,
				),

				'is_same_price_for_categories_enabled' => array(
					'default_value' => 1,
				),

				'is_labels_enabled' => array(
					'default_value' => 1,
				),

				'is_buyers_register_enabled' => array(
					'default_value' => 1,
				),

				'is_geolocation_search_enabled' => array(
					'default_value' => 0,
				),

				'is_property_carousel_enabled' => array(
					'default_value' => 1,
				),

				'is_properties_sharing_enabled' => array(
					'default_value' => 1,
				),

				'is_date_added_enabled' => array(
					'default_value' => 1,
				),

				'excerpt_length' => array(
					'default_value' => 10,
				),

				'is_single_listing_map_enabled' => array(
					'default_value' => 1,
				),

				'is_listing_description_enabled' => array(
					'default_value' => 1,
				),

				'is_login_form_enabled' => array(
					'default_value' => 1,
				),

				'is_login_facebook_enabled' => array(
					'default_value' => 0,
				),

				'is_login_google_enabled' => array(
					'default_value' => 0,
				),

				'is_white_label_enabled' => array(
					'default_value' => 0,
				),

				'is_update_search_results_enabled' => array(
					'default_value' => 1,
				),

				'is_locations_autocomplete_enabled' => array(
					'default_value' => 1,
				),

				'is_terms_icons_enabled' => array(
					'default_value' => 1,
				),

				'is_properties_archive_enabled' => array(
					'default_value' => true,
				),

				'is_request_form_geolocation_enabled' => array(
					'default_value' => 1,
				),

				'default_code_request_form' => array(
					'default_value' => 'US',
				), 

				'is_lightbox_disabled' => array(
					'default_value' => false,
				),

				'is_download_font' => array(
					'default_value' => true,
				),

				'is_default_archive_template_enabled' => array(
					'default_value' => true,
				),

				'is_tel_code_disabled' => array(
					'default_value' => false,
				),

				'title_mode' => array(
					'default_value' => 'address',
					'values' => array(
						'address' => __( 'Address', 'es' ),
						'title' => __( 'Title', 'es' ),
					),
				),

				'properties_sorting_options' => array(
					'default_value' => array_keys( $default_sorting_options ),
					'values' => $sorting_options,
				),

				'properties_default_sorting_option' => array(
					'default_value' => 'newest',
					'values' => $sorting_options
				),

				'properties_per_page' => array(
					'default_value' => 40,
				),

				'saved_searches_per_page' => array(
					'default_value' => 42,
				),

				'wishlist_properties_per_page' => array(
					'default_value' => 42,
				),

				'google_api_key' => array(),

				'default_lat_lng' => array(),

				'recaptcha_site_key' => array(),

				'recaptcha_secret_key' => array(),

				'recaptcha_version' => array(
					'values' => array(
						'v2' => __( 'reCAPTCHA v2', 'es' ),
						'v3' => __( 'reCAPTCHA v3', 'es' ),
					),
					'default_value' => 'v3',
				),

				'terms_input_type' => array(
					'default_value' => 'text',
					'values' => array(
						'text' => __( 'Text', 'es' ),
						'checkbox' => __( 'Checkbox', 'es' ),
					),
				),

				'terms_forms' => array(
					'default_value' => array( 'sign_up_form', 'request_form' ),
					'values' => array(
						'sign_up_form' => __( 'Sign up', 'es' ),
						'request_form' => __( 'Request form', 'es' ),
					),
				),

				'recaptcha_forms' => array(
					'default_value' => array( 'sign_up_form', 'request_form' ),
					'values' => array(
						'sign_up_form' => __( 'Sign up', 'es' ),
						'sign_in_form' => __( 'Sign in', 'es' ),
						'reset_pwd_form' => __( 'Reset password', 'es' ),
						'request_form' => __( 'Request form', 'es' ),
					),
				),

				'listing_meta_icons' => array(
					'default_value' => array(
						array(
							'enabled' => 1,
							'field' => 'bedrooms',
							'icon' => '{plugin_url}public/img/bed.svg',
							'icon_color' => '#DADADA',
						),
						array(
							'enabled' => 1,
							'field' => 'bathrooms',
							'icon' => '{plugin_url}public/img/bathroom.svg',
							'icon_color' => '#DADADA',
						),
						array(
							'enabled' => 1,
							'field' => 'area',
							'icon' => '{plugin_url}public/img/area.svg',
							'icon_color' => '#DADADA',
						),
					),
				),

				'listing_meta_icons_cache' => array(
					'default_value' => '',
				),

				'is_address_components_clickable' => array(
					'default_value' => 1,
				),

				'is_clusters_enabled' => array(
					'default_value' => 1,
				),

				'map_markers_list' => array(),

				'post_type_name' => array(
					'default_value' => __( 'Property', 'es' ),
				),

				'is_layout_switcher_enabled' => array(
					'default_value' => 1,
				),

				'is_amenities_collapse_enabled' => array(
					'default_value' => 1,
				),

				'is_features_collapse_enabled' => array(
					'default_value' => 1,
				),

				'map_zoom' => array(
					'default_value' => 12,
				),

				'single_property_map_zoom' => array(
					'default_value' => 16,
				),

				// Admin & PDF logo attachment ID.
				'logo_attachment_id' => array(),
				'default_property_image_id' => array(),
				'map_marker_color' => array(
					'default_value' => '#37474F'
				),

				'search_half_baths_list' => array(
					'default_value' => '1,2,3,4'
				),

				'property_item_carousel_images_num' => array(
					'default_value' => 5,
				),

				'search_min_floor' => array(
					'default_value' => 1
				),

				'search_max_floor' => array(
					'default_value' => 10
				),

				'search_min_floor_level' => array(
					'default_value' => 1
				),

				'search_max_floor_level' => array(
					'default_value' => 170
				),

				'date_format' => array(
					'default_value' => 'm/d/y',
					'values' => array(
						'd/m/y' =>  date( 'd/m/y' ),
						'm/d/y' =>  date( 'm/d/y' ),
						'd.m.y' =>  date( 'd.m.y' ),
						'Y.m.d' =>  date( 'Y.m.d' ),
						'Y-m-d' =>  date( 'Y-m-d' ),
					),
				),

				'map_cluster_color' => array(
					'default_value' => '#37474F',
				),

				'map_cluster_icon' => array(
					'default_value' => 'cluster1',
					'values' => array(
						'cluster1' => '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle opacity="0.25" cx="22" cy="22" r="22" fill="#263238" data-color/>
<circle cx="22" cy="22" r="16" fill="#263238" data-color/>
{text}
</svg>
',

						'cluster2' => '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<path class="disable_hover" d="M33 24L22 39.5L11 24H33Z" fill="#263238" data-color/>
<circle cx="22" cy="20" r="16" fill="#263238" data-color/>{text}
</svg>
',

						'cluster3' => '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="22" cy="22" r="22" fill="white"/>
<circle cx="22" cy="22" r="20" fill="#263238" data-color/>
<circle cx="22" cy="22" r="16" fill="white"/>
{text}
</svg>',
					),
				),

				'map_marker_icon' => array(
					'default_value' => 'marker1',
					'values' => array(
						'marker1' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path data-color fill-rule="evenodd" clip-rule="evenodd" d="M12 23.3276L12.6577 22.7533C18.1887 17.9237 21 13.7068 21 10C21 4.75066 16.9029 1 12 1C7.09705 1 3 4.75066 3 10C3 13.7068 5.81131 17.9237 11.3423 22.7533L12 23.3276ZM9 10C9 8.34315 10.3431 7 12 7C13.6569 7 15 8.34315 15 10C15 11.6569 13.6569 13 12 13C10.3431 13 9 11.6569 9 10Z" fill="#263238"/>
</svg>
',

						'marker2' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M12 23.3276L12.6577 22.7533C18.1887 17.9237 21 13.7068 21 10C21 4.75066 16.9029 1 12 1C7.09705 1 3 4.75066 3 10C3 13.7068 5.81131 17.9237 11.3423 22.7533L12 23.3276ZM12 20.6634C7.30661 16.4335 5 12.8492 5 10C5 5.8966 8.16411 3 12 3C15.8359 3 19 5.8966 19 10C19 12.8492 16.6934 16.4335 12 20.6634ZM12 5C14.7614 5 17 7.23858 17 10C17 12.7614 14.7614 15 12 15C9.23858 15 7 12.7614 7 10C7 7.23858 9.23858 5 12 5ZM9 10C9 8.34315 10.3431 7 12 7C13.6569 7 15 8.34315 15 10C15 11.6569 13.6569 13 12 13C10.3431 13 9 11.6569 9 10Z" fill="#37474F" data-color/>
</svg>
',

						'marker3' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M13 11.9V19H11V11.9C8.71776 11.4367 7 9.41896 7 7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7C17 9.41896 15.2822 11.4367 13 11.9ZM9 14.1573V16.1844C6.06718 16.5505 4 17.3867 4 18C4 18.807 7.57914 20 12 20C16.4209 20 20 18.807 20 18C20 17.3867 17.9328 16.5505 15 16.1844V14.1573C19.0559 14.6017 22 15.9678 22 18C22 20.5068 17.5203 22 12 22C6.47973 22 2 20.5068 2 18C2 15.9678 4.94412 14.6017 9 14.1573ZM15 7C15 8.65685 13.6569 10 12 10C10.3431 10 9 8.65685 9 7C9 5.34315 10.3431 4 12 4C13.6569 4 15 5.34315 15 7Z" fill="#37474F" data-color/>
</svg>
',
					),
				),

				'time_format' => array(
					'default_value' => 'G',
					'values' => array(
						'h' => __( '12-hour clock', 'es' ),
						'G' => __( '24-hour clock', 'es' ),
					),
				),

				'price_input_type' => array(
					'default_value' => 'dropdown',
					'values' => array(
						'manual_input' => __( 'Manual Input', 'es' ),
						'dropdown' => __( 'Dropdown', 'es' ),
					),
				),

				'min_prices_list' => array(
					'default_value' => '50000,75000,100000,125000,150000,175000,200000,300000,400000,500000,600000,700000,800000,900000,1000000,1250000,1500000,1750000,2000000,2500000,3000000,5000000,10000000',
				),

				'max_prices_list' => array(
					'default_value' => '75000,100000,125000,150000,175000,200000,300000,400000,500000,600000,700000,800000,900000,1000000,1250000,1500000,1750000,2000000,2500000,3000000,5000000,10000000,20000000',
				),

				'main_color' => array(
					'default_value' => '#FF5A5F',
				),

				'default_label_color' => array(
					'default_value' => '#69C200',
				),
				'secondary_color' => array(
					'default_value' => '#13A48E',
				),

				'responsive_breakpoints' => array(
					'default_value' => array(
						'listing-item' => array(
							'selector' => '.js-es-listing',
							'breakpoints' => array(
								'es-listing--hide-labels' => array( 'max' => 220 ),
							),
						),
						'properties-slider' => array(
							'selector' => '.es-properties-slider',
							'breakpoints' => array(
								'es-properties-slider--desktop' => array( 'min' => 960 ),
								'es-properties-slider--tablet' => array( 'min' => 1 ),
							),
						),
						'listings' => array(
							'selector' => '.es-listings:not(.es-listings--ignore-responsive)',
							'breakpoints' => array(
								'es-listings--list'    => array( 'min' => 850 ),
								'es-listings--list-sm' => array( 'min' => 740 ),
								'es-listings--grid-6'  => array( 'min' => 1250 ),
								'es-listings--grid-5'  => array( 'min' => 1050 ),
								'es-listings--grid-4'  => array( 'min' => 850 ),
								'es-listings--grid-3'  => array( 'min' => 650 ),
								'es-listings--grid-2'  => array( 'min' => 460 ),
								'es-listings--grid-1'  => array( 'min' => 1 ),
							),
						),
						'single-property' => array(
							'selector' => '.js-es-single',
							'breakpoints' => array(
								'es-single--xsm' => array( 'min' => 400 ),
								'es-single--sm'  => array( 'min' => 520 ),
								'es-single--md'  => array( 'min' => 650 ),
								'es-single--lg'  => array( 'min' => 800 ),
								'es-single--xl'  => array( 'min' => 1000 )
							),
						),
						'single-gallery' => array(
							'selector' => '.js-es-property-gallery',
							'breakpoints' => array_reverse( array(
								'es-gallery--xsm' => array( 'min' => 1 ),
								'es-gallery--sm'  => array( 'min' => 520 ),
								'es-gallery--md'  => array( 'min' => 600 ),
								'es-gallery--lg'  => array( 'min' => 800 ),
								'es-gallery--xl'  => array( 'min' => 1000 )
							) ),
						),
						'single-slider' => array(
							'selector' => '.js-es-slider',
							'breakpoints' => array_reverse( array(
								'es-slider--xsm' => array( 'min' => 1 ),
								'es-slider--sm'  => array( 'min' => 520 ),
								'es-slider--md'  => array( 'min' => 600 ),
								'es-slider--lg'  => array( 'min' => 800 ),
								'es-slider--xl'  => array( 'min' => 1000 )
							) ),
						),
						'main_search' => array(
							'selector' => '.js-es-search--main',
							'breakpoints' => array(
								'es-search--desktop'   => array( 'min' => 500 ),
								'es-search--collapsed' => array( 'min' => 1 ),
							),
						),
						'simple_search' => array(
							'selector' => '.js-es-search--simple',
							'breakpoints' => array(
								'es-search--desktop'   => array( 'min' => 720 ),
								'es-search--collapsed' => array( 'min' => 1 ),
							),
						),
						'half_map' => array(
							'selector' => '.js-es-properties.es-properties--hfm',
							'breakpoints' => array(
								'es-properties--hfm--min-map' => array( 'min' => 721, 'max' => 1169 ),
								'es-properties--hfm--only-map es-properties--hfm--mobile-map' => array( 'max' => 720, 'min' => 1 )
							),
						),
						'listings-navbar' => array(
							'selector' => '.js-es-listings-filter',
							'breakpoints' => array(
								'es-listings-filter--tablet' => array( 'min' => 540, 'max' => 620 ),
								'es-listings-filter--mobile' => array( 'min' => 0, 'max' => 539 )
							),
						),
						'profile' => array(
							'selector' => '.js-es-profile',
							'breakpoints' => array(
								'es-profile--tablet' => array( 'min' => 400, 'max' => 719 ),
								'es-profile--mobile' => array( 'min' => 1, 'max' => 399 ),
							),
						),
					),
				),

				'listings_offset_corrector' => array(
					'default_value' => 150,
				),

				'new_user_info_email_content' => array(
					'default_value' => '<p>Thank you for your registration! Your account information is below</p><b>Username: </b>{user_login}<p>You can enter your account <a href="{profile_link}">here</a>.</p>',
				),

				'new_user_info_email_subject' => array(
					'default_value' => _x( 'Your username and password info', 'user email subject', 'es' ),
				),

				'new_user_registered_admin_email_content' => array(
					'default_value' => '<p>New user registration on your site {site_name}.</p><b>Username: </b> {user_login}<br><b>Email:</b> {user_email}',
				),

				'new_user_registered_admin_email_subject' => array(
					'default_value' => _x( 'New user registered', 'user email subject', 'es' ),
				),

				'reset_password_email_content' => array(
					'default_value' => '<p>Someone has requested a password reset for the following account:</p><p>{site_url}</p><b>Username: </b> {user_login}<p>If this was a mistake, just ignore this email and nothing will happen.</p><p>To reset your password, visit the following <a href="{reset_link}">link</a></p>',
				),

				'reset_password_email_subject' => array(
					'default_value' => _x( 'Password Reset Request', 'user email subject', 'es' ),
				),

				'request_property_info_email_content' => array(
					'default_value' => '<p>Request about property <a href="{post_link}" target="_blank">#{post_id}</a></p><br><b>Name: </b>{name}<br><b>Email: </b>{email}<br><b>Phone: </b>{phone}<br><b>Property Link: </b><a target="_blank" href="{post_link}">{post_link}</a><br><b>Property address: </b>{property_address}<br><b>Request: </b>{request}',
				),

				'request_property_info_email_subject' => array(
					'default_value' => _x( 'New listing #{post_id} request submitted', 'user email subject', 'es' ),
				),
			);

			foreach ( array( 'es_category', 'es_type', 'es_rent_period', 'es_status' ) as $taxonomy ) {
				static::$settings_list[ 'search_' . $taxonomy . '_field_mode' ] = array(
					'default_value' => 'checkboxes-bordered',
					'values' => array(
						'checkboxes-bordered' => _x( 'Buttons', 'plugin settings', 'es' ),
						'select' => _x( 'Dropdown', 'plugin settings', 'es' ),
					),
				);
			}

			foreach ( array( 'floors', 'floor_level' ) as $field ) {
				static::$settings_list[ 'is_search_' . $field . '_range_enabled' ] = array(
					'default_value' => 1,
				);
			}

			foreach ( array( 'area', 'lot_size' ) as $field ) {
				static::$settings_list[ 'search_min_' . $field . '_list' ] = array(
					'default_value' => '500,750,1000,1250,1500,1750,2000,2250,2500,2750,3000,4000,5000,7500',
				);

				static::$settings_list[ 'search_max_' . $field . '_list' ] = array(
					'default_value' => '750,1000,1250,1500,1750,2000,2250,2500,2750,3000,4000,5000,7500,10000',
				);

				static::$settings_list[ 'is_search_' . $field . '_range_enabled' ] = array(
					'default_value' => 1,
				);
			}

			foreach ( array( 'bedrooms', 'bathrooms', 'half_baths' ) as $field ) {
				static::$settings_list[ 'is_search_' . $field . '_range_enabled' ] = array(
					'default_value' => 0,
				);

				static::$settings_list[ 'search_' . $field . '_list' ] = array(
					'default_value' => '1,2,3,4',
				);

				static::$settings_list[ 'search_min_' . $field . '_list' ] = array(
					'default_value' => '1,2,3,4,5,6,7,8,9',
				);

				static::$settings_list[ 'search_max_' . $field . '_list' ] = array(
					'default_value' => '2,3,4,5,6,7,8,9,10',
				);
			}

			static::$settings_list = apply_filters( 'es_get_available_settings', static::$settings_list );
		}

		return static::$settings_list;
	}

	/**
	 * Return list if available values using setting name.
	 *
	 * @param $name
	 * @return null
	 */
	public static function get_available_values( $name ) {
		$settings = static::get_available_settings( static::FORCE_SETTINGS );
		$name = sanitize_key( $name );

		$defined_values = ! empty( $settings[ $name ]['values'] ) ? $settings[ $name ]['values'] : array();

		return apply_filters( 'es_settings_get_available_values', $defined_values, $name );
	}

	/**
	 * Return option value using setting name.
	 *
	 * @param $name
	 * @return string|null
	 */
	public function __get( $name ) {
		return isset( static::$options[ $name ] ) ? static::$options[ $name ] : $this->get_default_value( $name );
	}

	/**
	 * Return field default value.
	 *
	 * @param $name
	 * @return null
	 */
	public function get_default_value( $name ) {
		$settings = static::get_available_settings();
		return ! empty( $settings[ $name ]['default_value'] ) ? $settings[ $name ]['default_value'] : null;
	}

	/**
	 * Magic method for empty and isset methods.
	 *
	 * @param $name
	 * @return bool
	 */
	public function __isset( $name ) {
		$value = $this->__get( $name );
		return ! empty( $value );
	}

	/**
	 * Save one settings.
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return void
	 */
	public function save_one( $name, $value ) {
		$name = sanitize_key( $name );
		$this->load_options();
		$value = static::validate_input( $name, $value );
		static::$options = empty( static::$options ) ? array() : static::$options;
		static::$options[ $name ] = $value;

		if ( 'language' == $name ) {
			if ( get_locale() != $value && current_user_can( 'install_languages' ) ) {
				try {
					if ( ! function_exists( 'wp_download_language_pack' ) ) {
						/** WordPress Translation Installation API */
						require_once( ABSPATH . 'wp-admin/includes/translation-install.php' );
						if ( ! function_exists( 'request_filesystem_credentials' ) ) {
							require_once( ABSPATH . 'wp-admin/includes/file.php' );
						}
					}

					$language = wp_download_language_pack( $value );

					if ( $language ) {
						update_site_option( 'WPLANG', $language );
					}
				} catch ( Exception $e ) {

				}
			}
		}

		update_option( static::OPTIONS_CONTAINER_NAME, static::$options );
	}

	/**
	 * Validate user input.
	 *
	 * @param $name
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function validate_input( $name, $value ) {
		return $value;
	}

	/**
	 * Save settings list.
	 *
	 * @param array $data
	 * @see update_option
	 */
	public function save( array $data ) {
		if ( ! empty( $data ) ) {
			$settings = static::get_available_settings();
			$this->load_options();

			foreach ( $settings as $name => $setting ) {
				$name = sanitize_key( $name );
				if ( isset( $data[ $name ] ) ) {

					$prev = $this->{$name};

					if ( ( is_string( $data[ $name ] ) && $data[ $name ] != ' ' ) || is_array( $data[ $name ] ) ) {
						$data[ $name ] = static::validate_input( $name, $data[ $name ] );
					}

					$this->save_one( $name, $data[ $name ] );

					do_action( 'es_settings_save', $name, $data[ $name ], $prev, $data, $this );
				}
			}
		}
	}

	/**
	 * Return label of the value.
	 *
	 * @param $name
	 * @param $value
	 * @return null
	 */
	public function get_label( $name, $value ) {
		$default = static::get_available_values( $name );
		return ! empty( $default[ $value ] ) ? $default[ $value ] : null;
	}
}
