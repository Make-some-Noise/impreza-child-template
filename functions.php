<?php

/*------------------------------------*\
	Year Shortcode [year]
\*------------------------------------*/

add_shortcode('year', 'year_shortcode');
function year_shortcode() {
	$year = date('Y');
	return $year;
}
/*------------------------------------*\
	GTM Insert & Configure Function
\*------------------------------------*/

add_action('wp_head','gtm_insert_function', 20);
function gtm_insert_function() { ?>

	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': 
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<GTM_CODE>');</script>
	<!-- End Google Tag Manager -->

<?php }

add_action('__before_header','gtm_configure_function', 20);
function gtm_configure_function() { ?>

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<GTM_CODE>"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) --> 

<?php }

/*------------------------------------*\
	WOFF2 support
\*------------------------------------*/

add_filter('upload_mimes', 'add_custom_upload_mimes');
function add_custom_upload_mimes($existing_mimes) {
	$existing_mimes['woff2'] = 'application/font-woff2';
	return $existing_mimes;
}

// Scripts and styles
add_action('wp_enqueue_scripts', 'THEME_SLUG_conditional_scripts'); // Add Conditional Page

function THEME_SLUG_conditional_scripts() {

	// Styles
	wp_enqueue_style( 'THEME_SLUG-style', get_stylesheet_directory_uri() . '/assets/css/style.min.css', array(), theme_version( get_stylesheet_directory() . '/assets/css/style.min.css' ), 'all');

	// Scripts
	wp_register_script('THEME_SLUG-main-script', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), theme_version( get_stylesheet_directory() . '/assets/js/main.js' ), true);
	
	// wp_register_script('THEME_SLUG-script-with-vars', get_stylesheet_directory_uri() . '/assets/js/script-with-vars.js', array('jquery'), theme_version( get_stylesheet_directory() . '/assets/js/script-with-vars.js' ), true);
	// wp_register_script('lottie', get_stylesheet_directory_uri() . '/assets/js/packages/lottie.js', array(), theme_version( get_stylesheet_directory() . '/assets/js/packages/lottie.js' ), true); // Conditional script(s)
	
	$translation_array = array( 'folder_uri' => get_stylesheet_directory_uri() );
	
	// Enqueue scripts
	wp_enqueue_script('THEME_SLUG-main-script');

	// wp_enqueue_script('lottie');
	// wp_localize_script( 'THEME_SLUG-script-with-vars', 'theme_obj', $translation_array );
}

// Loads theme version in production and timestamp of last file change when debugging
function theme_version( $file ) {
	return WP_DEBUG ? date( "YmdHi", filemtime( $file ) ) : wp_get_theme()->get('Version');
}