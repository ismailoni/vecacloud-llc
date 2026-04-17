<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php if ( is_front_page() || is_home() ) : ?>
		<meta name="description" content="Expert consulting for Salesforce, HubSpot, CRM &amp; ERP integrations. We help businesses connect systems into one scalable, reliable ecosystem.">
		<meta property="og:title" content="VescaCloud | Salesforce, HubSpot, CRM &amp; ERP Integration Consultants" />
		<meta property="og:description" content="Expert consulting to connect your business systems into one reliable ecosystem." />
		<meta property="og:image" content="https://vescacloud.com/wp-content/uploads/2026/02/cropped-favicon.png" />
		<meta property="og:url" content="https://www.vescacloud.com" />
		<meta property="og:type" content="website" />
	<?php endif; ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<?php if ( ! is_page( 'admin-panel' ) ) : ?>
		<header id="masthead" class="site-header">
			<div class="container">
				<div class="header-inner">
					<div class="site-branding">
						<?php echo omni_solutions_get_logo(); ?>
					</div>

					<nav id="site-navigation" class="main-navigation">
						<?php
						wp_nav_menu( array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'fallback_cb'    => 'wp_page_menu',
						) );
						?>
						<div class="mobile-nav-footer">
							<a href="<?php echo esc_url( home_url( '/consultation' ) ); ?>" class="btn btn-primary btn-mobile">
								<?php esc_html_e( 'Get Started', 'omni-solutions' ); ?>
							</a>
						</div>
					</nav>

					<div class="header-actions">
						<a href="<?php echo esc_url( home_url( '/consultation' ) ); ?>" class="get-started">
							<?php esc_html_e( 'Get Started', 'omni-solutions' ); ?>
						</a>
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
							<span class="hamburger">
								<span></span>
								<span></span>
								<span></span>
							</span>
						</button>
					</div>
				</div>
			</div>
		</header>
	<?php endif; ?>

	<main id="main" class="site-main">
