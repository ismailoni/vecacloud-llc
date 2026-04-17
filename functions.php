<?php
/**
 * Omni Solutions Theme Functions
 *
 * @package Omni_Solutions
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1280;
}

/**
 * Register theme support and add custom post types
 */
function omni_solutions_theme_setup() {
	// Add theme support
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Register custom image sizes
	add_image_size( 'omni-featured', 1200, 600, true );
	add_image_size( 'omni-thumbnail', 400, 300, true );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'omni-solutions' ),
		'footer'  => esc_html__( 'Footer Menu', 'omni-solutions' ),
	) );
}
add_action( 'after_setup_theme', 'omni_solutions_theme_setup' );

/**
 * Enqueue scripts and styles
 */
function omni_solutions_enqueue_assets() {
	// Main stylesheet
	wp_enqueue_style(
		'omni-solutions-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		wp_get_theme()->get( 'Version' ),
		'all'
	);

	// Page-specific styles
	wp_enqueue_style(
		'omni-solutions-pages',
		get_template_directory_uri() . '/assets/css/pages.css',
		array( 'omni-solutions-main' ),
		wp_get_theme()->get( 'Version' ),
		'all'
	);

	// Google Fonts
	wp_enqueue_style(
		'omni-solutions-google-fonts',
		'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700&display=swap',
		array(),
		wp_get_theme()->get( 'Version' ),
		'all'
	);

	// Main script
	wp_enqueue_script(
		'omni-solutions-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);

	// Localize script
	wp_localize_script( 'omni-solutions-main', 'omniSolutions', array(
		'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
		'siteUrl'    => get_site_url(),
		'apiNonce'   => wp_create_nonce( 'omni_solutions_nonce' ),
		'homeUrl'    => home_url(),
		'blogSearchNonce' => wp_create_nonce( 'omni_blog_search' ),
	) );

	// Remove WP emoji styles and scripts
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'wp_enqueue_scripts', 'omni_solutions_enqueue_assets' );

/**
 * Admin scripts and styles
 */
function omni_solutions_admin_enqueue_assets( $hook ) {
	wp_enqueue_style(
		'omni-solutions-admin',
		get_template_directory_uri() . '/assets/css/admin.css',
		array(),
		wp_get_theme()->get( 'Version' ),
		'all'
	);
}
add_action( 'admin_enqueue_scripts', 'omni_solutions_admin_enqueue_assets' );

/**
 * Register widget areas
 */
function omni_solutions_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'omni-solutions' ),
		'id'            => 'primary-sidebar',
		'description'   => esc_html__( 'Main sidebar', 'omni-solutions' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widgets', 'omni-solutions' ),
		'id'            => 'footer-widgets',
		'description'   => esc_html__( 'Widgets displayed in the footer', 'omni-solutions' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'omni_solutions_widgets_init' );

/**
 * Custom excerpt length
 */
function omni_solutions_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'omni_solutions_excerpt_length' );

/**
 * Custom excerpt more text
 */
function omni_solutions_excerpt_more( $more ) {
	return ' ... <a href="' . get_the_permalink() . '" class="read-more">' . esc_html__( 'Read More', 'omni-solutions' ) . '</a>';
}
add_filter( 'excerpt_more', 'omni_solutions_excerpt_more' );

/**
 * Add admin color scheme
 */
function omni_solutions_admin_color_scheme() {
	global $wp_admin_bar;
	if ( $wp_admin_bar ) {
		$wp_admin_bar->add_menu( array(
			'id'    => 'theme-info',
			'title' => 'Omni Solutions Theme',
		) );
	}
}
add_action( 'wp_before_admin_bar_render', 'omni_solutions_admin_color_scheme' );

/**
 * Custom login styles
 */
function omni_solutions_login_enqueue_scripts() {
	wp_enqueue_style(
		'omni-solutions-login',
		get_template_directory_uri() . '/assets/css/login.css',
		array(),
		wp_get_theme()->get( 'Version' ),
		'all'
	);
}
add_action( 'login_enqueue_scripts', 'omni_solutions_login_enqueue_scripts' );

/**
 * Custom logo URL
 */
function omni_solutions_login_header_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'omni_solutions_login_header_url' );

/**
 * Custom logo title
 */
function omni_solutions_login_header_title() {
	return get_bloginfo( 'name' );
}
add_filter( 'login_headertext', 'omni_solutions_login_header_title' );

/**
 * Sanitize custom theme options
 */
function omni_solutions_sanitize_hex_color( $color ) {
	if ( empty( $color ) ) {
		return '';
	}
	return sanitize_hex_color( $color );
}

/**
 * Get option helper
 */
function omni_solutions_get_option( $option, $default = '' ) {
	$value = get_option( 'omni_solutions_' . $option, $default );
	return $value ? $value : $default;
}

/**
 * Get default admin notification email (settings-aware)
 *
 * This is kept for backward compatibility. Specialized helpers below
 * can override this per channel (consultation, jobs, contact).
 */
function omni_solutions_get_admin_email() {
	$custom = get_option( 'omni_solutions_admin_email' );
	if ( $custom && is_email( $custom ) ) {
		return $custom;
	}
	return get_option( 'admin_email' );
}

/**
 * Get consultation notification email.
 */
function omni_solutions_get_consultation_email() {
	$custom = get_option( 'omni_solutions_consultation_email' );
	if ( $custom && is_email( $custom ) ) {
		return $custom;
	}
	return omni_solutions_get_admin_email();
}

/**
 * Get job application notification email.
 */
function omni_solutions_get_jobs_email() {
	$custom = get_option( 'omni_solutions_jobs_email' );
	if ( $custom && is_email( $custom ) ) {
		return $custom;
	}
	return omni_solutions_get_admin_email();
}

/**
 * Get contact (About page / general contact) notification email.
 */
function omni_solutions_get_contact_email() {
	$custom = get_option( 'omni_solutions_contact_email' );
	if ( $custom && is_email( $custom ) ) {
		return $custom;
	}
	return omni_solutions_get_admin_email();
}

/**
 * Small inline SVG icon helper for blog UI
 */
function omni_solutions_blog_icon( $name ) {
	switch ( $name ) {
		case 'calendar':
			return '<svg class="blog-icon blog-icon-calendar" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>';
		case 'clock':
			return '<svg class="blog-icon blog-icon-clock" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><polyline points="12 7 12 12 16 14"></polyline></svg>';
		case 'search':
			return '<svg class="blog-icon blog-icon-search" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"></circle><line x1="16.5" y1="16.5" x2="21" y2="21"></line></svg>';
		default:
			return '';
	}
}

/**
 * Get custom logo
 */
function omni_solutions_get_logo() {
	$custom_logo_id = get_theme_mod( 'custom_logo' );
	$html = '';

	if ( $custom_logo_id ) {
		$html = sprintf(
			'<a href="%1$s" class="logo">%2$s<span>%3$s</span></a>',
			esc_url( home_url( '/' ) ),
			wp_get_attachment_image( $custom_logo_id, 'full' ),
			esc_html( get_bloginfo( 'name' ) )
		);
	} else {
		$html = sprintf(
			'<a href="%1$s" class="logo"><span>%2$s</span></a>',
			esc_url( home_url( '/' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
	}

	return $html;
}

/**
 * Add body classes
 */
function omni_solutions_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'singular';
	}

	if ( is_home() || is_archive() ) {
		$classes[] = 'listing';
	}

	return $classes;
}
add_filter( 'body_class', 'omni_solutions_body_classes' );

/**
 * Custom document titles for key pages
 */
function omni_solutions_custom_page_titles( $title_parts ) {
	$has_custom_title = false;

	if ( is_front_page() ) {
		$title_parts['title'] = 'VescaCloud | Salesforce, HubSpot, CRM & ERP integration Consultants';
		$has_custom_title   = true;
	} elseif ( is_page( 'about' ) ) {
		$title_parts['title'] = 'About Us | VescaCloud - Our Team, Values & Certifications';
		$has_custom_title   = true;
	} elseif ( ( is_home() && get_option( 'page_for_posts' ) ) || is_page( 'blog' ) ) {
		$title_parts['title'] = 'Blog | VescaCloud - Sales force & Integration Insights';
		$has_custom_title   = true;
	} elseif ( is_page( 'careers' ) ) {
		$title_parts['title'] = 'Careers | VescaCloud - Join Our Consulting Team';
		$has_custom_title   = true;
	} elseif ( is_page( 'consultation' ) ) {
		$title_parts['title'] = 'Book a Consultation | VescaCloud - Free 30-Minute Strategy Call';
		$has_custom_title   = true;
	}

	if ( $has_custom_title ) {
		if ( isset( $title_parts['site'] ) ) {
			unset( $title_parts['site'] );
		}
		if ( isset( $title_parts['tagline'] ) ) {
			unset( $title_parts['tagline'] );
		}
	}

	return $title_parts;
}
add_filter( 'document_title_parts', 'omni_solutions_custom_page_titles' );

/**
 * Register custom post types
 */
function omni_solutions_register_post_types() {
	// Technology Post Type
	register_post_type( 'technology', array(
		'labels'              => array(
			'name'               => _x( 'Technologies', 'post type general name', 'omni-solutions' ),
			'singular_name'      => _x( 'Technology', 'post type singular name', 'omni-solutions' ),
			'menu_name'          => _x( 'Technologies', 'admin menu', 'omni-solutions' ),
			'name_admin_bar'     => _x( 'Technology', 'add new on admin bar', 'omni-solutions' ),
		),
		'description'         => __( 'Technology integrations', 'omni-solutions' ),
		'public'              => true,
		'has_archive'         => false,
		'menu_position'       => 6,
		'menu_icon'           => 'dashicons-admin-settings',
		'supports'            => array( 'title', 'editor', 'thumbnail' ),
		'show_in_rest'        => true,
	) );

	// Service Post Type
	register_post_type( 'service', array(
		'labels'              => array(
			'name'               => _x( 'Services', 'post type general name', 'omni-solutions' ),
			'singular_name'      => _x( 'Service', 'post type singular name', 'omni-solutions' ),
			'menu_name'          => _x( 'Services', 'admin menu', 'omni-solutions' ),
			'name_admin_bar'     => _x( 'Service', 'add new on admin bar', 'omni-solutions' ),
		),
		'description'         => __( 'Services offered', 'omni-solutions' ),
		'public'              => true,
		'has_archive'         => true,
		'menu_position'       => 7,
		'menu_icon'           => 'dashicons-briefcase',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'        => true,
		'rewrite'             => array( 'slug' => 'services' ),
	) );

	// Case Study Post Type
	register_post_type( 'case_study', array(
		'labels'              => array(
			'name'               => _x( 'Case Studies', 'post type general name', 'omni-solutions' ),
			'singular_name'      => _x( 'Case Study', 'post type singular name', 'omni-solutions' ),
			'menu_name'          => _x( 'Case Studies', 'admin menu', 'omni-solutions' ),
			'name_admin_bar'     => _x( 'Case Study', 'add new on admin bar', 'omni-solutions' ),
		),
		'description'         => __( 'Client case studies', 'omni-solutions' ),
		'public'              => true,
		'has_archive'         => true,
		'menu_position'       => 8,
		'menu_icon'           => 'dashicons-portfolio',
		'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'        => true,
		'rewrite'             => array( 'slug' => 'case-studies' ),
	) );
}
add_action( 'init', 'omni_solutions_register_post_types' );

/**
 * Register custom taxonomies
 */
function omni_solutions_register_taxonomies() {
	// Service Categories
	register_taxonomy( 'service_category', 'service', array(
		'labels'            => array(
			'name'          => _x( 'Service Categories', 'taxonomy general name', 'omni-solutions' ),
			'singular_name' => _x( 'Service Category', 'taxonomy singular name', 'omni-solutions' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'service-category' ),
	) );

	// Industry Categories
	register_taxonomy( 'industry', 'case_study', array(
		'labels'            => array(
			'name'          => _x( 'Industries', 'taxonomy general name', 'omni-solutions' ),
			'singular_name' => _x( 'Industry', 'taxonomy singular name', 'omni-solutions' ),
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_in_rest'      => true,
		'rewrite'           => array( 'slug' => 'industry' ),
	) );
}
add_action( 'init', 'omni_solutions_register_taxonomies' );

/**
 * Filter hook for adding custom classes to menu items
 */
function omni_solutions_nav_menu_link_attributes( $atts, $item, $args ) {
	if ( $args->theme_location === 'primary' ) {
		$atts['class'] = 'nav-link';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'omni_solutions_nav_menu_link_attributes', 10, 3 );

/**
 * Clean up WordPress head
 */
function omni_solutions_remove_wp_version() {
	remove_action( 'wp_head', 'wp_generator' );
}
add_action( 'init', 'omni_solutions_remove_wp_version' );

/**
 * Disable Gutenberg block library
 */
add_filter( 'wp_enqueue_scripts', function() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}, 100 );

/**
 * Create consultation requests table on theme activation
 */
function omni_solutions_create_consultation_table() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name      = $wpdb->prefix . 'consultation_requests';

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		first_name varchar(100) NOT NULL,
		last_name varchar(100) NOT NULL,
		email varchar(100) NOT NULL,
		company_website varchar(255),
		message longtext NOT NULL,
		created_at datetime DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}
add_action( 'after_switch_theme', 'omni_solutions_create_consultation_table' );

/**
 * Handle consultation form submission
 */
function omni_solutions_handle_consultation_submission() {
	// Verify nonce
	if ( ! isset( $_POST['consultation_nonce'] ) || ! wp_verify_nonce( $_POST['consultation_nonce'], 'consultation_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed' ), 403 );
		return;
	}

	// Sanitize and validate input
	$first_name       = isset( $_POST['first_name'] ) ? sanitize_text_field( $_POST['first_name'] ) : '';
	$last_name        = isset( $_POST['last_name'] ) ? sanitize_text_field( $_POST['last_name'] ) : '';
	$email            = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	$company_website  = isset( $_POST['company_website'] ) ? esc_url_raw( $_POST['company_website'] ) : '';
	$message          = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

	// Validate required fields
	if ( empty( $first_name ) || empty( $last_name ) || empty( $email ) || empty( $message ) ) {
		wp_send_json_error( array( 'message' => 'Please fill in all required fields' ) );
		return;
	}

	// Validate email
	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => 'Please enter a valid email address' ) );
		return;
	}

	// Ensure table exists
	omni_solutions_create_consultation_table();

	// Insert into database
	global $wpdb;
	$table_name = $wpdb->prefix . 'consultation_requests';

	$result = $wpdb->insert(
		$table_name,
		array(
			'first_name'      => $first_name,
			'last_name'       => $last_name,
			'email'           => $email,
			'company_website' => $company_website,
			'message'         => $message,
		),
		array( '%s', '%s', '%s', '%s', '%s' )
	);

	if ( ! $result ) {
		wp_send_json_error( array( 'message' => 'Failed to save request' ) );
		return;
	}

	// Prepare common email data
	$admin_email        = omni_solutions_get_consultation_email();
    $site_name          = get_bloginfo( 'name' );
    $site_url           = home_url( '/' );
    // Ideally, get a logo URL from customizer, or use a placeholder
    $logo_url           = get_site_icon_url() ?: 'https://via.placeholder.com/150x50/0f172a/38bdf8?text=' . urlencode($site_name); 
    $admin_requests_url = home_url( '/admin-panel?tab=requests' );
    $headers            = array( 'Content-Type: text/html; charset=UTF-8' );

 // --- SHARED STYLES (Light Mode / Professional) ---
    $bg_main    = '#f1f5f9'; // Slate 100 (The very outer background)
    $bg_card    = '#ffffff'; // Pure White (The main email container)
    $bg_input   = '#f8fafc'; // Slate 50 (The background for the message box)
    $text_main  = '#0f172a'; // Slate 900 (Primary text)
    $text_muted = '#64748b'; // Slate 500 (Labels and secondary text)
    $accent     = '#0ea5e9'; // Sky 600 (Slightly deeper blue for light mode contrast)
    $border     = '#e2e8f0'; // Slate 200 (Subtle dividers)
    
    // Common CSS for the email wrapper
    $wrapper_start = '
    <div style="background-color:'.$bg_main.'; padding: 40px 0; font-family: \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color:'.$bg_card.'; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);">
                        <tr>
                            <td align="center" style="padding: 30px 40px; border-bottom: 1px solid '.$border.';">
								<a href="'.$site_url.'" target="_blank" style="text-decoration:none; color:'.$text_main.';">
									<span style="display:inline-block; vertical-align:middle;">
										<img src="'.$logo_url.'" alt="'.$site_name.'" style="display:block; max-height:40px; border:0;">
									</span>
									<span style="display:inline-block; vertical-align:middle; margin-left:4px; font-size:16px; font-weight:700; color:'.$text_main.';">VescaCloud</span>
								</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 40px;">';

    $wrapper_end = '
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 30px; background-color:'.$bg_input.'; border-top: 1px solid '.$border.';">
                                <p style="margin: 0; font-size: 12px; color: '.$text_muted.'; line-height: 1.5;">
                                    &copy; ' . date("Y") . ' ' . esc_html($site_name) . '. All rights reserved.<br>
                                    <a href="'.$site_url.'" style="color: '.$text_muted.'; text-decoration: none;">'.$site_url.'</a>
                                </p>
                            </td>
                        </tr>
                    </table>
                    </td>
            </tr>
        </table>
    </div>';

    // ------------------------------------------
    // 1. ADMIN NOTIFICATION EMAIL
    // ------------------------------------------
    
    $subject = '🚀 New Consultation: ' . $first_name . ' ' . $last_name;

    $message_body  = $wrapper_start;
    
    // Title
    $message_body .= '<h1 style="margin: 0 0 24px; font-size: 24px; font-weight: 600; color: '.$text_main.';">New Consultation Request</h1>';
    $message_body .= '<p style="margin: 0 0 24px; font-size: 16px; color: '.$text_muted.';">You have received a new inquiry via your website form.</p>';

    // Key Details Table
    $message_body .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">';
    
    $details = [
        'Client Name' => $first_name . ' ' . $last_name,
        'Email Address' => $email,
        'Website' => $company_website // This handles the check internally below
    ];

    foreach($details as $label => $value) {
        if(empty($value)) continue;
        $display_val = ($label === 'Website') ? '<a href="'.esc_url($value).'" style="color:'.$accent.'; text-decoration:none;">'.esc_html($value).'</a>' : esc_html($value);
        
        $message_body .= '<tr>
            <td width="35%" style="padding: 12px 0; border-bottom: 1px solid '.$border.'; color: '.$text_muted.'; font-size: 14px; font-weight: 600;">'.strtoupper($label).'</td>
            <td width="65%" style="padding: 12px 0; border-bottom: 1px solid '.$border.'; color: '.$text_main.'; font-size: 15px;">'.$display_val.'</td>
        </tr>';
    }
    $message_body .= '</table>';

    // Message Block
    $message_body .= '<p style="margin: 0 0 12px; font-size: 14px; font-weight: 600; color: '.$text_muted.';">MESSAGE</p>';
    $message_body .= '<div style="background-color: '.$bg_input.'; border: 1px solid '.$border.'; border-radius: 8px; padding: 20px; color: '.$text_main.'; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">';
    $message_body .= nl2br(esc_html($message));
    $message_body .= '</div>';

    // CTA Button
    $message_body .= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center">';
    $message_body .= '<a href="'.esc_url($admin_requests_url).'" style="display: inline-block; padding: 14px 32px; font-size: 16px; font-weight: 600; color: #ffffff; background-color: #0ea5e9; background-image: linear-gradient(135deg, #0ea5e9, #6366f1); border-radius: 50px; text-decoration: none;">View Request in Admin Panel</a>';
    $message_body .= '</td></tr></table>';

    $message_body .= $wrapper_end;

    wp_mail( $admin_email, $subject, $message_body, $headers );


    // ------------------------------------------
    // 2. USER CONFIRMATION EMAIL
    // ------------------------------------------

    $user_subject = 'We received your consultation request';

    $user_message  = $wrapper_start;

    // Greeting
    $user_message .= '<h1 style="margin: 0 0 16px; font-size: 24px; font-weight: 600; color: '.$text_main.';">Thank you, '.esc_html($first_name).'!</h1>';
    
    // Intro Text
    $user_message .= '<p style="margin: 0 0 24px; font-size: 16px; line-height: 1.6; color: '.$text_muted.';">We have successfully received your consultation details. Our team is reviewing your requirements and will get back to you within <strong>24 hours</strong>.</p>';

    // Copy of message
    $user_message .= '<p style="margin: 0 0 12px; font-size: 14px; color: '.$text_muted.';">Here is a copy of your message:</p>';
    $user_message .= '<div style="background-color: '.$bg_input.'; border-left: 4px solid '.$accent.'; padding: 20px; color: '.$text_main.'; font-style: italic; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">';
    $user_message .= '"' . nl2br(esc_html($message)) . '"';
    $user_message .= '</div>';

    // Sign off
    $user_message .= '<p style="margin: 0; font-size: 16px; color: '.$text_main.';">Best regards,<br><span style="color: '.$accent.'; font-weight: 600;">The VescaCloud Team</span></p>';

    $user_message .= $wrapper_end;

    wp_mail( $email, $user_subject, $user_message, $headers );

    wp_send_json_success( array( 'message' => 'Request submitted successfully' ) );
}
add_action( 'wp_ajax_submit_consultation', 'omni_solutions_handle_consultation_submission' );
add_action( 'wp_ajax_nopriv_submit_consultation', 'omni_solutions_handle_consultation_submission' );

/**
 * Handle About page contact form submission (non-AJAX)
 *
 * Exposes $about_form_success and $about_form_error for use in the About template.
 */
function omni_solutions_handle_about_contact_form() {
	global $about_form_success, $about_form_error;

	// Default state for template usage.
	$about_form_success = false;
	$about_form_error   = '';

	if ( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {
		return;
	}

	// Only process About page contact form submissions.
	if ( ! is_page( 'about' ) ) {
		return;
	}

	if ( ! isset( $_POST['about_contact_nonce'] ) || ! wp_verify_nonce( $_POST['about_contact_nonce'], 'about_contact' ) ) {
		$about_form_error = __( 'Security check failed. Please try again.', 'omni-solutions' );
		return;
	}

	$about_name    = isset( $_POST['about-name'] ) ? sanitize_text_field( wp_unslash( $_POST['about-name'] ) ) : '';
	$about_email   = isset( $_POST['about-email'] ) ? sanitize_email( wp_unslash( $_POST['about-email'] ) ) : '';
	$about_message = isset( $_POST['about-message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['about-message'] ) ) : '';

	if ( empty( $about_name ) || empty( $about_email ) || empty( $about_message ) ) {
		$about_form_error = __( 'Please fill in all required fields.', 'omni-solutions' );
		return;
	}

	if ( ! is_email( $about_email ) ) {
		$about_form_error = __( 'Please enter a valid email address.', 'omni-solutions' );
		return;
	}

	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );
	$headers   = array( 'Content-Type: text/html; charset=UTF-8' );

	// Shared email styling (aligned with consultation emails).
	$bg_main    = '#f1f5f9';
	$bg_card    = '#ffffff';
	$bg_input   = '#f8fafc';
	$text_main  = '#0f172a';
	$text_muted = '#64748b';
	$accent     = '#0ea5e9';
	$border     = '#e2e8f0';
	$logo_url   = get_site_icon_url() ? get_site_icon_url() : '';

	$wrapper_start = '
	<div style="background-color:' . $bg_main . '; padding: 40px 0; font-family: \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center">
					<table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color:' . $bg_card . '; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);">
						<tr>
							<td align="center" style="padding: 30px 40px; border-bottom: 1px solid ' . $border . ';">
								<a href="' . esc_url( $site_url ) . '" target="_blank" style="text-decoration:none; color:' . $text_main . ';">
									<span style="display:inline-block; vertical-align:middle;">';

	if ( $logo_url ) {
		$wrapper_start .= '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_name ) . '" style="display:block; max-height:40px; border:0;">';
	} else {
		$wrapper_start .= '<span style="display:inline-block; padding: 8px 14px; border-radius: 9999px; background: linear-gradient(135deg, #0ea5e9, #6366f1); color: #ffffff; font-weight: 700; font-size: 14px;">' . esc_html( $site_name ) . '</span>';
	}

	$wrapper_start .= '									</span>
									<span style="display:inline-block; vertical-align:middle; margin-left:4px; font-size:16px; font-weight:700; color:' . $text_main . ';">' . esc_html( $site_name ) . '</span>
								</a>
							</td>
						</tr>
						<tr>
							<td style="padding: 40px;">';

	$wrapper_end = '
							</td>
						</tr>
						<tr>
							<td align="center" style="padding: 30px; background-color:' . $bg_input . '; border-top: 1px solid ' . $border . ';">
								<p style="margin: 0; font-size: 12px; color: ' . $text_muted . '; line-height: 1.5;">
									&copy; ' . date( 'Y' ) . ' ' . esc_html( $site_name ) . '. All rights reserved.<br>
									<a href="' . esc_url( $site_url ) . '" style="color: ' . $text_muted . '; text-decoration: none;">' . esc_html( $site_url ) . '</a>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>';

	// Admin notification email.
	$admin_email   = omni_solutions_get_contact_email();
	$admin_subject = sprintf( __( 'New About Page Contact from %s', 'omni-solutions' ), $about_name );

	$admin_body  = $wrapper_start;
	$admin_body .= '<h1 style="margin: 0 0 24px; font-size: 24px; font-weight: 600; color: ' . $text_main . ';">' . esc_html__( 'New About Page Inquiry', 'omni-solutions' ) . '</h1>';
	$admin_body .= '<p style="margin: 0 0 24px; font-size: 16px; color: ' . $text_muted . ';">' . esc_html__( 'You have received a new message from the About page.', 'omni-solutions' ) . '</p>';

	$admin_body .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">';
	$details = array(
		'Name'  => $about_name,
		'Email' => $about_email,
	);
	foreach ( $details as $label => $value ) {
		if ( empty( $value ) ) {
			continue;
		}
		$admin_body .= '<tr>' .
			'<td width="35%" style="padding: 12px 0; border-bottom: 1px solid ' . $border . '; color: ' . $text_muted . '; font-size: 14px; font-weight: 600;">' . esc_html( strtoupper( $label ) ) . '</td>' .
			'<td width="65%" style="padding: 12px 0; border-bottom: 1px solid ' . $border . '; color: ' . $text_main . '; font-size: 15px;">' . esc_html( $value ) . '</td>' .
		'</tr>';
	}
	$admin_body .= '</table>';

	$admin_body .= '<p style="margin: 0 0 12px; font-size: 14px; font-weight: 600; color: ' . $text_muted . ';">' . esc_html__( 'Message', 'omni-solutions' ) . '</p>';
	$admin_body .= '<div style="background-color: ' . $bg_input . '; border: 1px solid ' . $border . '; border-radius: 8px; padding: 20px; color: ' . $text_main . '; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">' . nl2br( esc_html( $about_message ) ) . '</div>';

	$admin_body .= $wrapper_end;

	wp_mail( $admin_email, $admin_subject, $admin_body, $headers );

	// User confirmation email.
	$user_subject = sprintf( __( 'Thanks for contacting %s', 'omni-solutions' ), $site_name );
	$user_body    = $wrapper_start;
	$user_body   .= '<h1 style="margin: 0 0 16px; font-size: 24px; font-weight: 600; color: ' . $text_main . ';">' . sprintf( esc_html__( 'Thank you, %s!', 'omni-solutions' ), esc_html( $about_name ) ) . '</h1>';
	$user_body   .= '<p style="margin: 0 0 24px; font-size: 16px; line-height: 1.6; color: ' . $text_muted . ';">' . esc_html__( 'We have received your message and will get back to you within 24 hours.', 'omni-solutions' ) . '</p>';
	$user_body   .= '<p style="margin: 0 0 12px; font-size: 14px; color: ' . $text_muted . ';">' . esc_html__( 'Here is a copy of your message:', 'omni-solutions' ) . '</p>';
	$user_body   .= '<div style="background-color: ' . $bg_input . '; border-left: 4px solid ' . $accent . '; padding: 20px; color: ' . $text_main . '; font-style: italic; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">"' . nl2br( esc_html( $about_message ) ) . '"</div>';
	$user_body   .= '<p style="margin: 0; font-size: 16px; color: ' . $text_main . ';">' . esc_html__( 'Best regards,', 'omni-solutions' ) . '<br><span style="color: ' . $accent . '; font-weight: 600;">' . esc_html( $site_name ) . '</span></p>';
	$user_body   .= $wrapper_end;

	wp_mail( $about_email, $user_subject, $user_body, $headers );

	$about_form_success = true;
}
add_action( 'template_redirect', 'omni_solutions_handle_about_contact_form' );

/**
 * Handle About page contact form submission via AJAX
 */
function omni_solutions_handle_about_contact_ajax() {
	// Verify nonce.
	if ( ! isset( $_POST['about_contact_nonce'] ) || ! wp_verify_nonce( $_POST['about_contact_nonce'], 'about_contact' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please try again.', 'omni-solutions' ) ), 403 );
	}

	$about_name    = isset( $_POST['about-name'] ) ? sanitize_text_field( wp_unslash( $_POST['about-name'] ) ) : '';
	$about_email   = isset( $_POST['about-email'] ) ? sanitize_email( wp_unslash( $_POST['about-email'] ) ) : '';
	$about_message = isset( $_POST['about-message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['about-message'] ) ) : '';

	if ( empty( $about_name ) || empty( $about_email ) || empty( $about_message ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'omni-solutions' ) ) );
	}

	if ( ! is_email( $about_email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'omni-solutions' ) ) );
	}

	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );
	$headers   = array( 'Content-Type: text/html; charset=UTF-8' );

	// Shared email styling (aligned with consultation emails).
	$bg_main    = '#f1f5f9';
	$bg_card    = '#ffffff';
	$bg_input   = '#f8fafc';
	$text_main  = '#0f172a';
	$text_muted = '#64748b';
	$accent     = '#0ea5e9';
	$border     = '#e2e8f0';
	$logo_url   = get_site_icon_url() ? get_site_icon_url() : '';

	$wrapper_start = '
	<div style="background-color:' . $bg_main . '; padding: 40px 0; font-family: \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center">
					<table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color:' . $bg_card . '; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);">
						<tr>
							<td align="center" style="padding: 30px 40px; border-bottom: 1px solid ' . $border . ';">
								<a href="' . esc_url( $site_url ) . '" target="_blank" style="text-decoration:none; color:' . $text_main . ';">
									<span style="display:inline-block; vertical-align:middle;">';

	if ( $logo_url ) {
		$wrapper_start .= '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_name ) . '" style="display:block; max-height:40px; border:0;">';
	} else {
		$wrapper_start .= '<span style="display:inline-block; padding: 8px 14px; border-radius: 9999px; background: linear-gradient(135deg, #0ea5e9, #6366f1); color: #ffffff; font-weight: 700; font-size: 14px;">' . esc_html( $site_name ) . '</span>';
	}

	$wrapper_start .= '									</span>
									<span style="display:inline-block; vertical-align:middle; margin-left:4px; font-size:16px; font-weight:700; color:' . $text_main . ';">' . esc_html( $site_name ) . '</span>
								</a>
							</td>
						</tr>
						<tr>
							<td style="padding: 40px;">';

	$wrapper_end = '
							</td>
						</tr>
						<tr>
							<td align="center" style="padding: 30px; background-color:' . $bg_input . '; border-top: 1px solid ' . $border . ';">
								<p style="margin: 0; font-size: 12px; color: ' . $text_muted . '; line-height: 1.5;">
									&copy; ' . date( 'Y' ) . ' ' . esc_html( $site_name ) . '. All rights reserved.<br>
									<a href="' . esc_url( $site_url ) . '" style="color: ' . $text_muted . '; text-decoration: none;">' . esc_html( $site_url ) . '</a>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>';

	// Admin notification email.
	$admin_email   = omni_solutions_get_contact_email();
	$admin_subject = sprintf( __( 'New About Page Contact from %s', 'omni-solutions' ), $about_name );

	$admin_body  = $wrapper_start;
	$admin_body .= '<h1 style="margin: 0 0 24px; font-size: 24px; font-weight: 600; color: ' . $text_main . ';">' . esc_html__( 'New About Page Inquiry', 'omni-solutions' ) . '</h1>';
	$admin_body .= '<p style="margin: 0 0 24px; font-size: 16px; color: ' . $text_muted . ';">' . esc_html__( 'You have received a new message from the About page.', 'omni-solutions' ) . '</p>';

	$admin_body .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">';
	$details = array(
		'Name'  => $about_name,
		'Email' => $about_email,
	);
	foreach ( $details as $label => $value ) {
		if ( empty( $value ) ) {
			continue;
		}
		$admin_body .= '<tr>' .
			'<td width="35%" style="padding: 12px 0; border-bottom: 1px solid ' . $border . '; color: ' . $text_muted . '; font-size: 14px; font-weight: 600;">' . esc_html( strtoupper( $label ) ) . '</td>' .
			'<td width="65%" style="padding: 12px 0; border-bottom: 1px solid ' . $border . '; color: ' . $text_main . '; font-size: 15px;">' . esc_html( $value ) . '</td>' .
		'</tr>';
	}
	$admin_body .= '</table>';

	$admin_body .= '<p style="margin: 0 0 12px; font-size: 14px; font-weight: 600; color: ' . $text_muted . ';">' . esc_html__( 'Message', 'omni-solutions' ) . '</p>';
	$admin_body .= '<div style="background-color: ' . $bg_input . '; border: 1px solid ' . $border . '; border-radius: 8px; padding: 20px; color: ' . $text_main . '; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">' . nl2br( esc_html( $about_message ) ) . '</div>';

	$admin_body .= $wrapper_end;

	wp_mail( $admin_email, $admin_subject, $admin_body, $headers );

	// User confirmation email.
	$user_subject = sprintf( __( 'Thanks for contacting %s', 'omni-solutions' ), $site_name );
	$user_body    = $wrapper_start;
	$user_body   .= '<h1 style="margin: 0 0 16px; font-size: 24px; font-weight: 600; color: ' . $text_main . ';">' . sprintf( esc_html__( 'Thank you, %s!', 'omni-solutions' ), esc_html( $about_name ) ) . '</h1>';
	$user_body   .= '<p style="margin: 0 0 24px; font-size: 16px; line-height: 1.6; color: ' . $text_muted . ';">' . esc_html__( 'We have received your message and will get back to you within 24 hours.', 'omni-solutions' ) . '</p>';
	$user_body   .= '<p style="margin: 0 0 12px; font-size: 14px; color: ' . $text_muted . ';">' . esc_html__( 'Here is a copy of your message:', 'omni-solutions' ) . '</p>';
	$user_body   .= '<div style="background-color: ' . $bg_input . '; border-left: 4px solid ' . $accent . '; padding: 20px; color: ' . $text_main . '; font-style: italic; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">"' . nl2br( esc_html( $about_message ) ) . '"</div>';
	$user_body   .= '<p style="margin: 0; font-size: 16px; color: ' . $text_main . ';">' . esc_html__( 'Best regards,', 'omni-solutions' ) . '<br><span style="color: ' . $accent . '; font-weight: 600;">' . esc_html( $site_name ) . '</span></p>';
	$user_body   .= $wrapper_end;

	wp_mail( $about_email, $user_subject, $user_body, $headers );

	wp_send_json_success( array(
		'message' => __( 'Thanks for reaching out. We\'ll get back to you within 24 hours.', 'omni-solutions' ),
	) );
}
add_action( 'wp_ajax_submit_about_contact', 'omni_solutions_handle_about_contact_ajax' );
add_action( 'wp_ajax_nopriv_submit_about_contact', 'omni_solutions_handle_about_contact_ajax' );

/**
 * Handle blog post creation from admin panel
 */
function omni_solutions_create_post_ajax() {
	// Verify user is logged in
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => 'You must be logged in to create posts' ), 403 );
		return;
	}

	// Verify user has permission
	if ( ! current_user_can( 'publish_posts' ) ) {
		wp_send_json_error( array( 'message' => 'You do not have permission to create posts' ), 403 );
		return;
	}

	// Verify nonce
	if ( ! isset( $_POST['post_nonce'] ) || ! wp_verify_nonce( $_POST['post_nonce'], 'create_post_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed' ), 403 );
		return;
	}

	// Sanitize and validate input
	$post_title = isset( $_POST['post_title'] ) ? sanitize_text_field( $_POST['post_title'] ) : '';
	$post_content = isset( $_POST['post_content'] ) ? wp_kses_post( $_POST['post_content'] ) : '';
	$post_excerpt = isset( $_POST['post_excerpt'] ) ? sanitize_textarea_field( $_POST['post_excerpt'] ) : '';
	$post_category = isset( $_POST['post_category'] ) ? intval( $_POST['post_category'] ) : 0;

	// Validate required fields
	if ( empty( $post_title ) || empty( $post_content ) ) {
		wp_send_json_error( array( 'message' => 'Please fill in all required fields' ) );
		return;
	}

	// Create the post
	$post_data = array(
		'post_title'   => $post_title,
		'post_content' => $post_content,
		'post_excerpt' => $post_excerpt,
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_author'  => get_current_user_id(),
	);

	$post_id = wp_insert_post( $post_data );

	if ( is_wp_error( $post_id ) ) {
		wp_send_json_error( array( 'message' => 'Error creating post: ' . $post_id->get_error_message() ) );
		return;
	}

	// Set category if selected
	if ( ! empty( $post_category ) ) {
		wp_set_post_terms( $post_id, array( $post_category ), 'category' );
	}

	wp_send_json_success( array(
		'message' => 'Post created successfully',
		'post_id' => $post_id,
		'post_url' => get_permalink( $post_id ),
	) );
}
add_action( 'wp_ajax_create_post', 'omni_solutions_create_post_ajax' );
add_action( 'wp_ajax_nopriv_create_post', 'omni_solutions_create_post_ajax' );


/**
 * Handle certification image upload
 */
function omni_solutions_upload_certification() {
	// Verify user is logged in and has permission
	if ( ! is_user_logged_in() || ! current_user_can( 'upload_files' ) ) {
		wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
		return;
	}

	// Verify nonce
	       if ( ! isset( $_POST['cert_nonce'] ) || ! wp_verify_nonce( $_POST['cert_nonce'], 'upload_cert_nonce' ) ) {
		       wp_send_json_error( array( 'message' => 'Security check failed' ), 403 );
		       return;
	       }

	// Check if file was uploaded
	if ( empty( $_FILES['cert_image'] ) ) {
		wp_send_json_error( array( 'message' => 'No file uploaded' ) );
		return;
	}

	// Handle file upload
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';

	$attachment_id = media_handle_upload( 'cert_image', 0 );

	if ( is_wp_error( $attachment_id ) ) {
		wp_send_json_error( array( 'message' => 'Upload failed: ' . $attachment_id->get_error_message() ) );
		return;
	}

	// Get existing certifications
	$certifications = get_option( 'omni_certifications', array() );

	// Add new certification (prepend so newest appear first)
	$new_cert = array(
		'id'    => $attachment_id,
		'url'   => wp_get_attachment_url( $attachment_id ),
		'title' => get_the_title( $attachment_id ),
	);

	array_unshift( $certifications, $new_cert );

	update_option( 'omni_certifications', $certifications );

	// Ensure option cache is cleared so new items show immediately
	if ( function_exists( 'wp_cache_delete' ) ) {
		wp_cache_delete( 'omni_certifications', 'options' );
		wp_cache_delete( 'alloptions', 'options' );
	}

	wp_send_json_success( array(
		'message'        => 'Certification uploaded successfully',
		'certification'  => $new_cert,
		'certifications' => $certifications,
	) );
}
add_action( 'wp_ajax_upload_certification', 'omni_solutions_upload_certification' );

/**
 * Handle certification deletion
 */
function omni_solutions_delete_certification() {
	// Verify user is logged in and has permission
	if ( ! is_user_logged_in() || ! current_user_can( 'delete_posts' ) ) {
		wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
		return;
	}

	// Verify nonce
	if ( ! isset( $_POST['cert_nonce'] ) || ! wp_verify_nonce( $_POST['cert_nonce'], 'delete_cert_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed' ), 403 );
		return;
	}

	$attachment_id = isset( $_POST['attachment_id'] ) ? intval( $_POST['attachment_id'] ) : 0;

	if ( ! $attachment_id ) {
		wp_send_json_error( array( 'message' => 'Invalid attachment ID' ) );
		return;
	}

	// Get existing certifications
	$certifications = get_option( 'omni_certifications', array() );

	// Remove certification from array
	$certifications = array_filter(
		$certifications,
		function ( $cert ) use ( $attachment_id ) {
			return $cert['id'] !== $attachment_id;
		}
	);

	// Reindex array
	$certifications = array_values( $certifications );

	update_option( 'omni_certifications', $certifications );

	// Delete attachment
	wp_delete_attachment( $attachment_id, true );

	wp_send_json_success( array(
		'message'        => 'Certification deleted successfully',
		'certifications' => $certifications,
	) );
}
add_action( 'wp_ajax_delete_certification', 'omni_solutions_delete_certification' );

/**
 * Get all jobs from options
 */
function omni_solutions_get_jobs() {
	return get_option( 'omni_jobs', array() );
}

/**
 * Handle job creation via AJAX
 */
function omni_solutions_create_job() {
	// Verify user is logged in and has permission
	if ( ! is_user_logged_in() || ! current_user_can( 'delete_posts' ) ) {
		wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
		return;
	}

	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'job_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed' ), 403 );
		return;
	}

	$title = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
	$location = isset( $_POST['location'] ) ? sanitize_text_field( $_POST['location'] ) : '';
	$type = isset( $_POST['type'] ) ? sanitize_text_field( $_POST['type'] ) : '';
	$description = isset( $_POST['description'] ) ? sanitize_textarea_field( $_POST['description'] ) : '';

	if ( empty( $title ) || empty( $location ) || empty( $type ) || empty( $description ) ) {
		wp_send_json_error( array( 'message' => 'All fields are required' ) );
		return;
	}

	$jobs = get_option( 'omni_jobs', array() );

	$job = array(
		'id'          => 'job-' . time() . '-' . wp_rand( 1000, 9999 ),
		'title'       => $title,
		'location'    => $location,
		'type'        => $type,
		'description' => $description,
	);

	$jobs[] = $job;
	update_option( 'omni_jobs', $jobs );

	wp_send_json_success( array(
		'message' => 'Job created successfully',
		'job'     => $job,
		'jobs'    => $jobs,
	) );
}
add_action( 'wp_ajax_create_job', 'omni_solutions_create_job' );

/**
 * Handle job deletion via AJAX
 */
function omni_solutions_delete_job() {
	// Verify user is logged in and has permission
	if ( ! is_user_logged_in() || ! current_user_can( 'delete_posts' ) ) {
		wp_send_json_error( array( 'message' => 'Permission denied' ), 403 );
		return;
	}

	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'job_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Security check failed' ), 403 );
		return;
	}

	$job_id = isset( $_POST['job_id'] ) ? sanitize_text_field( $_POST['job_id'] ) : '';

	if ( empty( $job_id ) ) {
		wp_send_json_error( array( 'message' => 'Invalid job ID' ) );
		return;
	}

	$jobs = get_option( 'omni_jobs', array() );

	// Remove job from array
	$jobs = array_filter(
		$jobs,
		function ( $job ) use ( $job_id ) {
			return $job['id'] !== $job_id;
		}
	);

	// Reindex array
	$jobs = array_values( $jobs );

	update_option( 'omni_jobs', $jobs );

	wp_send_json_success( array(
		'message' => 'Job deleted successfully',
		'jobs'    => $jobs,
	) );
}
add_action( 'wp_ajax_delete_job', 'omni_solutions_delete_job' );

/**
 * Handle job application submissions from Careers page via AJAX
 */
function omni_solutions_handle_job_application() {
	// Verify nonce.
	if ( ! isset( $_POST['job_apply_nonce'] ) || ! wp_verify_nonce( $_POST['job_apply_nonce'], 'job_apply' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please try again.', 'omni-solutions' ) ), 403 );
	}

	$job_id       = isset( $_POST['job_id'] ) ? sanitize_text_field( wp_unslash( $_POST['job_id'] ) ) : '';
	$job_title    = isset( $_POST['job_title'] ) ? sanitize_text_field( wp_unslash( $_POST['job_title'] ) ) : '';
	$job_location = isset( $_POST['job_location'] ) ? sanitize_text_field( wp_unslash( $_POST['job_location'] ) ) : '';
	$job_type     = isset( $_POST['job_type'] ) ? sanitize_text_field( wp_unslash( $_POST['job_type'] ) ) : '';

	$first_name  = isset( $_POST['firstName'] ) ? sanitize_text_field( wp_unslash( $_POST['firstName'] ) ) : '';
	$last_name   = isset( $_POST['lastName'] ) ? sanitize_text_field( wp_unslash( $_POST['lastName'] ) ) : '';
	$email       = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone       = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$linkedin    = isset( $_POST['linkedin'] ) ? esc_url_raw( wp_unslash( $_POST['linkedin'] ) ) : '';
	$cover_letter = isset( $_POST['coverLetter'] ) ? sanitize_textarea_field( wp_unslash( $_POST['coverLetter'] ) ) : '';

	if ( empty( $job_title ) || empty( $first_name ) || empty( $last_name ) || empty( $email ) || empty( $cover_letter ) ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all required fields.', 'omni-solutions' ) ) );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'omni-solutions' ) ) );
	}

	$site_name = get_bloginfo( 'name' );
	$site_url  = home_url( '/' );
	$headers   = array( 'Content-Type: text/html; charset=UTF-8' );

	// Shared email styling (aligned with consultation/About emails).
	$bg_main    = '#f1f5f9';
	$bg_card    = '#ffffff';
	$bg_input   = '#f8fafc';
	$text_main  = '#0f172a';
	$text_muted = '#64748b';
	$accent     = '#0ea5e9';
	$border     = '#e2e8f0';
	$logo_url   = get_site_icon_url() ? get_site_icon_url() : '';

	$wrapper_start = '
	<div style="background-color:' . $bg_main . '; padding: 40px 0; font-family: \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td align="center">
					<table width="600" border="0" cellspacing="0" cellpadding="0" style="background-color:' . $bg_card . '; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);">
						<tr>
							<td align="center" style="padding: 30px 40px; border-bottom: 1px solid ' . $border . ';">
								<a href="' . esc_url( $site_url ) . '" target="_blank" style="text-decoration:none; color:' . $text_main . ';">
									<span style="display:inline-block; vertical-align:middle;">';

	if ( $logo_url ) {
		$wrapper_start .= '<img src="' . esc_url( $logo_url ) . '" alt="' . esc_attr( $site_name ) . '" style="display:block; max-height:40px; border:0;">';
	} else {
		$wrapper_start .= '<span style="display:inline-block; padding: 8px 14px; border-radius: 9999px; background: linear-gradient(135deg, #0ea5e9, #6366f1); color: #ffffff; font-weight: 700; font-size: 14px;">' . esc_html( $site_name ) . '</span>';
	}

	$wrapper_start .= '									</span>
									<span style="display:inline-block; vertical-align:middle; margin-left:4px; font-size:16px; font-weight:700; color:' . $text_main . ';">' . esc_html( $site_name ) . '</span>
								</a>
							</td>
						</tr>
						<tr>
							<td style="padding: 40px;">';

	$wrapper_end = '
							</td>
						</tr>
						<tr>
							<td align="center" style="padding: 30px; background-color:' . $bg_input . '; border-top: 1px solid ' . $border . ';">
								<p style="margin: 0; font-size: 12px; color: ' . $text_muted . '; line-height: 1.5;">
									&copy; ' . date( 'Y' ) . ' ' . esc_html( $site_name ) . '. All rights reserved.<br>
									<a href="' . esc_url( $site_url ) . '" style="color: ' . $text_muted . '; text-decoration: none;">' . esc_html( $site_url ) . '</a>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>';

	// Admin notification email.
	$admin_email   = omni_solutions_get_jobs_email();
	$admin_subject = sprintf( __( 'New Job Application: %1$s – %2$s %3$s', 'omni-solutions' ), $job_title, $first_name, $last_name );

	$admin_body  = $wrapper_start;
	$admin_body .= '<h1 style="margin: 0 0 24px; font-size: 24px; font-weight: 600; color: ' . $text_main . ';">' . esc_html__( 'New Job Application', 'omni-solutions' ) . '</h1>';
	$admin_body .= '<p style="margin: 0 0 24px; font-size: 16px; color: ' . $text_muted . ';">' . esc_html__( 'You have received a new job application from your Careers page.', 'omni-solutions' ) . '</p>';

	// Position details.
	if ( $job_title || $job_location || $job_type ) {
		$position_line = $job_title ? $job_title : '';
		if ( $job_location ) {
			$position_line .= $position_line ? ' – ' . $job_location : $job_location;
		}
		if ( $job_type ) {
			$position_line .= $position_line ? ' (' . $job_type . ')' : '(' . $job_type . ')';
		}

		$admin_body .= '<p style="margin: 0 0 16px; font-size: 15px; color: ' . $text_main . ';"><strong>' . esc_html__( 'Position:', 'omni-solutions' ) . '</strong> ' . esc_html( $position_line ) . '</p>';
	}

	// Applicant details table.
	$admin_body .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 24px;">';
	$details = array(
		'Name'   => $first_name . ' ' . $last_name,
		'Email'  => $email,
		'Phone'  => $phone,
		'LinkedIn' => $linkedin,
	);
	foreach ( $details as $label => $value ) {
		if ( empty( $value ) ) {
			continue;
		}
		$display_val = 'LinkedIn' === $label ? '<a href="' . esc_url( $value ) . '" style="color:' . $accent . '; text-decoration:none;">' . esc_html( $value ) . '</a>' : esc_html( $value );
		$admin_body .= '<tr>' .
			'<td width="35%" style="padding: 12px 0; border-bottom: 1px solid ' . $border . '; color: ' . $text_muted . '; font-size: 14px; font-weight: 600;">' . esc_html( strtoupper( $label ) ) . '</td>' .
			'<td width="65%" style="padding: 12px 0; border-bottom: 1px solid ' . $border . '; color: ' . $text_main . '; font-size: 15px;">' . $display_val . '</td>' .
		'</tr>';
	}
	$admin_body .= '</table>';

	// Cover letter block.
	$admin_body .= '<p style="margin: 0 0 12px; font-size: 14px; font-weight: 600; color: ' . $text_muted . ';">' . esc_html__( 'Cover Letter', 'omni-solutions' ) . '</p>';
	$admin_body .= '<div style="background-color: ' . $bg_input . '; border: 1px solid ' . $border . '; border-radius: 8px; padding: 20px; color: ' . $text_main . '; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">' . nl2br( esc_html( $cover_letter ) ) . '</div>';

	$admin_body .= $wrapper_end;

	wp_mail( $admin_email, $admin_subject, $admin_body, $headers );

	// User confirmation email.
	$user_subject = sprintf( __( 'Thanks for applying for %s', 'omni-solutions' ), $job_title ? $job_title : __( 'a role', 'omni-solutions' ) );
	$user_body    = $wrapper_start;
	$user_body   .= '<h1 style="margin: 0 0 16px; font-size: 24px; font-weight: 600; color: ' . $text_main . ';">' . sprintf( esc_html__( 'Thank you, %s!', 'omni-solutions' ), esc_html( $first_name ) ) . '</h1>';
	$user_body   .= '<p style="margin: 0 0 24px; font-size: 16px; line-height: 1.6; color: ' . $text_muted . ';">' . esc_html__( 'We have received your application and our team will review it shortly.', 'omni-solutions' ) . '</p>';

	if ( $job_title ) {
		$user_body .= '<p style="margin: 0 0 16px; font-size: 15px; color: ' . $text_main . ';"><strong>' . esc_html__( 'Role:', 'omni-solutions' ) . '</strong> ' . esc_html( $job_title ) . '</p>';
	}

	$user_body   .= '<p style="margin: 0 0 12px; font-size: 14px; color: ' . $text_muted . ';">' . esc_html__( 'Here is a copy of your cover letter:', 'omni-solutions' ) . '</p>';
	$user_body   .= '<div style="background-color: ' . $bg_input . '; border-left: 4px solid ' . $accent . '; padding: 20px; color: ' . $text_main . '; font-style: italic; line-height: 1.6; font-size: 15px; margin-bottom: 30px;">"' . nl2br( esc_html( $cover_letter ) ) . '"</div>';
	$user_body   .= '<p style="margin: 0; font-size: 16px; color: ' . $text_main . ';">' . esc_html__( 'Best regards,', 'omni-solutions' ) . '<br><span style="color: ' . $accent . '; font-weight: 600;">' . esc_html( $site_name ) . '</span></p>';
	$user_body   .= $wrapper_end;

	wp_mail( $email, $user_subject, $user_body, $headers );

	wp_send_json_success( array(
		'message' => __( 'Application submitted. We\'ll review it and get back to you soon.', 'omni-solutions' ),
	) );
}
add_action( 'wp_ajax_submit_job_application', 'omni_solutions_handle_job_application' );
add_action( 'wp_ajax_nopriv_submit_job_application', 'omni_solutions_handle_job_application' );
