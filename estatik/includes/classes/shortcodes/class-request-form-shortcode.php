<?php

/**
 * Class Es_Search_Form_Shortcode.
 */
class Es_Request_Form_Shortcode extends Es_Shortcode {

    /**
     * @var int
     */
    const SEND_ADMIN = 1;

    /**
     * @var int
     */
    const SEND_OTHER = -1;

    /**
     * Recipient signature format version. Bumping it invalidates every signature
     * rendered by an earlier release.
     *
     * @var string
     */
    const SIGNATURE_VERSION = 'v2';

    /**
     * Max submissions accepted from a single IP per rate limit window.
     *
     * @var int
     */
    const RATE_LIMIT_MAX = 5;

    /**
     * Rate limit window, in seconds.
     *
     * @var int
     */
    const RATE_LIMIT_WINDOW = 300;

    /**
     * Recipient list whose signature has been verified for the current request.
     *
     * Stays null until a signature check passes, so an unverified request can
     * never resolve to a recipient.
     *
     * @var array|null
     */
    protected $_verified_recipient_emails = null;

    /**
     * Return list of "send_to" selectbox field.
     *
     * @return mixed
     */
    public static function get_send_to_list() {
        return apply_filters( 'es_request_widget_get_send_to_list', array(
            self::SEND_ADMIN => __( 'Admin', 'es' ),
            self::SEND_OTHER => __( 'Other email', 'es' ),
        ) );
    }

    /**
     * Return search shortcode DOM.
     *
     * @return string|void
     */
    public function get_content() {
        ob_start();
        es_load_template( sprintf( 'front/shortcodes/request/request-form-%s.php', $this->_attributes['layout'] ), array(
            'shortcode_instance' => $this,
            'attributes' => $this->_attributes,
        ) );
        return ob_get_clean();
    }

    /**
     * Return shortcode default attributes.
     *
     * @return array|void
     */
    public function get_default_attributes() {
        return apply_filters( sprintf( '%s_default_attributes', static::get_shortcode_name() ), array(
            'layout' => 'sidebar', // sidebar, section
            'title' => __( 'Ask an Agent About This Home', 'es' ),
            'background' => '#263238',
            'color' => '#ffffff',
            'post_id' => get_the_ID(),
            'recipient_type' => static::SEND_ADMIN,
            'name' => null,
            'email' => null,

            'message' => __( "Hello, I'd like more information about this home. Thank you!", 'es' ),
            'disable_tel' => false,
            'disable_name' => false,
            'custom_email' => false,
            'disable_email' => false,
            'subject' => __( 'Estatik Request Info from', 'es' ),
            'button_text' => __( 'Request info', 'es' ),
        ) );
    }

    /**
     * @return Exception|string
     */
    public static function get_shortcode_name() {
        return 'es_request_form';
    }

    /**
     * Return request form frontend fields config.
     *
     * @return mixed|void
     */
    public function get_fields_config() {
        $uid = uniqid();
        $user = es_get_user_entity();

        return apply_filters( 'es_request_form_fields', array(
            'name' => array(
                'label' => __( 'Name*', 'es' ),
                'type' => 'text',
                'attributes' => array(
                    'required' => 'required',
                    'id' => 'name-' . $uid,
                    'maxlength' => 50,
                ),
                'value' => $user ? $user->get_full_name() : '',
            ),
            'email' => array(
                'label' => __( 'Email*', 'es' ),
                'type' => 'email',
                'attributes' => array(
                    'required' => 'required',
                    'id' => 'email-' . $uid,
                    'maxlength' => 256,
                ),
                'value' => $user ? $user->get_email() : '',
            ),
            'phone' => array(
                'label' => __( 'Phone', 'es' ),
                'type' => 'phone',
                'is_country_code_disabled' => ests( 'is_tel_code_disabled' ),
                'codes' => es_esc_json_attr( ests_values( 'phone_codes' ) ),
                'icons' => es_esc_json_attr( ests_values( 'country_icons' ) ),
                'code_config' => array(
                    'options' => ests_values( 'country' ),
                    'attributes' => array(
                        'id' => 'es-field-code-' . uniqid(),
                    )
                ),
            ),
            'message' => array(
                'label' => __( 'Message*', 'es' ),
                'type' => 'textarea',
                'attributes' => array(
                    'id' => 'message-' . $uid,
                    'required' => 'required',
                    'maxlength' => 500,
                ),
                'value' => $this->_attributes['message']
            ),
        ), $this );
    }

    /**
     * Parse an arbitrary recipient value into a canonical list of valid emails.
     *
     * Both the signature we render and the signature we verify are built from the
     * output of this method, and the mail is sent to that same output. Signing one
     * representation of the value while sending to another is what allowed a
     * replayed signature to carry attacker chosen recipients.
     *
     * @param mixed $value
     *
     * @return array
     */
    public static function normalize_recipient_emails( $value ) {
        if ( is_array( $value ) ) {
            $value = implode( ',', array_filter( $value, 'is_scalar' ) );
        }

        if ( ! is_scalar( $value ) ) {
            return array();
        }

        $emails = array();

        foreach ( explode( ',', wp_strip_all_tags( (string) $value ) ) as $email ) {
            $email = sanitize_email( trim( $email ) );

            if ( $email && is_email( $email ) ) {
                // Key by lowercase so case variants cannot produce duplicates.
                $emails[ strtolower( $email ) ] = $email;
            }
        }

        $emails = array_values( $emails );

        // Canonical order, so the signature does not depend on submitted order.
        sort( $emails );

        return $emails;
    }

    /**
     * Build the recipient routing signature for a type and recipient list.
     *
     * @param int   $recipient_type
     * @param mixed $emails
     *
     * @return string
     */
    public static function get_recipient_signature( $recipient_type, $emails ) {
        $emails = static::normalize_recipient_emails( $emails );

        $payload = implode( '|', array(
            static::SIGNATURE_VERSION,
            (int) $recipient_type,
            implode( ',', $emails ),
        ) );

        return hash_hmac( 'sha256', $payload, wp_salt( 'auth' ) );
    }

    /**
     * Whether the current client has exceeded the submission rate limit.
     *
     * Counts every attempt, not just successful sends, so a harvested nonce and
     * signature pair cannot be replayed in bulk.
     *
     * @return bool
     */
    public static function is_rate_limited() {
        $limit = (int) apply_filters( 'es_request_form_rate_limit', static::RATE_LIMIT_MAX );
        $window = (int) apply_filters( 'es_request_form_rate_limit_window', static::RATE_LIMIT_WINDOW );

        if ( $limit < 1 || $window < 1 ) {
            return false;
        }

        $ip = isset( $_SERVER['REMOTE_ADDR'] ) ? (string) $_SERVER['REMOTE_ADDR'] : '';
        $key = 'es_rf_rate_' . md5( $ip );

        $count = (int) get_transient( $key );

        if ( $count >= $limit ) {
            return true;
        }

        set_transient( $key, $count + 1, $window );

        return false;
    }

    /**
     * Set the recipient list that passed signature verification.
     *
     * @param array $emails
     *
     * @return void
     */
    public function set_verified_recipient_emails( $emails ) {
        $this->_verified_recipient_emails = static::normalize_recipient_emails( $emails );
    }

    /**
     * Submit request form handler.
     *
     * @return void
     */
    public static function submit_form() {
        $btn = '<a href="" class="es-btn es-btn--secondary js-es-close-popup">' . __( 'Got it', 'es' ) . '</a>';
        $id = es_clean( filter_input( INPUT_POST, 'uniqid' ) );

        if ( static::is_rate_limited() ) {
            $response = es_error_ajax_response( sprintf(
                '<span class="es-icon es-icon_close"></span><h4>%s</h4><p>%s</p>%s',
                __( 'Error!', 'es' ),
                __( 'Too many requests. Please, wait a few minutes and try again.', 'es' ),
                $btn
            ) );

            $content = $response;
            $response['message'] = sprintf( "<div id='es-request-form-popup' class='es-magnific-popup es-ajax-form-popup'>%s</div>", $response['message'] );

            wp_die( json_encode( apply_filters( 'es_request_form_submit_response', $response, $content ) ) );
        }

        $recipient_type = (int) filter_input( INPUT_POST, 'recipient_type' );

        // Normalise before verifying, and keep the result: this exact array is the
        // one get_emails() sends to. Read $_POST directly so array payloads reach
        // the normaliser instead of being silently dropped by filter_input().
        $send_to_emails = static::normalize_recipient_emails(
            isset( $_POST['send_to_emails'] ) ? wp_unslash( $_POST['send_to_emails'] ) : ''
        );

        $send_to_emails_signature = isset( $_POST['send_to_emails_signature'] ) && is_scalar( $_POST['send_to_emails_signature'] )
            ? trim( (string) wp_unslash( $_POST['send_to_emails_signature'] ) )
            : '';

        $is_send_to_emails_valid = $send_to_emails_signature
            && hash_equals( static::get_recipient_signature( $recipient_type, $send_to_emails ), $send_to_emails_signature );

        if ( wp_verify_nonce( es_get_nonce( 'es_request_form_nonce_' . $id ), 'es_submit_request_form' ) && $is_send_to_emails_valid ) {
            if ( es_verify_recaptcha() ) {
                if ( ( isset( $_POST['terms_conditions'] ) && ! empty( $_POST['terms_conditions'] ) ) || ! isset( $_POST['terms_conditions'] ) ) {
                    $data = apply_filters( 'es_request_form_submit_data', es_clean( $_POST ) );
                    $instance = new static( $data );
                    $data['subject'] = $instance->_attributes['subject'];
                    $instance->set_verified_recipient_emails( $send_to_emails );
                    $emails = $instance->get_emails();

                    $email_instance = es_get_email_instance( static::get_email_instance_name( $data ), $data );

                    if ( $email_instance::is_active() && $emails && $email_instance->send( $emails ) ) {
                        $response = es_success_ajax_response(
                            __( '<span class="es-icon es-icon_check-mark"></span><h4>Thank you!</h4><p>We\'ve sent along your message. The agent will follow up with you soon.</p>', 'es' ) . $btn
                        );
                        do_action( 'es_after_request_form_submitted', $data, $emails );
                    } else {
                        $response = es_error_ajax_response(
                            __( '<span class="es-icon es-icon_close"></span><h4>Error!</h4><p>Your message wasn\'t sent. Please, contact support.</p>', 'es' ) . $btn
                        );
                    }
                } else {
                    $response = es_error_ajax_response(
                        __( '<span class="es-icon es-icon_close"></span><h4>Error!</h4><p>Please, confirm terms & conditions</p>', 'es' ) . $btn
                    );
                }
            } else {
                $response = es_error_ajax_response(
                    __( '<span class="es-icon es-icon_close"></span><h4>Error!</h4><p>Invalid reCAPTCHA. Please, reload the page and try again.</p>', 'es' ) . $btn
                );
            }

        } else {
            $error = __( 'Invalid security nonce. Please, reload the page and try again.', 'es' );
            $response = es_error_ajax_response( sprintf( '<span class="es-icon es-icon_close"></span><h4>%s</h4><p>%s</p>%s', __( 'Error!', 'es' ), $error, $btn ) );
        }

        $content = $response;
        $response['message'] = sprintf( "<div id='es-request-form-popup' class='es-magnific-popup es-ajax-form-popup'>%s</div>", $response['message'] );

        wp_die( json_encode( apply_filters( 'es_request_form_submit_response', $response, $content ) ) );
    }

    /**
     * Render request form security fields.
     *
     * @param array $args
     *
     * @return void
     */
    public static function render_security_fields( $args ) {
        $attributes = $args['attributes'] ?? array();

        $recipient_type = isset( $attributes['recipient_type'] ) ? (int) $attributes['recipient_type'] : static::SEND_ADMIN;

        $send_to_emails = ! empty( $attributes['custom_email'] ) ? $attributes['custom_email'] : '';

        $signature = static::get_recipient_signature( $recipient_type, $send_to_emails );

        echo '<input type="hidden" name="send_to_emails_signature" value="' . esc_attr( $signature ) . '">';
    }

    /**
     * @param $data
     *
     * @return string
     */
    public static function get_email_instance_name( $data ) {
        $result = 'request_property_info';

        if ( ! empty( $data['post_id'] ) ) {
            $entity = es_get_entity_by_id( $data['post_id'] );
            if ( $entity ) {
                $email_instance = sprintf( 'request_%s_info', $entity::get_entity_name() );
                $types = es_get_email_types_list();

                $result = ! empty( $types[ $email_instance ] ) ? $email_instance : $result;
            }
        }

        return $result;
    }

    /**
     * Get recipient emails by recipient type.
     *
     * @return mixed|void
     */
    public function get_emails() {
        $emails = array();
        $type = (int) $this->_attributes['recipient_type'];

        if ( static::SEND_OTHER === $type ) {
            // Only the signature verified list may be used here. Never re-read
            // $_POST: parsing the request again is what let a valid signature be
            // paired with a different recipient list.
            $emails = is_array( $this->_verified_recipient_emails ) ? $this->_verified_recipient_emails : array();
        }

        if ( static::SEND_ADMIN === $type ) {
            $emails = es_get_admin_emails();
        }

        $emails = $emails ? array_unique( $emails ) : array();

        return apply_filters( 'es_request_form_get_emails', $emails, $this );
    }

}

add_action( 'wp_ajax_es_submit_request_form', array( 'Es_Request_Form_Shortcode', 'submit_form' ) );
add_action( 'wp_ajax_nopriv_es_submit_request_form', array( 'Es_Request_Form_Shortcode', 'submit_form' ) );
add_action( 'es_before_request_form', array( 'Es_Request_Form_Shortcode', 'render_security_fields' ) );
