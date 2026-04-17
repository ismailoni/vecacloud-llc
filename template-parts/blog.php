<?php
/**
 * Blog Page Template with Instant Client-Side Filtering
 *
 * @package Omni_Solutions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// 1. Get categories: use admin-chosen list if available.
$selected_filter_cats = get_option( 'omni_blog_filter_categories', array() );
if ( is_array( $selected_filter_cats ) && ! empty( $selected_filter_cats ) ) {
	$categories = array();
	foreach ( $selected_filter_cats as $cat_id ) {
		$term = get_category( (int) $cat_id );
		if ( $term && ! is_wp_error( $term ) ) {
			$categories[] = $term;
		}
	}
} else {
	$categories = get_categories(
		array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => true,
		)
	);
}

// Never show the default "Uncategorized" category in filters.
$default_cat_id = (int) get_option( 'default_category' );
if ( ! empty( $categories ) && $default_cat_id ) {
	$categories = array_values(
		array_filter(
			$categories,
			function ( $cat ) use ( $default_cat_id ) {
				if ( ! $cat || is_wp_error( $cat ) ) {
					return false;
				}
				if ( (int) $cat->term_id === $default_cat_id ) {
					return false;
				}
				return true;
			}
		)
	);
}

// 2. Get all posts once for client-side filtering.
$all_posts_query = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => -1,
		'post_status'         => 'publish',
		'ignore_sticky_posts' => true,
	)
);

$posts_data    = array();
$icon_calendar = omni_solutions_blog_icon( 'calendar' );
$icon_clock    = omni_solutions_blog_icon( 'clock' );

if ( $all_posts_query->have_posts() ) {
	while ( $all_posts_query->have_posts() ) {
		$all_posts_query->the_post();

		$cats     = get_the_category();
		$cat_name = ! empty( $cats ) ? $cats[0]->name : '';
		$cat_id   = ! empty( $cats ) ? $cats[0]->term_id : '';

		$read_time = get_post_meta( get_the_ID(), 'read_time', true );
		if ( empty( $read_time ) ) {
			$read_time = __( '5 min read', 'omni-solutions' );
		}

		$search_text = strtolower( get_the_title() . ' ' . wp_strip_all_tags( get_the_excerpt() ) );

		$posts_data[] = array(
			'id'          => get_the_ID(),
			'title'       => get_the_title(),
			'link'        => get_the_permalink(),
			'excerpt'     => wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 20 ),
			'date'        => get_the_date( 'M j, Y' ),
			'cat_name'    => $cat_name,
			'cat_id'      => $cat_id,
			'read_time'   => $read_time,
			'search_text' => $search_text,
		);
	}
	wp_reset_postdata();
}
?>

<div class="blog-container">
	<div class="blog-header-section">
		<h1 class="blog-title"><?php esc_html_e( 'Our Insights', 'omni-solutions' ); ?></h1>
		<p class="blog-subtitle"><?php esc_html_e( 'Expert perspectives on Salesforce, integrations, and business technology.', 'omni-solutions' ); ?></p>
	</div>

	<div class="blog-search-section">
		<div class="blog-search-wrapper">
			<input
			type="text"
			id="js-blog-search"
			class="blog-search-input"
			placeholder="<?php esc_attr_e( 'Search articles...', 'omni-solutions' ); ?>"
			/>
			<?php echo omni_solutions_blog_icon( 'search' ); ?>
		</div>

		<div class="blog-category-filters" id="js-category-filters">
			<button class="blog-category-tag active" data-cat="all">
				<?php esc_html_e( 'All', 'omni-solutions' ); ?>
			</button>
			<?php foreach ( $categories as $category ) : ?>
				<button class="blog-category-tag" data-cat="<?php echo esc_attr( $category->term_id ); ?>">
					<?php echo esc_html( $category->name ); ?>
				</button>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="blog-posts-grid" id="js-blog-grid"></div>

	<div id="js-no-results" class="blog-no-posts" style="display: none;">
		<p class="blog-no-posts-title"><?php esc_html_e( 'No articles found', 'omni-solutions' ); ?></p>
		<p class="blog-no-posts-text"><?php esc_html_e( 'Try adjusting your search terms.', 'omni-solutions' ); ?></p>
		<button id="js-clear-search" class="blog-clear-filters-btn">
			<?php esc_html_e( 'Clear Filters', 'omni-solutions' ); ?>
		</button>
	</div>

	<div class="blog-cta-card">
		<h3 class="blog-cta-title"><?php esc_html_e( 'Want similar results for your company?', 'omni-solutions' ); ?></h3>
		<p class="blog-cta-text"><?php esc_html_e( "In just a 30-minute call, we'll show you how to turn Salesforce into a growth engine for your business.", 'omni-solutions' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/consultation' ) ); ?>" class="blog-cta-button">
			<?php esc_html_e( 'Book a 30 Min Call', 'omni-solutions' ); ?>
		</a>
	</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// 1. Data Source
	const allPosts = <?php echo wp_json_encode( $posts_data ); ?>;
	const icons = {
		calendar: `<?php echo $icon_calendar; ?>`,
		clock: `<?php echo $icon_clock; ?>`
	};

	// 2. DOM Elements
	const grid = document.getElementById('js-blog-grid');
	const searchInput = document.getElementById('js-blog-search');
	const filters = document.getElementById('js-category-filters');
	const noResults = document.getElementById('js-no-results');
	const clearBtn = document.getElementById('js-clear-search');

	let activeCategory = 'all';
	let searchTerm = '';

	// 3. Render function
	function renderPosts(posts) {
		grid.innerHTML = '';

		if (!posts.length) {
			noResults.style.display = 'block';
			return;
		}

		noResults.style.display = 'none';

		posts.forEach(function(post) {
			const cardHTML = `
				<a href="${post.link}" class="blog-post-card-link fade-in">
					<article class="blog-post-card">
						<div class="blog-card-header">
							${post.cat_name ? `<div class="blog-post-category">${post.cat_name}</div>` : ''}
							<h2 class="blog-post-title-text">${post.title}</h2>
						</div>
						<div class="blog-card-content">
							<p class="blog-post-excerpt-text">${post.excerpt}</p>
							<div class="blog-post-meta-row">
								<div class="blog-meta-item">
									${icons.calendar}
									<time>${post.date}</time>
								</div>
								<div class="blog-meta-item">
									${icons.clock}
									<span>${post.read_time}</span>
								</div>
							</div>
						</div>
					</article>
				</a>
			`;
			grid.insertAdjacentHTML('beforeend', cardHTML);
		});
	}

	// 4. Filter logic
	function filterPosts() {
		const term = searchTerm;
		const cat = activeCategory;

		const filtered = allPosts.filter(function(post) {
			const matchesCategory = (cat === 'all') || (String(post.cat_id) === String(cat));
			const matchesSearch = !term || post.search_text.indexOf(term) !== -1;
			return matchesCategory && matchesSearch;
		});

		renderPosts(filtered);
	}

	// 5. Event listeners
	searchInput.addEventListener('input', function(e) {
		searchTerm = (e.target.value || '').toLowerCase().trim();
		filterPosts();
	});

	filters.addEventListener('click', function(e) {
		const btn = e.target.closest('.blog-category-tag');
		if (!btn) return;

		filters.querySelectorAll('.blog-category-tag').forEach(function(b) {
			b.classList.remove('active');
		});
		btn.classList.add('active');

		activeCategory = btn.getAttribute('data-cat') || 'all';
		filterPosts();
	});

	if (clearBtn) {
		clearBtn.addEventListener('click', function() {
			searchInput.value = '';
			searchTerm = '';
			activeCategory = 'all';

			filters.querySelectorAll('.blog-category-tag').forEach(function(b) {
				b.classList.remove('active');
			});
			const allBtn = filters.querySelector('[data-cat="all"]');
			if (allBtn) {
				allBtn.classList.add('active');
			}

			filterPosts();
		});
	}

	// Initial render
	renderPosts(allPosts);
});
</script>

<style>
@keyframes fadeIn {
	from { opacity: 0; transform: translateY(10px); }
	to { opacity: 1; transform: translateY(0); }
}

.fade-in {
	animation: fadeIn 0.3s ease-out forwards;
}
</style>