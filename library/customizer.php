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

	// Rename the Title/Tagline section
	$wp_customize->get_section( 'title_tagline' )->title = __( 'Site Title, Tagline & Footer Message', 'arras' );

	// Add Footer Message
	$wp_customize->add_setting(
		'arras-options[footer_message]',
		array(
			'default'			=> __( 'Copyright ', 'arras' ) . date( 'Y' ) . '. ' . get_bloginfo( 'name' ),
			'type'				=> 'option',
			'sanitize_callback'	=> 'wp_kses_post',
	) );
	$wp_customize->add_control( 'footer-message', array(
		'label'			=> __( 'Footer Message', 'arras' ),
		'description'	=> __( 'You may use some limited html here (for links, etc).', 'arras' ),
		'section'		=> 'title_tagline',
		'settings'		=> 'arras-options[footer_message]',
		'type'			=> 'textarea',
		'priority'		=> 35
	) );

	// Add Homepage Panel, Sections and Settings
	// -- Panel --
	$wp_customize->add_panel( 'homepage', array(
		'title' 			=> __( 'Homepage Settings', 'arras' ),
		'active_callback'	=> 'is_front_page',
		'priority'			=> 30,
	) );

	// -- Sections --
	$wp_customize->add_section( 'duplicate-posts', array(
	    'panel' 		=> 'homepage',
	    'title' 		=> __( 'Duplicate Posts', 'arras' ),
	    'priority' 		=> 10,
	    ) );
	$wp_customize->add_section( 'slideshow', array(
	    'panel' 		=> 'homepage',
	    'title' 		=> __( 'Slideshow', 'arras' ),
	    'priority' 		=> 20,
	    ) );
	$wp_customize->add_section( 'featured-1', array(
	    'panel' 		=> 'homepage',
	    'title' 		=> __( 'First Featured Posts Section', 'arras' ),
	    'priority' 		=> 30,
	    ) );
	$wp_customize->add_section( 'featured-2', array(
	    'panel' 		=> 'homepage',
	    'title' 		=> __( 'Second Featured Posts Section', 'arras' ),
	    'priority' 		=> 40,
	    ) );
	$wp_customize->add_section( 'news', array(
	    'panel' 		=> 'homepage',
	    'title' 		=> __( 'News Posts', 'arras' ),
	    'priority' 		=> 10,
	    ) );

	// -- Settings --
	$wp_customize->add_setting(
		'arras-options[hide_duplicates]', array(
			'default' 			=> true,
			'type' 				=> 'option',
			'sanitize_callback' => 'arras_sanitize_boolian',
	) );

	$wp_customize->add_setting(
		'arras-options[enable_slideshow]', array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_setting(
			'arras-options[slideshow_count]', array(
			'default'			=> get_option( 'posts_per_page' ),
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_positive_integer',
) );
	$wp_customize->add_setting(
			'arras-options[slideshow_posttype]', array(
			'default'			=> 'post',
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_post_type',
) );
	$wp_customize->add_setting(
			'arras-options[slideshow_tax]', array(
			'default'			=> 'category',
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_taxonomy',
) );
	$wp_customize->add_setting(
		'arras-options[slideshow_cat]', array(
			'default'			=> arras_get_cats( 'slideshow_cat' ),
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_terms',
	) );

	// -- Controls --
	$wp_customize->add_control( 'hide-duplicates', array(
	    'label' 		=> __( 'Hide Duplicate Posts', 'arras' ),
	    'description' 	=> __( 'Prevents duplicate posts from displaying in both the slideshow the featured posts. May cause slowdown, depending on post count.', 'arras' ),
	    'section' 		=> 'duplicate-posts',
	    'settings'		=> 'arras-options[hide_duplicates]',
	    'type'			=> 'checkbox',
	    'priority' 		=> 5,
	) );
	$wp_customize->add_control( 'enable-slideshow', array(
		'label'			=> __( 'Enable Slideshow', 'arras' ),
		'section'		=> 'slideshow',
		'settings'		=> 'arras-options[enable_slideshow]',
		'type'			=> 'checkbox',
		'priority'		=> 1,
	) );
	$wp_customize->add_control( 'slideshow-count', array(
		'label'			=> __( 'Maximum Posts in Slideshow', 'arras' ),
		'section'		=> 'slideshow',
		'settings'		=> 'arras-options[slideshow_count]',
		'type'			=> 'number',
		'priority'		=> 3,
	) );
	$wp_customize->add_control( 'slideshow-posttype', array(
		'label'			=> __( 'Slideshow Post Type', 'arras' ),
		'description'	=> __( 'If you change this, please save and then refresh the page to get updated taxonomy and term choices.', 'arras' ),
		'section'		=> 'slideshow',
		'settings'		=> 'arras-options[slideshow_posttype]',
		'type'			=> 'select',
		'choices'		=> arras_get_posttypes(),
		'priority'		=> 5,
	) );
	$wp_customize->add_control( 'slideshow-taxonomy', array(
		'label'			=> __( 'Slideshow Taxonomy', 'arras' ),
		'description'	=> __( 'If you change this, please save and then refresh the page to get updated term choices.', 'arras' ),
		'section'		=> 'slideshow',
		'settings'		=> 'arras-options[slideshow_tax]',
		'type'			=> 'select',
		'choices'		=> arras_get_taxonomies( arras_get_option( 'slideshow_posttype' ) ),
		'priority'		=> 7,
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

	// Add Post Meta Section, Settings & Controls
	// -- Section --
	$wp_customize->add_section( 'post-meta',
	array(
		'title'			=> __( 'Post Meta Display', 'arras' ),
		'description'	=> __( 'Options for displaying meta-data on single posts.', 'arras' ),
		'priority'		=> 35,
	) );

	// -- Settings --
	$wp_customize->add_setting(
		'arras-options[post_author]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_setting(
		'arras-options[post_date]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_setting(
		'arras-options[post_cats]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_setting(
		'arras-options[post_tags]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_setting(
		'arras-options[single_thumbs]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_setting(
		'arras-options[relative_postdates]',
		array(
			'default'			=> false,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );

	// -- Controls --
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

	// Add color scheme setting and control.
	$wp_customize->add_setting(
		'color_scheme',
		array(
			'default'			=> 'default',
			'sanitize_callback' => 'arras_sanitize_color_scheme',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'label'    => __( 'Base Color Scheme', 'arras' ),
		'section'  => 'colors',
		'type'     => 'select',
		'choices'  => arras_get_color_scheme_choices(),
		'priority' => 1,
	) );

	// Add custom header color (this is the background color for the entire header area)
	$wp_customize->add_setting(
		'header_background_color',
		array(
			'default'			=> $color_scheme[0],
			'sanitize_callback'	=> 'sanitize_hex_color',
	) );

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_background_color',
			array(
				'label'		=> __( 'Header Background Color', 'arras' ),
				'section'	=> 'colors',
				'settings'	=> 'header_background_color',
				'priority'	=> 3,
			)
		)
	);

	// Add Logo Uploader
	$wp_customize->get_section( 'header_image' )->title = __( 'Header Image and Logo', 'arras' );
	$wp_customize->add_setting(
		'arras-options[site_logo]',
		array(
			'default'			=> esc_url( get_option( 'arras-options[site_logo]' ) ),
			'type'				=> 'option',
			'sanitize_callback'	=> 'esc_url_raw',
	) );
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

	// Add Social Links Section, Settings and Controls
	// -- Section --
	$wp_customize->add_section( 'social',
	array(
		'title'		=> __( 'Social Media Links', 'arras' ),
		'priority'	=> 100,
	) );

	// -- Settings --
	$wp_customize->add_setting(
		'arras-options[show_rss]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_setting(
		'arras-options[twitter]',
		array(
			'default'			=> '',
			'type'				=> 'option',
			'sanitize_callback'	=> 'esc_url_raw',
	) );
	$wp_customize->add_setting(
		'arras-options[facebook]',
		array(
			'default'			=> '',
			'type'				=> 'option',
			'sanitize_callback'	=> 'esc_url_raw',
	) );
	$wp_customize->add_setting(
		'arras-options[google]',
		array(
			'default'			=> '',
			'type'				=> 'option',
			'sanitize_callback'	=> 'esc_url_raw',
	) );
	$wp_customize->add_setting(
		'arras-options[flickr]',
		array(
			'default'			=> '',
			'type'				=> 'option',
			'sanitize_callback'	=> 'esc_url_raw',
	) );
	$wp_customize->add_setting(
		'arras-options[youtube]',
		array(
			'default'			=> '',
			'type'				=> 'option',
			'sanitize_callback'	=> 'esc_url_raw',
	) );

	// -- Controls --
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

	// Add Layout Section, Settings and Controls
	$wp_customize->add_section( 'layout',
	array(
		'title'		=> __( 'Layout', 'arras' ),
		'priority'	=> 110,
	) );

	// Add Layout Settings
	$wp_customize->add_setting(
		'arras-options[layout]',
		array(
			'default'			=> '2c-r',
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_layouts',
	) );
	$wp_customize->add_control( 'layout', array(
		'label'		=> __( 'Sidebar Arrangement', 'arras' ),
		'section'	=> 'layout',
		'settings'	=> 'arras-options[layout]',
		'type'		=> 'select',
		'choices'	=> arras_get_layouts(),
		'priority'	=> 1,
	) );

	// Add Default Tapestry
	$wp_customize->add_setting(
		'arras-options[default_tapestry]',
		array(
			'default'			=> 'quick',
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_tapestries',
	) );
	$wp_customize->add_control( 'default-tapestry', array(
		'label'		=> __( 'Default Display Mode', 'arras' ),
		'section'	=> 'layout',
		'settings'	=> 'arras-options[default_tapestry]',
		'type'		=> 'select',
		'choices'	=> arras_get_tapestry_choices(),
		'priority'	=> 3,
	) );

	// Add Auto Thumbnail Option
	$wp_customize->add_setting(
		'arras-options[auto_thumbs]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
	) );
	$wp_customize->add_control( 'auto-thumbs', array(
		'label'			=> __( 'Auto-Thumbnail', 'arras' ),
		'description'	=> __( 'Automatically retrieve the first attached image from the post as featured image when no image is specified.', 'arras' ),
		'section'		=> 'layout',
		'settings'		=> 'arras-options[auto_thumbs]',
		'type'			=> 'checkbox',
		'priority'		=> 2,
	) );

	// Add Node-based options
	$wp_customize->add_setting(
		'arras-options[nodes_per_row]',
		array(
			'default'			=> 3,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_nodes_per_row',
	) );
	$wp_customize->add_setting(
		'arras-options[nodes_excerpt]',
		array(
			'default'			=> true,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_boolian',
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

	// Add Excerpt Limit option
	$wp_customize->add_setting(
		'arras-options[excerpt_limit]',
		array(
			'default'			=> 30,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_excerpt_limit',
	) );
	$wp_customize->add_control( 'excerpt-limit', array(
		'label'			=> __( 'Excerpt Limit', 'arras' ),
		'description'	=> __( 'Number of words to trim excerpts. Trims only if no excerpt is specified for a post. Maximum 300 words. Enter 0 for no trim.', 'arras' ),
		'section'		=> 'layout',
		'settings'		=> 'arras-options[excerpt_limit]',
		'type'			=> 'number',
		'priority'		=> 6,
	) );

	// Add Footer Columns Option
	$wp_customize->add_setting(
		'arras-options[footer_columns]',
		array(
			'default'			=> 3,
			'type'				=> 'option',
			'sanitize_callback'	=> 'arras_sanitize_footer_cols',
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
	wp_enqueue_script( 'arras-customizer-customize', get_template_directory_uri() . '/js/customizer.js',array( 'jquery', 'customize-controls' ), false, true );
}
*/
