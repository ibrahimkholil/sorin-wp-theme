<?php
namespace Sorin\ThemeOptions;
class ThemeOptions
{
	private $config;

	public function __construct()
	{
		global $config;
		$this->config = $config;
		$this->initThemeOptions();
		$this->registerSections();
		add_action('admin_enqueue_scripts',[$this,'enqueueAssets']);
	}
	public function initThemeOptions()
	{
		if ( ! class_exists( 'Redux' ) ) {
			return;
		}
		$this->config->optionName = apply_filters( 'theme_opt/opt_name', $this->config->optionName );
		$theme = wp_get_theme();
		$args = array(
			'sorinThemeOptions'    => $this->config->optionName,
			'display_name'         => $theme->get( 'Name' ),
			'display_version'      => $theme->get( 'Version' ),
			'menu_type'            => 'menu',
			'allow_sub_menu'       => true,
			'menu_title'           => __( 'Sorin', $this->config->textDomain ),
			'page_title'           => __( 'Sorin Options', $this->config->textDomain ),
			'google_api_key'       => '',
			// Set it you want google fonts to update weekly. A google_api_key value is required.
			'google_update_weekly' => true,
			// Must be defined to add google fonts to the typography module
			'async_typography'     => true,
			// Use a asynchronous font on the front end or font string
			//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
			'admin_bar'            => true,
			// Show the panel pages on the admin bar
			'admin_bar_icon'       => 'dashicons-portfolio',
			// Choose an icon for the admin bar menu
			'admin_bar_priority'   => 50,
			// Choose an priority for the admin bar menu
			'global_variable'      => '',
			// Set a different name for your global variable other than the opt_name
			'dev_mode'             => false,
			// Show the time the page took to load, etc
			'update_notice'        => false,
			// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
			'customizer'           => true,
			// Enable basic customizer support
			//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
			//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

			// OPTIONAL -> Give you extra features
			'page_priority'        => null,
			// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
			'page_parent'          => 'themes.php',
			// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
			'page_permissions'     => 'manage_options',
			// Permissions needed to access the options panel.
			'menu_icon'            => $this->config->url.'/includes/theme-options/assets/images/sorin.png',
			// Specify a custom URL to an icon
			'last_tab'             => '',
			// Force your panel to always open to a specific tab (by id)
			'page_icon'            => 'icon-themes',
			// Icon displayed in the admin panel next to your menu_title
			'page_slug'            => '',
			// Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
			'save_defaults'        => true,
			// On load save the defaults to DB before user clicks save or not
			'default_show'         => false,
			// If true, shows the default value next to each field that is not the default value.
			'default_mark'         => '',
			// What to print by the field's title if the value shown is default. Suggested: *
			'show_import_export'   => true,
			// Shows the Import/Export panel when not used as a field.

			// CAREFUL -> These options are for advanced use only
			'transient_time'       => 60 * MINUTE_IN_SECONDS,
			'output'               => true,
			// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
			'output_tag'           => true,
			// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
			// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

			// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
			'database'             => '',
			// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
			'use_cdn'              => true,
			// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

			// HINTS
			'hints'                => array(
				'icon'          => 'el el-question-sign',
				'icon_position' => 'right',
				'icon_color'    => 'lightgray',
				'icon_size'     => 'normal',
				'tip_style'     => array(
					'color'   => 'red',
					'shadow'  => true,
					'rounded' => false,
					'style'   => '',
				),
				'tip_position'  => array(
					'my' => 'top left',
					'at' => 'bottom right',
				),
				'tip_effect'    => array(
					'show' => array(
						'effect'   => 'slide',
						'duration' => '500',
						'event'    => 'mouseover',
					),
					'hide' => array(
						'effect'   => 'slide',
						'duration' => '500',
						'event'    => 'click mouseleave',
					),
				),
			)
		);

		// Panel Intro text -> before the form
		if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
			if ( ! empty( $args['global_variable'] ) ) {
				$v = $args['global_variable'];
			} else {
				$v = str_replace( '-', '_', $args['sorinThemeOptions'] );
			}
			$args['intro_text'] = '';
		} else {
			$args['intro_text'] = '';
		}

		// Add content after the form.
		$args['footer_text'] = '';
		\Redux::setArgs( $this->config->optionName, $args );
		$tabs = array(
			array(
				'id'      => 'redux-help-tab-1',
				'title'   => __( 'Theme Information 1', $this->config->textDomain),
				'content' => __( '<p>This is the tab content, HTML is allowed.</p>', $this->config->textDomain  )
			),
			array(
				'id'      => 'redux-help-tab-2',
				'title'   => __( 'Theme Information 2', $this->config->textDomain  ),
				'content' => '<p>'.__( 'This is the tab content, HTML is allowed', $this->config->textDomain ).'</p>'
			)
		);
		\Redux::setHelpTab( $this->config->optionName, $tabs );
		$content = __( '<p>This is the sidebar content, HTML is allowed.</p>', $this->config->textDomain );
		\Redux::setHelpSidebar( $this->config->optionName, $content );
	}
	public function registerSections()
	{
		$this->removeDemo();
		$this->generalSection();
        $this->headerSection();
		$this->socialSection();
		$this->typographySection();
		$this->footerSection();

	}
	public function generalSection()
	{
		\Redux::setSection( $this->config->optionName, array(
			'title'            => __( 'General Settings', $this->config->textDomain ),
			'id'               => 'generalOptions',
			'desc'             => __( 'Set General settings Fields.!', $this->config->textDomain ),
			'customizer_width' => '400px',
			'icon'             => 'el el-home',
			'fields'           => array(
				array(
					'id'       => 'siteLogo',
					'type'     => 'media',
					'url'      => true,
					'title'    => __('Site Logo', $this->config->textDomain),
					'compiler' => 'true',
					'desc'     => __('Site Logo media uploader.', $this->config->textDomain),
					'subtitle' => __('Site Logo media uploader.', $this->config->textDomain),
					'default' => array('url' => trailingslashit($this->config->url) . '/includes/theme-options/assets/images/logo.png'),
				),
                array(
                    'id'       => 'sorinPreloder',
                    'type'     => 'switch',
                    'title'    => __('Preloader Off', $this->config->textDomain),
                    'subtitle' => __('Set header button on/off', $this->config->textDomain),
                    'options' => array(
                        'on' => __('On',  $this->config->textDomain),
                        'off' => __('Off',  $this->config->textDomain),
                    ),
                    'default'  =>true,
                ),
                array(
                    'id'       => 'sorinPreloderText',
                    'type'     => 'text',
                    'title'    => __('Preloader Text', $this->config->textDomain),
                    'subtitle' => __('Set Preloader Text', $this->config->textDomain),
                    'desc'     => __( 'Word must be 5 to 8 character.', $this->config->textDomain ),
                    'default'  => 'sorin',
                ),
			)
		) );
	}
    public function headerSection()
    {
        \Redux::setSection($this->config->optionName, array(
            'title'   => __('Header', $this->config->textDomain),
            'id'      => 'headerSection',
            'desc'    => __('Set your top style Header platforms.', $this->config->textDomain),
            'icon'    => 'el el-credit-card',
            'fields'  => array(
                array(
                    'id'       => 'headerSticky',
                    'type'     => 'switch',
                    'title'    => __('Sticky Header', $this->config->textDomain),
                    'subtitle' => __('Set Sticky Header on/off', $this->config->textDomain),
                    'options' => array(
                        'on' => __('On',  $this->config->textDomain),
                        'off' => __('Off',  $this->config->textDomain),
                    ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'headerTopBg',
                    'type'     => 'color',
                    'title'    => __('Header Top Background', $this->config->textDomain),
                    'subtitle' => __('Set Header Top Background.', $this->config->textDomain),
                    'output'    => array('background-color' => '.sr-header-top')
                ),
                array(
                    'id'       => 'headerNumber',
                    'type'     => 'text',
                    'title'    => __('Header Number', $this->config->textDomain),
                    'subtitle' => __('Set Header Number.', $this->config->textDomain),
                    'desc'     => '',
                    'default'  => '',
                    'placeholder'  => 'e.g +015689222',
                ),
                array(
                    'id'       => 'headerEmail',
                    'type'     => 'text',
                    'title'    => __('Header Email', $this->config->textDomain),
                    'subtitle' => __('Set Header Email.', $this->config->textDomain),
                    'desc'     => '',
                    'default'  => '',
                    'placeholder'  => 'example@yourdomain.com',
                ),
                array(
                    'id'       => 'headerBtnText',
                    'type'     => 'text',
                    'title'    => __('Header Button Text', $this->config->textDomain),
                    'subtitle' => __('Set Header Button Text.', $this->config->textDomain),
                    'desc'     => '',
                    'default'  => '',
                ),
                array(
                    'id'       => 'headerBtnUrl',
                    'type'     => 'text',
                    'title'    => __('Header Button Link', $this->config->textDomain),
                    'subtitle' => __('Set Header Button Link.', $this->config->textDomain),
                    'desc'     => 'E.G: http://example.com',
                    'default'  => '',
                ),
                array(
                    'id'       => 'headerBtnOff',
                    'type'     => 'switch',
                    'title'    => __('Header Button  Hide', $this->config->textDomain),
                    'subtitle' => __('Set header button on/off', $this->config->textDomain),
                    'options' => array(
                        'on' => __('On',  $this->config->textDomain),
                        'off' => __('Off',  $this->config->textDomain),
                    ),
                    'default'  => true,
                )
            )
        ));
    }
	public function socialSection()
	{
		\Redux::setSection($this->config->optionName, array(
			'title'   => __('Social Network', $this->config->textDomain),
			'id'      => 'socialShare',
			'desc'    => __('Set profile links for your Social Share platforms.', $this->config->textDomain),
			'icon'    => 'el el-random',
			'fields'  => array(
				array(
					'id'       => 'socialShareTwitter',
					'type'     => 'text',
					'title'    => __('Twitter', $this->config->textDomain),
					'subtitle' => __('Set profile link for Twitter.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareFacebook',
					'type'     => 'text',
					'title'    => __('Facebook', $this->config->textDomain),
					'subtitle' => __('Set profile link for Facebook.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareGoogle',
					'type'     => 'text',
					'title'    => __('Google Plus', $this->config->textDomain),
					'subtitle' => __('Set profile link for Google Plus.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareLinkedin',
					'type'     => 'text',
					'title'    => __('Linkedin', $this->config->textDomain),
					'subtitle' => __('Set profile link for linkedin.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialSharePinterest',
					'type'     => 'text',
					'title'    => __('Pinterest', $this->config->textDomain),
					'subtitle' => __('Set profile link for Pinterest.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareTumblr',
					'type'     => 'text',
					'title'    => __('Tumblr', $this->config->textDomain),
					'subtitle' => __('Set profile link for Tumblr.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareDribbble',
					'type'     => 'text',
					'title'    => __('Dribbble', $this->config->textDomain),
					'subtitle' => __('Set profile link for Dribbble.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareInstagram',
					'type'     => 'text',
					'title'    => __('Instagram', $this->config->textDomain),
					'subtitle' => __('Set profile link for Instagram.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareYoutube',
					'type'     => 'text',
					'title'    => __('Youtube', $this->config->textDomain),
					'subtitle' => __('Set profile link for Youtube.', $this->config->textDomain),
					'desc'     => '',
					'default'  => '',
				),
				array(
					'id'       => 'socialShareHeight',
					'type'     => 'text',
					'title'    => __('Icon Height', $this->config->textDomain),
					'subtitle' => __('Set icon Height', $this->config->textDomain),
					'desc'     => __('Set Icon Height in (px)', $this->config->textDomain),
					'default'  => '',
				),
				array(
					'id'       => 'socialShareWidth',
					'type'     => 'text',
					'title'    => __('Icon Width', $this->config->textDomain),
					'subtitle' => __('Set icon Width', $this->config->textDomain),
					'desc'     => __('Set Icon Width in (px)', $this->config->textDomain),
					'default'  => '',
				),
				array(
					'id'       => 'socialShareBackgroundColor',
					'type'     => 'color_rgba',
					'title'    => __('Icon Background color', $this->config->textDomain),
					'transparent' => false,
					'subtitle' => __('Set icon Background color', $this->config->textDomain),
					'desc'     => __('Set Icon Background color', $this->config->textDomain),
					'default'  => '#188ff4',

				),
				array(
					'id'       => 'socialShareBackgroundHover',
					'type'     => 'color_rgba',
					'title'    => __('Icon Background Hover', $this->config->textDomain),
					'transparent' => false,
					'subtitle' => __('Set icon Background Hover', $this->config->textDomain),
					'desc'     => __('Set Icon Background Hover ', $this->config->textDomain),
					'default'  => '#94d015',
//					'validate' => 'color',
				),
				array(
					'id'       => 'socialShareLinkColor',
					'type'     => 'link_color',
					'title'    => __('Icon Color Option', $this->config->textDomain),
					'subtitle' => __('Set Icon colors', $this->config->textDomain),
					'default'  => array(
						'regular'  => '#1e73be', // blue
						'hover'    => '#dd3333', // red
						'active'   => '#8224e3',  // purple
						'visited'  => '#8224e3',  // purple
					)
				)
			)
		));
	}
	public function typographySection()
	{
        \Redux::setSection($this->config->optionName, array(
            'title'  => __( 'Typography', $this->config->textDomain ),
            'id'     => 'typography',
            'icon'   => 'el el-font',
            'fields' => array(
                array(
                    'id'       => 'sorinBodyFont',
                    'type'     => 'typography',
                    'title'    => __( 'Body Font', $this->config->textDomain ),
                    'subtitle' => __( 'Specify the body font properties.', $this->config->textDomain ),
                    'google'   => true,
                    'subsets'       => false,
                    'output' => array('body'),
                    'default'  => array(
                        'color'       => '#dd9933',
                        'font-size'   => '30px',
                        'font-family' => 'Arial,Helvetica,sans-serif',
                        'font-weight' => 'Normal',
                    ),
                ),
                array(
                    'id'          => 'sorinHeadingOne',
                    'type'        => 'typography',
                    'title'       => __( 'Heading H1', $this->config->textDomain ),
                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                    //'google'      => false,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup' => true,
                    // Select a backup non-google font in addition to a google font
                    //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    //'font-size'     => false,
                    //'line-height'   => false,
                    //'word-spacing'  => true,  // Defaults to false
                    //'letter-spacing'=> true,  // Defaults to false
                    //'color'         => false,
                    //'preview'       => false, // Disable the previewer
                    'all_styles'  => true,
                    // Enable all Google Font style/weight variations to be added to the page
                    'output'      => array( '.site-title, h1' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'compiler'    => array( 'site-title-compiler' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'units'       => 'px',
                    // Defaults to px
                    'subtitle'    => __( 'Typography option with each property can be called individually.', $this->config->textDomain ),
                    'default'     => array(
                        'color'       => '#333',
                        'font-style'  => '700',
                        'font-family' => 'Abel',
                        'google'      => true,
                        'font-size'   => '33px',
                        'line-height' => '40px'
                    ),
                ),
                array(
                    'id'          => 'sorinHeadingTwo',
                    'type'        => 'typography',
                    'title'       => __( 'Heading H2', $this->config->textDomain ),
                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                    //'google'      => false,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup' => true,
                    // Select a backup non-google font in addition to a google font
                    //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    //'font-size'     => false,
                    //'line-height'   => false,
                    //'word-spacing'  => true,  // Defaults to false
                    //'letter-spacing'=> true,  // Defaults to false
                    //'color'         => false,
                    //'preview'       => false, // Disable the previewer
                    'all_styles'  => true,
                    // Enable all Google Font style/weight variations to be added to the page
                    'output'      => array( '.site-title' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'compiler'    => array( 'site-title-compiler' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'units'       => 'px',
                    // Defaults to px
                    'subtitle'    => __( 'Typography option with each property can be called individually.', $this->config->textDomain ),
                    'default'     => array(
                        'color'       => '#333',
                        'font-style'  => '700',
                        'font-family' => 'Abel',
                        'google'      => true,
                        'font-size'   => '33px',
                        'line-height' => '40px'
                    ),
                ),
                array(
                    'id'          => 'sorinHeadingThree',
                    'type'        => 'typography',
                    'title'       => __( 'Heading H3', $this->config->textDomain ),
                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                    //'google'      => false,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup' => true,
                    // Select a backup non-google font in addition to a google font
                    //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    //'font-size'     => false,
                    //'line-height'   => false,
                    //'word-spacing'  => true,  // Defaults to false
                    //'letter-spacing'=> true,  // Defaults to false
                    //'color'         => false,
                    //'preview'       => false, // Disable the previewer
                    'all_styles'  => true,
                    // Enable all Google Font style/weight variations to be added to the page
                    'output'      => array( '.site-title' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'compiler'    => array( 'site-title-compiler' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'units'       => 'px',
                    // Defaults to px
                    'subtitle'    => __( 'Typography option with each property can be called individually.', $this->config->textDomain ),
                    'default'     => array(
                        'color'       => '#333',
                        'font-style'  => '700',
                        'font-family' => 'Abel',
                        'google'      => true,
                        'font-size'   => '33px',
                        'line-height' => '40px'
                    ),
                ),
                array(
                    'id'          => 'sorinHeadingFour',
                    'type'        => 'typography',
                    'title'       => __( 'Heading H4', $this->config->textDomain ),
                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                    //'google'      => false,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup' => true,
                    // Select a backup non-google font in addition to a google font
                    //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    //'font-size'     => false,
                    //'line-height'   => false,
                    //'word-spacing'  => true,  // Defaults to false
                    //'letter-spacing'=> true,  // Defaults to false
                    //'color'         => false,
                    //'preview'       => false, // Disable the previewer
                    'all_styles'  => true,
                    // Enable all Google Font style/weight variations to be added to the page
                    'output'      => array( '.site-title' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'compiler'    => array( 'site-title-compiler' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'units'       => 'px',
                    // Defaults to px
                    'subtitle'    => __( 'Typography option with each property can be called individually.', $this->config->textDomain ),
                    'default'     => array(
                        'color'       => '#333',
                        'font-style'  => '700',
                        'font-family' => 'Abel',
                        'google'      => true,
                        'font-size'   => '33px',
                        'line-height' => '40px'
                    ),
                ),
                array(
                    'id'          => 'sorinHeadingFive',
                    'type'        => 'typography',
                    'title'       => __( 'Heading H5', $this->config->textDomain ),
                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                    //'google'      => false,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup' => true,
                    // Select a backup non-google font in addition to a google font
                    //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    //'font-size'     => false,
                    //'line-height'   => false,
                    //'word-spacing'  => true,  // Defaults to false
                    //'letter-spacing'=> true,  // Defaults to false
                    //'color'         => false,
                    //'preview'       => false, // Disable the previewer
                    'all_styles'  => true,
                    // Enable all Google Font style/weight variations to be added to the page
                    'output'      => array( '.site-title' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'compiler'    => array( 'site-title-compiler' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'units'       => 'px',
                    // Defaults to px
                    'subtitle'    => __( 'Typography option with each property can be called individually.', $this->config->textDomain ),
                    'default'     => array(
                        'color'       => '#333',
                        'font-style'  => '700',
                        'font-family' => 'Abel',
                        'google'      => true,
                        'font-size'   => '33px',
                        'line-height' => '40px'
                    ),
                ),
                array(
                    'id'          => 'sorinHeadingSix',
                    'type'        => 'typography',
                    'title'       => __( 'Heading H6', $this->config->textDomain ),
                    //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                    //'google'      => false,
                    // Disable google fonts. Won't work if you haven't defined your google api key
                    'font-backup' => true,
                    // Select a backup non-google font in addition to a google font
                    //'font-style'    => false, // Includes font-style and weight. Can use font-style or font-weight to declare
                    'subsets'       => false, // Only appears if google is true and subsets not set to false
                    //'font-size'     => false,
                    //'line-height'   => false,
                    //'word-spacing'  => true,  // Defaults to false
                    //'letter-spacing'=> true,  // Defaults to false
                    //'color'         => false,
                    //'preview'       => false, // Disable the previewer
                    'all_styles'  => true,
                    // Enable all Google Font style/weight variations to be added to the page
                    'output'      => array( '.site-title' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'compiler'    => array( 'site-title-compiler' ),
                    // An array of CSS selectors to apply this font style to dynamically
                    'units'       => 'px',
                    // Defaults to px
                    'subtitle'    => __( 'Typography option with each property can be called individually.', $this->config->textDomain ),
                    'default'     => array(
                        'color'       => '#333',
                        'font-style'  => '700',
                        'font-family' => 'Abel',
                        'google'      => true,
                        'font-size'   => '33px',
                        'line-height' => '40px'
                    ),
                ),
            )
        ) );
	}
	public function footerSection()
	{
        \Redux::setSection($this->config->optionName, array(
            'title'  => __( 'Footer', $this->config->textDomain ),
            'id'     => 'footerSection',
            'icon'   => 'el el-credit-card',
            'fields' => array(
                array(
                    'id'       => 'footerLayout',
                    'type'     => 'image_select',
                    'title'    => __('Footer Layout', $this->config->textDomain),
                    'subtitle' => __('Select Footer content and sidebar alignment. Choose between 1, 2 or 3 column layout.', $this->config->textDomain),
                    'options'  => array(
                        '1'      => array(
                            'alt'   => '1 Column',
                            'img'   => trailingslashit($this->config->url) . '/includes/theme-options/assets/images/1col.png'
                        ),
                        '2'      => array(
                            'alt'   => '2 Column Left',
                            'img'   => trailingslashit($this->config->url) . '/includes/theme-options/assets/images/2cl.png'
                        ),
                        '3'      => array(
                            'alt'   => '2 Column Right',
                            'img'  => trailingslashit($this->config->url) . '/includes/theme-options/assets/images/2cr.png'
                        ),
                        '4'      => array(
                            'alt'   => '3 Column Middle',
                            'img'   => trailingslashit($this->config->url) . '/includes/theme-options/assets/images/3cm.png'
                        ),
                        '5'      => array(
                            'alt'   => '3 Column Left',
                            'img'   => trailingslashit($this->config->url) . '/includes/theme-options/assets/images/3cl.png'
                        ),
                        '6'      => array(
                            'alt'  => '3 Column Right',
                            'img'  => trailingslashit($this->config->url) . '/includes/theme-options/assets/images/3cr.png'
                        )
                    ),
                    'default' => '2'
                ),
                array(
                    'id'       => 'copyRiteText',
                    'type'     => 'textarea',
                    'title'    => __( 'Copyrite Text', $this->config->textDomain ),
                    'default'  =>'© Copyright OrangeTheme 2018. All Rights Reserved',
                ),
         )
        ) );
	}
	public function removeDemo()
	{

        /*
         *
         * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
         *
         */

        /*
        *
        * --> Action hook examples
        *
        */

        // If Redux is running as a plugin, this will remove the demo notice and links
        //add_action( 'redux/loaded', 'remove_demo' );

        // Function to test the compiler hook and demo CSS output.
        // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
        //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

        // Change the arguments after they've been declared, but before the panel is created
        //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

        // Change the default value of a field after it's been set, but before it's been useds
        //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

        // Dynamically add a section. Can be also used to modify sections/fields
        //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

        /**
         * This is a test function that will let you see when the compiler hook occurs.
         * It only runs if a field    set with compiler=>true is changed.
         * */
        if ( ! function_exists( 'compiler_action' ) ) {
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
                //print_r($options); //Option values
                //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
            }
        }

        /**
         * Custom function for the callback validation referenced above
         * */
        if ( ! function_exists( 'redux_validate_callback_function' ) ) {
            function redux_validate_callback_function( $field, $value, $existing_value ) {
                $error   = false;
                $warning = false;

                //do your validation
                if ( $value == 1 ) {
                    $error = true;
                    $value = $existing_value;
                } elseif ( $value == 2 ) {
                    $warning = true;
                    $value   = $existing_value;
                }

                $return['value'] = $value;

                if ( $error == true ) {
                    $field['msg']    = 'your custom error message';
                    $return['error'] = $field;
                }

                if ( $warning == true ) {
                    $field['msg']      = 'your custom warning message';
                    $return['warning'] = $field;
                }

                return $return;
            }
        }
        /**
         * Custom function for the callback referenced above
         */
        if ( ! function_exists( 'redux_my_custom_field' ) ) {
            function redux_my_custom_field( $field, $value ) {
                print_r( $field );
                echo '<br/>';
                print_r( $value );
            }
        }
        /**
         * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
         * Simply include this function in the child themes functions.php file.
         * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
         * so you must use get_template_directory_uri() if you want to use any of the built in icons
         * */
        if ( ! function_exists( 'dynamic_section' ) ) {
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', $this->config->textDomain ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', $this->config->textDomain ),
                    'icon'   => 'el el-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }
        }

        /**
         * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
         * */
        if ( ! function_exists( 'change_arguments' ) ) {
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }
        }

        /**
         * Filter hook for filtering the default value of any given field. Very useful in development mode.
         * */
        if ( ! function_exists( 'change_defaults' ) ) {
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }
        }
        /**
         * Removes the demo link and the notice of integrated demo from the redux-framework plugin
         */
        if ( ! function_exists( 'remove_demo' ) ) {
            function remove_demo() {
                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }
        }
	}
	public function enqueueAssets()
	{
		//$screen = get_current_screen();
//		if(strpos(strtolower($screen->id),$this->config->name)){
//		}
        wp_enqueue_style('adminOption', $this->config->url .' /assets/dist/css/admin.css',array(),true);

    }
}