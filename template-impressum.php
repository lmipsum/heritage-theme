<?php
/**
 * Template Name: Impressum Template
 */
?>
<?php
	$fields = get_fields();
?>

<?php while (have_posts()) : the_post(); ?>
	<div id="impressumId">
				<?php $impressum = $fields["impressum"]; ?>
				<?php if( !empty( $impressum ) ) : ?>
					<section id="impressum-section">
						<div class = "container">
							<div class="col-xs-10 col-xs-offset-1">
								<h2>Impressum</h2>
								<div class = "impressum-content">
									<?=$impressum;?>
								</div>
							</div>
						</div>
					</section>
				<?php endif; ?>;
			</div>
<?php endwhile; ?>