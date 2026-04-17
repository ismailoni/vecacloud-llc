<?php
/**
 * Admin Dashboard Page Template
 *
 * @package Omni_Solutions
 */

// Handle consultation request deletion before any output.
if ( is_user_logged_in() && isset( $_POST['delete_request'], $_POST['delete_nonce'], $_POST['request_id'] ) ) {
	$request_id = intval( $_POST['request_id'] );
	$nonce      = sanitize_text_field( wp_unslash( $_POST['delete_nonce'] ) );

	if ( $request_id && wp_verify_nonce( $nonce, 'delete_request_' . $request_id ) ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'consultation_requests';
		$wpdb->delete( $table_name, array( 'id' => $request_id ), array( '%d' ) );

		// Redirect back to the requests tab to avoid resubmission.
		wp_safe_redirect(
			add_query_arg(
				array(
					'tab'     => 'requests',
					'deleted' => 1,
				),
				home_url( '/admin-panel' )
			)
		);
		exit;
	}
}
?>

<div class="admin-page">
	<?php
	if ( is_user_logged_in() ) :
		$current_user = wp_get_current_user();
		$active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'dashboard';
		?>
		<!-- Admin Header -->
		<header class="admin-header">
			<div class="admin-header-content">
				<div class="admin-header-left">
					<h1 class="admin-site-title"><?php esc_html_e( 'VescaCloud Admin', 'omni-solutions' ); ?></h1>
				</div>
				<div class="admin-header-right">
					<span class="admin-welcome-text">
						<?php printf( esc_html__( 'Welcome, %s', 'omni-solutions' ), esc_html( $current_user->display_name ) ); ?>
					</span>
					<a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" class="admin-logout-btn">
						<?php esc_html_e( 'Sign Out', 'omni-solutions' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url() ); ?>" class="admin-back-btn">
						<?php esc_html_e( 'Back to Home', 'omni-solutions' ); ?>
					</a>
				</div>
			</div>
		</header>

		<!-- Admin Tabs Navigation -->
		<nav class="admin-tabs-nav">
			<a href="?tab=dashboard" class="admin-tab-link<?php echo ( $active_tab === 'dashboard' ) ? ' active' : ''; ?>">
				<?php esc_html_e( 'Dashboard', 'omni-solutions' ); ?>
			</a>
			<a href="?tab=blog" class="admin-tab-link<?php echo ( $active_tab === 'blog' ) ? ' active' : ''; ?>">
				<?php esc_html_e( 'Blog Posts', 'omni-solutions' ); ?>
			</a>
			<a href="?tab=jobs" class="admin-tab-link<?php echo ( $active_tab === 'jobs' ) ? ' active' : ''; ?>">
				<?php esc_html_e( 'Job Listings', 'omni-solutions' ); ?>
			</a>
			<a href="?tab=certifications" class="admin-tab-link<?php echo ( $active_tab === 'certifications' ) ? ' active' : ''; ?>">
				<?php esc_html_e( 'Certifications', 'omni-solutions' ); ?>
			</a>
			<a href="?tab=requests" class="admin-tab-link<?php echo ( $active_tab === 'requests' ) ? ' active' : ''; ?>">
				<?php esc_html_e( 'Consultation Requests', 'omni-solutions' ); ?>
			</a>
			<a href="?tab=settings" class="admin-tab-link<?php echo ( $active_tab === 'settings' ) ? ' active' : ''; ?>">
				<?php esc_html_e( 'Settings', 'omni-solutions' ); ?>
			</a>
		</nav>

		<!-- Admin Content -->
		<main class="admin-main">
			<?php if ( $active_tab === 'dashboard' ) : ?>
				<!-- Dashboard Section -->
				<div class="admin-dashboard">
					<div class="admin-dashboard-header">
						<h2 class="admin-dashboard-title"><?php esc_html_e( 'Dashboard', 'omni-solutions' ); ?></h2>
						<p class="admin-dashboard-subtitle"><?php esc_html_e( 'Manage your website content', 'omni-solutions' ); ?></p>
					</div>

					<?php
					// High-level stats for a more modern dashboard overview.
					$post_counts   = wp_count_posts( 'post' );
					$page_counts   = wp_count_posts( 'page' );
					$total_posts   = isset( $post_counts->publish ) ? (int) $post_counts->publish : 0;
					$total_pages   = isset( $page_counts->publish ) ? (int) $page_counts->publish : 0;
					$jobs          = omni_solutions_get_jobs();
					$total_jobs    = is_array( $jobs ) ? count( $jobs ) : 0;
					$total_requests = 0;

					global $wpdb;
					$table_name = $wpdb->prefix . 'consultation_requests';
					if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table_name ) ) === $table_name ) {
						$total_requests = (int) $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
					}
					?>

					<div class="admin-stats-grid">
						<div class="admin-stat-card">
							<div class="admin-stat-label"><?php esc_html_e( 'Published Posts', 'omni-solutions' ); ?></div>
							<div class="admin-stat-value"><?php echo esc_html( number_format_i18n( $total_posts ) ); ?></div>
						</div>
						<div class="admin-stat-card">
							<div class="admin-stat-label"><?php esc_html_e( 'Published Pages', 'omni-solutions' ); ?></div>
							<div class="admin-stat-value"><?php echo esc_html( number_format_i18n( $total_pages ) ); ?></div>
						</div>
						<div class="admin-stat-card">
							<div class="admin-stat-label"><?php esc_html_e( 'Job Listings', 'omni-solutions' ); ?></div>
							<div class="admin-stat-value"><?php echo esc_html( number_format_i18n( $total_jobs ) ); ?></div>
						</div>
						<div class="admin-stat-card">
							<div class="admin-stat-label"><?php esc_html_e( 'Consultation Requests', 'omni-solutions' ); ?></div>
							<div class="admin-stat-value"><?php echo esc_html( number_format_i18n( $total_requests ) ); ?></div>
						</div>
					</div>

					<!-- Dashboard Grid -->
					<div class="admin-dashboard-grid">
						<!-- Posts Widget -->
						<div class="admin-widget">
							<div class="admin-widget-header">
								<h3><?php esc_html_e( 'Recent Blog Posts', 'omni-solutions' ); ?></h3>
							</div>
							<div class="admin-widget-body">
								<?php
								$recent_posts = new WP_Query(
									array(
										'posts_per_page' => 5,
										'post_type'      => 'post',
									)
								);

								if ( $recent_posts->have_posts() ) :
									?>
									<ul class="admin-posts-list">
										<?php
										while ( $recent_posts->have_posts() ) :
											$recent_posts->the_post();
											?>
											<li class="admin-posts-item">
												<div class="admin-posts-item-title">
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												</div>
												<span class="admin-posts-item-date"><?php the_time( get_option( 'date_format' ) ); ?></span>
											</li>
											<?php
										endwhile;
										?>
									</ul>
									<?php
								else :
									?>
									<p class="admin-widget-empty"><?php esc_html_e( 'No posts yet.', 'omni-solutions' ); ?></p>
									<?php
								endif;
								wp_reset_postdata();
								?>
						</div>
						<div class="admin-widget-footer">
							<button class="admin-widget-link admin-modal-trigger" data-modal="newPostModal">
								<svg class="admin-widget-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
								<?php esc_html_e( 'Add New Post', 'omni-solutions' ); ?>
							</button>
						</div>
					</div>

					<!-- Pages Widget -->
					<div class="admin-widget">
						<div class="admin-widget-header">
							<h3><?php esc_html_e( 'Pages', 'omni-solutions' ); ?></h3>
						</div>
							<div class="admin-widget-body">
								<?php
								$pages = get_pages(
									array(
										'number' => 5,
									)
								);

								if ( ! empty( $pages ) ) :
									?>
									<ul class="admin-posts-list">
										<?php
										foreach ( $pages as $page ) :
											?>
											<li class="admin-posts-item">
												<div class="admin-posts-item-title">
													<a href="<?php echo esc_url( get_page_link( $page->ID ) ); ?>"><?php echo esc_html( $page->post_title ); ?></a>
												</div>
												<span class="admin-posts-item-date"><?php echo esc_html( get_the_date( get_option( 'date_format' ), $page->ID ) ); ?></span>
											</li>
											<?php
										endforeach;
										?>
									</ul>
									<?php
								else :
									?>
									<p class="admin-widget-empty"><?php esc_html_e( 'No pages yet.', 'omni-solutions' ); ?></p>
									<?php
								endif;
								?>
							</div>
							<div class="admin-widget-footer">
								<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page' ) ); ?>" class="admin-widget-link admin-page-link">
									<svg class="admin-widget-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
									<?php esc_html_e( 'New Page', 'omni-solutions' ); ?>
								</a>
							</div>
						</div>

						<!-- Quick Links Widget -->
						<div class="admin-widget">
							<div class="admin-widget-header">
								<h3><?php esc_html_e( 'Quick Links', 'omni-solutions' ); ?></h3>
							</div>
							<div class="admin-widget-body">
								<ul class="admin-links-list">
									<li><a href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'WordPress Admin', 'omni-solutions' ); ?></a></li>
									<li><a href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>"><?php esc_html_e( 'All Posts', 'omni-solutions' ); ?></a></li>
									<li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>"><?php esc_html_e( 'All Pages', 'omni-solutions' ); ?></a></li>
									<li><a href="<?php echo esc_url( admin_url( 'users.php' ) ); ?>"><?php esc_html_e( 'Users', 'omni-solutions' ); ?></a></li>
									<li><a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>"><?php esc_html_e( 'Customize Theme', 'omni-solutions' ); ?></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

			<?php elseif ( $active_tab === 'blog' ) : ?>
				<!-- Blog Management Section -->
				<div class="admin-blog-section">
					<div class="admin-section-header">
						<div>
							<h2 class="admin-section-title"><?php esc_html_e( 'Blog Posts', 'omni-solutions' ); ?></h2>
							<p class="admin-section-subtitle"><?php esc_html_e( 'Create and manage your blog posts', 'omni-solutions' ); ?></p>
						</div>
						<button class="admin-btn admin-btn-primary" id="openNewPostModal">
							<?php esc_html_e( '+ New Post', 'omni-solutions' ); ?>
						</button>
					</div>

					<!-- Posts Table -->
					<div class="admin-table-wrapper">
						<?php
						$all_posts = new WP_Query(
							array(
								'posts_per_page' => 20,
								'post_type'      => 'post',
								'orderby'        => 'date',
								'order'          => 'DESC',
							)
						);

						if ( $all_posts->have_posts() ) :
							?>
							<table class="admin-table">
								<thead class="admin-table-head">
									<tr>
										<th><?php esc_html_e( 'Title', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Category', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Date', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Status', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Actions', 'omni-solutions' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php
									while ( $all_posts->have_posts() ) :
										$all_posts->the_post();
										$category = get_the_category();
										$category_name = ! empty( $category ) ? $category[0]->name : 'Uncategorized';
										?>
										<tr class="admin-table-row">
											<td class="admin-table-title">
												<a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a>
											</td>
											<td><?php echo esc_html( $category_name ); ?></td>
											<td><?php echo esc_html( get_the_date( 'M j, Y' ) ); ?></td>
											<td>
												<span class="admin-status-badge<?php echo ( 'publish' === get_post_status() ) ? ' published' : ' draft'; ?>">
													<?php echo ( 'publish' === get_post_status() ) ? esc_html_e( 'Published', 'omni-solutions' ) : esc_html_e( 'Draft', 'omni-solutions' ); ?>
												</span>
											</td>
											<td class="admin-table-actions">
												<a href="<?php echo esc_url( get_edit_post_link() ); ?>" class="admin-action-link admin-edit">
													<?php esc_html_e( 'Edit', 'omni-solutions' ); ?>
												</a>
												<a href="<?php the_permalink(); ?>" class="admin-action-link admin-view" target="_blank">
													<?php esc_html_e( 'View', 'omni-solutions' ); ?>
												</a>
											</td>
										</tr>
										<?php
									endwhile;
									?>
								</tbody>
							</table>
							<?php
						else :
							?>
							<div class="admin-empty-state">
								<div class="admin-empty-icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="11" x2="12" y2="17"></line><line x1="9" y1="14" x2="15" y2="14"></line></svg>
								</div>
								<p><?php esc_html_e( 'No blog posts yet.', 'omni-solutions' ); ?></p>
								<p class="admin-empty-subtext"><?php esc_html_e( 'Create your first post to get started', 'omni-solutions' ); ?></p>
								<button class="admin-btn admin-btn-primary admin-modal-trigger" data-modal="newPostModal">
									<svg class="admin-btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
									<?php esc_html_e( 'Create Your First Post', 'omni-solutions' ); ?>
								</button>
							</div>
							<?php
						endif;
						wp_reset_postdata();
						?>
					</div>
				</div>

			<?php elseif ( $active_tab === 'certifications' ) : ?>
				<!-- Certifications Management Section -->
				<div class="admin-certifications-section">
					<div class="admin-section-header">
						<div>
							<h2 class="admin-section-title"><?php esc_html_e( 'Certification Badges', 'omni-solutions' ); ?></h2>
							<p class="admin-section-subtitle"><?php esc_html_e( 'Upload and manage certification images displayed on the About page', 'omni-solutions' ); ?></p>
						</div>
					</div>

					<!-- Upload Form -->
					<div class="admin-cert-upload-card">
						<form id="certUploadForm" class="admin-cert-upload-form" enctype="multipart/form-data">
							<?php wp_nonce_field( 'upload_cert_nonce', 'cert_nonce' ); ?>
							<div class="admin-cert-upload-area">
								<input type="file" id="certImageInput" name="cert_image" accept="image/*" required>
								<label for="certImageInput" class="admin-cert-upload-label">
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
									<span class="admin-cert-upload-text"><?php esc_html_e( 'Click to upload or drag and drop', 'omni-solutions' ); ?></span>
									<span class="admin-cert-upload-hint"><?php esc_html_e( 'PNG, JPG, GIF up to 10MB', 'omni-solutions' ); ?></span>
								</label>
							</div>
							<button type="submit" class="admin-btn admin-btn-primary" id="uploadCertBtn">
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
								<?php esc_html_e( 'Upload Certification', 'omni-solutions' ); ?>
							</button>
							<div id="certUploadMessage" class="admin-form-message"></div>
						</form>
					</div>

					<!-- Certifications Grid -->
					<div class="admin-cert-grid" id="certificationsGrid">
						<?php
						$certifications = get_option( 'omni_certifications', array() );
						if ( ! empty( $certifications ) ) :
							foreach ( $certifications as $cert ) :
								?>
								<div class="admin-cert-item" data-id="<?php echo esc_attr( $cert['id'] ); ?>">
									<div class="admin-cert-image-wrapper">
										<img src="<?php echo esc_url( $cert['url'] ); ?>" alt="<?php echo esc_attr( $cert['title'] ); ?>" loading="lazy" decoding="async">
									</div>
									<div class="admin-cert-actions">
										<span class="admin-cert-title"><?php echo esc_html( $cert['title'] ); ?></span>
										<button class="admin-btn admin-btn-danger admin-btn-sm delete-cert" data-id="<?php echo esc_attr( $cert['id'] ); ?>">
											<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
											<?php esc_html_e( 'Delete', 'omni-solutions' ); ?>
										</button>
									</div>
								</div>
								<?php
							endforeach;
						else :
							?>
							<div class="admin-empty-state" id="certsEmptyState">
								<div class="admin-empty-icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
								</div>
								<p><?php esc_html_e( 'No certifications uploaded yet.', 'omni-solutions' ); ?></p>
								<p class="admin-empty-subtext"><?php esc_html_e( 'Upload your first certification badge to get started', 'omni-solutions' ); ?></p>
							</div>
							<?php
						endif;
						?>
					</div>
				</div>

			<?php elseif ( $active_tab === 'jobs' ) : ?>
				<!-- Job Listings Section -->
				<div class="admin-jobs-section">
					<div class="admin-section-header">
						<div>
							<h2 class="admin-section-title"><?php esc_html_e( 'Job Listings', 'omni-solutions' ); ?></h2>
							<p class="admin-section-subtitle"><?php esc_html_e( 'Manage open positions on your careers page', 'omni-solutions' ); ?></p>
						</div>
						<button class="admin-btn admin-btn-primary admin-btn-add-job" id="openNewJobModal" type="button">
							<svg class="admin-btn-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
							<?php esc_html_e( 'Add New Job', 'omni-solutions' ); ?>
						</button>
					</div>

					<!-- Jobs Table -->
					<div class="admin-table-wrapper admin-jobs-table">
						<?php
						$jobs = omni_solutions_get_jobs();

						if ( ! empty( $jobs ) ) :
							?>
							<table class="admin-table">
								<thead class="admin-table-head">
									<tr>
										<th><?php esc_html_e( 'Job Title', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Location', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Type', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Description', 'omni-solutions' ); ?></th>
										<th><?php esc_html_e( 'Actions', 'omni-solutions' ); ?></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ( $jobs as $job ) : ?>
										<tr class="admin-table-row">
											<td class="admin-table-title"><?php echo esc_html( $job['title'] ); ?></td>
											<td><?php echo esc_html( $job['location'] ); ?></td>
											<td><?php echo esc_html( $job['type'] ); ?></td>
											<td><?php echo esc_html( wp_trim_words( $job['description'], 10 ) ); ?></td>
											<td>
												<button class="admin-btn admin-btn-danger delete-job" data-job-id="<?php echo esc_attr( $job['id'] ); ?>" type="button">
													<?php esc_html_e( 'Delete', 'omni-solutions' ); ?>
												</button>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<?php
						else :
							?>
							<div class="admin-empty-state">
								<p><?php esc_html_e( 'No job listings yet. Add your first job posting!', 'omni-solutions' ); ?></p>
							</div>
							<?php
						endif;
						?>
					</div>

					<div id="jobFormMessage" class="admin-form-message"></div>
				</div>

			<?php elseif ( $active_tab === 'requests' ) : ?>
				<!-- Consultation Requests Section -->
				<div class="admin-requests-section">
					<div class="admin-section-header">
						<div>
							<h2 class="admin-section-title"><?php esc_html_e( 'Consultation Requests', 'omni-solutions' ); ?></h2>
							<p class="admin-section-subtitle"><?php esc_html_e( 'View and manage incoming consultation requests', 'omni-solutions' ); ?></p>
						</div>
					</div>

					<?php if ( isset( $_GET['deleted'] ) ) : ?>
						<div class="admin-message admin-message-success">
							<?php esc_html_e( 'Consultation request deleted.', 'omni-solutions' ); ?>
						</div>
					<?php endif; ?>

					<!-- Requests List -->
					<div class="admin-requests-list">
						<?php
						global $wpdb;
						$table_name = $wpdb->prefix . 'consultation_requests';

						// Check if table exists
						if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) === $table_name ) {
							$requests = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY created_at DESC LIMIT 50" );

							if ( ! empty( $requests ) ) :
								foreach ( $requests as $request ) :
									?>
									<div class="admin-request-card">
										<div class="admin-request-header">
											<div>
												<h3 class="admin-request-name"><?php echo esc_html( $request->first_name . ' ' . $request->last_name ); ?></h3>
												<p class="admin-request-email">
													<a href="mailto:<?php echo esc_attr( $request->email ); ?>"><?php echo esc_html( $request->email ); ?></a>
												</p>
											</div>
											<span class="admin-request-date"><?php echo esc_html( wp_date( 'M j, Y g:i A', strtotime( $request->created_at ) ) ); ?></span>
										</div>

										<div class="admin-request-body">
											<div class="admin-request-meta">
												<span class="admin-request-meta-item">
													<strong><?php esc_html_e( 'Company:', 'omni-solutions' ); ?></strong>
													<a href="<?php echo esc_attr( $request->company_website ); ?>" target="_blank"><?php echo esc_html( $request->company_website ); ?></a>
												</span>
											</div>
											<p class="admin-request-message"><?php echo esc_html( $request->message ); ?></p>
										</div>

										<div class="admin-request-footer">
											<form method="POST" class="admin-request-delete-form" style="display: inline;">
												<?php wp_nonce_field( 'delete_request_' . $request->id, 'delete_nonce' ); ?>
												<input type="hidden" name="request_id" value="<?php echo esc_attr( $request->id ); ?>">
												<button type="submit" name="delete_request" class="admin-btn admin-btn-danger" onclick="return confirm('<?php esc_attr_e( 'Are you sure?', 'omni-solutions' ); ?>')">
													<?php esc_html_e( 'Delete', 'omni-solutions' ); ?>
												</button>
											</form>
										</div>
									</div>
									<?php
								endforeach;
							else :
								?>
								<div class="admin-empty-state">
									<p><?php esc_html_e( 'No consultation requests yet.', 'omni-solutions' ); ?></p>
								</div>
								<?php
							endif;
						} else {
							?>
							<div class="admin-empty-state">
								<p><?php esc_html_e( 'Consultation requests table not found. Please ensure the consultation form is properly configured.', 'omni-solutions' ); ?></p>
							</div>
							<?php
						}
						?>
					</div>
				</div>

			<?php elseif ( $active_tab === 'settings' ) : ?>
				<!-- Settings Section -->
				<div class="admin-settings-section">
					<div class="admin-section-header">
						<div>
							<h2 class="admin-section-title"><?php esc_html_e( 'Settings', 'omni-solutions' ); ?></h2>
							<p class="admin-section-subtitle"><?php esc_html_e( 'Configure admin notification email', 'omni-solutions' ); ?></p>
						</div>
					</div>

					<?php
					$default_admin_email      = get_option( 'omni_solutions_admin_email', get_option( 'admin_email' ) );
					$current_consult_email    = get_option( 'omni_solutions_consultation_email', $default_admin_email );
					$current_jobs_email       = get_option( 'omni_solutions_jobs_email', $default_admin_email );
					$current_contact_email    = get_option( 'omni_solutions_contact_email', $default_admin_email );
					$settings_message          = '';
					if ( isset( $_POST['omni_settings_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['omni_settings_nonce'] ) ), 'omni_save_settings' ) && current_user_can( 'manage_options' ) ) {
						$new_consult_email = isset( $_POST['omni_consultation_email'] ) ? sanitize_email( wp_unslash( $_POST['omni_consultation_email'] ) ) : '';
						$new_jobs_email    = isset( $_POST['omni_jobs_email'] ) ? sanitize_email( wp_unslash( $_POST['omni_jobs_email'] ) ) : '';
						$new_contact_email = isset( $_POST['omni_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['omni_contact_email'] ) ) : '';

						if ( empty( $new_consult_email ) || empty( $new_jobs_email ) || empty( $new_contact_email ) || ! is_email( $new_consult_email ) || ! is_email( $new_jobs_email ) || ! is_email( $new_contact_email ) ) {
							$settings_message = '<div class="admin-message admin-message-error">' . esc_html__( 'Please enter valid email addresses for all fields.', 'omni-solutions' ) . '</div>';
						} else {
							update_option( 'omni_solutions_consultation_email', $new_consult_email );
							update_option( 'omni_solutions_jobs_email', $new_jobs_email );
							update_option( 'omni_solutions_contact_email', $new_contact_email );

							$current_consult_email = $new_consult_email;
							$current_jobs_email    = $new_jobs_email;
							$current_contact_email = $new_contact_email;
							$settings_message       = '<div class="admin-message admin-message-success">' . esc_html__( 'Settings saved successfully.', 'omni-solutions' ) . '</div>';
						}
					}
					?>

					<?php if ( ! empty( $settings_message ) ) : ?>
						<div class="admin-form-message"><?php echo wp_kses_post( $settings_message ); ?></div>
					<?php endif; ?>

					<form method="post" class="admin-settings-form">
						<?php wp_nonce_field( 'omni_save_settings', 'omni_settings_nonce' ); ?>
						<div class="admin-form-group admin-form-email">
							<label for="omni_consultation_email"><?php esc_html_e( 'Consultation notification email', 'omni-solutions' ); ?> <span class="required">*</span></label>
							<input type="email" id="omni_consultation_email" name="omni_consultation_email" required value="<?php echo esc_attr( $current_consult_email ); ?>" placeholder="<?php echo esc_attr( $default_admin_email ); ?>">
							<p class="admin-field-help"><?php esc_html_e( 'Consultation form submissions will be sent to this address.', 'omni-solutions' ); ?></p>
						</div>
						<div class="admin-form-group admin-form-email">
							<label for="omni_jobs_email"><?php esc_html_e( 'Job application notification email', 'omni-solutions' ); ?> <span class="required">*</span></label>
							<input type="email" id="omni_jobs_email" name="omni_jobs_email" required value="<?php echo esc_attr( $current_jobs_email ); ?>" placeholder="<?php echo esc_attr( $default_admin_email ); ?>">
							<p class="admin-field-help"><?php esc_html_e( 'Job applications from the Careers page will be sent here.', 'omni-solutions' ); ?></p>
						</div>
						<div class="admin-form-group admin-form-email">
							<label for="omni_contact_email"><?php esc_html_e( 'Contact form notification email', 'omni-solutions' ); ?> <span class="required">*</span></label>
							<input type="email" id="omni_contact_email" name="omni_contact_email" required value="<?php echo esc_attr( $current_contact_email ); ?>" placeholder="<?php echo esc_attr( $default_admin_email ); ?>">
							<p class="admin-field-help"><?php esc_html_e( 'About Page Contact form submissions will be sent here.', 'omni-solutions' ); ?></p>
						</div>
						<div class="admin-form-actions">
							<button type="submit" class="admin-btn admin-btn-primary"><?php esc_html_e( 'Save Settings', 'omni-solutions' ); ?></button>
						</div>
					</form>
				</div>

			<?php endif; ?>
		</main>
	<?php
	else :
		?>
		<!-- Login Page -->
		<div class="admin-login-page">
			<div class="admin-login-card">
				<div class="admin-login-header">
					<h1><?php esc_html_e( 'Admin Login', 'omni-solutions' ); ?></h1>
					<p><?php esc_html_e( 'Enter your credentials to access the admin panel', 'omni-solutions' ); ?></p>
				</div>
				<div class="admin-login-body">
					<?php
					wp_login_form(
						array(
							'redirect' => home_url( '/admin-panel' ),
							'label_username' => esc_html__( 'Username or Email', 'omni-solutions' ),
							'label_password' => esc_html__( 'Password', 'omni-solutions' ),
							'label_remember' => esc_html__( 'Remember Me', 'omni-solutions' ),
							'label_log_in' => esc_html__( 'Sign In', 'omni-solutions' ),
						)
					);
					?>
				</div>
				<div class="admin-login-footer">
					<a href="<?php echo esc_url( home_url() ); ?>" class="admin-login-home-link">
						<?php esc_html_e( '← Back to Home', 'omni-solutions' ); ?>
					</a>
				</div>
			</div>
		</div>
	<?php
	endif;
	?>
</div>

<!-- New Post Modal -->
<div id="newPostModal" class="admin-modal">
	<div class="admin-modal-content">
		<div class="admin-modal-header">
			<h2><?php esc_html_e( 'Create New Blog Post', 'omni-solutions' ); ?></h2>
			<button class="admin-modal-close" id="closeNewPostModal">&times;</button>
		</div>
		<form id="newPostForm" class="admin-post-form">
			<?php wp_nonce_field( 'create_post_nonce', 'post_nonce' ); ?>
			
			<div class="admin-form-group">
				<label for="postTitle"><?php esc_html_e( 'Post Title', 'omni-solutions' ); ?> <span class="required">*</span></label>
				<input type="text" id="postTitle" name="post_title" required placeholder="<?php esc_attr_e( 'Enter post title', 'omni-solutions' ); ?>">
			</div>

			<div class="admin-form-group">
				<label for="postCategory"><?php esc_html_e( 'Category', 'omni-solutions' ); ?></label>
				<select id="postCategory" name="post_category">
					<option value="">-- <?php esc_html_e( 'Select Category', 'omni-solutions' ); ?> --</option>
					<?php
					$categories = get_categories( array( 'hide_empty' => false ) );
					foreach ( $categories as $cat ) :
						?>
						<option value="<?php echo esc_attr( $cat->term_id ); ?>"><?php echo esc_html( $cat->name ); ?></option>
						<?php
					endforeach;
					?>
				</select>
			</div>

			<div class="admin-form-group">
				<label for="postContent"><?php esc_html_e( 'Content', 'omni-solutions' ); ?> <span class="required">*</span></label>
				<textarea id="postContent" name="post_content" required placeholder="<?php esc_attr_e( 'Write your post content here...', 'omni-solutions' ); ?>" rows="8"></textarea>
			</div>

			<div class="admin-form-actions">
				<button type="submit" class="admin-btn admin-btn-primary" id="submitPostBtn">
					<?php esc_html_e( 'Create Post', 'omni-solutions' ); ?>
				</button>
				<button type="button" class="admin-btn admin-btn-secondary" id="cancelPostBtn">
					<?php esc_html_e( 'Cancel', 'omni-solutions' ); ?>
				</button>
			</div>

			<div id="postFormMessage" class="admin-form-message"></div>
		</form>
	</div>
</div>

<div id="newJobModal" class="admin-modal">
	<div class="admin-modal-content admin-modal-content--wide">
		<div class="admin-modal-header">
			<h2><?php esc_html_e( 'Create New Job Listing', 'omni-solutions' ); ?></h2>
			<button class="admin-modal-close" id="closeNewJobModal">&times;</button>
		</div>
		<form id="newJobForm" class="admin-job-form">
			<?php wp_nonce_field( 'job_nonce', 'nonce' ); ?>
			
			<div class="admin-form-group">
				<label for="jobTitle"><?php esc_html_e( 'Job Title', 'omni-solutions' ); ?> <span class="required">*</span></label>
				<input type="text" id="jobTitle" name="title" required placeholder="<?php esc_attr_e( 'e.g., Senior Salesforce Architect', 'omni-solutions' ); ?>">
			</div>

			<div class="admin-form-group">
				<label for="jobLocation"><?php esc_html_e( 'Location', 'omni-solutions' ); ?> <span class="required">*</span></label>
				<input type="text" id="jobLocation" name="location" required placeholder="<?php esc_attr_e( 'e.g., Remote / New York', 'omni-solutions' ); ?>">
			</div>

			<div class="admin-form-group">
				<label for="jobType"><?php esc_html_e( 'Employment Type', 'omni-solutions' ); ?> <span class="required">*</span></label>
				<select id="jobType" name="type" required>
					<option value="">-- <?php esc_html_e( 'Select Type', 'omni-solutions' ); ?> --</option>
					<option value="Full-time"><?php esc_html_e( 'Full-time', 'omni-solutions' ); ?></option>
					<option value="Part-time"><?php esc_html_e( 'Part-time', 'omni-solutions' ); ?></option>
					<option value="Contract"><?php esc_html_e( 'Contract', 'omni-solutions' ); ?></option>
					<option value="Freelance"><?php esc_html_e( 'Freelance', 'omni-solutions' ); ?></option>
				</select>
			</div>

			<div class="admin-form-group">
				<label for="jobDescription"><?php esc_html_e( 'Job Description', 'omni-solutions' ); ?> <span class="required">*</span></label>
				<textarea id="jobDescription" name="description" required placeholder="<?php esc_attr_e( 'Describe the job responsibilities and requirements...', 'omni-solutions' ); ?>" rows="6"></textarea>
			</div>

			<div class="admin-form-actions">
				<button type="submit" class="admin-btn admin-btn-primary" id="submitJobBtn">
					<?php esc_html_e( 'Create Job Listing', 'omni-solutions' ); ?>
				</button>
				<button type="button" class="admin-btn admin-btn-secondary" id="cancelJobBtn">
					<?php esc_html_e( 'Cancel', 'omni-solutions' ); ?>
				</button>
			</div>

			<div id="jobFormMessage" class="admin-form-message"></div>
		</form>
	</div>
</div>

<script>
document.addEventListener( 'DOMContentLoaded', function() {
	// Central AJAX URL for all admin-panel requests
	const ajaxUrl = '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>';
	
	const modal = document.getElementById( 'newPostModal' );
	const openBtn = document.getElementById( 'openNewPostModal' );
	const closeBtn = document.getElementById( 'closeNewPostModal' );
	const cancelBtn = document.getElementById( 'cancelPostBtn' );
	const form = document.getElementById( 'newPostForm' );
	const messageDiv = document.getElementById( 'postFormMessage' );
	const modalTriggers = document.querySelectorAll( '.admin-modal-trigger[data-modal="newPostModal"]' );

	// Open modal from any trigger button
	function openModal() {
		modal.classList.add( 'open' );
		document.body.style.overflow = 'hidden';
	}

	openBtn?.addEventListener( 'click', openModal );
	modalTriggers.forEach( trigger => {
		trigger.addEventListener( 'click', openModal );
	});

	// Close modal
	function closeModal() {
		modal.classList.remove( 'open' );
		document.body.style.overflow = 'auto';
		form.reset();
		messageDiv.innerHTML = '';
	}

	closeBtn.addEventListener( 'click', closeModal );
	cancelBtn.addEventListener( 'click', closeModal );

	// Close on outside click
	modal.addEventListener( 'click', function( e ) {
		if ( e.target === modal ) {
			closeModal();
		}
	});

	// Handle form submission
	form.addEventListener( 'submit', function( e ) {
		e.preventDefault();

		const submitBtn = document.getElementById( 'submitPostBtn' );
		const originalText = submitBtn.textContent;
		submitBtn.disabled = true;
		submitBtn.textContent = '<?php esc_html_e( 'Creating...', 'omni-solutions' ); ?>';

		const formData = new FormData( form );
		formData.append( 'action', 'create_post' );

		fetch( ajaxUrl, {
			method: 'POST',
			body: formData,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then( response => response.json() )
		.then( data => {
			if ( data.success ) {
				messageDiv.innerHTML = '<div class="admin-message admin-message-success"><?php esc_html_e( 'Post created successfully! Reloading...', 'omni-solutions' ); ?></div>';
				if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
					window.omniSolutions.showToast('<?php echo esc_js( __( 'Post created successfully!', 'omni-solutions' ) ); ?>', 'success');
				}
				setTimeout( function() {
					location.reload();
				}, 1500 );
			} else {
				messageDiv.innerHTML = '<div class="admin-message admin-message-error">' + ( data.data.message || '<?php esc_html_e( 'Error creating post', 'omni-solutions' ); ?>' ) + '</div>';
				submitBtn.disabled = false;
				submitBtn.textContent = originalText;
			}
		})
		.catch( error => {
			messageDiv.innerHTML = '<div class="admin-message admin-message-error"><?php esc_html_e( 'Error: Could not create post', 'omni-solutions' ); ?></div>';
			submitBtn.disabled = false;
			submitBtn.textContent = originalText;
		});
	});

	// Certification upload handling
	const certForm = document.getElementById( 'certUploadForm' );
	const certInput = document.getElementById( 'certImageInput' );
	const certMessage = document.getElementById( 'certUploadMessage' );
	const certGrid = document.getElementById( 'certificationsGrid' );

	if ( certForm && certInput && certMessage ) {
		// File input preview
		certInput.addEventListener( 'change', function() {
			const fileName = this.files[0]?.name || '';
			if ( fileName ) {
				const label = document.querySelector( '.admin-cert-upload-text' );
				if ( label ) {
					label.textContent = fileName;
				}
			}
		});

		// Upload form submission
		certForm.addEventListener( 'submit', function( e ) {
			e.preventDefault();

			const uploadBtn = document.getElementById( 'uploadCertBtn' );
			if ( ! uploadBtn ) return;

			const originalText = uploadBtn.textContent;
			uploadBtn.disabled = true;
			uploadBtn.textContent = '<?php esc_html_e( 'Uploading...', 'omni-solutions' ); ?>';

			const formData = new FormData( certForm );
			formData.append( 'action', 'upload_certification' );

			fetch( ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then( response => response.json() )
			.then( data => {
				if ( data.success ) {
					certMessage.innerHTML = '<div class="admin-message admin-message-success"><?php esc_html_e( 'Certification uploaded successfully! Reloading...', 'omni-solutions' ); ?></div>';
					if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
						window.omniSolutions.showToast('<?php echo esc_js( __( 'Certification uploaded successfully!', 'omni-solutions' ) ); ?>', 'success');
					}
					setTimeout( function() {
						location.reload();
					}, 1500 );
				} else {
					certMessage.innerHTML = '<div class="admin-message admin-message-error">' + ( data.data?.message || '<?php esc_html_e( 'Upload failed', 'omni-solutions' ); ?>' ) + '</div>';
					uploadBtn.disabled = false;
					uploadBtn.textContent = originalText;
				}
			})
			.catch( error => {
				certMessage.innerHTML = '<div class="admin-message admin-message-error"><?php esc_html_e( 'Error uploading certification', 'omni-solutions' ); ?></div>';
				uploadBtn.disabled = false;
				uploadBtn.textContent = originalText;
			});
		});
	}

	// Certification deletion
	document.addEventListener( 'click', function( e ) {
		if ( e.target.closest( '.delete-cert' ) ) {
			if ( ! confirm( '<?php esc_html_e( 'Are you sure you want to delete this certification?', 'omni-solutions' ); ?>' ) ) {
				return;
			}

			const btn = e.target.closest( '.delete-cert' );
			const certId = btn.dataset.id;
			const certItem = btn.closest( '.admin-cert-item' );
			const grid = document.getElementById( 'certificationsGrid' );

			btn.disabled = true;
			btn.textContent = '<?php esc_html_e( 'Deleting...', 'omni-solutions' ); ?>';

			const formData = new FormData();
			formData.append( 'action', 'delete_certification' );
			formData.append( 'attachment_id', certId );
			formData.append( 'cert_nonce', '<?php echo esc_js( wp_create_nonce( 'delete_cert_nonce' ) ); ?>' );

			fetch( ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then( response => response.json() )
			.then( data => {
				if ( data.success ) {
					certItem.style.opacity = '0';
					setTimeout( function() {
						certItem.remove();
						// Check if grid is empty
						if ( grid && grid.children.length === 0 ) {
							location.reload();
						}
					}, 300 );
					if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
						window.omniSolutions.showToast('<?php echo esc_js( __( 'Certification deleted.', 'omni-solutions' ) ); ?>', 'success');
					}
				} else {
					const errorMessage = data.data?.message || '<?php echo esc_js( __( 'Delete failed', 'omni-solutions' ) ); ?>';
					if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
						window.omniSolutions.showToast( errorMessage, 'error' );
					} else {
						alert( errorMessage );
					}
					btn.disabled = false;
				}
			})
			.catch( error => {
				const errorMessage = '<?php echo esc_js( __( 'Error deleting certification', 'omni-solutions' ) ); ?>';
				if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
					window.omniSolutions.showToast( errorMessage, 'error' );
				} else {
					alert( errorMessage );
				}
				btn.disabled = false;
			});
		}
	});

	// Job modal handling
	const jobModal = document.getElementById( 'newJobModal' );
	if ( jobModal ) {
		const openJobBtn = document.getElementById( 'openNewJobModal' );
		const closeJobBtn = document.getElementById( 'closeNewJobModal' );
		const cancelJobBtn = document.getElementById( 'cancelJobBtn' );
		const jobForm = document.getElementById( 'newJobForm' );
		const jobMessage = document.getElementById( 'jobFormMessage' );

		function openJobModal() {
			jobModal.classList.add( 'open' );
			document.body.style.overflow = 'hidden';
		}

		function closeJobModal() {
			jobModal.classList.remove( 'open' );
			document.body.style.overflow = 'auto';
			jobForm.reset();
			jobMessage.innerHTML = '';
		}

		openJobBtn?.addEventListener( 'click', openJobModal );
		closeJobBtn?.addEventListener( 'click', closeJobModal );
		cancelJobBtn?.addEventListener( 'click', closeJobModal );

		jobModal.addEventListener( 'click', function( e ) {
			if ( e.target === jobModal ) {
				closeJobModal();
			}
		});

		jobForm?.addEventListener( 'submit', function( e ) {
			e.preventDefault();

			const submitBtn = document.getElementById( 'submitJobBtn' );
			const originalText = submitBtn.textContent;
			submitBtn.disabled = true;
			submitBtn.textContent = '<?php esc_html_e( 'Creating...', 'omni-solutions' ); ?>';

			const formData = new FormData( jobForm );
			formData.append( 'action', 'create_job' );

			fetch( ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then( response => response.json() )
			.then( data => {
				if ( data.success ) {
					jobMessage.innerHTML = '<div class="admin-message admin-message-success"><?php esc_html_e( 'Job created successfully! Reloading...', 'omni-solutions' ); ?></div>';
					if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
						window.omniSolutions.showToast('<?php echo esc_js( __( 'Job created successfully!', 'omni-solutions' ) ); ?>', 'success');
					}
					setTimeout( function() {
						location.reload();
					}, 1500 );
				} else {
					jobMessage.innerHTML = '<div class="admin-message admin-message-error">' + ( data.data?.message || '<?php esc_html_e( 'Error creating job', 'omni-solutions' ); ?>' ) + '</div>';
					submitBtn.disabled = false;
					submitBtn.textContent = originalText;
				}
			})
			.catch( error => {
				jobMessage.innerHTML = '<div class="admin-message admin-message-error"><?php esc_html_e( 'Error creating job', 'omni-solutions' ); ?></div>';
				submitBtn.disabled = false;
				submitBtn.textContent = originalText;
			});
		});
	}

	// Job deletion
	document.addEventListener( 'click', function( e ) {
		if ( e.target.closest( '.delete-job' ) ) {
			if ( ! confirm( '<?php esc_html_e( 'Are you sure you want to delete this job listing?', 'omni-solutions' ); ?>' ) ) {
				return;
			}

			const btn = e.target.closest( '.delete-job' );
			const jobId = btn.dataset.jobId;
			const jobRow = btn.closest( 'tr' );

			btn.disabled = true;
			btn.textContent = '<?php esc_html_e( 'Deleting...', 'omni-solutions' ); ?>';

			const formData = new FormData();
			formData.append( 'action', 'delete_job' );
			formData.append( 'job_id', jobId );
			formData.append( 'nonce', '<?php echo esc_js( wp_create_nonce( 'job_nonce' ) ); ?>' );

			fetch( ajaxUrl, {
				method: 'POST',
				body: formData
			})
			.then( response => response.json() )
			.then( data => {
				if ( data.success ) {
					jobRow.style.opacity = '0';
					setTimeout( function() {
						location.reload();
					}, 300 );
					if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
						window.omniSolutions.showToast('<?php echo esc_js( __( 'Job deleted.', 'omni-solutions' ) ); ?>', 'success');
					}
				} else {
					const errorMessage = data.data?.message || '<?php echo esc_js( __( 'Delete failed', 'omni-solutions' ) ); ?>';
					if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
						window.omniSolutions.showToast( errorMessage, 'error' );
					} else {
						alert( errorMessage );
					}
					btn.disabled = false;
					btn.textContent = '<?php esc_html_e( 'Delete', 'omni-solutions' ); ?>';
				}
			})
			.catch( error => {
				const errorMessage = '<?php echo esc_js( __( 'Error deleting job', 'omni-solutions' ) ); ?>';
				if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
					window.omniSolutions.showToast( errorMessage, 'error' );
				} else {
					alert( errorMessage );
				}
				btn.disabled = false;
				btn.textContent = '<?php esc_html_e( 'Delete', 'omni-solutions' ); ?>';
			});
		}
	});

	// Show toast for any server-rendered admin messages (e.g., settings saved, consultation deleted)
	if ( window.omniSolutions && typeof window.omniSolutions.showToast === 'function' ) {
		const serverMessages = document.querySelectorAll( '.admin-message' );
		serverMessages.forEach( function( msg ) {
			const text = ( msg.textContent || '' ).trim();
			if ( ! text ) return;

			if ( msg.classList.contains( 'admin-message-success' ) ) {
				window.omniSolutions.showToast( text, 'success' );
			} else if ( msg.classList.contains( 'admin-message-error' ) ) {
				window.omniSolutions.showToast( text, 'error' );
			}
		});
	}
});
</script>

