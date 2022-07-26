<?php
/**
 * Template Name: Presse Template
 */
?>
<?php
	$fields = get_fields();
?>

<?php while (have_posts()) : the_post(); ?>
	<div id="presseId" class="active-page">
				<?php $presse = $fields["presse"]; ?>
				<?php if( !empty( $presse ) ) : ?>
					 <section id = "presse-section">
						<div class = "container">
							<div class="col-xs-10 col-xs-offset-1">
								<h2>Presse</h2>
								<div class = "impressum-content">
									<?=$presse;?>
								</div>
								<div id = "presseNav">
									<div id = "pressemappe"><p>pressemappe</p></div>
									<a href="$fields["pdf_url"]"><div id = "pressetexte"><p>pressetexte</p></div></a>
									<a href="$fields["photos_url"]"><div id = "pressefotos"><p>pressefotos</p></div></a>
								</div>
							</div>
						</div>
					 </section>
				<?php endif; ?>;
			</div>
<?php endwhile; ?>