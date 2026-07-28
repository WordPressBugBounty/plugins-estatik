<?php

/**
 * Class Es_Facebook_Authentication
 */
class Es_Facebook_Authentication extends Es_Authentication {

    /**
     * @var string
     */
    protected $_login_url = 'https://www.facebook.com/dialog/oauth';

    /**
     * @var int
     */
    protected $_state_lifetime = 10 * MINUTE_IN_SECONDS;

    /**
     * @var bool
     */
    protected $_state_verified = false;

    /**
     * Es_Facebook_Authentication constructor.
     *
     * @param array $config
     */
    public function __construct( $config = array() ) {
        $config = es_parse_args( $config, array(
            'client_id' => ests( 'facebook_app_id' ),
            'client_secret' => ests( 'facebook_app_secret' ),
            'redirect_uri' => '',
            'response_type' => 'code',
            'scope' => 'email',
            'code' => '',
            'state' => '',
            'error_code' => '',
            'error_message' => '',
            'context' => '',
        ) );

        parent::__construct( $config );
    }

    /**
     * @return string
     * @throws Exception
     */
    public function create_auth_url() {
        $state = $this->create_state();

        return add_query_arg( array(
            'client_id' => $this->_config['client_id'],
            'redirect_uri' => $this->_config['redirect_uri'],
            'response_type' => $this->_config['response_type'],
            'scope' => $this->_config['scope'],
            'state' => $state,
        ), $this->_login_url );
    }

    /**
     * Generate and store OAuth state.
     *
     * @return string
     * @throws Exception
     */
    protected function create_state() {
        if ( headers_sent() ) {
            throw new Exception( __( 'Unable to initialize Facebook authentication.', 'es' ) );
        }

        $state = bin2hex( random_bytes( 32 ) );
        $state_hash = hash( 'sha256', $state );

        set_transient( $this->get_state_transient_name( $state_hash ), 1, $this->_state_lifetime );

        setcookie( $this->get_state_cookie_name( $state_hash ), $state, array(
            'expires' => time() + $this->_state_lifetime,
            'path' => COOKIEPATH ?: '/',
            'domain' => COOKIE_DOMAIN ?: '',
            'secure' => is_ssl(),
            'httponly' => true,
            'samesite' => 'Lax',
        ) );

        return $state;
    }

    /**
     * Verify OAuth state.
     *
     * @return void
     * @throws Exception
     */
    protected function verify_state() {
        if ( $this->_state_verified ) {
            return;
        }

        $received_state = ! empty( $this->_config['state'] ) ? $this->_config['state'] : '';

        if ( ! is_string( $received_state ) || ! preg_match( '/^[a-f0-9]{64}$/', $received_state ) ) {
            throw new Exception( __( 'The Facebook authentication request could not be verified. Please try again.', 'es' ) );
        }

        $state_hash = hash( 'sha256', $received_state );
        $cookie_name = $this->get_state_cookie_name( $state_hash );
        $expected_state = isset( $_COOKIE[ $cookie_name ] ) ? wp_unslash( $_COOKIE[ $cookie_name ] ) : '';

        if ( ! is_string( $expected_state ) || ! preg_match( '/^[a-f0-9]{64}$/', $expected_state ) || ! hash_equals( $expected_state, $received_state ) ) {
            $this->delete_state_cookie( $state_hash );

            throw new Exception( __( 'The Facebook authentication request could not be verified. Please try again.', 'es' ) );
        }

        $transient_name = $this->get_state_transient_name( $state_hash );

        if ( ! get_transient( $transient_name ) ) {
            $this->delete_state_cookie( $state_hash );

            throw new Exception( __( 'The Facebook authentication request has expired or has already been used.', 'es' ) );
        }

        delete_transient( $transient_name );
        $this->delete_state_cookie( $state_hash );

        $this->_state_verified = true;
    }

    /**
     * Delete OAuth state cookie.
     *
     * @param string $state_hash
     *
     * @return void
     */
    protected function delete_state_cookie( $state_hash ) {
        if ( headers_sent() ) {
            return;
        }

        setcookie( $this->get_state_cookie_name( $state_hash ), '', array(
            'expires' => time() - HOUR_IN_SECONDS,
            'path' => COOKIEPATH ?: '/',
            'domain' => COOKIE_DOMAIN ?: '',
            'secure' => is_ssl(),
            'httponly' => true,
            'samesite' => 'Lax',
        ) );
    }

    /**
     * Return OAuth state cookie name.
     *
     * @return string
     */
    protected function get_state_cookie_name( $state_hash ) {
        return 'es_facebook_oauth_state_' . substr( $state_hash, 0, 16 );
    }

    /**
     * Return OAuth state transient name.
     *
     * @param string $state_hash
     *
     * @return string
     */
    protected function get_state_transient_name( $state_hash ) {
        return 'es_fb_oauth_' . $state_hash;
    }

    /**
     * @param $code
     */
    public function set_code( $code ) {
        $this->_config['code'] = $code;
    }

    /**
     * @param $state
     */
    public function set_state( $state ) {
        $this->_config['state'] = $state;
    }

    /**
     * Generate access token.
     *
     * @return string
     * @throws Exception
     */
    public function get_access_token_response() {
        $this->_user_data = null;

        $this->verify_state();

        if ( empty( $this->_config['code'] ) ) {
            throw new Exception( __( 'Facebook authorization code is missing.', 'es' ) );
        }

        $params = array(
            'client_id' => $this->_config['client_id'],
            'redirect_uri' => $this->_config['redirect_uri'],
            'client_secret' => $this->_config['client_secret'],
            'code' => $this->_config['code'],
        );

        $response = wp_safe_remote_get( add_query_arg( $params, 'https://graph.facebook.com/v2.7/oauth/access_token' ) );

        if ( is_wp_error( $response ) ) {
            throw new Exception( $response->get_error_message() );
        }

        $token_response = json_decode( wp_remote_retrieve_body( $response ) );

        if ( ! empty( $token_response->error->message ) ) {
            throw new Exception( $token_response->error->message, $token_response->error->code );
        }

        return $token_response;
    }

    /**
     * Return FB user by access token.
     *
     * @return stdClass|bool
     * @throws Exception
     */
    public function get_user() {
        if ( ! empty( $this->_user_data ) ) {
            return $this->_user_data;
        }

        $token = $this->get_access_token_response();

        if ( isset( $token->access_token ) ) {
            $params = array(
                'access_token' => $token->access_token,
                'appsecret_proof' => hash_hmac( 'sha256', $token->access_token, $this->_config['client_secret'] ),
                'fields' => 'id,name,email,picture,link,locale,first_name,last_name',
            );

            $user_response = wp_safe_remote_get( 'https://graph.facebook.com/v2.7/me' . '?' . urldecode( http_build_query( $params ) ) );

            if ( is_wp_error( $user_response ) ) {
                throw new Exception( $user_response->get_error_message() );
            }

            $this->_user_data = json_decode( wp_remote_retrieve_body( $user_response ) );

            return $this->_user_data;
        }

        return false;
    }

    /**
     * Register new user.
     *
     * @return mixed|void
     * @throws Exception
     */
    public function register() {
        $fb_user = $this->get_user();

        if ( ! empty( $fb_user->email ) ) {
            $user_data = array(
                'user_login' => $fb_user->email,
                'user_pass' => wp_generate_password(),
                'user_email' => $fb_user->email,
                'first_name' => $fb_user->first_name,
                'last_name' => $fb_user->last_name,
            );

            $user_id = wp_insert_user( $user_data );

            if ( ! is_wp_error( $user_id ) ) {
                update_user_meta( $user_id, 'auth_facebook', 1 );

                do_action( 'register_new_user', $user_id );
                do_action( 'social_register_new_user', $user_id, $this );
            } else {
                throw new Exception( $user_id->get_error_message() );
            }
        } else if ( ! empty( $fb_user->error ) ) {
            throw new Exception( $fb_user->error->message );
        } else {
            throw new Exception( __( 'Facebook user email is empty', 'es' ) );
        }

        return $user_id;
    }

    /**
     * Is valid auth data.
     *
     * @return bool
     * @throws Exception
     */
    public function is_valid() {
        if ( ! empty( $this->_config['error_code'] ) ) {
            throw new Exception( $this->_config['error_message'], $this->_config['error_code'] );
        }

        return ! empty( $this->_config['client_id'] ) && ! empty( $this->_config['client_secret'] );
    }

    /**
     * @return string
     */
    public function get_network_name() {
        return 'facebook';
    }
}
