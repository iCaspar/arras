<?php
/**
 * Arras Customizer Functions
 *
 * @package Arras
 * @since 3.0
 */

add_action( 'customize_register', 'arras_customizer' );
/**
 * Configures the WP Customizer for Arras
 * @param  WP_Customize_Manager $wp_customize WP Customizer object
 * @return null
 */
function arras_customizer( $wp_customize ) {
	/**
	 * We need to roll our own multiple select customize control class
	 * (as of 4.2 it's not in core, but we can hope ... someday)
	 */
	class Arras_Checkbox_Multi_Select extends WP_Customize_Control {
	    /**
	     * The type of customize control being rendered.
	     */
	    public $type = 'multiple-select';

	    public function enqueue()
	    {
	    	wp_enqueue_script( 'arras-multi-select', get_template_directory_uri() . '/js/jquery.multiple.select.js', array( 'jquery' ), '1.1.0', true );
	    	wp_enqueue_style( 'arras-multi-select', get_template_directory_uri() . '/css/multiple-select.css', array(), '1.1.0', 'all' );
	    }

	    /**
	     * Displays the multiple select on the customize screen.
	     */
	    public function render_content()
	    {
		    if ( empty( $this->choices ) ) return;
		    ?>
		    <label>
	            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	            <?php if ( ! empty( $this->description ) ): ?>
	            	<span class="description customize-control-description"><?php echo $this->description; ?></span>
	            <?php endif; ?>
	            <select name="<?php echo $this->id; ?>" <?php $this->link(); ?> multiple="multiple" class="multi-select">
	                <?php
	                foreach ( $this->choices as $value => $label ) {
	                    $selected = ( in_array( $value, $this->value() ) ) ? selected( 1, 1, false ) : '';
	                    echo '<option value="' . esc_attr( $value ) . '"' . $selected . '>' . $label . '</option>';
	                    }
	                ?>
	            </select>
	        </label>
	    <?php } // end render_content()
	} // end class Arras_Customize_Control_Multiple_Select


	$color_scheme = arras_get_current_color_scheme();

	// Tweak a couple of the built-in sections
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Title, Tagline & Footer Message', 'arras' );
	$wp_customize->get_section( 'header_image' )->title = __( 'Header Image and Logo', 'arras' );


	/**
	 * Array for adding custom panels.
	 * 'panel-id' => array( 'title', 'description', 'active_callback', priority )
	 */
	$panels = array(
		'homepage'		=> array( __( 'Homepage Settings', 'arras'), '', 'is_front_page', 30 ),
	);
	$panels = apply_filters( 'arras_customizer_panels', $panels );
	foreach ( $panels as $id => $args ) {
		$wp_customize->add_panel( $id, array(
			'title' 			=> $args[0],
			'description'		=> $args[1],
			'active_callback'	=> $args[2],
			'priority'			=> $args[3],
		) );
	}


	/**
	 * Array for adding custom sections.
	 * 'section-id' => array( 'panel-id', 'title', 'description', 'active_callback', priority )
	 * @var array
	 */
	$sections = array(
		// Sections on the Builtin Panel
		'post-meta'			=> array( '', __( 'Post Display', 'arras' ), __( 'Options for displaying meta-data on single posts.', 'arras' ), 35 ),
		'social'			=> array( '', __( 'Social Media Links', 'arras' ), '', 100 ),

		// Sections on the Homepage Panel
		'duplicate-posts'	=> array( 'homepage', __( 'Duplicate Posts', 'arras' ), '', 10 ),
		'slideshow'			=> array( 'homepage', __( 'Slideshow', 'arras'), '', 20 ),
		'featured-1'		=> array( 'homepage', __( 'Featured #1', 'arras'), '', 20 ),
		'featured-2'		=> array( 'homepage', __( 'Featured #2', 'arras'), '', 20 ),
		'news'				=> array( 'homepage', __( 'News', 'arras'), '', 20 ),

	);
	$sections = apply_filters( 'arras_customizer_sections', $sections );
	foreach ( $sections as $id => $args ) {
		$wp_customize->add_section( $id, array(
		    'panel' 		=> $args[0],
		    'title' 		=> $args[1],
		    'description'	=> $args[2],
		    'priority' 		=> $args[3],
		    ) );
	}

	// Generate Settings Objects
	$settings = arras_get_settings_data();
	foreach ( $settings as $id => $args ) {
		$wp_customize->add_setting( 'arras-options[' . $id . ']', array(
			'default'			=> $args[0],
			'type'				=> $args[1],
			'sanitize_callback'	=> $args[2],
		) );
	}


	/**
	 * Array for custom controls using default control class.
	 * 'control-id' =>
	 * 		array( 'label', 'description', 'section', 'settings', 'type', 'choices', priority )
	 * @var array
	 */
	$controls = array(
		// Site Title & Tagline Section
		'footer-message'	=> array(
			__( 'Footer Message', 'arras' ),
			__( 'You may use some limited html here (for links, etc).', 'arras' ),
			'title_tagline', 'footer_message', 'textarea', '', 35 ),

		// Duplicate Posts Section
		// Slideshow Section
		'enable-slideshow'	=> array(
			__( 'Enable Slideshow', 'arras' ), '', 'slideshow', 'enable_slideshow', 'checkbox', '', 1 ),
		'slideshow-posttype'	=> array(
			__( 'Slideshow Post Type', 'arras' ),
			__( 'If you change this, please save and then refresh the page to get updated taxonomy and term choices.', 'arras' ),
			'slideshow', 'slideshow_posttype', 'select', arras_get_posttypes(), 5 ),
		'slideshow-taxonomy'	=> array(
			__( 'Slideshow Taxonomy', 'arras' ), __( 'If you change this, please save and then refresh the page to get updated term choices.', 'arras' ),
			'slideshow', 'slideshow_tax', 'select', arras_get_taxonomies( arras_get_option( 'slideshow_posttype' ) ), 7 ),
		'slideshow-count'	=> array(
			__( 'Maximum Posts in Slideshow', 'arras' ), '', 'slideshow', 'slideshow_count', 'number', '', 13 ),

		// Featured #1 Section
		'enable-featured1'	=> array(
			__( 'Enable Featured #1', 'arras' ), '', 'featured-1', 'enable_featured1', 'checkbox', '', 1 ),
		'featured1-title'	=> array(
			__( 'Header for Featured #1 Section', 'arras'), '', 'featured-1', 'featured1_title', 'text', '', 3),
		'featured1-posttype'	=> array(
			__( 'Featured #1 Post Type', 'arras' ),
			__( 'If you change this, please save and then refresh the page to get updated taxonomy and term choices.', 'arras' ),
			'featured-1', 'featured1_posttype', 'select', arras_get_posttypes(), 5 ),
		'featured1-taxonomy'	=> array(
			__( 'Featured #1 Taxonomy', 'arras' ), __( 'If you change this, please save and then refresh the page to get updated term choices.', 'arras' ),
			'featured-1', 'featured1_tax', 'select', arras_get_taxonomies( arras_get_option( 'featured1_posttype' ) ), 7 ),
		'featured1-display'	=> array(
			__( 'Display Mode for Featured #1', 'arras' ), '', 'featured-1', 'featured1_display', 'select', arras_get_tapestry_choices(), 11 ),
		'featured1-count'	=> array(
			__( 'Maximum Posts in Featured #1', 'arras' ), '', 'featured-1', 'featured1_count', 'number', '', 13 ),

		// Featured #2 Section
		'enable-featured2'	=> array(
			__( 'Enable Featured #2', 'arras' ), '', 'featured-2', 'enable_featured2', 'checkbox', '', 1 ),
		'featured2-title'	=> array(
			__( 'Header for Featured #2 Section', 'arras'), '', 'featured-2', 'featured2_title', 'text', '', 3),
		'featured2-posttype'	=> array(
			__( 'Featured #2 Post Type', 'arras' ),
			__( 'If you change this, please save and then refresh the page to get updated taxonomy and term choices.', 'arras' ),
			'featured-2', 'featured2_posttype', 'select', arras_get_posttypes(), 5 ),
		'featured2-taxonomy'	=> array(
			__( 'Featured #2 Taxonomy', 'arras' ), __( 'If you change this, please save and then refresh the page to get updated term choices.', 'arras' ),
			'featured-2', 'featured2_tax', 'select', arras_get_taxonomies( arras_get_option( 'featured2_posttype' ) ), 7 ),
		'featured2-display'	=> array(
			__( 'Display Mode for Featured #2', 'arras' ), '', 'featured-2', 'featured2_display', 'select', arras_get_tapestry_choices(), 11 ),
		'featured2-count'	=> array(
			__( 'Maximum Posts in Featured #2', 'arras' ), '', 'featured-2', 'featured2_count', 'number', '', 13 ),

		// News Section
		'enable-news'		=> array(
			__( 'Enable News', 'arras' ), '', 'news', 'enable_news', 'checkbox', '', 1 ),
		'news-title'	=> array(
			__( 'Header for News Section', 'arras'), '', 'news', 'news_title', 'text', '', 3),
		'news-posttype'	=> array(
			__( 'News Post Type', 'arras' ),
			__( 'If you change this, please save and then refresh the page to get updated taxonomy and term choices.', 'arras' ),
			'news', 'news_posttype', 'select', arras_get_posttypes(), 5 ),
		'news-taxonomy'	=> array(
			__( 'News Taxonomy', 'arras' ), __( 'If you change this, please save and then refresh the page to get updated term choices.', 'arras' ),
			'news', 'news_tax', 'select', arras_get_taxonomies( arras_get_option( 'news_posttype' ) ), 7 ),
		'news-display'	=> array(
			__( 'Display Mode for News', 'arras' ), '', 'news', 'news_display', 'select', arras_get_tapestry_choices(), 11 ),
		'news-count'	=> array(
			__( 'Maximum Posts in News', 'arras' ), '', 'news', 'news_count', 'number', '', 13 ),

		// Post Display Section
		// Colors Section
		// Header Image and Logo Section
		// Social Media Section
		// Layout Section


	);
	$controls = apply_filters( 'arras_customizer_controls', $controls );
	foreach ( $controls as $id => $args ) {
		$wp_customize->add_control( $id, array(
			'label'			=> $args[0],
			'description'	=> $args[1],
			'section'		=> $args[2],
			'settings'		=> 'arras-options[' . $args[3] . ']',
			'type'			=> $args[4],
			'choices'		=> $args[5],
			'priority'		=> $args[6],
		) );
	}

	$wp_customize->add_control( 'hide-duplicates', array(
	    'label' 		=> __( 'Hide Duplicate Posts', 'arras' ),
	    'description' 	=> __( 'Prevents duplicate posts from displaying in both the slideshow the featured posts. May cause slowdown, depending on post count.', 'arras' ),
	    'section' 		=> 'duplicate-posts',
	    'settings'		=> 'arras-options[hide_duplicates]',
	    'type'			=> 'checkbox',
	    'priority' 		=> 5,
	) );
	$wp_customize->add_control(
		new Arras_Checkbox_Multi_Select(
			$wp_customize,
			'slideshow-cat',
			array(
				'label'			=> __( 'Slideshow Categories (or Terms)', 'arras' ),
				'section'		=> 'slideshow',
				'settings'		=> 'arras-options[slideshow_cat]',
				'type'			=> 'multiple-select',
				'choices'		=> arras_get_terms( arras_get_option( 'slideshow_tax' ), arras_get_option( 'slideshow_posttype' ) ),
				'priority'		=> 10,
		) ) );
	$wp_customize->add_control(
		new Arras_Checkbox_Multi_Select(
			$wp_customize,
			'featured1-cat',
			array(
				'label'			=> __( 'Featured #1 Categories (or Terms)', 'arras' ),
				'section'		=> 'featured-1',
				'settings'		=> 'arras-options[featured1_cat]',
				'type'			=> 'multiple-select',
				'choices'		=> arras_get_terms( arras_get_option( 'featured1_tax' ), arras_get_option( 'featured1_posttype' ) ),
				'priority'		=> 10,
		) ) );
	$wp_customize->add_control(
		new Arras_Checkbox_Multi_Select(
			$wp_customize,
			'featured2-cat',
			array(
				'label'			=> __( 'Featured #2 Categories (or Terms)', 'arras' ),
				'section'		=> 'featured-2',
				'settings'		=> 'arras-options[featured2_cat]',
				'type'			=> 'multiple-select',
				'choices'		=> arras_get_terms( arras_get_option( 'featured2_tax' ), arras_get_option( 'featured2_posttype' ) ),
				'priority'		=> 10,
		) ) );
	$wp_customize->add_control(
		new Arras_Checkbox_Multi_Select(
			$wp_customize,
			'news-cat',
			array(
				'label'			=> __( 'News Categories (or Terms)', 'arras' ),
				'section'		=> 'news',
				'settings'		=> 'arras-options[news_cat]',
				'type'			=> 'multiple-select',
				'choices'		=> arras_get_terms( arras_get_option( 'news_tax' ), arras_get_option( 'news_posttype' ) ),
				'priority'		=> 10,
		) ) );
	$wp_customize->add_control( 'post-author', array(
		'label'			=> __( 'Post Author', 'arras' ),
		'section'		=> 'post-meta',
		'settings'		=> 'arras-options[post_author]',
		'type'			=> 'checkbox',
		'priority'		=> 1
	) );
	$wp_customize->add_control( 'post-date', array(
		'label'			=> __( 'Post Date', 'arras' ),
		'section'		=> 'post-meta',
		'settings'		=> 'arras-options[post_date]',
		'type'			=> 'checkbox',
		'priority'		=> 2
	) );
	$wp_customize->add_control( 'post-categories', array(
		'label'			=> __( 'Post Categories', 'arras' ),
		'section'		=> 'post-meta',
		'settings'		=> 'arras-options[post_cats]',
		'type'			=> 'checkbox',
		'priority'		=> 3
	) );
	$wp_customize->add_control( 'post-tags', array(
		'label'			=> __( 'Post Tags', 'arras' ),
		'section'		=> 'post-meta',
		'settings'		=> 'arras-options[post_tags]',
		'type'			=> 'checkbox',
		'priority'		=> 4
	) );
	$wp_customize->add_control( 'single-thumbnail', array(
		'label'			=> __( 'Post Featured Image', 'arras' ),
		'section'		=> 'post-meta',
		'settings'		=> 'arras-options[single_thumbs]',
		'type'			=> 'checkbox',
		'priority'		=> 5
	) );
	$wp_customize->add_control( 'relative-postdates', array(
		'label'			=> __( 'Use Relative Postdates', 'arras' ),
		'description'	=> __( 'Display post dates relative to current time, eg. 2 days ago. (Note: Posts over a month old will always show with the regular date format.) ', 'arras' ),
		'section'		=> 'post-meta',
		'settings'		=> 'arras-options[relative_postdates]',
		'type'			=> 'checkbox',
		'priority'		=> 6
	) );
	$wp_customize->add_control( 'arras-options[color_scheme]', array(
		'label'    => __( 'Base Color Scheme', 'arras' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => arras_get_color_scheme_choices(),
		'priority' => 1,
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_background_color',
			array(
				'label'		=> __( 'Header Background Color', 'arras' ),
				'section'	=> 'colors',
				'settings'	=> 'arras-options[header_background_color]',
				'priority'	=> 3,
			)
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Upload_Control(
			$wp_customize,
			'site_logo',
			array(
				'label'		=> __( 'Site Logo', 'arras' ),
				'section'	=> 'header_image',
				'settings'	=> 'arras-options[site_logo]',
				'priority'	=> 1,
			)
		)
	);
	$wp_customize->add_control( 'show-rss', array(
		'label'			=> __( 'Show RSS Feed Icon', 'arras' ),
		'description'	=> __( 'Your RSS feed URL is: ', 'arras' ) . '<br />' . get_bloginfo( 'rss2_url' ),
		'section'		=> 'social',
		'settings'		=> 'arras-options[show_rss]',
		'type'			=> 'checkbox',
		'priority'		=> 1,
	) );
	$wp_customize->add_control( 'twitter', array(
		'label'			=> __( 'Twitter URL', 'arras' ),
		'section'		=> 'social',
		'settings'		=> 'arras-options[twitter]',
		'type'			=> 'url',
		'priority'		=> 2,
	) );
	$wp_customize->add_control( 'facebook', array(
		'label'			=> __( 'Facebook URL', 'arras' ),
		'section'		=> 'social',
		'settings'		=> 'arras-options[facebook]',
		'type'			=> 'url',
		'priority'		=> 3,
	) );
	$wp_customize->add_control( 'google', array(
		'label'			=> __( 'Google+ URL', 'arras' ),
		'section'		=> 'social',
		'settings'		=> 'arras-options[google]',
		'type'			=> 'url',
		'priority'		=> 4,
	) );
	$wp_customize->add_control( 'youtube', array(
		'label'			=> __( 'YouTube URL', 'arras' ),
		'section'		=> 'social',
		'settings'		=> 'arras-options[youtube]',
		'type'			=> 'url',
		'priority'		=> 5,
	) );
	$wp_customize->add_control( 'flickr', array(
		'label'			=> __( 'Flickr URL', 'arras' ),
		'section'		=> 'social',
		'settings'		=> 'arras-options[flickr]',
		'type'			=> 'url',
		'priority'		=> 6,
	) );
	$wp_customize->add_section( 'layout',
	array(
		'title'		=> __( 'Layout', 'arras' ),
		'priority'	=> 110,
	) );
	$wp_customize->add_control( 'layout', array(
		'label'		=> __( 'Sidebar Arrangement', 'arras' ),
		'section'	=> 'layout',
		'settings'	=> 'arras-options[layout]',
		'type'		=> 'select',
		'choices'	=> arras_get_layouts(),
		'priority'	=> 1,
	) );
	$wp_customize->add_control( 'default-tapestry', array(
		'label'		=> __( 'Default Display Mode', 'arras' ),
		'section'	=> 'layout',
		'settings'	=> 'arras-options[default_tapestry]',
		'type'		=> 'select',
		'choices'	=> arras_get_tapestry_choices(),
		'priority'	=> 3,
	) );
	$wp_customize->add_control( 'auto-thumbs', array(
		'label'			=> __( 'Auto-Thumbnail', 'arras' ),
		'description'	=> __( 'Automatically retrieve the first attached image from the post as featured image when no image is specified.', 'arras' ),
		'section'		=> 'layout',
		'settings'		=> 'arras-options[auto_thumbs]',
		'type'			=> 'checkbox',
		'priority'		=> 2,
	) );
	$wp_customize->add_control( 'nodes-per-row', array(
		'label'			=> __( 'Nodes per Row', 'arras' ),
		'description'	=> __( 'For Node-based Display Mode.', 'arras' ),
		'section'		=> 'layout',
		'settings'		=> 'arras-options[nodes_per_row]',
		'type'			=> 'select',
		'choices'		=> arras_get_numerical_choice_array( 12 ),
		'priority'		=> 4,
	) );
	$wp_customize->add_control( 'nodes-excerpt', array(
		'label'			=> __( 'Show Excerpts with Nodes', 'arras' ),
		'section'		=> 'layout',
		'settings'		=> 'arras-options[nodes_excerpt]',
		'type'			=> 'checkbox',
		'priority'		=> 5,
	) );
	$wp_customize->add_control( 'excerpt-limit', array(
		'label'			=> __( 'Excerpt Limit', 'arras' ),
		'description'	=> __( 'Number of words to trim excerpts. Trims only if no excerpt is specified for a post. Maximum 300 words. Enter 0 for no trim.', 'arras' ),
		'section'		=> 'layout',
		'settings'		=> 'arras-options[excerpt_limit]',
		'type'			=> 'number',
		'priority'		=> 6,
	) );
	$wp_customize->add_control( 'footer-columns', array(
		'label'			=> __( 'Footer Columns', 'arras' ),
		'description'	=> __( 'Each footer column gets its own widget area.', 'arras' ),
		'section'		=> 'layout',
		'settings'		=> 'arras-options[footer_columns]',
		'type'			=> 'select',
		'choices'		=> arras_get_numerical_choice_array( 4 ),
		'priority'		=> 7,
	) );

	return $wp_customize;

} // end arras_customizer()


function arras_get_settings_data() {
	$color_scheme = arras_get_current_color_scheme();

	/**
	 * Settings data array
	 * 'setting-id' => array( 'default', 'type', 'sanitize_callback' )
	 * @var array
	 */
	$settings = array(
		// Site Title & Tagline Section
		'footer_message' 	=> array( __( 'Copyright ', 'arras' ) . date( 'Y' ) . '. ' . get_bloginfo( 'name' ), 'option', 'wp_kses_post' ),

		// Duplicate Posts Section
		'hide_duplicates'	=> array( true, 'option', 'arras_sanitize_boolian' ),

		// Slideshow Section
		'enable_slideshow'	=> array( true, 'option', 'arras_sanitize_boolian' ),
		'slideshow_posttype'	=> array( 'post', 'option', 'arras_sanitize_post_type' ),
		'slideshow_tax'		=> array( 'category', 'option', 'arras_sanitize_taxonomy' ),
		'slideshow_cat'		=> array( '', 'option', 'arras_sanitize_terms' ),
		'slideshow_count'	=> array( 4, 'option', 'arras_sanitize_positive_integer' ),

		// Featured #1 Section
		'enable_featured1'	=> array( true, 'option', 'arras_sanitize_boolian' ),
		'featured1_title'	=> array( __( 'Featured Stories', 'arras' ), 'option', 'sanitize_text_field' ),
		'featured1_posttype'	=> array( 'post', 'option', 'arras_sanitize_post_type' ),
		'featured1_tax'		=> array( 'category', 'option', 'arras_sanitize_taxonomy' ),
		'featured1_cat'		=> array( '', 'option', 'arras_sanitize_terms' ),
		'featured1_display'	=> array( 'default', 'option', 'arras_sanitize_tapestries' ),
		'featured1_count'	=> array( 4, 'option', 'arras_sanitize_positive_integer' ),

		// Featured #2 Section
		'enable_featured2'	=> array( true, 'option', 'arras_sanitize_boolian' ),
		'featured2_title'	=> array( __( 'Editor\'s Picks', 'arras' ), 'option', 'sanitize_text_field' ),
		'featured2_posttype'	=> array( 'post', 'option', 'arras_sanitize_post_type' ),
		'featured2_tax'		=> array( 'category', 'option', 'arras_sanitize_taxonomy' ),
		'featured2_cat'		=> array( '', 'option', 'arras_sanitize_terms' ),
		'featured2_display'	=> array( 'quick', 'option', 'arras_sanitize_tapestries' ),
		'featured2_count'	=> array( 4, 'option', 'arras_sanitize_positive_integer' ),

		// News Section
		'enable_news'		=> array( true, 'option', 'arras_sanitize_boolian' ),
		'news_title'		=> array( __( 'News', 'arras' ), 'option', 'sanitize_text_field' ),
		'news_posttype'		=> array( 'post', 'option', 'arras_sanitize_post_type' ),
		'news_tax'			=> array( 'category', 'option', 'arras_sanitize_taxonomy' ),
		'news_cat'			=> array( '', 'option', 'arras_sanitize_terms' ),
		'news_display'		=> array( 'line', 'option', 'arras_sanitize_tapestries' ),
		'news_count'		=> array( get_option( 'posts_per_page' ), 'option', 'arras_sanitize_positive_integer' ),

		// Post Display Section
		'post_author'		=> array( true, 'option', 'arras_sanitize_boolian' ),
		'post_date'			=> array( true, 'option', 'arras_sanitize_boolian' ),
		'post_cats'			=> array( true, 'option', 'arras_sanitize_boolian' ),
		'post_tags'			=> array( true, 'option', 'arras_sanitize_boolian' ),
		'single_thumbs'		=> array( true, 'option', 'arras_sanitize_boolian' ),
		'relative_postdates'	=> array( false, 'option', 'arras_sanitize_boolian' ),

		// Colors Section
		'color_scheme'						=> array( 'default', 'option', 'arras_sanitize_color_scheme' ),
		'header_background_color'			=> array( $color_scheme[0], 'option', 'sanitize_hex_color' ),

		// Header Image and Logo Section
		'site_logo'			=> array( '', 'option', 'esc_url_raw' ),

		// Social Media Section
		'show_rss'			=> array( true, 'option', 'arras_sanitize_boolian' ),
		'twitter'			=> array( '', 'option', 'esc_url_raw' ),
		'facebook'			=> array( '', 'option', 'esc_url_raw' ),
		'google'				=> array( '', 'option', 'esc_url_raw' ),
		'flickr'				=> array( '', 'option', 'esc_url_raw' ),
		'youtube'			=> array( '', 'option', 'esc_url_raw' ),

		// Layout Section
		'layout'				=> array( '2c-r', 'option', 'arras_sanitize_layouts' ),
		'auto_thumbs'		=> array( true, 'option', 'arras_sanitize_boolian' ),
		'default_tapestry'	=> array( 'quick', 'option', 'arras_sanitize_tapestries' ),
		'nodes_per_row'		=> array( 3, 'option', 'arras_sanitize_nodes_per_row' ),
		'nodes_excerpt'		=> array( true, 'option', 'arras_sanitize_boolian' ),
		'excerpt_limit'		=> array( 30, 'option', 'arras_sanitize_excerpt_limit' ),
		'footer_columns'		=> array( 3, 'option', 'arras_sanitize_footer_cols' ),
	);
	return apply_filters( 'arras_customizer_settings', $settings );
}


/**
 * Makes sure a boolian input resolves to true or false
 * @param  mixed $value raw input
 * @return boolian        0 or 1
 */
function arras_sanitize_boolian( $value ) {
	$value = ( $value ) ? true : false;
	return $value;
}

/**
 * Generates an array of numerical choices from 1 to $max for display on radio or select control
 * @param  int $max maximum number for choices
 * @return array      choices in format: value => label
 */
function arras_get_numerical_choice_array( $max ) {
	$max = absint( $max );
	for ( $i = 1; $i <= $max; $i++ ) {
		$choices[$i] = $i;
	}
	return $choices;
}

/**
 * Makes sure an entered excerpt limit is a whole number <= 300
 * @param  int $value number of words for excerpt length
 * @return int        verified number of words for excerpt
 */
function arras_sanitize_excerpt_limit( $value ) {
	$value = absint( intval( $value ) );
	if ( $value > 300 ) $value = 300;
	return $value;
}


function arras_sanitize_footer_cols ( $value ) {
	if ( ( 1 || 2 || 3 || 4 ) != $value ) $value = 3;
	return $value;
}

function arras_sanitize_test( $input ) {

	return $input;
}

function arras_sanitize_positive_integer( $value ) {
	return absint( intval( $value ) );
}

function arras_sanitize_post_type ( $input ) {
	$posttypes = get_post_types( array( 'public' => true ), 'objects' );

	foreach ( $posttypes as $posttype => $obj ) {
			$valid_posttypes[] = $posttype;
	}
	return ( in_array( $input, $valid_posttypes ) ? $input : 'post' );
}

function arras_sanitize_taxonomy( $input ) {
	// TODO: Put a real validator in here
	return $input;
}

function arras_sanitize_terms( $input ) {
	// TODO: Put a real validator in here
	return $input;
}

function arras_get_cats( $setting ) {
	$raw = arras_get_option( $setting );

	if ( is_array( $raw ) ) return $raw;

	if (is_numeric( $raw ) ) return array( $raw );

	return false;

}

function arras_get_posttypes() {
	$posttypes = get_post_types( array( 'public' => true ), 'objects' );
	$posttypes_opt = array();

	foreach( $posttypes as $id => $obj ) {
			$posttypes_opt[$id] = $obj->labels->name;
	}

	return $posttypes_opt;
}

function arras_get_taxonomies( $posttype ) {
	$taxonomies = get_object_taxonomies( $posttype, 'objects');
	$taxonomy_opts = array();

	foreach( $taxonomies as $id => $object ) {
		if ( isset( $object->query_var ) ) {
			$taxonomy_opts[$id] = $object->labels->name;
		}
	}

	return $taxonomy_opts;
}

function arras_get_terms( $taxonomy = 'category', $posttype = 'post' ) {
	$terms = get_terms( $taxonomy, array( 'hide_empty' => false ) );
	if ( empty( $terms ) || is_WP_Error( $terms ) ) return null;

	$terms_options = array();

	if ( $taxonomy == 'category' && $posttype == 'post' ) {
		$terms_options[] = array( '-5' => __( 'Use Sticky Posts', 'arras' ) );
	}

	foreach ($terms as $term) {
		if ($taxonomy == 'category' || $taxonomy == 'post_tag') {
			$terms_options[$term->term_id] = $term->name;
		}
	}

	return $terms_options;
}


add_action( 'customize_controls_print_styles', 'arras_customizer_styles' );
/**
 * Enqueue custom styles for customizer
 */
function arras_customizer_styles() {
	wp_enqueue_style( 'arras-customizer', get_template_directory_uri() . '/css/customizer.css', null, null, 'screen' );
}
/**
 * For future use if nessary
 */
/*
add_action( 'customize_controls_enqueue_scripts', 'arras_customizer_scripts' );
/**
 * Enqueue custom scripts for customizer

function arras_customizer_scripts() {
	wp_enqueue_script( 'arras-customizer-customize', get_template_directory_uri() . '/js/script.js',array( 'jquery', 'customize-controls' ), false, true );
}
*/

function arras_get_option( $name ) {
	global $arras_options;

	// We're going to return options from the new option set if we have one.
	$options = get_option( 'arras-options' );
	if ( $options && isset( $options[$name] ) ) {
		return $options[$name];
	}

	// Otherwise, see if there's an old option for it.
	if (isset($arras_options->$name)) {
		return $arras_options->$name;
	} elseif (isset($arras_options->defaults[$name])) {
		return $arras_options->defaults[$name];
	}

	return null; // if we haven't found anything, fail quietly
}
