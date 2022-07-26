<?php
/**
 * Template Name: Restaurant Template
 */
?>
<?php
	$fields = get_fields();
?>

<?php while (have_posts()) : the_post(); ?>
	<div id="restaurantId">
		 <?php
			/* Slider Content */
			$cyclon_slider_restaurant_2 = $fields["cyclon_slider_restaurant_2_shortcode"];
			$cyclon_slider_restaurant_3 = $fields["cyclon_slider_restaurant_3_shortcode"];
		?>
		<?php if( !empty($cyclon_slider_restaurant_1) ) : ?>
		  <section id="restaurant-slider-1">
				<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_restaurant_1.'"]'); ?>
		  </section>
		<?php endif; ?>
		<?php if( !empty($cyclon_slider_restaurant_2) ) : ?>
		  <section id="restaurant-slider-2"  class="active">
				<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_restaurant_2.'"]'); ?>
		  </section>
		<?php endif; ?>
		<?php if( !empty($cyclon_slider_restaurant_3) ) : ?>
		  <section id="restaurant-slider-3">
				<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_restaurant_3.'"]'); ?>
		  </section>
		<?php endif; ?>
		<div class = "sub-navigation">
			<div class = "restaurant-nav-2 active" data-anchor = "#restaurant-slider-2"></div>
			<div class = "restaurant-nav-3" data-anchor = "#restaurant-slider-3"></div>
		</div>
	</div>
<?php endwhile; ?>