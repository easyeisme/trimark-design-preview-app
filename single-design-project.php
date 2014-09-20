<?php get_header(); ?>


<div class="body-main pg-design-single">
	<div class="page-wrapper">

		<?php if(have_posts()) { while(have_posts()) { the_post(); ?>

			<?php
			// Collect project data
			$project_data = array(
				'color' => array(
					'heading' => get_field('dp_heading_font_color'),
					'body' => get_field('dp_body_font_color')
				),
				'team' => array(),
				'design' => get_field('dp_design_set'),
			);

			// Last Modified Date (most recent)
			foreach($project_data['design'] as $i => $project) {
				$project_data['design'][$i]['dp_design_set_updated'] = 0;
				foreach($project['dp_design_set_design'] as $comp) {
					$a = get_post($comp['dp_design_set_design_img_full']);
					if(strtotime($a->post_modified) > $project_data['design'][$i]['dp_design_set_updated']) {
						$project_data['design'][$i]['dp_design_set_updated'] = strtotime($a->post_modified);
					}
				}
			}

			// Project Team Members
			foreach(get_field('dp_project_team_members') as $m) {
				$project_data['team'][$m['dp_project_team_member']->ID] = array(
					'name' => $m['dp_project_team_member']->post_title,
					'role' => get_post_meta($m['dp_project_team_member']->ID, 'employee_role', true),
					'email' => get_post_meta($m['dp_project_team_member']->ID, 'employee_email', true),
					'phone' => get_post_meta($m['dp_project_team_member']->ID, 'employee_phone', true)
				);
				if(!empty($m['dp_project_team_member_role'])) {
					$project_data['team'][$m['dp_project_team_member']->ID]['role'] = $m['dp_project_team_member_role'];
				}
			}
			?>

			<article class="clearfix" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="col-body">

					<?php // General Information ?>
					<section class="section">
						<h1 class="project-title no-margin"><?php the_title(); ?></h1>
						<?php
						$content = get_the_content();
						if(!empty($content)) {
							echo '<div class="project-description">';
								the_content();
							echo '</div>';
						}
						?>
					</section><!-- .section -->

					<?php // Design Sets / Comps ?>
					<?php foreach($project_data['design'] as $d) { ?>
						<a name="<?=get_link_target($d['dp_design_set_title'])?>"></a>
						<section class="section">
							<div class="design-set-updated">Updated: <span class="date"><?=date('m/d/Y', $d['dp_design_set_updated'])?></span></div>
							<h2 class="design-set-title"><?=$d['dp_design_set_title']?></h2>
							<div class="design-set-description"><?=$d['dp_design_set_desc']?></div>
							<?php
							if(count($d['dp_design_set_design']) > 0) {
								echo '<ul class="design-set-comps clearfix">';
									foreach($d['dp_design_set_design'] as $comp) {
										echo '<li>';
											echo '<a class="design-set-comp-link" href="'.get_attachment_link($comp['dp_design_set_design_img_full']).'">';
												echo '<img src="'.$comp['dp_design_set_design_img_thumb'].'" />';
												echo '<div class="design-comp-title">'.$comp['dp_design_set_design_name'].'</div>';
											echo '</a>';
										echo '</li>';
									}
								echo '</ul>';
							}
							?>
						</section>
					<?php } ?>

				</div><!-- .col-body -->
				<div class="col-sidebar">

					<section class="section">

						<?php // Project Team Members ?>
						<?php if(count($project_data['team']) > 0) { ?>
							<div class="sidebar-block sidebar-block-team">
								<div class="sidebar-block-title">Project Team Members</div>
								<ul>
									<?php
									foreach($project_data['team'] as $m) {
										echo '<li>';
											echo '<div class="team-member-name">'.$m['name'].'</div>';
											echo '<div class="team-member-role">'.$m['role'].'</div>';
											// echo $m['email'].'<br/>';
											// echo $m['phone'].'<br/>';
										echo '</li>';
									}
									?>
								</ul>
							</div><!-- .sidebar-block-team -->
						<?php } ?>

						<?php // Quick Links ?>
						<?php if(count($project_data['design']) > 0) { ?>
							<div class="sidebar-block sidebar-block-links">
								<div class="sidebar-block-title">Quick Design Links</div>
								<ul>
									<?php
									foreach($project_data['design'] as $d) {
										echo '<li><a class="scrollto-link" data-target="'.get_link_target($d['dp_design_set_title']).'" href="#">'.$d['dp_design_set_title'].'</a></li>';
									}
									?>
								</ul>
							</div><!-- .sidebar-block-links -->
						<?php } ?>

					</section><!-- .section -->

				</div><!-- .col-sidebar -->
			</article>

		<?php } } ?>

	</div><!-- .page-wrapper -->
</div><!-- .body-main -->


<?php get_footer(); ?>
