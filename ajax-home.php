<div id="homeId" class="active-page">
				 <?php
					/* Slider Content */
					$cyclon_slider_home = $fields["cyclon_slider_home_shortcode"];
				?>
				<?php if( !empty($cyclon_slider_home) ) : ?>
				  <section id="home-slider" class="active">
						<?= do_shortcode('[cycloneslider id="'.$cyclon_slider_home.'"]'); ?>
				  </section>
				<?php endif; ?>
			</div>