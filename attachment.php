<?php get_header(); ?>


<div class="body-main pg-design-attachment">

	<?php if(have_posts()) { while(have_posts()) { the_post(); ?>

		<?php
		// Collect attachment data
		$project_data = array(
			'meta' => wp_get_attachment_metadata($post->ID),
			'updated' => $post->post_modified,
			'parent' => $post->post_parent
		);
		?>

		<div class="design-display" style="
			background-image:url('<?=WP_CONTENT_URL?>/uploads/<?=$project_data['meta']['file']?>');
			height:<?=$project_data['meta']['height']?>px;">
		</div>


	<?php } } ?>

</div><!-- .body-main -->


<?php get_footer(); ?>
