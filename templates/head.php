<?php
	$slider_metadatas = get_slider_metas();
	switch($_SERVER['REQUEST_URI']) {
		case strpos($_SERVER['REQUEST_URI'], "/news-heritage-restaurant-hamburg-"):
			header('Location: http://'. $_SERVER['SERVER_NAME'] . '?link=news-heritage-restaurant-hamburg&title='.str_replace('/news-heritage-restaurant-hamburg-','',$_SERVER['REQUEST_URI']));
			break;
		case "/newsletter-confirm":
			header('Location: http://'. $_SERVER['SERVER_NAME'] . '?link=newsletter-confirm');
			break;
		default:
			break;
	}
?>

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<link rel="apple-touch-icon" sizes="57x57" href="apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="apple-touch-icon-120x120.png">
	<link rel="icon" type="image/png" href="/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/favicon/manifest.json">
	<link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="/favicon/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
  	<?php wp_head(); ?>
  	
	<?php
	$isSlider = false;
	if ( isset($_GET['link']) ) {
		foreach ($slider_metadatas as $slider_meta ) {
			if ( $_GET['link'] == $slider_meta['url'] ) { $isSlider = true;
				?>
				<title><?= $slider_meta['title'] ?></title>
				<meta property="og:title"  content="<?= $slider_meta['title'] ?>" />
				<meta property="og:description" content = "<?= $slider_meta['description'] ?>">
				<meta name="description" content="<?= $slider_meta['description'] ?>" />
				<?php
			}
			break;
		}
		if ( !$isSlider ) {
			switch($_GET['link']){
				case "news-heritage-restaurant-hamburg":
					?>
					<?php
					if(isset($_GET['title'])){

						$posttitle = strtoupper(str_replace("-", " ",$_GET["title"]));
						$getpost= get_page_by_slug($posttitle, "post");
						$postcontent= $getpost->post_content;
						$postdescription = $getpost->post_excerpt;
						$meta_title = (get_field('meta_title', $getpost->ID)) ? get_field('meta_title', $getpost->ID) : $posttitle;
						$meta_desc = (get_field('meta_description', $getpost->ID)) ? get_field('meta_description', $getpost->ID) : $postdescription;
						?>
						<title> <?= $getpost->post_title ?> - Heritage Restaurant Hamburg News/Events</title>
						<meta property="og:title"  content="<?= $meta_title;?>">
						<meta name="description" content = "<?= $meta_desc;?>">
						<meta property="og:description" content = "<?= $meta_desc;?>">
						<meta property="og:image" content = "<?php  echo wp_get_attachment_image_src( get_post_thumbnail_id( $getpost->ID), "large")[0]; ?>">
						<?php
					}else{?>
						<title>Heritage Restaurant Hamburg News/Events</title>
						<meta property="og:title"  content="Heritage Restaurant Hamburg News/Events" />
						<meta name="description" content = "Neuigkeiten des Feinschmecker Restaurants mit einzigartigem Ausblick in Hamburg Zentrum">
					<?php } ?>
					<?php
					break;
				case "presse-heritage-restaurant-hamburg":
					?>
					<title>Heritage Restaurant Hamburg Presse</title>
					<meta property="og:title"  content="Heritage Restaurant Hamburg Presse" />
					<meta name="description" content = "Presse – Erstklassiges Speiselokal in Hamburg St. Georg an der Außenalster ">
					<?php
					break;
				case "impressum-heritage-hamburg":
					?>
					<title>Heritage Restaurant Hamburg Impressum</title>
					<meta property="og:title"  content="Heritage Restaurant Hamburg Impressum" />
					<meta name="description" content = "Impressum – Heritage Restaurant in Hamburg">
					<?php
					break;
				case "datenschutz-heritage-hamburg":
					?>
					<title>Heritage Restaurant Hamburg Datenschutz</title>
					<meta property="og:title"  content="Heritage Restaurant Hamburg Datenschutz" />
					<meta name="description" content = "Datenschutz – Heritage Restaurant in Hamburg">
					<?php
					break;
				default:
					?>
					<title>Heritage, gehobenes Restaurant Hamburg</title>
					<meta property="og:title"  content="Heritage, gehobenes Restaurant Hamburg" />
					<meta name="description" content = "Gehobenes Restaurant mit phantastischer Aussicht und einzigartigem Ambiente in Hamburg an der Alster – zentrale Lage">
					<?php
					break;
			}
		}
	}
	?>
	<script type='text/javascript'>
		<?= "var slider_metadatas = ". json_encode($slider_metadatas) . ";\n";?>
	</script>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-88869212-1', 'auto');
		ga('send', 'pageview');

	</script>
</head>