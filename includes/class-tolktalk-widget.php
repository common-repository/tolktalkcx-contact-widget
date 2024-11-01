<?php
/**
 * The tolktalkCXWP_Widget class.
 *
 * @package tolktalkCXWP_Widget
 * @author  tolktalk
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

    /**
     * tolktalkCXWP_Widget.
     *
     * @since 1.0.0
     */
    class tolktalkCXWP_Widget extends WP_Widget
    {

        private $options;
        private $styles = array();

        /**
         * The constructor
         *
         * @return void
         * @since 1.0.0
         *
         */
        public function __construct()
        {
            $args = array(
                'classname' => 'tolktalkCXWP_Widget',
                'description' => __('Displays tolktalkCX Contact Widget', 'tolktalkcx-widget'),
            );

            parent::__construct('tolktalkCXWP_Widget', __('tolktalkCX Contact Widget', 'tolktalkcx-widget'), $args);
            add_action('admin_menu', array($this, 'tolktalkCX_add_plugin_page'));
            add_action('admin_init', array($this, 'tolktalkCX_plugin_register_settings'));
        }

        /**
         * Add options page
         */
        public function tolktalkCX_add_plugin_page()
        {
            // This page will be under "Settings"
            add_options_page(
                'Settings',
                'tolktalkCX Contact Widget',
                'manage_options',
                'tolktalk-widget-setting-admin',
                array($this, 'tolktalkCX_get_started_page')
            );
        }

        /**
         *
         * get started page call back
         */
        public function tolktalkCX_get_started_page()
        {
            // Set class property
            $this->options = get_option('tolktalk_option_name');
            ?>
            <style>
                @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600');

                .wrap {
                    display: flex;
                    justify-content: center;
                    margin: 3% 20px 0 0;
                }

                .wrap .custom-container {
                    font-family: 'Source Sans Pro', sans-serif;
                    width: 60%;
                    text-align: center;
                    font-size: 14px;
                    background-color: #ffffff;
                    padding: 30px;
                    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
                    border-radius: 6px;
                }

                .wrap .custom-container .heading {
                    font-family: 'Source Sans Pro', sans-serif;
                    display: flex;
                    justify-content: center;
                    margin-bottom: 6px;
                    align-items: center;
                    flex-wrap: wrap;
                }

                .wrap .custom-container .heading p {
                    margin: 0 0 10px 0;
                    padding: 0;
                    font-weight: 300;
                    font-size: 35px;
                    color: #14CC60;
                }

                .wrap .custom-container .heading img {
                    height: 34px;
                    margin-right: 5px;
                    margin-bottom: 10px;
                }

                .wrap .custom-container .panel {
                    padding: 0 25px;
                }

                .wrap .custom-container p {
                    font-size: 16px;
                    color: #000000;
                }

                .wrap .custom-container .panel .subheading {
                    margin: 0 0 20px;
                }

                .wrap .custom-container .panel .paragraph {
                    margin: 20px 0px;
                    font-size: 13px;
                }

                .wrap .custom-container .panel .paragraph-2 {
                    margin: 20px 0px 8px 0px;
                    font-size: 13px;
                }

                .wrap .custom-container .panel .paragraph-3 {
                    text-decoration: underline;
                    margin: 0px 0px 8px 0px;
                    font-size: 15px;
                    color: #4a4a4a;
                }

                .wrap .custom-container .panel a {
                    text-decoration: underline !important;
                }

                .wrap .custom-container .panel form {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .wrap .custom-container .panel form .button {
                    margin-left: 17px;
                }

                .wrap .custom-container .panel .form-table {
                    width: auto;
                    margin: 0px;
                }

                .wrap .custom-container .panel .form-table tbody tr {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .wrap .custom-container .panel .form-table tbody tr th {
                    text-align: right;
                    line-height: 2;
                    width: auto;
                    margin: 0 20px 0 0;
                    padding: 0px;
                    font-size: 16px;
                }

                .wrap .custom-container .panel .form-table tbody tr td {
                    padding: 0px;
                    margin: 0px;
                }

                .wrap .custom-container .panel .form-table tbody tr td .api-token {
                    width: 100%;
                    padding: 7px 9px;
                    font-size: 14px;
                    color: #949494;
                }

                .wrap .custom-container .panel .token__button {
                    color: #0073aa;
                    background-color: #ffffff;
                    border: none;
                    font-size: 13px;
                    text-decoration: underline;
                    cursor: pointer;
                    padding: 0;
                    margin: 0;
                }

                .wrap .custom-container .panel .token-content {
                    display: flex;
                    flex-direction: column;
                    width: 60%;
                }

                .wrap .custom-container .panel ul {
                    margin: 0px;
                    text-align: left;
                }

                .wrap .custom-container .panel ul li {
                    color: #000000;
                    margin-bottom: 10px;
                    font-size: 13px;
                }
            </style>

            <div class="wrap">
                <div class="custom-container">
                    <div class="heading">
                        <div style="width: 100%">
                            <img src="<?php echo plugin_dir_url( dirname( __FILE__ ) ) . 'includes/tolktalkcx.png'; ?>" alt="logo"/>
                        </div>
                        <p>tolktalkCX Contact Widget</p>
                    </div>
                    <div class="panel">
                        <p class="subheading">
                            Allow your website visitors to conveniently connect with your business directly from your website.
                            Convert your website "static contact us" page in to a "dynamic call-center-like" experience.
                        </p>
                        <p>
                            <a style="font-size:15px;" href="https://dashboard.tolktalk.com/" target="_blank">
                                Click here to access your tolktalkCX Dashboard
                            </a>
                        </p>

                        <?php $r1Connected = isset($this->options['token']) && !empty($this->options['token']) ?>
                        <?php if (!$r1Connected) : ?>
                            <a id="resolution1ConnectButton" href="javascript:void(0)" target="_blank" rel="opener">
                                <button class="button button-primary">
                                    Connect with tolktalkCX
                                </button>
                            </a>
                        <?php endif ?>
                        <?php if ($r1Connected) : ?>
                            <div class="heading">
                                <p>Widget has been installed!</p>
                            </div>
                        <?php endif ?>
                        <form id="resolution1TokenForm" method="post"
                              action="options.php" <?php echo(!$r1Connected ? 'style="display:none"' : '') ?>>
                            <?php
                            settings_fields('tolktalk_option_group');
                            do_settings_sections('tolktalk-widget-setting-admin');
                            ?>
                            <input name="submit" class="button button-primary" type="submit"
                                   value="<?php esc_attr_e('Save') ?>" style="display: none"/>
                        </form>
                        <?php if ($r1Connected) : ?>
                            <p class="paragraph-2">The <strong style="color:#4a4a4a;">API Token</strong> is used to
                                connect you to your tolktalkCX Dashboard to ensure conversations between
                                you and your customers are private.</p>
                            <p class="paragraph">
                                If the tolktalkCX Contact Widget associated with your Wordpress is incorrect, please <a id="resolution1ReconnectButton" href="javascript:void(0)" target="_blank" rel="opener">click here</a> to reconnect with tolktalkCX.
                            </p>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <script>
                (function () {
                    let nonce;
                    const form = document.getElementById('resolution1TokenForm');

                    const connectButton = document.getElementById('resolution1ConnectButton');
                    const reconnectButton = document.getElementById('resolution1ReconnectButton');

                    function generateLink() {
                        nonce = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
                        const params = new URLSearchParams({
                            nonce: nonce,
                            origin: window.location.origin,
                            source: 6,
                        });
                        return `https://dashboard.tolktalk.com/connect?${params.toString()}`;
                    }

                    const url = generateLink()
                    if (connectButton) connectButton.href = url;
                    if (reconnectButton) reconnectButton.href = url;

                    window.addEventListener('message', function (event) {
                        if (event.origin === 'https://dashboard.tolktalk.com') {
                            if (event.data.nonce && event.data.nonce === nonce) {
                                if (event.data.r1Event === 'connect' && event.data.token) {
                                    const tokenInput = form.querySelector('input[name="tolktalk_option_name[token]"]');
                                    const submitButton = form.querySelector('input[type="submit"]');
                                    tokenInput.value = event.data.token;
                                    submitButton.click();
                                }
                            }
                        }
                    }, false);
                })();
            </script>
            <?php
        }

        /**
         *
         * Register and add settings
         */
        public function tolktalkCX_plugin_register_settings()
        {
            register_setting(
                'tolktalk_option_group', // Option group
                'tolktalk_option_name', // Option name
                array($this, 'tolktalkCX_sanitize') // Sanitize
            );

            add_settings_section(
                'tolktalk_setting_section', // ID
                '', // Title
                array($this, 'tolktalkCX_print_section_info'), // Callback
                'tolktalk-widget-setting-admin' // Page
            );

            add_settings_field(
                'token', // ID
                'API Token:', // Title
                array($this, 'tolktalkCX_token_callback'), // Callback
                'tolktalk-widget-setting-admin', // Page
                'tolktalk_setting_section' // Section
            );
        }

        /**
         * Sanitize each setting field as needed
         *
         * @param array $input Contains all settings fields as array keys
         */
        public function tolktalkCX_sanitize($input)
        {
            $new_input = array();
            if (isset($input['token']))
                $new_input['token'] = sanitize_text_field($input['token']);

            return $new_input;
        }

        /**
         * Print the Section text
         */
        public function tolktalkCX_print_section_info()
        {
            // print 'Enter your settings below:';
        }

        /**
         * Get the settings option array and print one of its values
         */
        public function tolktalkCX_token_callback()
        {
            printf(
                '<input class="api-token" type="text" id="token" name="tolktalk_option_name[token]" placeholder="icclJ2agGMG5R" value="%s" readonly/>',
                isset($this->options['token']) ? esc_attr($this->options['token']) : ''
            );
        }

        /**
         * Displays widget for the frontend.
         *
         * @param array $args The widget args
         * @param string $instance The widget instance
         *
         * @return void
         * @since 1.0.0
         *
         */
        public function widget($args, $instance)
        {
            $this->options = get_option('tolktalk_option_name');

            /*
             * Validate token not empty.
             */
            if (!empty($this->options['token'])) :
                ?>
                <div id="resolution1"></div> <script> (function() { window.r1WidgetToken = "<?php echo esc_attr( $this->options['token']); ?>"; window.rSource = 6; const resolution = document.createElement('script'); resolution.src = "https://r1prod.azureedge.net/The_Script_widget_prod.js"; resolution.async = true; const one = document.createElement('link'); one.rel = "stylesheet"; one.type = "text/css"; one.href = "https://r1prod.azureedge.net/BasicStyle.css"; document.body.appendChild(resolution); document.head.appendChild(one); })() </script>
            <?php
            endif;
        }

        // /**
        //  * Handles widget updates in admin
        //  *
        //  * @param  array $new_instance
        //  * @param  array $old_instance
        //  *
        //  * @since 1.0.0
        //  *
        //  * @return array $instance
        //  */
        // public function update( $new_instance, $old_instance ) {
        // 	/* Updates widget title value */
        // 	$instance = $old_insatnce;

        // 	$instance['token'] = strip_tags( $new_instance['token'] );
        // 	return $instance;
        // }

        /**
         * Display widget form in admin.
         *
         * @param array $instance widget instance
         *
         * @return void
         * @since 1.0.0
         *
         */
        public function form($instance)
        {
            $this->options = get_option('tolktalk_option_name');
            if (empty($this->options['token'])):
                ?>
                <div>
                    <h3>tolktalkCX Contact Widget is not setup!</h3>
                    <p style="font-size: 14px;">
                        tolktalkCX account must be connected in order to setup your tolktalkCX Contact Widget
                    </p>
                    <p style="font-size: 14px;">To connect your tolktalkCX account,
                        navigate to <i>Settings > tolktalkCX Contact Widget</i>
                    </p>
                </div>
            <?php
            endif;
            if (!empty($this->options['token'])):
                ?>
                <div>
                    <h3>tolktalkCX Contact Widget has been setup successfully!</h3>
                    <p style="font-size: 14px;">To connect or reconnect with your tolktalkCX account,
                        navigate to <i>Settings > tolktalkCX Contact Widget</i>
                    </p>
                </div>

            <?php
            endif;
        }
    }


