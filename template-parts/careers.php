<?php
/**
 * Careers Page Template
 *
 * @package Omni_Solutions
 */

// Get jobs from database, fallback to defaults if empty
$jobs = omni_solutions_get_jobs();
if ( empty( $jobs ) ) {
	$jobs = array(
		array(
			'id'          => 'salesforce-architect',
			'title'       => esc_html__( 'Senior Salesforce Architect', 'omni-solutions' ),
			'location'    => esc_html__( 'Remote / New York', 'omni-solutions' ),
			'type'        => esc_html__( 'Full-time', 'omni-solutions' ),
			'description' => esc_html__( 'Lead complex implementations and design scalable solutions for enterprise clients.', 'omni-solutions' ),
		),
		array(
			'id'          => 'integration-engineer',
			'title'       => esc_html__( 'Integration Engineer', 'omni-solutions' ),
			'location'    => esc_html__( 'Remote', 'omni-solutions' ),
			'type'        => esc_html__( 'Full-time', 'omni-solutions' ),
			'description' => esc_html__( 'Build robust data pipelines and custom API integrations using Zapier, Make, and custom code.', 'omni-solutions' ),
		),
		array(
			'id'          => 'crm-consultant',
			'title'       => esc_html__( 'CRM Consultant', 'omni-solutions' ),
			'location'    => esc_html__( 'Remote', 'omni-solutions' ),
			'type'        => esc_html__( 'Contract', 'omni-solutions' ),
			'description' => esc_html__( 'Work closely with clients to optimize their HubSpot and Salesforce workflows.', 'omni-solutions' ),
		),
	);
}

function omni_solutions_careers_icon( $name ) {
	$icon_map = array(
		'briefcase' => 'briefcase.svg',
		'map-pin'   => 'map-pin.svg',
		'clock'     => 'clock.svg',
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

	$svg = str_replace( '<svg', '<svg class="career-icon"', $svg );

	return $svg;
}
?>
<main class="careers-page">
	<div class="container careers-container">
		<section class="careers-header">
			<h1 class="careers-title"><?php esc_html_e( 'Join the VescaCloud Team', 'omni-solutions' ); ?></h1>
			<p class="careers-subtitle">
				<?php esc_html_e( "Help us build the next generation of integrated business systems. We're always looking for talented experts to join our remote-first team.", 'omni-solutions' ); ?>
			</p>
		</section>

		<div class="careers-jobs">
			<?php foreach ( $jobs as $job ) : ?>
				<article class="career-card card">
					<div class="career-card-header">
						<div class="career-card-title">
							<h2><?php echo esc_html( $job['title'] ); ?></h2>
							<div class="career-meta">
								<span class="career-meta-item">
									<?php echo omni_solutions_careers_icon( 'map-pin' ); ?>
									<?php echo esc_html( $job['location'] ); ?>
								</span>
								<span class="career-meta-item">
									<?php echo omni_solutions_careers_icon( 'clock' ); ?>
									<?php echo esc_html( $job['type'] ); ?>
								</span>
							</div>
						</div>
						<button class="btn btn-primary career-apply-btn" type="button"
							data-job-id="<?php echo esc_attr( $job['id'] ); ?>"
							data-job-title="<?php echo esc_attr( $job['title'] ); ?>"
							data-job-location="<?php echo esc_attr( $job['location'] ); ?>"
							data-job-type="<?php echo esc_attr( $job['type'] ); ?>">
							<?php esc_html_e( 'Apply Now', 'omni-solutions' ); ?>
						</button>
					</div>
					<div class="career-card-content">
						<p><?php echo esc_html( $job['description'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</main>

<div class="career-modal" id="career-modal" aria-hidden="true">
	<div class="career-modal-backdrop" data-modal-close></div>
	<div class="career-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="career-modal-title">
		<button class="career-modal-close" type="button" data-modal-close aria-label="Close">×</button>
		<div class="career-modal-header">
			<h3 id="career-modal-title">
				<?php esc_html_e( 'Apply for', 'omni-solutions' ); ?>
				<span data-job-title></span>
			</h3>
			<p class="career-modal-subtitle">
				<span data-job-location></span>
				<span class="career-dot">•</span>
				<span data-job-type></span>
			</p>
		</div>
		<form class="career-form" id="career-apply-form">
			<?php wp_nonce_field( 'job_apply', 'job_apply_nonce' ); ?>
			<input type="hidden" name="action" value="submit_job_application">
			<input type="hidden" name="job_id" id="career-job-id">
			<input type="hidden" name="job_title" id="career-job-title">
			<input type="hidden" name="job_location" id="career-job-location">
			<input type="hidden" name="job_type" id="career-job-type">
			<div class="career-form-grid">
				<div class="form-group">
					<label for="career-first-name"><?php esc_html_e( 'First Name', 'omni-solutions' ); ?></label>
					<input id="career-first-name" name="firstName" type="text" placeholder="John" required>
				</div>
				<div class="form-group">
					<label for="career-last-name"><?php esc_html_e( 'Last Name', 'omni-solutions' ); ?></label>
					<input id="career-last-name" name="lastName" type="text" placeholder="Doe" required>
				</div>
			</div>
			<div class="form-group">
				<label for="career-email"><?php esc_html_e( 'Email', 'omni-solutions' ); ?></label>
				<input id="career-email" name="email" type="email" placeholder="john@example.com" required>
			</div>
			<div class="form-group">
				<label for="career-phone"><?php esc_html_e( 'Phone Number', 'omni-solutions' ); ?></label>
				<input id="career-phone" name="phone" type="tel" placeholder="+1 (555) 000-0000">
			</div>
			<div class="form-group">
				<label for="career-linkedin"><?php esc_html_e( 'LinkedIn Profile', 'omni-solutions' ); ?></label>
				<input id="career-linkedin" name="linkedin" type="url" placeholder="https://linkedin.com/in/yourprofile">
			</div>
			<div class="form-group">
				<label for="career-cover-letter"><?php esc_html_e( 'Why do you want to join VescaCloud?', 'omni-solutions' ); ?></label>
				<textarea id="career-cover-letter" name="coverLetter" placeholder="Tell us about your experience and why you're interested in this role..." rows="4" required></textarea>
			</div>
			<button class="btn btn-primary btn-block career-submit-btn" type="submit">
				<span class="btn-text"><?php esc_html_e( 'Submit Application', 'omni-solutions' ); ?></span>
				<span class="btn-loader" style="display:none;"><?php esc_html_e( 'Submitting...', 'omni-solutions' ); ?></span>
			</button>
			<p class="career-form-message" hidden></p>
		</form>
	</div>
</div>

<script>
	(function () {
		const modal = document.getElementById('career-modal');
		if (!modal) {
			return;
		}

		const titleEl = modal.querySelector('[data-job-title]');
		const locationEl = modal.querySelector('[data-job-location]');
		const typeEl = modal.querySelector('[data-job-type]');
		const applyButtons = document.querySelectorAll('.career-apply-btn');
		const closeTriggers = modal.querySelectorAll('[data-modal-close]');
		const form = modal.querySelector('#career-apply-form');
		const messageEl = modal.querySelector('.career-form-message');
		const submitBtn = modal.querySelector('.career-submit-btn');
		const submitText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
		const submitLoader = submitBtn ? submitBtn.querySelector('.btn-loader') : null;
		const hiddenJobId = modal.querySelector('#career-job-id');
		const hiddenJobTitle = modal.querySelector('#career-job-title');
		const hiddenJobLocation = modal.querySelector('#career-job-location');
		const hiddenJobType = modal.querySelector('#career-job-type');

		function openModal(button) {
			if (!button || !titleEl || !locationEl || !typeEl) {
				return;
			}

			const jobId = button.dataset.jobId || '';
			const jobTitle = button.dataset.jobTitle || '';
			const jobLocation = button.dataset.jobLocation || '';
			const jobType = button.dataset.jobType || '';

			titleEl.textContent = ' ' + jobTitle;
			locationEl.textContent = jobLocation;
			typeEl.textContent = jobType;

			if (hiddenJobId) hiddenJobId.value = jobId;
			if (hiddenJobTitle) hiddenJobTitle.value = jobTitle;
			if (hiddenJobLocation) hiddenJobLocation.value = jobLocation;
			if (hiddenJobType) hiddenJobType.value = jobType;
			modal.classList.add('is-open');
			modal.setAttribute('aria-hidden', 'false');
		}

		function closeModal() {
			modal.classList.remove('is-open');
			modal.setAttribute('aria-hidden', 'true');
			if (form) {
				form.reset();
			}
			if (messageEl) {
				messageEl.hidden = true;
				messageEl.textContent = '';
				messageEl.classList.remove('is-error', 'is-success');
			}
			if (submitBtn && submitText && submitLoader) {
				submitBtn.disabled = false;
				submitText.style.display = '';
				submitLoader.style.display = 'none';
			}
		}

		applyButtons.forEach((button) => {
			button.addEventListener('click', function () {
				openModal(button);
			});
		});

		closeTriggers.forEach((trigger) => {
			trigger.addEventListener('click', closeModal);
		});

		if (form) {
			form.addEventListener('submit', async function (event) {
				event.preventDefault();

				if (!window.omniSolutions || !omniSolutions.ajaxUrl) {
					return;
				}

				if (submitBtn && submitText && submitLoader) {
					submitBtn.disabled = true;
					submitText.style.display = 'none';
					submitLoader.style.display = '';
				}

				if (messageEl) {
					messageEl.hidden = true;
					messageEl.textContent = '';
					messageEl.classList.remove('is-error', 'is-success');
				}

				const formData = new FormData(form);
				// Ensure action is set correctly for AJAX.
				formData.set('action', 'submit_job_application');

				try {
					const response = await fetch(omniSolutions.ajaxUrl, {
						method: 'POST',
						body: formData
					});

					const result = await response.json();

					if (messageEl) {
						if (result && result.success) {
							messageEl.classList.add('is-success');
							messageEl.textContent = (result.data && result.data.message) || "<?php echo esc_js( __( "Application submitted. We'll review it and get back to you soon.", 'omni-solutions' ) ); ?>";
							messageEl.hidden = false;
							form.reset();

							if (window.omniSolutions && typeof omniSolutions.showToast === 'function') {
								omniSolutions.showToast(messageEl.textContent);
							}
							setTimeout(closeModal, 1800);
						} else {
							messageEl.classList.add('is-error');
							messageEl.textContent = (result && result.data && result.data.message) || "<?php echo esc_js( __( 'Something went wrong. Please try again.', 'omni-solutions' ) ); ?>";
							messageEl.hidden = false;
						}
					}
				} catch (error) {
					if (messageEl) {
						messageEl.classList.add('is-error');
						messageEl.textContent = "<?php echo esc_js( __( 'Network error. Please check your connection and try again.', 'omni-solutions' ) ); ?>";
						messageEl.hidden = false;
					}
				} finally {
					if (submitBtn && submitText && submitLoader) {
						submitBtn.disabled = false;
						submitText.style.display = '';
						submitLoader.style.display = 'none';
					}
				}
			});
		}

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape' && modal.classList.contains('is-open')) {
				closeModal();
			}
		});
	})();
</script>

