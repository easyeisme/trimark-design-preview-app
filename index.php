<?php get_header(); ?>


<div class="body-main">
	<div class="page-wrapper">

		<?php if(have_posts()) { while(have_posts()) { the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
				<sectino class="section">

					<h1 class="page-title no-margin" itemprop="headline"><?php the_title(); ?></h1>
					<?php the_content(); ?>

				</section><!-- .section -->
			</article>

		<?php } } else { ?>

			<article id="post-not-found">
				<section class="section">

					<h1 class="page-title no-margin" itemprop="headline">Post Not Found</h1>
					<p>Looks like this page no longer exists.  Sorry for the inconvenience.</p>

				</section><!-- .section -->
			</article>

		<?php } ?>

	</div><!-- .page-wrapper -->
</div><!-- .body-main -->


<?php get_footer(); ?>
