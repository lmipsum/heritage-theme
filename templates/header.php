<header class="banner">
  <div class="container">
    
    <nav class="nav-primary navbar navbar-default">
		<a href = "/" data-hash="#homeId"><div class="brand"></div></a>
		<button class = "menu-button"></button>
		<ul id="menu">
			 <div>
				<li id="home-link" class="left"><a href = "/" data-hash="#homeId" class="selected">home</a></li>
				<li id="restaurant-link" class="left"><a href = "/restaurant-innenstadt-hamburg"  data-hash = "#restaurantId">restaurant</a></li>		
			</div>
			<div>
				<li id="kulinarik-link" class="right"><a href = "/restaurant-gehobene-kueche-hamburg" data-hash = "#kulinarikId"><?= __('Cuisine', 'heritage') ?></a></li>
				<li id="news-link" class="right"><a href = "/news-heritage-restaurant-hamburg" data-hash = "#newsId">events & news</a></li>
			</div>
		</ul>
		<div class = "lang-select">
		<?php
					$languages =icl_get_languages('skip_missing=0&orderby=code');
					foreach($languages as $key => $value){
						if($value['active'] == "0") {
							echo "<a href = $value[url]>$key</a>";
						}else{
							echo "<a class='active-language' href = $value[url]>$key</a>" ;
						}
						if($key == "de"){
							echo "<span>|</span>";
						}
					}
				?>
		</div>
    </nav>
  </div>
</header>
