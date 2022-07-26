<?php
/**
 * Template Name: Kulinarik Template
 */
?>
<?php
	$fields = get_fields();
?>

<?php while (have_posts()) : the_post(); ?>
	<div id="kulinarikId">
		<?php
			/* Slider Content */
			$cyclon_slider_kulinarik_1 = $fields["cyclon_slider_kulinarik_1_shortcode"];
			$cyclon_slider_kulinarik_2 = $fields["cyclon_slider_kulinarik_2_shortcode"];
			$cyclon_slider_kulinarik_3 = $fields["cyclon_slider_kulinarik_3_shortcode"];
			$cyclon_slider_kulinarik_4 = $fields["cyclon_slider_kulinarik_4_shortcode"];
			$winzer = $fields["winzer"];
		?>
		<?php if( !empty($cyclon_slider_kulinarik_1) ) : ?>
		  <section id="kulinarik-slider-1" class="active">
				<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_kulinarik_1.'"]'); ?>
		  </section>
		<?php endif; ?>
		<?php if( !empty($cyclon_slider_kulinarik_2) ) : ?>
		  <section id="kulinarik-slider-2">
				<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_kulinarik_2.'"]'); ?>
		  </section>
		<?php endif; ?>
		<?php if( !empty($cyclon_slider_kulinarik_3) ) : ?>
		  <section id="kulinarik-slider-3">
				<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_kulinarik_3.'"]'); ?>
		  </section>
		<?php endif; ?>
		<?php if( !empty($cyclon_slider_kulinarik_4) ) : ?>
		  <section id="kulinarik-slider-4">
				<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_kulinarik_4.'"]'); ?>
		  </section>
		<?php endif; ?>
		<?php if(!empty($winzer)):?>
			<div id = "winzer">
				<div class = "container winzerlist">
					<div class = "col-xs-2 winzer-close">
					
					</div>
					<?php foreach($winzer as $item) : ?>
					<div class = "winzer-item col-xs-8 col-xs-offset-2">
						<div class = "col-xs-4 winzer-image-container">
							<img src="<?=$item["image"];?>" class = "winzer-image" />
						</div>
						<div class = "col-xs-8">
							<h2> <?=$item["title"];?></h2>
							<div class = "col-xs-10 winzer-description"><?=$item["description"];?> </div>
						</div>
						<div class = "col-xs-2 winzer-open"></div>
					</div>
					<div class = "winzer-instance col-xs-5 col-xs-offset-1">
						<div class = "col-xs-12">
							<img class="winzerFullImage" src="<?=$item["image"];?>" />
						</div>
						<div class = "col-xs-12">
							<h2><?=$item["title"];?></h2>
							<div class = "winzer-content"><?=$item["content"];?> </div>
						</div>
					</div>
					<?php endforeach;?>
					
					
					
				</div>
			</div>
		<?php endif; ?>
		<div class = "sub-navigation">
			<div class = "kulinarik-nav-1 active" data-anchor = "#kulinarik-slider-1"></div>
			<div class = "kulinarik-nav-2" data-anchor = "#kulinarik-slider-2"></div>
			<div class = "kulinarik-nav-3" data-anchor = "#kulinarik-slider-3"></div>
			<div class = "kulinarik-nav-4" data-anchor = "#kulinarik-slider-4"></div>
		</div>
	</div>
<?php endwhile; ?>