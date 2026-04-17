<?php
/**
 * About Page Template
 *
 * @package Omni_Solutions
 */
?>

<?php
// Ensure contact form state variables are always defined.
if ( ! isset( $about_form_error ) ) {
	$about_form_error = '';
}
if ( ! isset( $about_form_success ) ) {
	$about_form_success = false;
}

$values = array(
	array(
		'title'       => esc_html__( 'Empathy First', 'omni-solutions' ),
		'description' => esc_html__( 'We listen deeply to understand your unique business challenges before designing any solution.', 'omni-solutions' ),
		'icon'        => 'heart',
	),
	array(
		'title'       => esc_html__( 'Trust & Integrity', 'omni-solutions' ),
		'description' => esc_html__( 'Certified experts committed to transparent partnerships and data security at every step.', 'omni-solutions' ),
		'icon'        => 'shield',
	),
	array(
		'title'       => esc_html__( 'Scalable Excellence', 'omni-solutions' ),
		'description' => esc_html__( "We don't just fix today's problems; we build systems that grow with your future ambitions.", 'omni-solutions' ),
		'icon'        => 'zap',
	),
);

$locations = array(
	array(
		'region' => esc_html__( 'United States', 'omni-solutions' ),
		'city'   => esc_html__( 'New York / Remote', 'omni-solutions' ),
	),
	array(
		'region' => esc_html__( 'Morocco', 'omni-solutions' ),
		'city'   => esc_html__( 'Casablanca / Rabat', 'omni-solutions' ),
	),
	array(
		'region' => esc_html__( 'Europe', 'omni-solutions' ),
		'city'   => esc_html__( 'London / Paris / Remote', 'omni-solutions' ),
	),
);

$certifications = array(
	'Salesforce Administrator',
	'Salesforce Sales Cloud Consultant',
	'HubSpot Solutions Partner',
	'Azure Fundamentals',
);

function omni_solutions_about_icon( $name ) {
	$icon_map = array(
		'heart'   => 'heart.svg',
		'shield'  => 'shield.svg',
		'zap'     => 'zap.svg',
		'map-pin' => 'map-pin.svg',
		'users'   => 'users.svg',
		'award'   => 'award.svg',
		'badge-check' => 'badge-check.svg',
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
?>

<div class="container">
	<div class="about-page">
		<section class="about-values-modern">
			<div class="section-header text-center">
				<h1><?php esc_html_e( 'Our Values', 'omni-solutions' ); ?></h1>
				<p class="section-lead max-w-2xl mx-auto">
					<?php esc_html_e( 'The core principles that guide every integration and strategy we deliver.', 'omni-solutions' ); ?>
				</p>
			</div>
			<div class="about-values-grid">
				<?php foreach ( $values as $value ) : ?>
					<div class="card about-value-card">
						<div class="about-value-icon">
							<?php echo omni_solutions_about_icon( $value['icon'] ); ?>
						</div>
						<h3><?php echo esc_html( $value['title'] ); ?></h3>
						<p class="about-value-description"><?php echo esc_html( $value['description'] ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<section class="about-experts">
			<div class="section-header text-center">
				<h2><?php esc_html_e( 'Our Experts', 'omni-solutions' ); ?></h2>
				<p class="section-lead max-w-2xl mx-auto">
					<?php esc_html_e( 'A team of certified professionals with deep expertise across leading platforms.', 'omni-solutions' ); ?>
				</p>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
				<div class="card about-expert-card">
					<div class="about-expert-icon">
						<?php echo omni_solutions_about_icon( 'users' ); ?>
					</div>
					<div class="about-stat">25+</div>
					<h3><?php esc_html_e( 'Expert Consultants', 'omni-solutions' ); ?></h3>
					<p><?php esc_html_e( 'Seasoned professionals with hands-on experience across industries.', 'omni-solutions' ); ?></p>
				</div>
				<div class="card about-expert-card">
					<div class="about-expert-icon">
						<?php echo omni_solutions_about_icon( 'award' ); ?>
					</div>
					<div class="about-stat">15+</div>
					<h3><?php esc_html_e( 'Certifications Held', 'omni-solutions' ); ?></h3>
					<p><?php esc_html_e( 'Recognized credentials from Salesforce, HubSpot, Microsoft, and more.', 'omni-solutions' ); ?></p>
				</div>
				<div class="card about-expert-card">
					<div class="about-expert-icon">
						<?php echo omni_solutions_about_icon( 'badge-check' ); ?>
					</div>
					<div class="about-stat">10+</div>
					<h3><?php esc_html_e( 'Years Experience', 'omni-solutions' ); ?></h3>
					<p><?php esc_html_e( 'A decade of delivering successful CRM and integration projects.', 'omni-solutions' ); ?></p>
				</div>
			</div>

			<div class="about-certifications">
				<p class="about-cert-quote">
					<?php esc_html_e( '"A team you can trust at a price you can afford"', 'omni-solutions' ); ?>
				</p>
				<div class="about-cert-list">
					<?php
					$certifications_images = get_option( 'omni_certifications', array() );
					if ( ! empty( $certifications_images ) ) :
						foreach ( $certifications_images as $cert ) :
							?>
							<div class="about-cert-image">
								<img src="<?php echo esc_url( $cert['url'] ); ?>" alt="<?php echo esc_attr( $cert['title'] ); ?>" loading="lazy" decoding="async">
							</div>
							<?php
						endforeach;
					else :
						// Fallback to text badges if no images uploaded
						foreach ( $certifications as $certification ) :
							?>
							<span class="about-cert-badge"><?php echo esc_html( $certification ); ?></span>
							<?php
						endforeach;
					endif;
					?>
				</div>
				<p class="about-cert-message">
					<?php esc_html_e( 'Your operation is unique, and your Salesforce instance needs to be equally so. Let us make it fit you like a glove!', 'omni-solutions' ); ?>
				</p>
			</div>
		</section>

		<section class="about-locations">
			<div class="section-header text-center">
				<h2><?php esc_html_e( 'Global Presence', 'omni-solutions' ); ?></h2>
				<p class="section-lead max-w-2xl mx-auto">
					<?php esc_html_e( 'We operate across borders to support businesses worldwide.', 'omni-solutions' ); ?>
				</p>
			</div>
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php foreach ( $locations as $location ) : ?>
				<div class="about-location-card">
					<div class="about-location-icon">
						<?php echo omni_solutions_about_icon( 'map-pin' ); ?>
					</div>
					<div>
						<div class="about-location-title"><?php echo esc_html( $location['region'] ); ?></div>
						<div class="about-location-subtitle"><?php echo esc_html( $location['city'] ); ?></div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		</section>

		<section class="about-contact">
			<div class="section-header text-center">
				<h2><?php esc_html_e( 'Get in Touch', 'omni-solutions' ); ?></h2>
				<p class="section-lead max-w-2xl mx-auto">
					<?php esc_html_e( 'Have a question about our values or locations? Send us a message.', 'omni-solutions' ); ?>
				</p>
			</div>
			<div class="card about-contact-card">
				<form method="post" class="about-contact-form">
					<div class="consultation-card-header">
						<h3 class="consultation-card-title"><?php esc_html_e( 'Ask Our Team', 'omni-solutions' ); ?></h3>
						<p class="consultation-card-description"><?php esc_html_e( 'Share a bit about your question and we\'ll reply within 24 hours.', 'omni-solutions' ); ?></p>
					</div>

					<div class="form-group">
						<label for="about-name" class="form-label"><?php esc_html_e( 'Full Name', 'omni-solutions' ); ?></label>
						<input id="about-name" name="about-name" type="text" class="form-input" placeholder="<?php esc_attr_e( 'Enter your name', 'omni-solutions' ); ?>" required>
					</div>
					<div class="form-group">
						<label for="about-email" class="form-label"><?php esc_html_e( 'Email Address', 'omni-solutions' ); ?></label>
						<input id="about-email" name="about-email" type="email" class="form-input" placeholder="<?php esc_attr_e( 'you@company.com', 'omni-solutions' ); ?>" required>
					</div>
					<div class="form-group">
						<label for="about-message" class="form-label"><?php esc_html_e( 'Message', 'omni-solutions' ); ?></label>
						<textarea id="about-message" name="about-message" rows="5" class="form-textarea" placeholder="<?php esc_attr_e( 'How can we help you today?', 'omni-solutions' ); ?>" required></textarea>
					</div>
					<?php wp_nonce_field( 'about_contact', 'about_contact_nonce' ); ?>
					<input type="hidden" name="action" value="submit_about_contact" />

					<button class="consultation-submit-btn" type="submit">
						<span class="btn-text"><?php esc_html_e( 'Send Message', 'omni-solutions' ); ?></span>
						<span class="btn-loader" style="display: none;">
							<?php esc_html_e( 'Sending...', 'omni-solutions' ); ?>
						</span>
					</button>

					<div class="form-message" style="display: none;"></div>
				</form>
			</div>
		</section>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	const form = document.querySelector('.about-contact-form');
	if (!form) return;

	form.addEventListener('submit', async function(event) {
		event.preventDefault();

		const submitBtn = form.querySelector('.consultation-submit-btn');
		const btnText = submitBtn.querySelector('.btn-text');
		const btnLoader = submitBtn.querySelector('.btn-loader');
		const formMessage = form.querySelector('.form-message');

		const formData = new FormData(form);
		// Ensure correct AJAX action.
		formData.set('action', 'submit_about_contact');

		// Loading state
		submitBtn.disabled = true;
		btnText.style.display = 'none';
		btnLoader.style.display = 'inline-flex';
		formMessage.style.display = 'none';
		formMessage.className = 'form-message';

		try {
			const response = await fetch('<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', {
				method: 'POST',
				body: formData,
			});

			const result = await response.json();

			if (result && result.success) {
				formMessage.classList.add('success');
				formMessage.textContent = result.data && result.data.message
					? result.data.message
					: <?php echo wp_json_encode( __( "Thanks for reaching out. We'll get back to you within 24 hours.", 'omni-solutions' ) ); ?>;
				formMessage.style.display = 'block';
				form.reset();

				if (window.omniSolutions && typeof omniSolutions.showToast === 'function') {
					omniSolutions.showToast(formMessage.textContent || <?php echo wp_json_encode( __( "Message sent successfully.", 'omni-solutions' ) ); ?>);
				}
			} else {
				throw new Error(result && result.data && result.data.message ? result.data.message : 'Submission failed');
			}
		} catch (error) {
			formMessage.classList.add('error');
			formMessage.textContent = error.message || <?php echo wp_json_encode( __( 'Something went wrong. Please try again or email us directly.', 'omni-solutions' ) ); ?>;
			formMessage.style.display = 'block';
		} finally {
			btnText.style.display = 'block';
			btnLoader.style.display = 'none';
			submitBtn.disabled = false;
		}
	});
});
</script>

