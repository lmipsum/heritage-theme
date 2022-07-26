<?php
/**
 * Template Name: News Template
 */
?>
<?php
	$fields = get_fields();
?>

<?php while (have_posts()) : the_post(); ?>
	<div id="newsId">
		<?php $news = get_posts( array( 'offset'=> 0, 'category' => the_field( 'newsevents', $post->ID ) ) ); if ( !empty($news) ) : ?>
		<section id = "events">
			<div class = "container">	
				<div class = "news-container">
				<?php global $post; ?>
				<?php foreach( $news as $post ) : setup_postdata($post); ?>
				<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
					<div class = "event">
						<img src= "<?= $image[0]; ?>" />
						 <h2><?= the_title(); ?></h2>
						 <p><?= the_excerpt(); ?></h2>
						 <div class = "news-open"></div>
						 <div class = "event-instance col-xs-12">
							<div class = "col-xs-2 news-close"> </div>
							<div class = "col-xs-10 col-xs-offset-2">
								<img class="eventFullImage" src="<?= $image[0]; ?>" />
								<h2><?= the_title(); ?></h2>
								<div class = "event-content"><?= the_content(); ?> </div>
							</div>
						 </div>
					</div>
				<?php endforeach;?>
				</div>
			</div>
		</section>
		<?php /*$news = $fields["news"]; ?>
		<?php if( !empty( $news ) ) : ?>
			<section id = "events">
				<div class = "container">	
					<div class = "news-container">
						<?php foreach($news as $item) : ?>
							<div class = "event">
								<img src= "<?=$item["image"];?>" />
								 <h2><?=$item["title"];?></h2>
								 <p><?=$item["title"];?></h2>
								 <div class = "news-open"></div>
								 <div class = "event-instance col-xs-12">
									<div class = "col-xs-2 news-close"> </div>
									<div class = "col-xs-10 col-xs-offset-2">
										<img class="eventFullImage" src="<?=$item["image"];?>" />
										<h2><?=$item["title"];?></h2>
										<div class = "event-content"><?=$item["content"];?> </div>
									</div>
								 </div>
							</div>
						<?php endforeach;?>
					</div>
				</div>
				
			</section>
			<?php */ ?>
			<div class = "pager pager-left" id = "news-left"></div>
			<div class = "pager pager-right" id = "news-right"></div>
			<div class = "content-container">
				<div class = "container">
					<div class = "event-instance col-xs-12"></div>
				</div>
			</div>
		<?php endif; ?>
	</div>
<?php endwhile; ?>