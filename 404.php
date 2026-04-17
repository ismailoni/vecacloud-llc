<?php
/**
 * 404 Template
 *
 * @package Omni_Solutions
 */

get_header();
?>

<section class="not-found-page">
	<div class="not-found-inner card">
		<div class="not-found-badge">404</div>
		<h1 class="not-found-title"><?php esc_html_e( 'Page not found', 'omni-solutions' ); ?></h1>
		<p class="not-found-lead"><?php esc_html_e( "The page you're looking for may have been moved, deleted, or never existed.", 'omni-solutions' ); ?></p>

		<div class="not-found-actions">
			<a href="<?php echo esc_url( home_url() ); ?>" class="btn btn-primary">
				<?php esc_html_e( 'Back to Home', 'omni-solutions' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/consultation' ) ); ?>" class="btn btn-outline">
				<?php esc_html_e( 'Book a Consultation', 'omni-solutions' ); ?>
			</a>
		</div>

	</div>
</section>

<?php
get_footer();
