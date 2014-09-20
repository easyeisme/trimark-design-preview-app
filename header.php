<?php
// Redirect users from the front page accordingly
if(is_front_page()) {
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
</head>
<body <?php body_class(); ?>>



	<header class="header-main">
		<div class="page-wrapper">


			<?php // TriMark Logo ?>
			<div class="header-logo">
				<div class="circle"></div>
				<div class="triangle triangle-top"></div>
				<div class="triangle triangle-right"></div>
				<div class="triangle triangle-bottom"></div>
			</div><!-- .header-logo -->


			<?php // Additions to Header for Design Attachments ?>
			<?php if(is_user_logged_in() && (get_post_type($post) == 'design-project') && is_single()) { ?>

				<?php // Controls ?>
				<a class="header-back-btn" href="../"><i></i> Back</a>

			<?php } ?>


			<?php // Additions to Header for Design Attachments ?>
			<?php if(is_attachment() && (get_post_type($post->post_parent) == 'design-project')) { ?>

				<?php // Controls ?>
				<a class="header-back-btn" href="../"><i></i> Back</a>
				<div class="header-comp-grid-btn"></div>

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
								'link' => get_attachment_link($c['dp_design_set_design_img_full']),
								'img' => $c['dp_design_set_design_img_thumb'],
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
	</header><!-- .header-main -->
