<?php get_header(); ?>


<div class="body-main pg-portfolio-archive">
	<div class="page-wrapper">

		<?php // Security Clearance Required ?>
		<?php if(is_valid_administrator()) { ?>

			<?php
			// Modify the query for posts so that projects are retrieved alphabetically
			query_posts($query_string.'&orderby=title&order=ASC');
			?>
			<?php if(have_posts()) { while(have_posts()) { the_post(); ?>

				<article class="portfolio" id="post-<?php the_ID(); ?>">
					<h1><?php the_title(); ?></h1>
					<div class="masonry-grid" data-columns>
						<?php $portfolio = get_field('portfolio'); ?>
						<?php foreach($portfolio as $p) { ?>

							<?php
							// Data Collection
							$data = array();
							$data['title'] = $p['portfolio_title'];
							$data['img'] = $p['portfolio_image']['url'];
							$data['thumb'] = !empty($p['portfolio_thumb']) ? $p['portfolio_thumb'] : $p['portfolio_image']['sizes']['portfolio-thumb'];
							$data['author'] = get_field('portfolio_designer');
							if(!empty($data['author'])) {
								$data['author'] = $data['author']->post_title;
							}
							// echo '<pre>'.print_r($data,true).'</pre>';
							?>
							<div class="grid-item">
								<a class="thumbnail" rel="gallery" href="<?=$data['img']?>"><img src="<?=$data['thumb']?>" /></a>
								<div class="meta">
									<div class="title"><?=$data['title']?></div>
									<div class="byline">By: <?=$data['author']?></div>
								</div>
							</div>

						<?php } ?>

					</div>
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
