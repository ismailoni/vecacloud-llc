<?php
/**
 * Front Page Template
 *
 * @package Omni_Solutions
 */

get_header();

$services = array(
	array(
		'title'       => esc_html__( 'Implementations', 'omni-solutions' ),
		'description' => esc_html__( 'About to kick off your Salesforce journey? We help you get it right from day one. We take the time to understand your business and design a solution that empowers your team and sets you up for long-term success.', 'omni-solutions' ),
		'icon'        => 'cloud',
	),
	array(
		'title'       => esc_html__( 'Integrations', 'omni-solutions' ),
		'description' => esc_html__( 'Looking to supercharge Salesforce by connecting it with your other systems? We specialize in integrating Salesforce with accounting tools, marketing platforms, customer support systems, and custom databases—helping everything work together seamlessly.', 'omni-solutions' ),
		'icon'        => 'globe',
	),
	array(
		'title'       => esc_html__( 'Customizations', 'omni-solutions' ),
		'description' => esc_html__( 'Need automation, custom UI components, or a tailored experience? From simple workflows to advanced custom solutions, we make Salesforce work the way you need it to. Our goal is to shape the platform around your business—not the other way around.', 'omni-solutions' ),
		'icon'        => 'database',
	),
);

$clouds = array(
	array(
		'name'        => esc_html__( 'Sales Cloud', 'omni-solutions' ),
		'description' => esc_html__( 'Pipeline management, forecasting, and sales automation to close deals faster.', 'omni-solutions' ),
		'icon'        => 'briefcase',
	),
	array(
		'name'        => esc_html__( 'Service Cloud', 'omni-solutions' ),
		'description' => esc_html__( 'Customer support, case management, and omnichannel service solutions.', 'omni-solutions' ),
		'icon'        => 'headphones',
	),
	array(
		'name'        => esc_html__( 'Marketing Cloud', 'omni-solutions' ),
		'description' => esc_html__( 'Personalized campaigns, email journeys, and marketing automation at scale.', 'omni-solutions' ),
		'icon'        => 'trending',
	),
	array(
		'name'        => esc_html__( 'Experience Cloud', 'omni-solutions' ),
		'description' => esc_html__( 'Custom portals, communities, and partner engagement platforms.', 'omni-solutions' ),
		'icon'        => 'users',
	),
	array(
		'name'        => esc_html__( 'Field Service', 'omni-solutions' ),
		'description' => esc_html__( 'Mobile workforce management, scheduling optimization, and on-site service delivery.', 'omni-solutions' ),
		'icon'        => 'database',
	),
	array(
		'name'        => esc_html__( 'Nonprofit Cloud', 'omni-solutions' ),
		'description' => esc_html__( 'Fundraising, grant management, and program delivery for nonprofits.', 'omni-solutions' ),
		'icon'        => 'layers',
	),
	array(
		'name'        => esc_html__( 'Financial Services Cloud', 'omni-solutions' ),
		'description' => esc_html__( 'Client management, financial planning, and regulatory compliance for financial institutions.', 'omni-solutions' ),
		'icon'        => 'chart',
	),
	array(
		'name'        => esc_html__( 'Agentforce', 'omni-solutions' ),
		'description' => esc_html__( 'AI-powered autonomous agents that work alongside your team 24/7.', 'omni-solutions' ),
		'icon'        => 'sparkles',
	),
);

$technologies = array(
    array(
        'name'    => 'Zapier',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/f/fd/Zapier_logo.svg',
    ),
    array(
        'name'    => 'Make',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/e/ec/Make_Logo.png', 
    ),
    array(
        'name'    => 'QuickBooks',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/7/79/Intuit_QuickBooks_logo.svg',
    ),
    array(
        'name'    => 'Mailchimp',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/e/e4/MailChimp.svg',
    ),
    array(
        'name'    => 'Catchlight',
        'logoUrl' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIqgn_0wfmyJKMcmTq2ytoNRE6AzpkR5OXng&s',
    ),
    array(
        'name'    => 'HubSpot',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/3/3f/HubSpot_Logo.svg',
    ),
    array(
        'name'    => 'Snowflake',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/f/ff/Snowflake_Logo.svg',
    ),
    array(
        'name'    => 'Conga',
        'logoUrl' => 'https://images.seeklogo.com/logo-png/47/1/conga-logo-png_seeklogo-470620.png',
    ),
    array(
        'name'    => 'n8n',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/5/53/N8n-logo-new.svg',
    ),
    array(
        'name'    => 'Slack',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/b/b9/Slack_Technologies_Logo.svg',
    ),
    array(
        'name'    => 'Salesforce',
        'logoUrl' => 'https://upload.wikimedia.org/wikipedia/commons/f/f9/Salesforce.com_logo.svg',
    ),
	array(
		'name'    => 'Skyvia',
		'logoUrl' => 'https://www.getharvest.com/hubfs/integrations-new/skyvia-logo.svg'
	),
	array(
		'name'    => 'Copado',
		'logoUrl' => 'https://mma.prnewswire.com/media/1529240/Copado_Logo_Color_Logo.jpg'
	),
	array(
		'name'    => 'Gearset',
		'logoUrl' => 'https://appexchange.salesforce.com/image_host/61c0fa40-46e8-4b3e-91ac-852111e2d694.png'
	),
);

function omni_solutions_home_icon( $name ) {
	$icon_map = array(
		'cloud'       => 'cloud.svg',
		'globe'       => 'globe.svg',
		'database'    => 'database.svg',
		'briefcase'   => 'briefcase.svg',
		'headphones'  => 'headphones.svg',
		'trending'    => 'trending-up.svg',
		'users'       => 'users.svg',
		'layers'      => 'layers.svg',
		'chart'       => 'chart-bar.svg',
		'sparkles'    => 'sparkles.svg',
		'arrow-left'  => 'arrow-left.svg',
		'arrow-right' => 'arrow-right.svg',
	);

	if ( empty( $icon_map[ $name ] ) ) {
		return '';
	}

	$icon_path = get_template_directory() . '/assets/icons/' . $icon_map[ $name ];
	if ( ! file_exists( $icon_path ) ) {
		return '';
	}

	$svg = file_get_contents( $icon_path );
	if ( ! $svg ) {
		return '';
	}

	$svg = str_replace( '<svg', '<svg class="icon-svg"', $svg );

	return $svg;
}

$organization_json_ld = array(
	'@context'     => 'https://schema.org',
	'@type'        => 'Organization',
	'name'         => 'VescaCloud',
	'url'          => 'https://vescacloud.com',
	'logo'         => 'https://vescacloud.com/logo.png',
	'description'  => 'Expert consulting for Salesforce, HubSpot, CRM, and ERP integrations. We help businesses connect their systems into one scalable, reliable ecosystem.',
	'sameAs'       => array(
		'https://linkedin.com/company/vescacloud',
	),
	'contactPoint' => array(
		'@type'       => 'ContactPoint',
		'contactType' => 'sales',
		'url'         => 'https://vescacloud.com/consultation',
	),
	'address'      => array(
		array(
			'@type'            => 'PostalAddress',
			'addressLocality'  => 'New York',
			'addressCountry'   => 'US',
		),
		array(
			'@type'            => 'PostalAddress',
			'addressLocality'  => 'Casablanca',
			'addressCountry'   => 'MA',
		),
		array(
			'@type'            => 'PostalAddress',
			'addressLocality'  => 'London',
			'addressCountry'   => 'GB',
		),
	),
	'knowsAbout'   => array(
		'Salesforce',
		'HubSpot',
		'CRM Integration',
		'ERP Integration',
		'Systems Integration',
		'Data Migration',
		'API Integration',
		'Business Automation',
	),
);

$service_json_ld = array(
	'@context'        => 'https://schema.org',
	'@type'           => 'ProfessionalService',
	'name'            => 'VescaCloud',
	'serviceType'     => array(
		'Salesforce Consulting',
		'HubSpot Integration',
		'CRM Consulting',
		'ERP Integration',
		'Systems Integration',
	),
	'areaServed'      => 'Worldwide',
	'hasOfferCatalog' => array(
		'@type'           => 'OfferCatalog',
		'name'            => 'Consulting Services',
		'itemListElement' => array(
			array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type'       => 'Service',
					'name'        => 'Salesforce Implementation',
					'description' => 'End-to-end Salesforce setup and configuration tailored to your business needs.',
				),
			),
			array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type'       => 'Service',
					'name'        => 'System Integration',
					'description' => 'Connect Salesforce with your existing tools including accounting, marketing, and support platforms.',
				),
			),
			array(
				'@type'       => 'Offer',
				'itemOffered' => array(
					'@type'       => 'Service',
					'name'        => 'Salesforce Customization',
					'description' => 'Custom workflows, UI components, and automation tailored to your processes.',
				),
			),
		),
	),
);
?>

<script type="application/ld+json">
	<?php echo wp_json_encode( $organization_json_ld ); ?>
</script>
<script type="application/ld+json">
	<?php echo wp_json_encode( $service_json_ld ); ?>
</script>

<section class="hero home-hero">
	<div class="home-hero-bg"></div>
	<div class="home-hero-blob home-hero-blob-top"></div>
	<div class="home-hero-blob home-hero-blob-bottom"></div>
	<div class="container">
		<div class="hero-content">
			<div class="hero-text">
			<p class="hero-tag"><?php esc_html_e( 'Trusted by Growing Businesses', 'omni-solutions' ); ?></p>
			<h1 class="hero-title">
				<?php esc_html_e( 'Consulting & Integrations', 'omni-solutions' ); ?><br>
				<?php esc_html_e( 'That Drive Results.', 'omni-solutions' ); ?>
			</h1>
			<p class="hero-subtitle">
					<?php esc_html_e( 'From strategic consulting to seamless integrations, we help businesses get the most out of Salesforce, HubSpot, ERP, and CRM platforms — building scalable solutions that grow with you.', 'omni-solutions' ); ?>
				</p>
				<div class="hero-actions">
					<a class="btn-hero" href="<?php echo esc_url( home_url( '/consultation' ) ); ?>">
						<?php esc_html_e( 'Book a Consultation', 'omni-solutions' ); ?>
						<span class="hero-arrow">→</span>
					</a>
					<a class="btn-outline" href="#services">
						<?php esc_html_e( 'View Solutions', 'omni-solutions' ); ?>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="home-services" id="services">
	<div class="container">
		<div class="section-header text-center">
			<p class="section-kicker"><?php esc_html_e( 'What We Do', 'omni-solutions' ); ?></p>
			<h2><?php esc_html_e( 'Consulting & Integration Services', 'omni-solutions' ); ?></h2>
			<p class="section-lead max-w-2xl mx-auto">
				<?php esc_html_e( 'End-to-end consulting, integration, and customization — from strategy and implementation to ongoing optimization and support.', 'omni-solutions' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 home-service-grid">
			<?php foreach ( $services as $service ) : ?>
				<a class="card service-card service-card-link" href="<?php echo esc_url( home_url( '/consultation' ) ); ?>">
					<div class="service-icon">
						<?php echo omni_solutions_home_icon( $service['icon'] ); ?>
					</div>
					<div>
						<h3><?php echo esc_html( $service['title'] ); ?></h3>
						<p class="service-description"><?php echo esc_html( $service['description'] ); ?></p>
						<span class="service-link">
							<?php esc_html_e( 'Learn more', 'omni-solutions' ); ?>
							<span class="hero-arrow">&rarr;</span>
						</span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<div class="home-services-cta text-center">
			<p><?php esc_html_e( 'Get in touch to see how we can help.', 'omni-solutions' ); ?></p>
			<a class="btn btn-primary btn-pill" href="<?php echo esc_url( home_url( '/consultation' ) ); ?>">
				<?php esc_html_e( 'Contact Our Experts', 'omni-solutions' ); ?>
			</a>
		</div>
	</div>
</section>

<section class="home-clouds" id="clouds">
	<div class="container">
		<div class="section-header text-center">
			<p class="section-kicker"><?php esc_html_e( 'Our Salesforce Expertise', 'omni-solutions' ); ?></p>
			<h2><?php esc_html_e( 'Clouds We Work With', 'omni-solutions' ); ?></h2>
			<p class="section-lead max-w-2xl mx-auto">
				<?php esc_html_e( 'We consult across the full Salesforce ecosystem — helping you get the most out of every cloud.', 'omni-solutions' ); ?>
			</p>
		</div>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 home-cloud-grid">
			<?php foreach ( $clouds as $cloud ) : ?>
				<div class="card cloud-card">
					<div class="cloud-icon">
						<?php echo omni_solutions_home_icon( $cloud['icon'] ); ?>
					</div>
                    <div>
                        <h3><?php echo esc_html( $cloud['name'] ); ?></h3>
                        <p><?php echo esc_html( $cloud['description'] ); ?></p>
                    </div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="home-tech" id="solutions">
	<div class="container toolkit-container">
		<div class="section-header text-center">
			<p class="section-kicker"><?php esc_html_e( 'Our Toolkit', 'omni-solutions' ); ?></p>
			<h2><?php esc_html_e( 'Technologies We Specialize In', 'omni-solutions' ); ?></h2>
			<p class="section-lead max-w-2xl mx-auto">
				<?php esc_html_e( 'Our certified experts work with industry-leading platforms to deliver seamless solutions for your business.', 'omni-solutions' ); ?>
			</p>
		</div>

		<div class="relative w-full max-w-5xl mx-auto px-14 embla">
			<div class="relative w-full" role="region" aria-roledescription="carousel">
				<div class="overflow-hidden embla__viewport">
					<div class="tech-carousel embla__container" role="region" aria-label="<?php esc_attr_e( 'Technology carousel', 'omni-solutions' ); ?>">
						<?php foreach ( $technologies as $technology ) : ?>
							<div role="group" aria-roledescription="slide" class="tech-card-wrapper embla__slide">
								<a class="tech-card" href="<?php echo esc_url( home_url( '/consultation' ) ); ?>">
									<div class="tech-card-inner">
										<?php if ( ! empty( $technology['logoUrl'] ) ) : ?>
											<img src="<?php echo esc_url( $technology['logoUrl'] ); ?>" alt="<?php echo esc_attr( $technology['name'] ); ?>" class="tech-logo">
										<?php else : ?>
											<div class="tech-logo tech-logo-fallback"><?php echo esc_html( strtoupper( mb_substr( $technology['name'], 0, 2 ) ) ); ?></div>
										<?php endif; ?>
										<span class="tech-name"><?php echo esc_html( $technology['name'] ); ?></span>
									</div>
								</a>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<button class="carousel-nav carousel-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'omni-solutions' ); ?>">
					<?php echo omni_solutions_home_icon( 'arrow-left' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
				<button class="carousel-nav carousel-next" aria-label="<?php esc_attr_e( 'Next slide', 'omni-solutions' ); ?>">
					<?php echo omni_solutions_home_icon( 'arrow-right' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</button>
			</div>
		</div>
	</div>
</section>

<script src="https://unpkg.com/embla-carousel/embla-carousel.umd.js"></script>
<script src="https://unpkg.com/embla-carousel-autoplay/embla-carousel-autoplay.umd.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
	const emblaNode = document.querySelector('.home-tech .embla');
	if (!emblaNode || typeof EmblaCarousel === 'undefined') return;

	const viewportNode = emblaNode.querySelector('.embla__viewport');
	if (!viewportNode) return;

	const prevBtn = emblaNode.querySelector('.carousel-prev');
	const nextBtn = emblaNode.querySelector('.carousel-next');

	const emblaApi = EmblaCarousel(viewportNode, { loop: true, align: 'start', containScroll: 'trimSnaps' }, [
		typeof EmblaCarouselAutoplay !== 'undefined'
			? EmblaCarouselAutoplay({ delay: 2000 })
			: null,
	].filter(Boolean));

	const autoplay = emblaApi.plugins().autoplay;
	let autoplayResumeTimeout;

	function pauseAutoplayAndResume() {
		if (!autoplay) return;
		autoplay.stop();
		if (autoplayResumeTimeout) {
			clearTimeout(autoplayResumeTimeout);
		}
		autoplayResumeTimeout = setTimeout(function () {
			autoplay.play();
		}, 2000);
	}

	if (prevBtn) {
		prevBtn.addEventListener('click', function () {
			emblaApi.scrollPrev();
			pauseAutoplayAndResume();
		});
	}

	if (nextBtn) {
		nextBtn.addEventListener('click', function () {
			emblaApi.scrollNext();
			pauseAutoplayAndResume();
		});
	}

	if (autoplay) {
		autoplay.play();
	}
});
</script>

<section class="home-philosophy" id="about">
	<div class="container">
		<div class="section-header text-center">
			<p class="section-kicker"><?php esc_html_e( 'Why Us', 'omni-solutions' ); ?></p>
			<h2><?php esc_html_e( 'Philosophy', 'omni-solutions' ); ?></h2>
			<p class="section-lead-phil max-w-2xl mx-auto">
				<?php echo wp_kses_post( __( "At VescaCloud, we believe Salesforce is more than just a tool—it's the heart of your business operations. Our approach focuses on seamless <b>Salesforce integrations</b> and industry-leading <b>best practices</b>. With a deep bench of <b>certified experts</b>, we ensure your platform is built for scalability and long-term success.", 'omni-solutions' ) ); ?>
			</p>
		</div>

		<div class="home-stats grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<div class="stat-card">
				<div class="stat-number">100+</div>
				<div class="stat-label"><?php esc_html_e( 'Projects Delivered', 'omni-solutions' ); ?></div>
				<p><?php esc_html_e( 'Successful implementations across diverse industries.', 'omni-solutions' ); ?></p>
			</div>
			<div class="stat-card">
				<div class="stat-number">15+</div>
				<div class="stat-label"><?php esc_html_e( 'Certifications', 'omni-solutions' ); ?></div>
				<p><?php esc_html_e( 'Rigorous expertise backed by official Salesforce credentials.', 'omni-solutions' ); ?></p>
			</div>
			<div class="stat-card">
				<div class="stat-number">99%</div>
				<div class="stat-label"><?php esc_html_e( 'Success Rate', 'omni-solutions' ); ?></div>
				<p class="stat-description"><?php esc_html_e( 'Clean architecture designed for future-proof scalability.', 'omni-solutions' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="home-cta">
	<div class="home-cta-overlay"></div>
	<div class="container home-cta-inner">
		<h2><?php esc_html_e( 'Ready to optimize your stack?', 'omni-solutions' ); ?></h2>
		<p><?php esc_html_e( 'Schedule a free 30-minute consultation to discuss your integration needs.', 'omni-solutions' ); ?></p>
		<a class="btn btn-secondary btn-footer" href="<?php echo esc_url( home_url( '/consultation' ) ); ?>">
			<?php esc_html_e( 'Start Your Journey', 'omni-solutions' ); ?>
			<span class="hero-arrow">→</span>
		</a>
	</div>
</section>

<?php
get_footer();
