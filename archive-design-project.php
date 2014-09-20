<?php get_header(); ?>


<div class="body-main pg-design-archive">
	<div class="page-wrapper">

		<?php // Security Clearance Required ?>
		<?php if(is_user_logged_in()) { ?>

			<?php
			// Modify the query for posts so that projects are retrieved alphabetically
			query_posts($query_string.'&orderby=title&order=ASC');
			?>
			<?php if(have_posts()) { while(have_posts()) { the_post(); ?>

				<?php
				// Collect project data
				$project_data = array(
					'data' => get_field('dp_design_set'),
					'updated' => 0,
					'sets' => 0,
					'comps' => 0,
				);

				// Count Sets
				$project_data['sets'] = count($project_data['data']);

				// Count Comps
				foreach($project_data['data'] as $set) {
					$project_data['comps'] += count($set['dp_design_set_design']);
				}

				// Last Modified Date (most recent)
				foreach($project_data['data'] as $s) {
					foreach($s['dp_design_set_design'] as $c) {
						$a = get_post($c['dp_design_set_design_img_full']);
						if(strtotime($a->post_modified) > $project_data['updated']) {
							$project_data['updated'] = strtotime($a->post_modified);
						}
					}
				}
				if($project_data['updated'] <= 0) {
					$project_data['updated'] = strtotime(get_the_modified_date('Y-m-d h:i:s'));
				}
				?>

				<article id="post-<?php the_ID(); ?>">
					<a class="section project-link" href="<?php the_permalink() ?>">
						<h1 class="project-title h2 no-margin"><?php the_title(); ?></h1>
						<div class="project-meta">
							<div class="last-updated">
								Updated:&nbsp;
								<span class="date">
									<?=date('F j, Y, g:ia', $project_data['updated'])?>
									<span class="ago">(<?=floor((time()-$project_data['updated'])/(60*60*24))?> days)</span>
								</span>
							</div><!-- .last-updated -->
							<?=$project_data['sets']?> sets &nbsp;/&nbsp;
							<?=$project_data['comps']?> design comps
						</div><!-- .project-meta -->
					</a><!-- .project-link -->
				</article>

			<?php } } ?>

		<?php } else { ?>

			<article class="access-denied">
				<section class="section">
					<h1 class="no-margin">Access Denied</h1>
					<p>Administrators must be logged in to view the contents of this page.</p>
				</section><!-- .section -->
			</article>

		<?php } ?>

	</div><!-- .page-wrapper -->
</div><!-- .body-main -->


<?php get_footer(); ?>
