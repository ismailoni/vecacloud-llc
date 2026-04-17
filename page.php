<?php
/**
 * Page Template
 *
 * @package Omni_Solutions
 */

get_header();

$page_id = get_queried_object_id();
$page_slug = $page_id ? get_post_field( 'post_name', $page_id ) : '';

$template_map = array(
	'about'          => 'about',
	'careers'        => 'careers',
	'consultation'   => 'consultation',
	'privacy'        => 'privacy',
	'privacy-policy' => 'privacy',
	'admin-panel'    => 'admin-panel',
	'blog'           => 'blog',
);

if ( $page_slug && isset( $template_map[ $page_slug ] ) ) {
	$template_part = 'template-parts/' . $template_map[ $page_slug ];
	$template_file = locate_template( $template_part . '.php' );
	if ( $template_file ) {
		get_template_part( $template_part );
		get_footer();
		return;
	}
}
?>

<div class="container">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'page-content' ); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<?php
			if ( has_post_thumbnail() ) :
				?>
				<div class="featured-image">
					<?php the_post_thumbnail( 'omni-featured' ); ?>
				</div>
				<?php
			endif;
			?>

			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages(
				array(
					'before'      => '<nav class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'omni-solutions' ) . '</span>',
					'after'       => '</nav>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				)
			);
			?>
		</article>

		<?php
		// Comments
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
		?>
		<?php
	endwhile;
	?>
</div>

<?php
get_footer();
