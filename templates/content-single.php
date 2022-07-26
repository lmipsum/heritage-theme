<?php while (have_posts()) : the_post(); ?>
  <article id="newsId"<?php post_class(); ?>>
	<section id = "events">
		<div class = "container">	
			 <div style = "display: block;" class = "event-instance col-xs-12 col-md-8">
				<div class = "col-xs-12">
					<?= the_post_thumbnail( 'full' );  ?>
					<h2><?= the_title(); ?></h2>
					<div class = "event-content"><?= the_content(); ?> </div>
				</div>
			 </div>
		 </div>
	 </section>
	</article>
<?php endwhile; ?>