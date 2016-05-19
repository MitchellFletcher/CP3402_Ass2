<?php
/**
 * Barrierreef Theme Customizer.
 *
 * @package barrierreef
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function barrierreef_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	/**
	 * Custom Customizer Customizations
	 */

	/**
	 * HEADER
	 */

	// Create header background color setting
	$wp_customize->add_setting( 'header_color', array(
		'default' => '#2eafdd',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	// Add header background color control
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_color', array(
				'label' => __( 'Header Background Color', 'barrierreef' ),
				'section' => 'colors',
			)
		)
	);
	/**
	 * Content color
	 */

// Create background color setting
	$wp_customize->add_setting( 'content_color', array(
		'default' => '#ffffff',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport' => 'postMessage',
	));

	// Add header background color control
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'content_color', array(
				'label' => __( 'Content Background Color', 'barrierreef' ),
				'section' => 'colors',
			)
		)
	);
	/**
	 *FOOTER
	 */

	//Adding setting footer background
	$wp_customize->add_setting('footer_color', array(
		'default' => '#2eafdd',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
		
	));

	$wp_customize-> add_control
	(new WP_Customize_Color_Control(
		$wp_customize, 'footer_color', array(
			'label' =>  __( 'Footer Background Color', 'barrierreef' ),
			'section' => 'colors',
		)
	));



	/**
	 *SideBar
	 */

	// Add section to the Customizer
	$wp_customize->add_section( 'barrierreef-options', array(
		'title' => __( 'Theme Options', 'barrierreef' ),
		'capability' => 'edit_theme_options',
		'description' => __( 'Change the default display options for the theme.', 'barrierreef' ),
	));


	// Create sidebar layout setting
	$wp_customize->add_setting(	'layout_setting',
		array(
			'default' => 'no-sidebar',
			'type' => 'theme_mod',
			'sanitize_callback' => 'barrierreef_sanitize_layout',
			'transport' => 'postMessage'
		)
	);
	// Add sidebar layout controls
	$wp_customize->add_control(	'layout_control',
		array(
			'settings' => 'layout_setting',
			'type' => 'radio',
			'label' => __( 'Sidebar position', 'barrierreef' ),
			'choices' => array(
				'no-sidebar' => __( 'No sidebar (default)', 'barrierreef' ),
				'sidebar-left' => __( 'Left sidebar', 'barrierreef' ),
				'sidebar-right' => __( 'Right sidebar', 'barrierreef' )
			),
			'section' => 'barrierreef-options',
		)
	);

}
add_action( 'customize_register', 'barrierreef_customize_register' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function barrierreef_customize_preview_js() {
	wp_enqueue_script( 'barrierreef_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'barrierreef_customize_preview_js' );
/**
 * Sanitize layout options
 */
function barrierreef_sanitize_layout( $value ) {
	if ( !in_array( $value, array( 'sidebar-left', 'sidebar-right', 'no-sidebar' ) ) ) {
		$value = 'no-sidebar';
	}
	return $value;
}
/**
 * Inject Customizer CSS when appropriate
 */
function barrierreef_customizer_css() {
	$header_color = get_theme_mod('header_color');
	$footer_color = get_theme_mod('footer_color');
	$content_color = get_theme_mod('content_color');
?>
<style type="text/css">
		.site-header {
			background-color: <?php echo $header_color; ?>
		}
		.site-footer{
			background-color: <?php echo $footer_color; ?>
		}
		.site-content{
			background-color: <?php echo $content_color?>
		}

	</style>
	<?php
}
add_action( 'wp_head', 'barrierreef_customizer_css' );
