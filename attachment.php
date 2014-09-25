<?php get_header(); ?>


<div class="body-main pg-design-attachment">

	<?php if(have_posts()) { while(have_posts()) { the_post(); ?>

		<?php
		// Collect attachment data
		$project_data = array(
			'meta' => wp_get_attachment_metadata($post->ID),
			'updated' => $post->post_modified,
			'parent' => $post->post_parent,
			'bg' => '',
			'bg-class' => ''
		);

		// Determine the comp background
		$design_sets = get_field('dp_design_set', $post->post_parent);
		foreach($design_sets as $d) {
			foreach($d['dp_design_set_design'] as $c) {
				if($c['dp_design_set_design_img_full'] == $post->ID) {
					$project_data['bg'] = $c['dp_design_set_design_bg'];
					break;
				}
			}
		}

		// Generate a class that will be used to control the comp background
		if(!empty($project_data['bg'])) {
			$project_data['bg-class'] = 'bg-setting-'.$project_data['bg'];
		}
		?>

		<div class="page-background <?=$project_data['bg-class']?>">
			<div class="design-display" style="
				background-image:url('<?=WP_CONTENT_URL?>/uploads/<?=$project_data['meta']['file']?>');
				height:<?=$project_data['meta']['height']?>px;">
			</div>
		</div>


	<?php } } ?>

</div><!-- .body-main -->


<?php get_footer(); ?>
