<?php get_header(); ?>


<div class="body-main pg-past-work-archive">
	<div class="page-wrapper">

		<?php // Security Clearance Required ?>
		<?php if(is_valid_administrator()) { ?>

			<div class="masonry-grid" data-columns>

				<?php
				// Modify the query for posts so that projects are retrieved alphabetically
				//query_posts($query_string.'&orderby=title&order=ASC');
				?>
				<?php if(have_posts()) { while(have_posts()) { the_post(); ?>

					<div class="grid-item">
						<a class="thumbnail" rel="gallery" href="<?=get_field('pdw_img_full')?>"><img src="<?=get_field('pdw_img_thumb')?>" /></a>
						<div class="meta">
							<div class="title"><?php the_title(); ?></div>
							<div class="byline">By: <?=get_field('pdw_designer')?></div>
						</div>
					</div>

				<?php } } ?>

			</div>

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
