<?php
/**
 * Search Results Template
 *
 * @package Omni_Solutions
 */

get_header();
?>

<div class="container">
	<header class="search-header">
		<h1 class="search-title">
			<?php printf( esc_html__( 'Search Results for: %s', 'omni-solutions' ), '<span>' . get_search_query() . '</span>' ); ?>
		</h1>
	</header>

	<?php
	if ( have_posts() ) :
		?>
		<div class="search-results">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result card' ); ?>>
					<h2 class="entry-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="entry-meta">
						<?php printf( esc_html__( 'Posted on %s', 'omni-solutions' ), esc_html( get_the_date() ) ); ?>
					</div>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
				</article>
				<?php
			endwhile;

			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => esc_html__( '&larr; Previous', 'omni-solutions' ),
					'next_text' => esc_html__( 'Next &rarr;', 'omni-solutions' ),
				)
			);
			?>
		</div>
		<?php
	else :
		?>
		<div class="no-posts">
			<h2><?php esc_html_e( 'No results found', 'omni-solutions' ); ?></h2>
			<p><?php esc_html_e( 'Sorry, no posts matched your search. Please try again with different keywords.', 'omni-solutions' ); ?></p>
			<?php get_search_form(); ?>
		</div>
		<?php
	endif;
	?>
</div>

<?php
get_footer();
