<?php
namespace Sorin;
use Sorin\ThemeOptions\ThemeOptions;

class Theme
{
	/**
 * Theme version
 * @var string
 */
	private $config;
	/**
	 * Theme options
	 * @var array
	 */
	public $themeOptions;
	/**
	 * @method __construct()
	 */
	public function __construct()
	{
		global $config;
        $this->config = $config;
		$this->themeSetUp();
		$this->addThemeOptions();
		$this->sorinExcerpt();
		add_action('wp_enqueue_scripts', array( $this, 'enqueueAssets' ));
        add_shortcode('sorinpreloader',array($this,'sorinPreloaderRender'));
		add_action('widgets_init',array($this,'registerSidebars'));
	}
	public function themeSetUp()
	{
		/**
		 * Make theme available for translation
		 */
		load_theme_textdomain($this->config->textDomain);
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/**
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

        /*
         * Enable support for Post Thumbnails on posts and pages.
         * add_image_size( 'wordpress-thumbnail', 200, 200, FALSE );
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );
		// add custom image sizes
		add_image_size('sorin-large-thumb', 650, 650, true); // Home elements or about info 650x650
		add_image_size('sorin-large', 848, 400, true); // blog large and detail, size 848x400
		add_image_size('sorin-grid', 360, 240, true); // blog grid
		add_image_size('sorin-post', 243, 288, true); // posts for Medium

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

        /*
            * Enable support for Post Formats.
            * See https://developer.wordpress.org/themes/functionality/post-formats/
            */
        add_theme_support( 'post-formats', array(
                'aside',
                'image',
                'video',
                'quote',
                'link',
            )
        );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => __( 'Primary', $this->config->textDomain),
            'footer' => __( 'Footer', $this->config->textDomain ),
        ) );
        /**
         * Set the content width in pixels, based on the theme's design and stylesheet.
         *
         * Priority 0 to make it available to lower priority callbacks.
         *
         * @global int $content_width
         */
        $GLOBALS['content_width'] = apply_filters( 'sorin_content_width', 640 );
	}

	/*
	 *Register sidebar
	 *
	 */
    public function registerSidebars(){
        register_sidebar(array(
            'name' => esc_html__('Main Sidebar', $this->config->textDomain),
            'id' => 'sorin-main-sidebar',
            'description'   => esc_html__( 'This is default sidebar.', $this->config->textDomain ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h4 class="sr-widget-title">',
            'after_title' => '</h4>',
        ));
        register_sidebars(4, array(
            'name' => esc_html__('Footer Widget %d', $this->config->textDomain),
            'id' => 'sorin-footer-widget',
            'description'   => esc_html__( 'This is footer widget sidebar.', $this->config->textDomain ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '<div style="clear:both;"></div></div>',
            'before_title' => '<h4 class="sr-widget-title">',
            'after_title' => '</h4>',
        ));
    }
	/*
	 * Enqueue Assets files themes
	 * @var
	 */

	public function enqueueAssets()
	{
		/*
		* Enqueue css Files
		*/
		wp_enqueue_style('fontawesome-all', get_template_directory_uri() . '/assets/vendor/fontawesome/css/all.min.css', array() , ($this->config->version));
		wp_enqueue_style('bootstrap-min', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css', array() , ($this->config->version));
		wp_enqueue_style('main', get_template_directory_uri() . '/assets/dist/css/main.css', array() , ($this->config->version));
		wp_enqueue_style( 'stylesheet', get_stylesheet_uri() );

		/*
		* Enqueue js Files
		*/
		wp_enqueue_script('jQuery');
		wp_enqueue_script( 'popper-min','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
		wp_enqueue_script('bootstrap-min', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.min.js', array(
			'jquery'
		) , ($this->config->version), true);
		wp_enqueue_script('site', get_template_directory_uri() . '/assets/dist/js/site.js', array(
			'jquery'
		) , ($this->config->version), true);

		/*
		 * Enqueue for comment
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/*
     * Custom excerpt.
     * @return content
     */
	function sorinExcerpt($length = '', $read_more = false, $cont = false, $id = '') {
		$excerpt = get_the_excerpt();
		if ('' != $id) {
			$excerpt = get_the_excerpt($id);
		}
		if (true === $cont) {
			if ('' == $id) {
				$excerpt = get_the_content();
			} else {
				$excerpt = get_post_field('post_content', $id);
			}
		}
		if ($length > 0) {
			$excerpt = wp_trim_words($excerpt, $length, '...');
		}

		if ($read_more) {
			$excerpt .= '<a class="sorin-readmore-btn" href="' . esc_url(get_permalink(get_the_ID())) . '">' . esc_html__('Read More', $this->config->textDomain) . '</a>';
		}

		return $excerpt;
	}

	public function addThemeOptions()
	{
		include $this->config->dir.'/includes/theme-options/ThemeOptions.php';
		include $this->config->dir.'/lib/ReduxCore/framework.php';
		new ThemeOptions(new \Redux());
	}
	/**
	 * Preloader Shortcode
	 *
	 */
    public function sorinPreloaderRender(){
        ob_start();?>
        <div class="sr-preloader">
            <div class="sr-preloader-box">
                <?php
                        global $themeOptions;
                        $preloaderText = $themeOptions->sorinPreloderText;
                        $textPreg      = preg_split('//', $preloaderText, -1, PREG_SPLIT_NO_EMPTY);
                        foreach ($textPreg as $preloaderVal):?>
                        <div><?php echo esc_attr($preloaderVal);?></div>

                <?php  endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

