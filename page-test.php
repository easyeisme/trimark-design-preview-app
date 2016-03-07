<?php get_header(); ?>


<div class="body-main">
	<div class="page-wrapper">

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
			<section class="section">

				<h1 class="page-title no-margin" itemprop="headline"><?php the_title(); ?></h1>
				<?php the_content(); ?>

			</section><!-- .section -->
		</article>

	</div><!-- .page-wrapper -->
</div><!-- .body-main -->


<?php get_footer(); ?>
