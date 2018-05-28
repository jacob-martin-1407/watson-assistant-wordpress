<?php
namespace WatsonConv\Settings;

class Advanced {
    const SLUG = Main::SLUG.'_advanced';

    public static function init_page() {
        add_submenu_page(Main::SLUG, 'Watson Assistant Plugin Customization', 
            'Advanced Features', 'manage_options', self::SLUG, array(__CLASS__, 'render_page'));
    }

    public static function init_settings() {
        self::init_rate_limit_settings();
        self::init_client_rate_limit_settings();
        self::init_voice_call_intro();
        self::init_twilio_cred_settings();
        self::init_call_ui_settings();
        self::init_context_var_settings();
    }

    public static function render_page() {
    ?>
        <div class="wrap" style="max-width: 95em">
            <h2><?php esc_html_e('Advanced Plugin Features', self::SLUG); ?></h2>
            
            <?php 
                Main::render_isv_banner(); 
                settings_errors(); 
            ?>

            <h2 class="nav-tab-wrapper">
                <a onClick="switch_tab('usage_management')" class="nav-tab nav-tab-active usage_management_tab">Usage Management</a>
                <a onClick="switch_tab('predefined')" class="nav-tab predefined_tab">Pre-Defined Responses</a>
                <a onClick="switch_tab('voice_call')" class="nav-tab voice_call_tab">Voice Calling</a>
                <a onClick="switch_tab('context_var')" class="nav-tab context_var_tab">Context Variables</a>
            </h2>

            <form action="options.php" method="POST">
                <div class="tab-page predefined_page" style="display: none"><?php self::render_predefined(); ?></div>
                <?php
                    settings_fields(self::SLUG); 

                    ?> 
                        <div class="tab-page usage_management_page">
                            <?php do_settings_sections(self::SLUG.'_usage_management') ?>
                        </div>
                        <div class="tab-page voice_call_page" style="display: none">
                            <?php do_settings_sections(self::SLUG.'_voice_call') ?>
                        </div>
                        <div class="tab-page context_var_page" style="display: none">
                            <?php self::context_var_description() ?>
                            <hr>
                            <table width='100%'>
                                <tr>
                                    <td class="responsive">
                                        <h2>Enter Context Variable Labels Here</h2>
                                        <p>
                                            Enter your desired labels in the text boxes. Next to the 
                                            text boxes, you can see the corresponding values of the 
                                            fields which you have set in your Wordpress profile, as
                                            an example of the information that will be provided to the 
                                            chatbot.
                                        </p>
                                        <table class='form-table'>
                                            <?php do_settings_fields(self::SLUG.'_context_var', 'watsonconv_context_var') ?>
                                        </table>
                                    </td>
                                    <td id='context-var-image' class="responsive">
                                        <img 
                                            class="drop-shadow" 
                                            style="width: 40em" 
                                            src="<?php echo WATSON_CONV_URL ?>/img/context_var.jpg"
                                        >
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <?php
                ?>

                <?php submit_button(); ?>
                <p class="update-message notice inline notice-warning notice-alt"
                style="padding-top: 0.5em; padding-bottom: 0.5em">
                    <b>Note:</b> If you have a server-side caching plugin installed such as
                    WP Super Cache, you may need to clear your cache after changing settings or
                    deactivating the plugin. Otherwise, your action may not take effect.
                <p>
            </form>
        </div>
    <?php
    }
    public static function render_predefined() {
    ?>
    <div class="wrap" style="max-width: 60em; ">
        <p><?php esc_html_e('This page contains information on advanced features supported by this plugin.
            If you have not yet created your chatbot, you should see the Introduction tab first.'); ?></p>
        <h2> <?php esc_html_e('Preset Response Options'); ?></h2>
        <p><?php esc_html_e('Using this feature, you can create predefined message buttons that users can use to
            quickly and easily respond to messages from your chatbot as shown here.'); ?></p>
        <img class="drop-shadow" style="height: 24em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/result.png">
        <p><?php esc_html_e('The following instructions will guide you through the process of using this feature.') ?></p>

        <h4><?php esc_html_e('1. Open your chatbot workspace in Watson Assistant and go to the Dialog tab.') ?>
        <h4><?php esc_html_e('2. Select the node you want to create predefined messages for.') ?></h4>
        <img class="drop-shadow" style="width: 60em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/2_full_page_highlighted.jpg">
        <h4><?php esc_html_e('3. Click the 3 dots at the top-right of this section to get the following dropdown.
            Click the "Open JSON Editor" button.') ?></h4>
        <img class="drop-shadow" style="width: 44em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/4_json_dropdown.png">
        <h4><?php esc_html_e('A box should open up containing text resembling the picture below.') ?></h4>
        <img class="drop-shadow" style="width: 44em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/5_json_initial.png">
        <h4><?php esc_html_e('4. Find the line containing "text". In this case it\'s line 3. You will
             notice this line has an opening curly bracket at the end.') ?></h4>
        <img class="drop-shadow" style="width: 44em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/6_json_text_open.png">
        <h4><?php esc_html_e('5. Look below the word "text" to find the matching closing bracket.') ?></h4>
        <img class="drop-shadow" style="width: 44em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/7_json_text_close.png">
        <h4><?php esc_html_e('6. Add the following text after this closing bracket. The empty line 
            under "options" is where you\'ll put your predefined messages.') ?></h4>
        <img class="drop-shadow" style="width: 44em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/8_json_options_added.png">
        <h4><?php esc_html_e('7. Write your message options in the space below "options", with one message per line.
            Surround each message with double quotes and put a comma at the end of each line except for the last,
            as shown in the picture below.  ') ?></h4>
        <img class="drop-shadow" style="width: 44em" src="<?php echo WATSON_CONV_URL ?>/img/options_instructions/9_json_options_filled.png">
        <h4><?php esc_html_e('If done correctly, the chatbox on your Wordpress site should now show
            these response options as buttons like in the picture at the top of this page.') ?></h4>
    </div>
    <?php
    }

    // ---------------- Rate Limiting -------------------

    public static function init_rate_limit_settings() {
        $settings_page = self::SLUG . '_usage_management';

        add_settings_section('watsonconv_rate_limit', 'Total Usage Management',
            array(__CLASS__, 'rate_limit_description'), $settings_page);

        $overage_title = sprintf(
            '<span href="#" title="%s">%s</span>', 
            esc_html__(
                'This is the message that will be given to users who are talking with your chatbot
                when the Maximum Number of Total Requests is exceeded. The chat box will disappear
                when the user navigates to a different page.'
                , self::SLUG
            ),
            esc_html__('Overage Message', self::SLUG)
        );

        add_settings_field('watsonconv_use_limit', 'Limit Total API Requests',
            array(__CLASS__, 'render_use_limit'), $settings_page, 'watsonconv_rate_limit');
        add_settings_field('watsonconv_limit', 'Maximum Number of Total Requests',
            array(__CLASS__, 'render_limit'), $settings_page, 'watsonconv_rate_limit');
        add_settings_field('watsonconv_limit_message', $overage_title,
            array(__CLASS__, 'render_limit_message'), $settings_page, 'watsonconv_rate_limit');

        register_setting(self::SLUG, 'watsonconv_use_limit');
        register_setting(self::SLUG, 'watsonconv_interval');
        register_setting(self::SLUG, 'watsonconv_limit');
        register_setting(self::SLUG, 'watsonconv_limit_message');
    }

    public static function rate_limit_description($args) {
    ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <p>
                <?php esc_html_e('
                    This section allows you to prevent overusage of your credentials by
                    limiting use of the chat bot.
                ', self::SLUG) ?>
            </p>
            <p>
                <?php esc_html_e("
                    If you have a paid plan for Watson
                    Assistant, then the amount you have to pay is directly related to the
                    number of API requests made. The number of API requests is equal to the
                    number of messages sent by users of your chat bot, in addition to the chatbot's initial greeting.
                ", self::SLUG) ?>
            </p>
            <p>
                <?php 
                    esc_html_e("
                        For example, the Standard plan charges $0.0025 per API call (one API call includes
                        one message sent by a user and its response from the chatbot). That means if 
                        visitors to your site send a total of 1000 messages in a month, you will be 
                        charged ($0.0025 per API call) x (1000 calls) = $2.50. If you want to limit the 
                        costs incurred by this chatbot, you can put a limit on the total number of API 
                        requests for a specific period of time here. However, it is recommended to regularly
                        check your API usage for Watson Assistant in your
                    ", self::SLUG);
                    printf(
                        ' <a href="https://console.bluemix.net/dashboard/apps" target="_blank">%s</a> ', 
                        esc_html__('IBM Cloud Console', self::SLUG)
                    );
                    esc_html_e("
                        as that is the most accurate measure.
                    ", self::SLUG);
                ?>
            </p>
        </p>
    <?php
    }

    public static function render_use_limit() {
        Main::render_radio_buttons(
            'watsonconv_use_limit',
            'no',
            array(
                array(
                    'label' => esc_html__('Yes', self::SLUG),
                    'value' => 'yes'
                ), array(
                    'label' => esc_html__('No', self::SLUG),
                    'value' => 'no'
                )
            )
        );
    }

    public static function render_limit() {
        $limit = get_option('watsonconv_limit');
    ?>
        <input name="watsonconv_limit" id="watsonconv_limit" type="number"
            value="<?php echo empty($limit) ? 0 : $limit?>"
            style="width: 8em" />
        <select name="watsonconv_interval" id="watsonconv_interval">
            <option value="monthly" <?php selected(get_option('watsonconv_interval', 'monthly'), 'monthly')?>>
                Per Month
            </option>
            <option value="weekly" <?php selected(get_option('watsonconv_interval', 'monthly'), 'weekly')?>>
                Per Week
            </option>
            <option value="daily" <?php selected(get_option('watsonconv_interval', 'monthly'), 'daily')?>>
                Per Day
            </option>
            <option value="hourly" <?php selected(get_option('watsonconv_interval', 'monthly'), 'hourly')?>>
                Per Hour
            </option>
        </select>
    <?php
    }
    
    public static function render_limit_message() {
    ?>
        <input name="watsonconv_limit_message" id="watsonconv_limit_message" type="text"
            value="<?php echo get_option('watsonconv_limit_message', "Sorry, I can't talk right now. Try again later.") ?>"
            style="width: 40em" />
    <?php
    }

    // ---------- Rate Limiting Per Client --------------

    public static function init_client_rate_limit_settings() {
        $settings_page = self::SLUG . '_usage_management';

        add_settings_section('watsonconv_client_rate_limit', 'Usage Per Client',
            array(__CLASS__, 'client_rate_limit_description'), $settings_page);

        $overage_title = sprintf(
            '<span href="#" title="%s">%s</span>', 
            esc_html__(
                'This is the message that will be given to users who exceed the Maximum Number of
                Requests Per Client. The chat box will disappear when the user navigates to a 
                different page.'
                , self::SLUG
            ),
            esc_html__('Overage Message', self::SLUG)
        );

        add_settings_field('watsonconv_use_client_limit', 'Limit API Requests Per Client',
            array(__CLASS__, 'render_use_client_limit'), $settings_page, 'watsonconv_client_rate_limit');
        add_settings_field('watsonconv_client_limit', 'Maximum Number of Requests Per Client',
            array(__CLASS__, 'render_client_limit'), $settings_page, 'watsonconv_client_rate_limit');
        add_settings_field('watsonconv_client_limit_message', $overage_title,
            array(__CLASS__, 'render_client_limit_message'), $settings_page, 'watsonconv_client_rate_limit');

        register_setting(self::SLUG, 'watsonconv_use_client_limit');
        register_setting(self::SLUG, 'watsonconv_client_interval');
        register_setting(self::SLUG, 'watsonconv_client_limit');
        register_setting(self::SLUG, 'watsonconv_client_limit_message');
    }

    public static function render_use_client_limit() {
        Main::render_radio_buttons(
            'watsonconv_use_client_limit',
            'no',
            array(
                array(
                    'label' => esc_html__('Yes', self::SLUG),
                    'value' => 'yes'
                ), array(
                    'label' => esc_html__('No', self::SLUG),
                    'value' => 'no'
                )
            )
        );
    }

    public static function client_rate_limit_description($args) {
    ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <?php esc_html_e('
                These settings allow you to control how many messages can be sent by each
                visitor to your site, rather than in total. This can help protect against
                a few visitors from using up too many messages and, therefore, preventing
                the rest of the visitors from having access to the chatbot.
            ', self::SLUG) ?>
            </a>
        </p>
    <?php
    }

    public static function render_client_limit() {
        $client_limit = get_option('watsonconv_client_limit');
    ?>
        <input name="watsonconv_client_limit" id="watsonconv_client_limit" type="number"
            value="<?php echo empty($client_limit) ? 0 : $client_limit ?>"
            style="width: 8em" />
        <select name="watsonconv_client_interval" id="watsonconv_client_interval">
            <option value="monthly" <?php selected(get_option('watsonconv_client_interval', 'monthly'), 'monthly')?>>
                Per Month
            </option>
            <option value="weekly" <?php selected(get_option('watsonconv_client_interval', 'monthly'), 'weekly')?>>
                Per Week
            </option>
            <option value="daily" <?php selected(get_option('watsonconv_client_interval', 'monthly'), 'daily')?>>
                Per Day
            </option>
            <option value="hourly" <?php selected(get_option('watsonconv_client_interval', 'monthly'), 'hourly')?>>
                Per Hour
            </option>
        </select>
    <?php
    }
    
    public static function render_client_limit_message() {
    ?>
        <input name="watsonconv_client_limit_message" id="watsonconv_client_limit_message" type="text"
            value="<?php echo get_option('watsonconv_client_limit_message', "Sorry, I can't talk right now. Try again later.") ?>"
            style="width: 40em" />
    <?php
    }

    // ------------- Voice Calling -------------------

    public static function init_voice_call_intro() {
        $settings_page = self::SLUG . '_voice_call';

        add_settings_section('watsonconv_voice_call_intro', 'What is Voice Calling?',
            array(__CLASS__, 'voice_call_description'), $settings_page);
        
        add_settings_field('watsonconv_call_recipient', 'Phone Number to Receive Calls from Users',
            array(__CLASS__, 'render_call_recipient'), $settings_page, 'watsonconv_voice_call_intro');
        add_settings_field('watsonconv_use_twilio', 'Use Voice Calling?',
            array(__CLASS__, 'render_use_twilio'), $settings_page, 'watsonconv_voice_call_intro');

        register_setting(self::SLUG, 'watsonconv_call_recipient', array(__CLASS__, 'validate_phone'));
        register_setting(self::SLUG, 'watsonconv_use_twilio');

    }

    public static function voice_call_description($args) {
    ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>">
            <?php esc_html_e('The Voice Calling feature essentially allows users to get in 
                touch with a real person on your team if they get tired of speaking with a chatbot.') ?> <br><br>
            <?php esc_html_e('If you input your phone number below, the user will have the option to call you.
                They can either do this by simply dialing
                your number on their phone, or you can enable the VOIP feature which allows the user to call
                you directly from their browser through their internet connection, with no toll. This is powered
                by a service called ') ?>
            <a href="http://cocl.us/what-is-twilio" target="_blank">Twilio</a>.
        </p>
    <?php
    }
    
    public static function render_call_recipient() {
    ?>
        <input name="watsonconv_call_recipient" id="watsonconv_call_recipient" type="text"
            value="<?php echo get_option('watsonconv_call_recipient') ?>"
            placeholder="+15555555555"
            style="width: 24em" />
    <?php
    }

    public static function render_use_twilio() {
        Main::render_radio_buttons(
            'watsonconv_use_twilio',
            'no',
            array(
                array(
                    'label' => esc_html__('Yes', self::SLUG),
                    'value' => 'yes'
                ), array(
                    'label' => esc_html__('No', self::SLUG),
                    'value' => 'no'
                )
            )
        );
    }
    
    // ------------ Twilio Credentials ---------------

    public static function init_twilio_cred_settings() {
        $settings_page = self::SLUG . '_voice_call';

        add_settings_section('watsonconv_twilio_cred', '<span class="twilio_settings">Twilio Credentials</span>',
            array(__CLASS__, 'twilio_cred_description'), $settings_page);

        add_settings_field('watsonconv_twilo_sid', 'Account SID', array(__CLASS__, 'render_twilio_sid'),
            $settings_page, 'watsonconv_twilio_cred');
        add_settings_field('watsonconv_twilio_auth', 'Auth Token', array(__CLASS__, 'render_twilio_auth'),
            $settings_page, 'watsonconv_twilio_cred');
        add_settings_field('watsonconv_call_id', 'Caller ID (Verified Number with Twilio)',
            array(__CLASS__, 'render_call_id'), $settings_page, 'watsonconv_twilio_cred');
        add_settings_field('watsonconv_twilio_domain', 'Domain Name of this Website (Probably doesn\'t need changing)',
            array(__CLASS__, 'render_domain_name'), $settings_page, 'watsonconv_twilio_cred');

        register_setting(self::SLUG, 'watsonconv_twilio', array(__CLASS__, 'validate_twilio'));
        register_setting(self::SLUG, 'watsonconv_call_id', array(__CLASS__, 'validate_phone'));
    }

    public static function validate_twilio($new_config) {
        if (!empty($new_config['sid']) || !empty($new_config['auth_token'])) {
            $old_config = get_option('watsonconv_twilio');

            try {
                $client = new \Twilio\Rest\Client($new_config['sid'], $new_config['auth_token']);
                
                try {
                    $app = $client
                        ->applications(get_option('watsonconv_twiml_sid'))
                        ->fetch();
                } catch (\Twilio\Exceptions\RestException $e) {
                    $app = false;
                    $params = array('FriendlyName' => 'Chatbot for ' . $new_config['domain_name']);

                    foreach($client->account->applications->read($params) as $_app) {
                        $app = $_app;
                    }

                    if (!$app) {
                        $params = array('FriendlyName' => 'Chatbot for ' . $old_config['domain_name']);
        
                        foreach($client->account->applications->read($params) as $_app) {
                            $app = $_app;
                        }

                        if (!$app) {
                            $app = $client->applications->create('Chatbot for ' . $new_config['domain_name']);
                        }
                    }
                }

                $app->update(
                    array(
                        'voiceUrl' => $new_config['domain_name'] . '?rest_route=/watsonconv/v1/twilio-call',
                        'FriendlyName' => 'Chatbot for ' . $new_config['domain_name']
                    )
                );

                update_option('watsonconv_twiml_sid', $app->sid);
            } catch (\Exception $e) {
                add_settings_error(
                    'watsonconv_twilio', 
                    'twilio-invalid', 
                    $e->getMessage() . ' (' . $e->getCode() . ')'
                );
                
                return array(
                    'sid' => '',
                    'auth_token' => '',
                    'domain_name' => $old_config['domain_name']
                );
            }
        }

        return $new_config;
    }

    public static function validate_phone($number) {
        if (!empty($number) && !preg_match('/^\+?[1-9]\d{1,14}$/', $number)) {
            add_settings_error(
                'watsonconv_twilio', 
                'invalid-phone-number', 
                'Please use valid E.164 format for phone numbers (e.g. +15555555555).'
            );

            return '';
        }

        return $number;
    }

    public static function twilio_cred_description($args) {
    ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>" class="twilio_settings">
            <a href="http://cocl.us/try-twilio" target="_blank">
                <?php esc_html_e('Start by creating your free trial Twilio account here.')?>
            </a><br>
            <?php esc_html_e(' You can get your Account SID and Auth Token from your Twilio Dashboard.') ?> <br>
            <?php esc_html_e('For the caller ID, you can use a number that you\'ve either obtained from or') ?>
            <a href="https://www.twilio.com/console/phone-numbers/verified" target="_blank">
                <?php esc_html_e('verified with') ?>
            </a>
            <?php esc_html_e('Twilio.') ?> <br>
            <?php esc_html_e('Then just specify the phone number you want to answer the user\'s calls on 
                and you\'re good to go.') ?> <br>
            <?php esc_html_e('The Domain Name below is simply the domain name that Twilio will use 
                to reach your website. For most websites the default will work fine.', self::SLUG) ?> <br><br>
            <?php esc_html_e('Note: Phone numbers must be entered in E.164 format (e.g. +15555555555).') ?>
        </p>
    <?php
    }

    public static function render_twilio_sid() {
        $config = get_option('watsonconv_twilio');
        $sid = (empty($config) || empty($config['sid'])) ? '' : $config['sid'];
    ?>
        <input name="watsonconv_twilio[sid]" id="watsonconv_twilio_sid" type="text"
            value="<?php echo $sid ?>"
            placeholder="xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
            style="width: 24em" />
    <?php
    }

    public static function render_twilio_auth() {
        $config = get_option('watsonconv_twilio');
        $token = (empty($config) || empty($config['auth_token'])) ? '' : $config['auth_token'];
    ?>
        <input name="watsonconv_twilio[auth_token]" id="watsonconv_twilio_auth" type="password"
            value="<?php echo $token ?>"
            style="width: 24em"/>
    <?php
    }
    
    public static function render_call_id() {
    ?>
        <input name="watsonconv_call_id" id="watsonconv_call_id" type="text"
            value="<?php echo get_option('watsonconv_call_id') ?>"
            placeholder="+15555555555"
            style="width: 24em" />
    <?php
    }
    
    public static function render_domain_name() {
        $config = get_option('watsonconv_twilio');
        $domain_name = (empty($config) || empty($config['domain_name']))
            ? get_site_url() : $config['domain_name'];
    ?>
        <input name="watsonconv_twilio[domain_name]" id="watsonconv_twilio_domain" type="text"
            value="<?php echo $domain_name ?>"
            placeholder="<?php echo get_site_url() ?>"
            style="width: 24em" />
    <?php
    }
    
    // ------------ Voice Call UI Text ---------------

    public static function init_call_ui_settings() {
        $settings_page = self::SLUG . '_voice_call';

        add_settings_section('watsonconv_call_ui', '<span class="twilio_settings">Voice Call UI Text</span>',
            array(__CLASS__, 'twilio_call_ui_description'), $settings_page);

        add_settings_field('watsonconv_call_tooltip', 'This message will display when the user hovers over the phone button.', 
            array(__CLASS__, 'render_call_tooltip'), $settings_page, 'watsonconv_call_ui');
        add_settings_field('watsonconv_call_button', 'This is the text for the button to call using Twilio.',
            array(__CLASS__, 'render_call_button'), $settings_page, 'watsonconv_call_ui');
        add_settings_field('watsonconv_calling_text', 'This text is displayed when calling.',
            array(__CLASS__, 'render_calling_text'), $settings_page, 'watsonconv_call_ui');

        register_setting(self::SLUG, 'watsonconv_call_tooltip');
        register_setting(self::SLUG, 'watsonconv_call_button');
        register_setting(self::SLUG, 'watsonconv_calling_text');
    }

    public static function twilio_call_ui_description($args) {
    ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>" class="twilio_settings">
            <?php esc_html_e('Here, you can customize the text to be used in the voice calling 
                user interface.', self::SLUG) ?>
        </p>
    <?php
    }

    public static function render_call_tooltip() {
    ?>
        <input name="watsonconv_call_tooltip" id="watsonconv_call_tooltip" type="text"
            value="<?php echo get_option('watsonconv_call_tooltip') ?: 'Talk to a Live Agent' ?>"
            style="width: 24em" />
    <?php
    }

    public static function render_call_button() {
    ?>
        <input name="watsonconv_call_button" id="watsonconv_call_button" type="text"
            value="<?php echo get_option('watsonconv_call_button') ?: 'Start Toll-Free Call Here' ?>"
            style="width: 24em"/>
    <?php
    }
    
    public static function render_calling_text() {
    ?>
        <input name="watsonconv_calling_text" id="watsonconv_calling_text" type="text"
            value="<?php echo get_option('watsonconv_calling_text') ?: 'Calling Agent...' ?>"
            style="width: 24em"/>
    <?php
    }
    
    // ---------- Context Variable Settings -------------
    
    private static function init_context_var_settings() {
        $settings_page = self::SLUG . '_context_var';

        add_settings_section('watsonconv_context_var', '',
            array(__CLASS__, 'context_var_description'), $settings_page);

        $first_name_title = sprintf(
            '<span href="#" title="%s">%s</span>', 
            esc_html__(
                'The first name of the user.'
                , self::SLUG
            ),
            esc_html__('First Name', self::SLUG)
        );

        $last_name_title = sprintf(
            '<span href="#" title="%s">%s</span>', 
            esc_html__(
                'The last name of the user.'
                , self::SLUG
            ),
            esc_html__('Last Name', self::SLUG)
        );

        $nickname_title = sprintf(
            '<span href="#" title="%s">%s</span>', 
            esc_html__(
                "The user's nickname."
                , self::SLUG
            ),
            esc_html__('Nickname', self::SLUG)
        );

        $email_title = sprintf(
            '<span href="#" title="%s">%s</span>', 
            esc_html__(
                "The user's email address."
                , self::SLUG
            ),
            esc_html__('Email Address', self::SLUG)
        );

        $login_title = sprintf(
            '<span href="#" title="%s">%s</span>', 
            esc_html__(
                "The user's login username."
                , self::SLUG
            ),
            esc_html__('Username', self::SLUG)
        );
        
        add_settings_field('watsonconv_fname_var', $first_name_title,
            array(__CLASS__, 'render_fname_var'), $settings_page, 'watsonconv_context_var');
        add_settings_field('watsonconv_lname_var', $last_name_title,
            array(__CLASS__, 'render_lname_var'), $settings_page, 'watsonconv_context_var');
        add_settings_field('watsonconv_nname_var', $nickname_title,
            array(__CLASS__, 'render_nname_var'), $settings_page, 'watsonconv_context_var');
        add_settings_field('watsonconv_email_var', $email_title,
            array(__CLASS__, 'render_email_var'), $settings_page, 'watsonconv_context_var');
        add_settings_field('watsonconv_login_var', $login_title,
            array(__CLASS__, 'render_login_var'), $settings_page, 'watsonconv_context_var');

        register_setting(self::SLUG, 'watsonconv_fname_var', array(__CLASS__, 'validate_context_var'));
        register_setting(self::SLUG, 'watsonconv_lname_var', array(__CLASS__, 'validate_context_var'));
        register_setting(self::SLUG, 'watsonconv_nname_var', array(__CLASS__, 'validate_context_var'));
        register_setting(self::SLUG, 'watsonconv_email_var', array(__CLASS__, 'validate_context_var'));
        register_setting(self::SLUG, 'watsonconv_login_var', array(__CLASS__, 'validate_context_var'));
    }

    public static function context_var_description() {
    ?>
        <p>
            Would you like to use a user's name or email in your chatbot's dialog? 
            This page allows you to send user account information (such as first name, last name) to your
            Watson Assistant chatbot as a "context variable". You can use this to customize
            your dialog to say different things depending on the value of the context variable. 
            To do this, follow these instructions:
        </p>
        <ol>
            <li>Give labels to the values you want to use by filling out the fields below 
                (e.g. 'fname' for First Name).</li>
            <li>Navigate to you Watson Assistant workspace (the place where you create your chatbot's dialog).</li>
            <li>Now you can type <strong>$fname</strong> in your chatbot dialog and this 
                will be replaced with the user's first name.</li> 
            <li>Sometimes a user may not specify their first name and so this context 
                variable won't be sent. Because of this, you should check if the
                chatbot recognizes the context variable first like in the example below.</li>
        </ol>
    <?php
    } 

    public static function render_fname_var() {
    ?>
        <input name="watsonconv_fname_var" id="watsonconv_fname_var"
            type="text" style="width: 16em"
            placeholder="e.g. fname"
            value="<?php echo get_option('watsonconv_fname_var', '') ?>" 
        />
        <span class='dashicons dashicons-arrow-right-alt'></span>
        "<?php echo get_user_meta(get_current_user_id(), 'first_name', true); ?>"
    <?php
    }

    public static function render_lname_var() {
        ?>
            <input name="watsonconv_lname_var" id="watsonconv_lname_var"
                type="text" style="width: 16em"
                placeholder="e.g. lname"
                value="<?php echo get_option('watsonconv_lname_var', '') ?>" 
            />
            <span class='dashicons dashicons-arrow-right-alt'></span>
            "<?php echo get_user_meta(get_current_user_id(), 'last_name', true); ?>"
        <?php
    }

    public static function render_nname_var() {
        ?>
            <input name="watsonconv_nname_var" id="watsonconv_nname_var"
                type="text" style="width: 16em"
                placeholder="e.g. nickname"
                value="<?php echo get_option('watsonconv_nname_var', '') ?>" 
            />
            <span class='dashicons dashicons-arrow-right-alt'></span>
            "<?php echo get_user_meta(get_current_user_id(), 'nickname', true); ?>"
        <?php
    }

    public static function render_email_var() {
        ?>
            <input name="watsonconv_email_var" id="watsonconv_email_var"
                type="text" style="width: 16em"
                placeholder="e.g. email"
                value="<?php echo get_option('watsonconv_email_var', '') ?>" 
            />
            <span class='dashicons dashicons-arrow-right-alt'></span>
            "<?php echo wp_get_current_user()->get('user_email'); ?>"
        <?php
    }

    public static function render_login_var() {
        ?>
            <input name="watsonconv_login_var" id="watsonconv_login_var"
                type="text" style="width: 16em"
                placeholder="e.g. username"
                value="<?php echo get_option('watsonconv_login_var', '') ?>" 
            />
            <span class='dashicons dashicons-arrow-right-alt'></span>
            "<?php echo wp_get_current_user()->get('user_login'); ?>"
        <?php
    }

    public static function validate_context_var($str) 
    {
        if (preg_match('/^[a-zA-Z0-9_]*$/',$str)) {
            return $str;
        } else {
            add_settings_error('watsonconv', 'invalid-var-name', 
                'A context variable name can only contain upper and lowercase alphabetic characters,
                numeric characters (0-9), and underscores.');
            return '';
        }
    }
}
