<?php
/**
 * Consultation Request Page Template
 *
 * @package Omni_Solutions
 */

/**
 * Get consultation icon SVG
 */
function omni_solutions_consultation_icon( $name ) {
	$icon_map = array(
		'check-circle2' => 'check-circle2.svg',
		'loader2'       => 'loader2.svg',
	);

	if ( ! isset( $icon_map[ $name ] ) ) {
		return '';
	}

	$icon_path = get_template_directory() . '/assets/icons/' . $icon_map[ $name ];
	if ( ! file_exists( $icon_path ) ) {
		return '';
	}

	$svg = file_get_contents( $icon_path );
	$svg = str_replace( '<svg', '<svg class="consultation-icon"', $svg );
	return $svg;
}
?>

<div class="consultation-container">
	<div class="consultation-grid">
		<!-- Left Section: Benefits -->
		<div class="consultation-left">
			<h1 class="consultation-title"><?php esc_html_e( 'Schedule Your Free Consultation', 'omni-solutions' ); ?></h1>
			<p class="consultation-subtitle"><?php esc_html_e( 'Take the first step toward a more integrated and efficient business ecosystem. During our 30-minute call, we\'ll:', 'omni-solutions' ); ?></p>

			<ul class="consultation-benefits-list">
				<li class="benefit-item">
					<?php echo omni_solutions_consultation_icon( 'check-circle2' ); ?>
					<span><?php esc_html_e( 'Audit your current system architecture', 'omni-solutions' ); ?></span>
				</li>
				<li class="benefit-item">
					<?php echo omni_solutions_consultation_icon( 'check-circle2' ); ?>
					<span><?php esc_html_e( 'Identify high-impact automation opportunities', 'omni-solutions' ); ?></span>
				</li>
				<li class="benefit-item">
					<?php echo omni_solutions_consultation_icon( 'check-circle2' ); ?>
					<span><?php esc_html_e( 'Discuss potential integration roadmaps', 'omni-solutions' ); ?></span>
				</li>
				<li class="benefit-item">
					<?php echo omni_solutions_consultation_icon( 'check-circle2' ); ?>
					<span><?php esc_html_e( 'Provide initial scalability recommendations', 'omni-solutions' ); ?></span>
				</li>
			</ul>
		</div>

		<!-- Right Section: Form Card -->
		<div class="consultation-right">
			<div class="consultation-card">
				<div class="consultation-card-header">
					<h2 class="consultation-card-title"><?php esc_html_e( 'Request a Call', 'omni-solutions' ); ?></h2>
					<p class="consultation-card-description"><?php esc_html_e( 'Fill out the form below and an expert will reach out shortly.', 'omni-solutions' ); ?></p>
				</div>

				<div class="consultation-card-content">
					<form class="consultation-form" method="POST" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
						<?php wp_nonce_field( 'consultation_nonce', 'consultation_nonce' ); ?>
						<input type="hidden" name="action" value="submit_consultation">

						<!-- Name Row -->
						<div class="form-row">
							<div class="form-group">
								<label for="first_name" class="form-label"><?php esc_html_e( 'First Name', 'omni-solutions' ); ?></label>
								<input type="text" id="first_name" name="first_name" class="form-input" placeholder="<?php esc_attr_e( 'John', 'omni-solutions' ); ?>" required>
							</div>
							<div class="form-group">
								<label for="last_name" class="form-label"><?php esc_html_e( 'Last Name', 'omni-solutions' ); ?></label>
								<input type="text" id="last_name" name="last_name" class="form-input" placeholder="<?php esc_attr_e( 'Doe', 'omni-solutions' ); ?>" required>
							</div>
						</div>

						<!-- Email -->
						<div class="form-group">
							<label for="email" class="form-label"><?php esc_html_e( 'Work Email', 'omni-solutions' ); ?></label>
							<input type="email" id="email" name="email" class="form-input" placeholder="<?php esc_attr_e( 'john@company.com', 'omni-solutions' ); ?>" required>
						</div>

						<!-- Company Website -->
						<div class="form-group">
							<label for="company_website" class="form-label"><?php esc_html_e( 'Company Website', 'omni-solutions' ); ?></label>
							<input type="text" inputmode="url" id="company_website" name="company_website" class="form-input" placeholder="<?php esc_attr_e( 'https://www.example.com or example.com', 'omni-solutions' ); ?>" required>
						</div>

						<!-- Message -->
						<div class="form-group">
							<label for="message" class="form-label"><?php esc_html_e( 'How can we help?', 'omni-solutions' ); ?></label>
							<textarea id="message" name="message" class="form-textarea" placeholder="<?php esc_attr_e( 'Tell us about your current systems and goals...', 'omni-solutions' ); ?>" rows="4" required></textarea>
						</div>

						<!-- Submit Button -->
						<button type="submit" class="consultation-submit-btn">
							<span class="btn-text"><?php esc_html_e( 'Send Request', 'omni-solutions' ); ?></span>
							<span class="btn-loader" style="display: none;">
								<?php echo omni_solutions_consultation_icon( 'loader2' ); ?>
								<?php esc_html_e( 'Sending...', 'omni-solutions' ); ?>
							</span>
						</button>

						<!-- Form Messages -->
						<div class="form-message" style="display: none;"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	document.addEventListener( 'DOMContentLoaded', function() {
		const form = document.querySelector( '.consultation-form' );
		if ( !form ) return;

		form.addEventListener( 'submit', async function( e ) {
			e.preventDefault();

			const submitBtn = form.querySelector( '.consultation-submit-btn' );
			const btnText = submitBtn.querySelector( '.btn-text' );
			const btnLoader = submitBtn.querySelector( '.btn-loader' );
			const formMessage = form.querySelector( '.form-message' );

			// Get form data
			const formData = new FormData( form );

			// Show loading state
			submitBtn.disabled = true;
			btnText.style.display = 'none';
			btnLoader.style.display = 'flex';

			try {
				const response = await fetch( '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>', {
					method: 'POST',
					body: formData,
				} );

				const result = await response.json();

				if ( result.success ) {
					form.reset();

					if ( window.omniSolutions && typeof omniSolutions.showToast === 'function' ) {
						omniSolutions.showToast(
							<?php
								echo wp_json_encode(
									__( "Consultation requested! We'll be in touch within 24 hours.", 'omni-solutions' )
								);
							?>
						);
					}
				

					// Reset button state after 2 seconds
					setTimeout( function() {
						btnText.style.display = 'block';
						btnLoader.style.display = 'none';
						submitBtn.disabled = false;
					}, 2000 );
				} else {
					var errorMessage = 'Submission failed';
					if ( result && result.data && result.data.message ) {
						errorMessage = result.data.message;
					}
					throw new Error( errorMessage );
				}
			} catch ( error ) {
				formMessage.className = 'form-message error';
				var fallbackMessage = <?php echo wp_json_encode( __( 'Something went wrong. Please try again or email us directly.', 'omni-solutions' ) ); ?>;
				formMessage.textContent = fallbackMessage;
				console.error( 'Consultation form submission error:', error );
				formMessage.style.display = 'block';

				// Reset button state
				setTimeout( function() {
					btnText.style.display = 'block';
					btnLoader.style.display = 'none';
					submitBtn.disabled = false;
				}, 2000 );
			}
		} );
	} );
</script>


