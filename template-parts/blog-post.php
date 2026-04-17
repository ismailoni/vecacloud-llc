<?php
/**
 * Single Blog Post Template
 *
 * @package Omni_Solutions
 */

/**
 * Get blog post icon SVG
 */
function omni_solutions_post_icon( $name ) {
	$icon_map = array(
		'calendar' => 'calendar.svg',
		'clock'    => 'clock.svg',
		'share2'   => 'share2.svg',
		'twitter'  => 'twitter.svg',
		'linkedin' => 'linkedin.svg',
		'facebook' => 'facebook.svg',
		'link2'    => 'link2.svg',
		'check'    => 'check.svg',
	);

	if ( ! isset( $icon_map[ $name ] ) ) {
		return '';
	}

	$icon_path = get_template_directory() . '/assets/icons/' . $icon_map[ $name ];
	if ( ! file_exists( $icon_path ) ) {
		return '';
	}

	$svg = file_get_contents( $icon_path );
	$svg = str_replace( '<svg', '<svg class="post-icon"', $svg );
	return $svg;
}

while ( have_posts() ) :
	the_post();
	$post_id = get_the_ID();
	$read_time = get_post_meta( $post_id, 'read_time', true );
	if ( empty( $read_time ) ) {
		$read_time = '5 min read';
	}
	$categories = get_the_category();
	$category_name = ! empty( $categories ) ? $categories[0]->name : '';
	?>

	<article class="post-single-container">
		<div class="post-header-section">
			<?php if ( $category_name ) : ?>
				<div class="post-category-badge"><?php echo esc_html( $category_name ); ?></div>
			<?php endif; ?>
			
			<h1 class="post-single-title"><?php the_title(); ?></h1>
			
			<div class="post-meta-row">
				<div class="post-meta-item">
					<?php echo omni_solutions_post_icon( 'calendar' ); ?>
					<time datetime="<?php the_time( 'c' ); ?>">
						<?php echo get_the_date( 'F j, Y' ); ?>
					</time>
				</div>
				<div class="post-meta-item">
					<?php echo omni_solutions_post_icon( 'clock' ); ?>
					<span><?php echo esc_html( $read_time ); ?></span>
				</div>
				<div class="post-share-dropdown">
					<button class="post-share-trigger" data-post-id="<?php echo esc_attr( $post_id ); ?>">
						<?php echo omni_solutions_post_icon( 'share2' ); ?>
						<span><?php esc_html_e( 'Share', 'omni-solutions' ); ?></span>
					</button>
					<div class="post-share-menu" style="display: none;">
						<a href="#" class="post-share-option" data-type="twitter">
							<?php echo omni_solutions_post_icon( 'twitter' ); ?>
							<span><?php esc_html_e( 'Twitter / X', 'omni-solutions' ); ?></span>
						</a>
						<a href="#" class="post-share-option" data-type="linkedin">
							<?php echo omni_solutions_post_icon( 'linkedin' ); ?>
							<span><?php esc_html_e( 'LinkedIn', 'omni-solutions' ); ?></span>
						</a>
						<a href="#" class="post-share-option" data-type="facebook">
							<?php echo omni_solutions_post_icon( 'facebook' ); ?>
							<span><?php esc_html_e( 'Facebook', 'omni-solutions' ); ?></span>
						</a>
						<button class="post-share-option" data-type="copy-link">
							<?php echo omni_solutions_post_icon( 'link2' ); ?>
							<span class="copy-text"><?php esc_html_e( 'Copy Link', 'omni-solutions' ); ?></span>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="post-content-section">
			<?php the_content(); ?>
		</div>

		<!-- CTA Card -->
		<div class="post-cta-card">
			<h3 class="post-cta-title"><?php esc_html_e( 'Want similar results for your company?', 'omni-solutions' ); ?></h3>
			<p class="post-cta-text"><?php esc_html_e( "In just a 30-minute call, we'll show you how to turn Salesforce into a growth engine for your business.", 'omni-solutions' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/consultation' ) ); ?>" class="post-cta-button">
				<?php esc_html_e( 'Book a 30 Min Call', 'omni-solutions' ); ?>
			</a>
		</div>
	</article>

	<script>
		document.addEventListener( 'DOMContentLoaded', function() {
			const shareDropdown = document.querySelector( '.post-share-dropdown' );
			const shareTrigger = document.querySelector( '.post-share-trigger' );
			const shareMenu = document.querySelector( '.post-share-menu' );
			const shareOptions = document.querySelectorAll( '.post-share-option' );
			const pageUrl = window.location.href;
			const pageTitle = document.querySelector( '.post-single-title' )?.textContent || '';

			// Toggle menu
			shareTrigger.addEventListener( 'click', function( e ) {
				e.preventDefault();
				shareMenu.style.display = shareMenu.style.display === 'none' ? 'block' : 'none';
			} );

			// Close menu when clicking outside
			document.addEventListener( 'click', function( e ) {
				if ( !shareDropdown.contains( e.target ) ) {
					shareMenu.style.display = 'none';
				}
			} );

			// Handle share options
			shareOptions.forEach( function( option ) {
				option.addEventListener( 'click', function( e ) {
					e.preventDefault();
					const type = this.getAttribute( 'data-type' );

					if ( type === 'twitter' ) {
						const url = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent( pageUrl ) + '&text=' + encodeURIComponent( pageTitle );
						window.open( url, '_blank', 'noopener,noreferrer' );
					} else if ( type === 'linkedin' ) {
						const url = 'https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent( pageUrl );
						window.open( url, '_blank', 'noopener,noreferrer' );
					} else if ( type === 'facebook' ) {
						const url = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent( pageUrl );
						window.open( url, '_blank', 'noopener,noreferrer' );
					} else if ( type === 'copy-link' ) {
						navigator.clipboard.writeText( pageUrl ).then( function() {
							const copyText = option.querySelector( '.copy-text' );
							const originalText = copyText.textContent;
							copyText.textContent = 'Copied!';
							option.innerHTML = '<?php echo omni_solutions_post_icon( 'check' ); ?>' + '<span class="copy-text">Copied!</span>';
							setTimeout( function() {
								copyText.textContent = originalText;
								option.innerHTML = '<?php echo omni_solutions_post_icon( 'link2' ); ?>' + '<span class="copy-text">' + originalText + '</span>';
							}, 2000 );
						} );
					}
					shareMenu.style.display = 'none';
				} );
			} );
		} );
	</script>

	<?php
endwhile;
?>

