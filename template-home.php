<?php
/**
 * Template Name: Home Template
 */
?>
<?php
	$fields = get_fields();
	//$r_pdf = $fields["pdf"];
	$r_pdf = [];
	$r_pdf[1]['name'] = 'speisekarte';
	$r_pdf[1]['file'] = esc_url( get_theme_mod( 'speisekarte' ) );
	$r_pdf[2]['name'] = 'weinkarte';
	$r_pdf[2]['file'] = esc_url( get_theme_mod( 'weinkarte' ) );
	//print_r(( get_theme_mod( 'speisekarte' )));
?>
<script>
	var pdf = <?= json_encode($r_pdf, true); ?>;
</script>

<?php while (have_posts()) : the_post(); ?>
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
			</div>
			<div id="kulinarikId">
				<?php
					/* Slider Content */
					$cyclon_slider_kulinarik_1 = $fields["cyclon_slider_kulinarik_1_shortcode"];
					$cyclon_slider_kulinarik_2 = $fields["cyclon_slider_kulinarik_2_shortcode"];
					//$winzer = $fields["winzer"];
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
				<?php /* if(!empty($winzer)):?>
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
							<div class = "winzer-instance col-xs-8 col-xs-offset-2">
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
				<?php endif; */?>
				<div class = "sub-navigation">
					<div class = "kulinarik-nav-1 active" data-anchor = "#kulinarik-slider-1"></div>
					<div class = "kulinarik-nav-2" data-anchor = "#kulinarik-slider-2"></div>
				</div>
			</div>
			<div id="newsId">
				<?php //print_r($fields["news_posts"]);
				$news = get_posts( array( 'offset'=> 0, 'category' => $fields["news_posts"]->term_id, 'orderby' => 'date', 'order' => 'DESC' ) ); if ( !empty($news) ) : ?>
				<section id = "events">
					<div class = "container">	
						<div class = "news-container">
						<?php global $post; ?>
						<?php foreach( $news as $post ) : setup_postdata($post); ?>
						<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
							<div id="event_<?= $post->post_name ?>" class="event">
								<img src= "<?= $image[0]; ?>" />
								 <h2 class="text-uppercase"><?= the_title(); ?></h2>
								 <div class="excerpt"><p><?= the_excerpt(); ?></p></div>
								 <div class = "news-open"></div>
								 <div class = "event-instance">
									<div class = "col-xs-2 news-close"> </div>
									<div class = "col-xs-12 col-lg-9 col-lg-offset-1">
										<img class="eventFullImage" src="<?= $image[0]; ?>" />
										<h2 class="text-uppercase"><?= the_title(); ?></h2>
										<div class = "event-content"><?= the_content(); ?> </div>
									</div>
								 </div>
							</div>
						<?php endforeach;?>
						</div>
					</div>
				</section>
				<?php /* ?>
				<?php $news = $fields["news"]; ?>
				<?php if( !empty( $news ) ) : ?>
					<section id = "events">
						<div class = "container">	
							<div class = "news-container">
								<?php foreach($news as $item) : ?>
									<div class = "event">
										<img src= "<?=$item["image"];?>" />
										 <h2><?=$item["title"];?></h2>
										 <p><?=$item["description"];?></h2>
										 <div class = "news-open"></div>
										 <div class = "event-instance col-xs-12 col-md-8">
											<div class = "col-xs-2 news-close"> </div>
											<div class = "col-xs-12 col-md-10">
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
							<div class = "event-instance"></div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div id="impressumId">
				<?php $impressum = $fields["impressum_new"]; ?>
				<?php if( !empty( $impressum ) ) : ?>
					<section id="impressum-section">
						<div class = "container">
							<div class="col-xs-12 col-md-9 col-md-offset-2">
								<h2>Impressum</h2>
								<div class = "impressum-content">
									<?=$impressum;?>
								</div>
							</div>
						</div>
					</section>
				<?php endif; ?>;
			</div>
			<div id="datenschutzId">
				<?php $datenschutz = $fields["datenschutz"]; ?>
				<?php if( !empty( $datenschutz ) ) : ?>
					<section id="impressum-section">
						<div class = "container">
							<div class="col-xs-12 col-md-9 col-md-offset-2">
								<h2>datenschutz</h2>
								<div class = "impressum-content">
									<?=$datenschutz;?>
								</div>
							</div>
						</div>
					</section>
				<?php endif; ?>;
			</div>
			<div id="presseId">
				<?php $presse = $fields["presse"]; ?>
				<?php if( !empty( $presse ) ) : ?>
					 <section id = "presse-section">
						<div class = "container">
							<div class="col-xs-12 col-md-10 col-md-offset-1">
								<h2><?= __('Learn more about the Heritage', 'heritage') ?></h2>
								<div class = "impressum-content">
									<?=$presse;?>
								</div>
								<div id = "presseNav">
									<a href="<?= $fields["pdf_url"] ?>" target="_blank"><div id = "pressetexte"><p><?= __('Press Releases', 'heritage') ?></p></div></a>
									<a href="<?= $fields["photos_url"] ?>"><div id = "pressefotos"><p><?= __('Press Photos', 'heritage') ?></p></div></a>
								</div>
							</div>
						</div>
					 </section>
				<?php endif; ?>;
			</div>
			<?php
			$unsubscribe = false;
			$optin = false;

			// Load default message
			$data = array();
			$data = es_cls_settings::es_setting_select(1);

			if(isset($_GET['ces'])) {
				$noerror = true;
				if($_GET['ces'] == "unsubscribe") $unsubscribe = true;
				if($_GET['ces'] == "optin") $optin = true;
			}
			?>
			<div id="newsletter-popup"<?php if($unsubscribe || $optin) echo 'style="display:block"';?>>
				<script> var admin_mail = '<?= $data['es_c_adminemail']; ?>'; </script>
				<div id="newsletter-popup-inner">
					<div class="mail-image"></div>
					<?php
					if($unsubscribe) {
						$message = esc_html(stripslashes($data['es_c_unsubhtml']));
						$message = str_replace("\r\n", "<br />", $message);
						?>
							<h2>Auf Wiedersehen</h2>
							<p><?= $message ?></p>
					<?php
						};
						if($optin) {
							$message = esc_html(stripslashes($data['es_c_subhtml']));
							$message = str_replace("\r\n", "<br />", $message);
					?>
							<h2>Vielen Dank</h2>
							<p><?= $message ?></p>
					<?php
						} if (!$optin && !$unsubscribe) {
					?>
					<h2>Schönen Gruß aus dem Heritage</h2>
					<p>Sie haben soeben eine E-Mail von uns erhalten. Bitte klicken Sie auf den Link in der E-Mail, um die Anmeldung für unseren Newsletter abzuschließen.</p>
					<p>E-Mail nicht erhalten?<br> 
					Bitte prüfen Sie Ihren Spam-Ordner oder schreiben <a href="mailto:<?= $data['es_c_adminemail']; ?>">Sie uns.</a></p>
					<?php
						};
					?>
				</div>
			</div>
<?php endwhile; ?>
