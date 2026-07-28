<?php

/**
 * Class Es_Google_Authentication
 */
class Es_Google_Authentication extends Es_Authentication {

    /**
     * @var int
     */
    protected $_state_lifetime = 10 * MINUTE_IN_SECONDS;

    /**
     * @var bool
     */
    protected $_state_verified = false;

    /**
     * Es_Google_Authentication constructor.
     *
     * @param array $config
     */
    public function __construct( $config = array() ) {
        $config = es_parse_args( $config, array(
            'client_id' => ests( 'google_client_key' ),
            'client_secret' => ests( 'google_client_secret' ),
            'redirect_uri' => '',
            'context' => '',
            'code' => '',
            'state' => '',
            'error' => '',
            'error_description' => '',
        ) );

        parent::__construct( $config );
    }

    /**
     * Return google auth login url.
     *
     * @return string|void
     * @throws Exception
     */
    public function create_auth_url() {
        $state = $this->create_state();

        return add_query_arg( array(
            'redirect_uri' => urlencode( $this->get_redirect_url() ),
            'response_type' => 'code',
            'client_id' => $this->_config['client_id'],
            'access_type' => 'online',
            'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
            'auth_nonce' => wp_create_nonce( 'es_auth_action' ),
            'state' => $state,
        ), 'https://accounts.google.com/o/oauth2/v2/auth' );
    }


    /**
     * Generate and store OAuth state.
     *
     * @return string
     * @throws Exception
     */
    protected function create_state() {
        if ( headers_sent() ) {
            throw new Exception( __( 'Unable to initialize Google authentication.', 'es' ) );
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
            throw new Exception( __( 'The Google authentication request could not be verified. Please try again.', 'es' ) );
        }

        $state_hash = hash( 'sha256', $received_state );
        $cookie_name = $this->get_state_cookie_name( $state_hash );
        $expected_state = isset( $_COOKIE[ $cookie_name ] ) ? wp_unslash( $_COOKIE[ $cookie_name ] ) : '';

        if ( ! is_string( $expected_state ) || ! preg_match( '/^[a-f0-9]{64}$/', $expected_state ) || ! hash_equals( $expected_state, $received_state ) ) {
            $this->delete_state_cookie( $state_hash );

            throw new Exception( __( 'The Google authentication request could not be verified. Please try again.', 'es' ) );
        }

        $transient_name = $this->get_state_transient_name( $state_hash );

        if ( ! get_transient( $transient_name ) ) {
            $this->delete_state_cookie( $state_hash );

            throw new Exception( __( 'The Google authentication request has expired or has already been used.', 'es' ) );
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
        return 'es_google_oauth_state_' . substr( $state_hash, 0, 16 );
    }

    /**
     * Return OAuth state transient name.
     *
     * @param string $state_hash
     *
     * @return string
     */
    protected function get_state_transient_name( $state_hash ) {
        return 'es_google_oauth_' . $state_hash;
    }

    /**
     * @return bool
     */
    public function is_valid() {
        if ( ! empty( $this->_config['error'] ) ) {
            return false;
        }

        return ! empty( $this->_config['client_id'] ) && ! empty( $this->_config['client_secret'] );
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
            throw new Exception( __( 'Google authorization code is missing.', 'es' ) );
        }

        $params = array(
            'client_id' => $this->_config['client_id'],
            'redirect_uri' => $this->get_redirect_url(),
            'client_secret' => $this->_config['client_secret'],
            'code' => $this->_config['code'],
            'grant_type' => 'authorization_code',
        );

        $response = wp_safe_remote_post( 'https://www.googleapis.com/oauth2/v4/token', array(
            'method' => 'POST',
            'body' => $params,
        ) );

        if ( is_wp_error( $response ) ) {
            throw new Exception( $response->get_error_message() );
        }

        $token_response = json_decode( wp_remote_retrieve_body( $response ) );

        if ( ! empty( $token_response->error_description ) ) {
            throw new Exception( $token_response->error_description );
        }

        if ( ! empty( $token_response->error_message ) ) {
            throw new Exception( $token_response->error_message );
        }

        if ( ! empty( $token_response->error ) ) {
            throw new Exception( is_string( $token_response->error ) ? $token_response->error : __( 'Unable to receive Google access token.', 'es' ) );
        }

        return $token_response;
    }

    /**
     * @return string
     */
    public function get_network_name() {
        return 'google';
    }

    /**
     * Return Google user by access token.
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
            $user_response = wp_safe_remote_get( 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,picture', array(
                'headers' => array(
                    'Authorization' => 'Bearer ' . $token->access_token,
                ),
            ) );

            if ( is_wp_error( $user_response ) ) {
                throw new Exception( $user_response->get_error_message() );
            }

            $this->_user_data = json_decode( wp_remote_retrieve_body( $user_response ) );

            if ( ! empty( $this->_user_data->error->message ) ) {
                throw new Exception( $this->_user_data->error->message );
            }

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
        $g_user = $this->get_user();

        if ( ! empty( $g_user->email ) ) {
            $g_user->first_name = '';
            $g_user->last_name = '';

            if ( ! empty( $g_user->name ) ) {
                $name = explode( ' ', $g_user->name, 2 );

                if ( ! empty( $name[0] ) ) {
                    $g_user->first_name = $name[0];
                }

                if ( ! empty( $name[1] ) ) {
                    $g_user->last_name = $name[1];
                }

                // picture
            }

            $user_data = array(
                'user_login' => $g_user->email,
                'user_pass' => wp_generate_password(),
                'user_email' => $g_user->email,
                'first_name' => $g_user->first_name,
                'last_name' => $g_user->last_name,
            );

            $user_id = wp_insert_user( $user_data );

            if ( ! is_wp_error( $user_id ) ) {
                update_user_meta( $user_id, 'auth_google', 1 );

                do_action( 'register_new_user', $user_id );
                do_action( 'social_register_new_user', $user_id, $this );
            } else {
                throw new Exception( $user_id->get_error_message() );
            }
        } else {
            throw new Exception( __( 'Google user email is empty', 'es' ) );
        }

        return $user_id;
    }
}
