<?php
// Determine what type of page is being displayed.
// The behavior of the header will change depending on the type of page being displayed.
$pg = '';
if(is_front_page()) {
	$pg = 'front page';
}
if((get_post_type($post) == 'design-project') && is_single()) {
	$pg = 'design project';
}
if(is_attachment() && (get_post_type($post->post_parent) == 'design-project')) {
	$pg = 'design comp';
}


// Redirect users from the front page accordingly
if($pg == 'front page') {
	header('Location: designs/');
	exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>TriMark Digital - Projects Preview App</title>
	<meta name="robots" content="noindex, nofollow" />

	<?php /*
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	*/ ?>

	<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/library/img/favicon.png">
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/library/img/favicon.ico">
	<![endif]-->

	<?php wp_head(); ?>

	<?php // Google Analytics - 09/22/2014 ?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		ga('create', 'UA-4076497-21', 'auto');
		ga('send', 'pageview');
	</script>

</head>
<body <?php body_class(); ?>>



	<header class="header-main">
		<div class="header-toolbar-prime">
			<div class="page-wrapper main clearfix">


				<?php // TriMark Logo ?>
				<div class="header-logo">
					<div class="circle"></div>
					<div class="triangle triangle-top"></div>
					<div class="triangle triangle-right"></div>
					<div class="triangle triangle-bottom"></div>
				</div><!-- .header-logo -->


				<?php // Additions to Header for Design Attachments ?>
				<?php if(($pg == 'design project') && is_user_logged_in()) { ?>

					<?php // Controls ?>
					<a class="header-btn header-back-btn" href="../"><i class="fa fa-chevron-left"></i> Back</a>

				<?php } ?>


				<?php // Additions to Header for Design Comp Attachments ?>
				<?php if($pg == 'design comp') { ?>

					<?php // Controls ?>
					<a class="header-btn header-back-btn header-back2project-btn" href="../"><i class="fa fa-chevron-left"></i> <span class="label">Return to<br/>Project</span></a>
					<div class="header-btn header-comp-grid-btn closed"><i class="i-trigger fa fa-th"></i></div>

					<?php
					// Collect the necessary information about the current comp.
					// Also, collect all other comps that are within the same project as this comp.
					$design_sets = get_field('dp_design_set', $post->post_parent);
					$comp_set_full = array();
					$comp_info = array(
						'client-name' => get_the_title($post->post_parent),
						'design-set-name' => '',
						'comp-name' => ''
					);
					foreach($design_sets as $d) {
						if(count($d['dp_design_set_design']) > 0) {
							foreach($d['dp_design_set_design'] as $c) {
								// Collect info on current comp
								if($c['dp_design_set_design_img_full'] == $post->ID) {
									$comp_info['design-set-name'] = $d['dp_design_set_title'];
									$comp_info['comp-name'] = $c['dp_design_set_design_name'];
								}
								// Collect info on all related comps
								$comp_set_full[] = array(
									'id' => $c['dp_design_set_design_img_full'],
									'link' => get_attachment_link($c['dp_design_set_design_img_full']),
									'img' => $c['dp_design_set_design_img_thumb'],
									'set' => $d['dp_design_set_title'],
									'name' => $c['dp_design_set_design_name']
								);
							}
						}
					}
					?>

					<?php // Comp Information ?>
					<div class="header-comp-info">
						<div class="client-design">
							<?=$comp_info['client-name']?> &nbsp;-&nbsp;
							<?=$comp_info['design-set-name']?>
						</div>
						<div class="comp"><?=$comp_info['comp-name']?></div>
					</div><!-- .header-comp-info -->

				<?php } ?>

			</div><!-- .page-wrapper -->
		</div><!-- .header-toolbar-prime -->

		<?php // Project Comp Sets ?>
		<?php if($pg == 'design comp') { ?>
			<div class="header-project-comp-grid">
				<div class="page-wrapper">
					<ul class="clearfix">
						<?php
						foreach($comp_set_full as $c) {
							echo '<li><a href="'.$c['link'].'"'.(($c['id']==$post->ID) ? ' class="active"' : '').'>';
								echo '<img src="'.$c['img'].'" />';
								echo '<div class="comp-meta">';
									echo '<div class="set">'.$c['set'].'</div>';
									echo '<div class="title">'.$c['name'].'</div>';
								echo '</div>';
							echo '</a></li>';
						}
						?>
					</ul>
					<div class="header-project-comp-grid-ctrl ctrl-prev"><i class="fa fa-arrow-circle-o-left"></i></div>
					<div class="header-project-comp-grid-ctrl ctrl-next"><i class="fa fa-arrow-circle-o-right"></i></div>
				</div><!-- .page-wrapper -->
			</div><!-- .header-project-comp-grid -->
		<?php } ?>
	</header><!-- .header-main -->
