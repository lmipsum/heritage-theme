<footer class="content-info">  
	<div class = "footer-top">
		<div class="container">
			<div class = "offnungszeiten col-xs-12 col-lg-4">
				<p><?= __('Opening Hours', 'heritage') ?></p>
			</div>
			<div class = "reservierung col-xs-12 col-lg-4">
				<p><?= __('Book a Table', 'heritage') ?></p>
			</div>
			<div class = "verpassen col-xs-12 col-lg-4">
				<p><?= __('Don´t miss', 'heritage') ?></p><div class = "footer-close-button"></div>
			</div>
		</div>
	</div>
	<div class="footer-main">
		<div class="container">
			<div class = "mobile-footer-top">
				<div class = "offnungszeiten col-xs-12 col-lg-4">
					<p><?= __('Opening Hours', 'heritage') ?></p>
				</div>
			</div>
			<div class="col-xs-12 col-lg-5" id="offnungszeiten">
				
				<div class="col-xs-6 col-sm-6">
					<p class="tableTitle">restaurant & bar</p>
					<div class = "row">
						<b><?= __('Daily from 6:00 PM', 'heritage') ?></b>
					</div>
					<div class = "row">
						<?= nl2br(__("A la carte orders are welcome until 11:00 PM", "heritage")) ?>
					</div>
				</div>
				<div class="col-xs-6 col-sm-6">
					<p class="tableTitle"><?= __('Address', 'heritage') ?></p>
					<div class = "row">
						<b>HERITAGE Restaurant</b>
					</div>
					<div class = "row">
						Le Meridien Hamburg
					</div>
					<div class = "row">
						An der Alster 52-56
					</div>
					<div class = "row">
						20099 Hamburg
					</div>
				</div>
			 </div>
			 <div class = "mobile-footer-top">
				<div class = "reservierung col-xs-12 col-lg-4">
					<p><?= __('Book a Table', 'heritage') ?></p>
				</div>
			</div>
			 <div class="col-xs-12 col-lg-3" id="reservierung">				
				<p class="lead">+49 (0) 40 2100 1070</p>
				<button class="reserve-btn"><?= __('Online Reservation', 'heritage') ?></button>
				<p><a href = "mailto:info@heritage-restaurant.com" class="info-email">info@heritage-restaurant.com</a></p>
			 </div>
			 <div class = "mobile-footer-top">
				<div class = "verpassen col-xs-12 col-lg-4">
					<p><?= __('Don´t miss', 'heritage') ?></p><div class = "footer-close-button"></div>
				</div>
			</div>
			 <div class="col-xs-12 col-lg-4" id="verpassen">
				<?= do_shortcode( '[custom-email-subscribers desc="' . __('Would you like to be updated on the newest creations on our menu, new delicious wines and upcoming events?', 'heritage') . '"]' ); ?>
				<?php /* ?>
				<p>Sie möchten über neueste Kreationen auf unserer Speisekarte, neue feine Weine und bevorstehende Events auf dem Laufenden gehalten werden?</p>
				<div class = "checkboxes">
					<p class = "checkbox-title"><b>Bestellen Sie unseren „Gruß aus dem Heritage“ und Sie erhalten per E-Mail aktuelle Infos über:</b></p>
					<div class="unique-checkbox">
					  <input type="checkbox" value="1" id="speisekarte" name="speisekarte"  />
					  <label for="speisekarte"></label>
					</div>
					<p class = "checkbox-label">Speise- oder Weinkarten</p>
					
					<div class="unique-checkbox">
					  <input type="checkbox" value="2" id="events&news" name="events&news"  />
					  <label for="events&news"></label>
					</div>
					<p class = "checkbox-label">News und events</p>
					
					<div class="unique-checkbox license">
					  <input type="checkbox" value="4" id="datenkarte" name="datenkarte" checked  />
					  <label for="datenkarte"></label>
					</div>
					<p class = "checkbox-label">Ja, ich habe die <u>Datenschutzbestimmungen</u> gelesen und bin einverstanden. </p>
				</div>
				<input class="email" type="email" placeholder="E-Mail"/><input type = "button" class="send"/>
				<?php */ ?>
			 </div>
			 <div class = "col-xs-12 bottom">
				<div class = "social">
					<a href = "https://www.facebook.com" target="_blank">
					<div class = "facebook">
					
					</div>
					</a>
					<a href = "https://www.google.com" target="_blank">
						<div class = "google">
						
						</div>
					</a>
				</div>
				<div class = "bottom-menu">
					<a class = "presse" href = "/presse-heritage-restaurant-hamburg" data-hash="#presseId"><?= __('Press', 'heritage') ?></a><span>|</span><a class = "impressum" href = "/impressum-heritage-hamburg" data-hash="#impressumId"><?= __('Legal Notice', 'heritage') ?></a>
				</div>
			 </div>
			</div>
			<?php // dynamic_sidebar('sidebar-footer'); ?>
		</div>
	</div>
</footer>
