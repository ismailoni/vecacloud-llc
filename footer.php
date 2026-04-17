	</main>

	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="footer-grid">
				<div class="footer-brand cols-span-2">
					<a class="footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/logo.png" alt="<?php esc_attr_e( 'VescaCloud', 'omni-solutions' ); ?>">
						<span><?php esc_html_e( 'VescaCloud', 'omni-solutions' ); ?></span>
					</a>
					<p class="footer-description">
						<?php esc_html_e( 'Expert Salesforce and systems integration consulting for modern enterprises.', 'omni-solutions' ); ?>
					</p>
				</div>

				<div class="footer-column">
					<h4><?php esc_html_e( 'Menu', 'omni-solutions' ); ?></h4>
					<nav>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'omni-solutions' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/#services' ) ); ?>"><?php esc_html_e( 'Services', 'omni-solutions' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/#solutions' ) ); ?>"><?php esc_html_e( 'Solutions', 'omni-solutions' ); ?></a>
					</nav>
				</div>

				<div class="footer-column">
					<h4><?php esc_html_e( 'Resource', 'omni-solutions' ); ?></h4>
					<nav>
						<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>"><?php esc_html_e( 'Blog', 'omni-solutions' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/careers' ) ); ?>"><?php esc_html_e( 'Careers', 'omni-solutions' ); ?></a>
						<a href="<?php echo esc_url( home_url( '/consultation' ) ); ?>"><?php esc_html_e( 'Get Started', 'omni-solutions' ); ?></a>
					</nav>
				</div>

				<div class="footer-column">
					<h4><?php esc_html_e( 'About', 'omni-solutions' ); ?></h4>
					<nav>
						<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About us', 'omni-solutions' ); ?></a>
						<a href="https://www.linkedin.com/company/vescacloud-llc" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'LinkedIn', 'omni-solutions' ); ?></a>
					</nav>
				</div>
			</div>

			<div class="footer-bottom">
				<p><?php echo esc_html( sprintf( '© %s VescaCloud. All rights reserved.', date( 'Y' ) ) ); ?></p>
				<div class="footer-legal">
					<a href="<?php echo esc_url( home_url( '/privacy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'omni-solutions' ); ?></a>
				</div>
			</div>
		</div>
	</footer>

	<div id="omni-toast" class="omni-toast" role="status" aria-live="polite" aria-atomic="true"></div>

	<?php wp_footer(); ?>
</body>
</html>
