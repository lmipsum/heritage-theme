<?php
 /**
  * Sage includes
  *
  * The $sage_includes array determines the code library included in your theme.
  * Add or remove files to the array as needed. Supports child theme overrides.
  *
  * Please note that missing files will produce a fatal error.
  *
  * @link https://github.com/roots/sage/pull/1042
  */
 $sage_includes = array(
   'lib/assets.php',    // Scripts and stylesheets
   'lib/extras.php',    // Custom functions
   'lib/setup.php',     // Theme setup
   'lib/titles.php',    // Page titles
   'lib/wrapper.php',   // Theme wrapper class
   'lib/customizer.php' // Theme customizer
 );
 
 foreach ($sage_includes as $file) {
   if (!$filepath = locate_template($file)) {
     trigger_error(sprintf(__('Error locating %s for inclusion', 'heritage'), $file), E_USER_ERROR);
   }
 
   require_once $filepath;
 }
 unset($file, $filepath);
 
 /**
  * Custom theme options
  */
 function custom_theme_options( $wp_customize ) {
 	$wp_customize->add_section( 'pdf_section' , array(
     'title'       => __( 'Karten update', 'heritage' ),
     'priority'    => 40
   ));
 
 	$wp_customize->add_setting( 'speisekarte' );
   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'speisekarte', array(
     'label'    => __( 'Speisekarte', 'heritage' ),
     'description'  => __( 'Please insert url to the pdf file', 'heritage' ),
 		'section'  => 'pdf_section',
     'settings' => 'speisekarte'
   )));
 
 	$wp_customize->add_setting( 'weinkarte' );
   $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'weinkarte', array(
     'label'    => __( 'Weinkarte', 'heritage' ),
 		'description' => __( 'Please insert url to the pdf file', 'heritage' ),
     'section'  => 'pdf_section',
     'settings' => 'weinkarte'
   )));
 }
 add_action('customize_register', 'custom_theme_options');
 
 /**
  * Shortcode to get posts by category slug
  */
 function posts_func( $atts ) {
 	$atts = shortcode_atts( array(
 		'cat_slug' => 'news-events',
		'mail_group' => 'Public',
		'title' => 'Unsere aktuellen Events und News'
 	), $atts, 'posts' );
 	
 	global $post;
 	$slug = $atts['cat_slug'];
	$mail_group = $atts['mail_group'];
	$title = $atts['title'];
 	$html = '<h3 style="text-transform: uppercase; font-size: 20px; color: #000; font-family: Calibri; font-weight: normal;">'. $title . '</h3><table border="0" width="100%" style="border-collapse: collapse; padding:10px 0 20px;"><tbody>';

 	$args = array(
        'category_name' => $slug, 
        'date_query' => array(
            'after' => get_last_newsletter_sent('post', $mail_group) 
        )
    );

 	$result = get_posts( $args );

 	foreach( $result as $mypost ) {
 		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($mypost->ID) );
		$html .= '<tr style="border-bottom: 1px solid rgb(212,211,209);">';
		$html .= '<td width="270"><a href="' .site_url() .'/news-heritage-restaurant-hamburg"><img src="' . $feat_image . '" width="270" style="border:1px solid #BE9F57;" \></a></td>';
		$html .= '<td width="270" valign="top"><table width="240" border="0" align="center" cellpadding="0" cellspacing="0">';
		$html .= '<tr valign="top"><td><a href="'.site_url() .'/#newsId" style="text-decoration: none;"><h2 style="color:#BE9F57; font-size: 20px; text-transform:uppercase; font-family: Calibri; font-weight: normal;">'.$mypost->post_title.'</h2></a></td></tr>';
		$html .= '<tr valign="middle"><td style="font-size: 14px; color: #000; font-family: Calibri; font-weight: normal;">' . $mypost->post_excerpt . ' </td></tr>';
		$html .= '<tr align="right" valign="bottom"><td><a style="color: #BE9F57; text-decoration: none; font-family: Calibri; font-weight: normal; text-transform: uppercase;" href="'.site_url() .'/#newsId">mehr</a></td></tr>';
		$html .= '</table></td></tr>';
 	};
	$html .= '</tbody></table>';

	if (empty($result)) $html = '';

 	return $html;
 }
 add_shortcode( 'posts', 'posts_func' );
 
 /**
  * Shortcode to get custom theme option fields
  */
 function cto_func( $atts ) {
 	$atts = shortcode_atts( array(
 		'pdf' => 'speisekarte',
		'mail_group' => 'Public'
 	), $atts, 'karte' );
 
 	$pdf = $atts['pdf'];
	$mail_group = $atts['mail_group'];

    if(!should_pdf_newsletter_sent($pdf, $mail_group)) 
        return '';
    
 	$html = '<table width="100%" border="0" style="border-collapse: collapse;"><tr valign="middle" style="border-bottom: 1px solid rgb(212,211,209);"><td><a style="color: #BE9F57; text-transform: uppercase; font-size: 20px; text-decoration: none; text-transform: uppercase; font-family: Calibri; font-weight: normal;" href="' . esc_url( get_theme_mod( $pdf ) ) . '" target="_blank">' . $pdf . ' </a></td>';
	$html .= '<td align="right" style="padding-top: 8px;"><a style="color: #BE9F57; text-transform: uppercase; font-size: 20px; text-decoration: none;" href="' . esc_url( get_theme_mod( $pdf ) ) . '" target="_blank"><img src="'. content_url() .'/themes/heritage/assets/images/winzer-open.png" /></a></td></tr></table></td>';

 	return $html;
 }
 add_shortcode( 'karte', 'cto_func' );
 
 /**
  * Email Subscribers Plugin widget override
  */
 function ces_func( $atts ) {
 	if ( ! is_array( $atts ) ) {
 		return '';
 	}
 	
 	//[custom-email-subscribers namefield="NO" desc=""]
 	$es_name = isset($atts['namefield']) ? $atts['namefield'] : 'NO';
 	$es_desc = isset($atts['desc']) ? $atts['desc'] : __('Would you like to be updated on the newest creations on our menu, new delicious wines and upcoming events?', 'heritage');
 	$es_group = isset($atts['group']) ? $atts['group'] : '';
 	
 	$arr = array();
 	$arr["es_title"] 	= "";
 	$arr["es_desc"] 	= $es_desc;
 	$arr["es_name"] 	= $es_name;
 	$arr["es_group"] 	= $es_group;
 	return cload_subscription($arr);
 }
 add_shortcode( 'custom-email-subscribers', 'ces_func' );
 
 function cload_subscription($arr) {
 	$es_name = trim($arr['es_name']);
 	$es_desc = trim($arr['es_desc']);
 	$es_group = trim($arr['es_group']);
 	$url = "'" . home_url() . "'";
 	$es = "";	
 	global $es_includes;
 	if (!isset($es_includes) || $es_includes !== true) { 
 		$es_includes = true;
 		$es = $es . '<link rel="stylesheet" media="screen" type="text/css" href="'.ES_URL.'widget/es-widget.css" />';
 	} 
 	$es = $es . '<script language="javascript" type="text/javascript" src="'.ES_URL.'widget/es-widget-page.js"></script>';
 	
 	if( $es_desc <> "" ) { 
 		$es = $es . '<p>'.$es_desc.'</p>';
 	} 
 	$es = $es . '<div class="es_msg"><span id="es_msg_pg"></span></div>';
 	$es .= '<div class = "checkboxes">
 				<p class = "checkbox-title"><b>' . __("Order our \"Greetings from the HERITAGE\" and via email, you´ll receive the latest information on", "heritage") . ':</b></p>
 				<div class="unique-checkbox">
 					<input type="checkbox" value="1" id="speisekarte" name="speisekarte"  />
 					<label for="speisekarte"></label>
 				</div>
 				<p class = "checkbox-label">' . __("Menu or wine list", "heritage") . '</p>
 				
 				<div class="unique-checkbox">
 					<input type="checkbox" value="2" id="eventsnews" name="eventsnews"  />
 					<label for="eventsnews"></label>
 				</div>
 				<p class = "checkbox-label">' . __("News and events", "heritage") . '</p>
 				
 				<div class="unique-checkbox license">
 					<input type="checkbox" value="4" id="datenkarte" name="datenkarte" checked disabled />
 					<label for="datenkarte"></label>
 				</div>
 				<p class = "checkbox-label">' . __("Yes, I have read the <u><a href = \"/datenschutz-heritage-hamburg\" data-hash=\"#datenschutzId\">privacy policy</a></u> and agree with it.", "heritage") . '</p>
 			</div>';
 		$es = $es . '<input class="email es_textbox_class" name="es_txt_email_pg" id="es_txt_email_pg" onkeypress="if(event.keyCode==13) es_submit_pages('.$url.')" value="" maxlength="225" type="text">';
 		$es = $es . '<input class="send es_textbox_button" name="es_txt_button_pg" id="es_txt_button_pg" onClick="return es_submit_pages('.$url.')" type="button">';
 	if( $es_name != "YES" ) {
 		$es = $es . '<input name="es_txt_name_pg" id="es_txt_name_pg" value="" type="hidden">';
 	}
 	$es = $es . '<input name="es_txt_group_pg" id="es_txt_group_pg" value="'.$es_group.'" type="hidden">';
 	return $es;
 }
 
 // Watch pdf updates - Media upload
 add_filter('wp_handle_upload_prefilter', 'watch_pdf_update' );
 function watch_pdf_update( $file ) {
 	if (strpos($file['name'], '.pdf') !== false) {
 		echo $file['name'];
 		$filenames = maybe_unserialize(get_option('theme_mods_heritage'));
 		if(basename($filenames['speisekarte']) == $file['name']) {
 			update_option('speisekarte_change_time', time(), false);
 		} elseif(basename($filenames['weinkarte']) == $file['name']) {
 			update_option('weinkarte_change_time', time(), false);
 		}		
 	}
     return $file;
 }
 
// Watch pdf updates - URL Change
add_filter( 'pre_update_option_theme_mods_heritage', 'watch_pdf_urlupdate', 10, 2 );
function watch_pdf_urlupdate( $new_value, $old_value ) {
	$new = maybe_unserialize($new_value);
	$old = maybe_unserialize($old_value);
	if($new['speisekarte'] != $old['speisekarte']) {
		update_option('speisekarte_change_time', time(), false);
	} elseif($new['weinkarte'] != $old['weinkarte']) {
		update_option('weinkarte_change_time', time(), false);
	}
	return $new_value;
}

// Email helper functions - @param type pdf or post
function get_last_newsletter_sent($type = 'pdf', $mail_group = 'Public') {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$arrRes = array();
	if($type == 'pdf')
		$type = 'Heritage | Karten update im Heritage';
	else
		$type = 'Heritage | News & Events';

    if($mail_group == 'Public')
        $type = 'Heritage | News & Events | Karten update im Heritage';

	$sSql = "SELECT * FROM `".$prefix."es_sentdetails` where 1=1 AND (es_sent_subject='" . $type . "') ORDER BY es_sent_starttime DESC LIMIT 0,1";
	$arrRes = $wpdb->get_row($sSql, ARRAY_A);

	return $arrRes['es_sent_starttime'];
}

// Check if updated since last email @param type speisekarte or weinkarte
function should_pdf_newsletter_sent($type = 'speisekarte', $mail_group = 'Public') {
	if ($mail_group == 'Heritage | News & Events') return false;
	if(date('Y-m-d H:i:s', intval(get_option($type . '_change_time'))) > get_last_newsletter_sent('pdf', $mail_group))
		return true;
	else
		return false;
}

function get_page_by_slug($slug, $post_type) {
	$args = array(
		'name'        => $slug,
		'post_type'   => $post_type,
		'post_status' => 'publish',
		'numberposts' => 1
	);
	$my_posts = get_posts($args);
	if( $my_posts ) return $my_posts[0];
	return false;
}

function custom_mce_options($init)
{
	$init['valid_children'] = "+body[style]";
	$init['valid_children'] = "+body[link]";
	return $init;
}
add_filter('tiny_mce_before_init', 'custom_mce_options');

function remove_empty_p( $content ) {
	$content = force_balance_tags( $content );
	$content = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
	$content = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content );
	return $content;
}
add_filter('the_content', 'remove_empty_p', 20, 1);

/* error redirect */
function my_page_template_redirect()
{
    if( is_404() || is_author('innostart') )
    {
        wp_redirect( home_url( ) );
        exit();
    }
}
//add_action( 'template_redirect', 'my_page_template_redirect' );

function get_slider_metas() {
	$sliders = new WP_Query(['offset' => 0, 'post_type'  => 'cycloneslider']);
	$array = [];
	$array2 = [];
	$array3 = [];
	if( have_rows('page_meta') ):
		while ( have_rows('page_meta') ) : the_row();
			if ( get_sub_field('section') === '#homeId' ) :
				$array[] = [
					'section' => get_sub_field('section'),
					'title' => get_sub_field('meta_title'),
					'url' => "/",
					'description' => get_sub_field('meta_description')
				];
			else :
				$array3[] = [
					'section' => get_sub_field('section'),
					'title' => get_sub_field('meta_title'),
					'url' => get_sub_field('url_slug'),
					'description' => get_sub_field('meta_description')
				];
			endif;
		endwhile;
	else :
		// old data
		$array[] = [
			'section' => "#homeId",
			'title' => "Heritage, gehobenes Restaurant Hamburg ",
			'url' => "/",
			'description' => "Gehobenes Restaurant mit phantastischer Aussicht und einzigartigem Ambiente in Hamburg an der Alster – zentrale Lage"
		];
		$array3 = [
			[
				'section' => "#newsId",
				'title' => "Heritage Restaurant Hamburg News/Events",
				'url' => "news-heritage-restaurant-hamburg",
				'description' => "Neuigkeiten des Feinschmecker Restaurants mit einzigartigem Ausblick in Hamburg Zentrum"
			],
			[
				'section' => "#presseId",
				'title' => "Heritage Restaurant Hamburg Presse",
				'url' => "presse-heritage-restaurant-hamburg",
				'description' => "Presse – Erstklassiges Speiselokal in Hamburg St. Georg an der Außenalster "
			],
			[
				'section' => "#impressumId",
				'title' => "Heritage Restaurant Hamburg Impressum",
				'url' => "impressum-heritage-hamburg",
				'description' => "Impressum – Heritage Restaurant in Hamburg"
			],
			[
				'section' => "#datenschutzId",
				'title' => "Heritage Restaurant Hamburg Datenschutz",
				'url' => "datenschutz-heritage-hamburg",
				'description' => "Datenschutz – Heritage Restaurant in Hamburg"
			],
		];
	endif;
	if ( $sliders->have_posts() ) :
		while ( $sliders->have_posts() ) : $sliders->the_post();
			if( have_rows('slider_meta') ):
				$index = 1;
				while ( have_rows('slider_meta') ) : the_row();
					$slider_name = get_post_field( 'post_name', get_post() );
					switch($slider_name) {
						case 'restaurant_slider_2':
							$section = '#restaurantId';
							break;
						case 'kulinarik_slider_1':
							$section = '#kulinarikId';
							break;
						case 'kulinarik_slider_2':
							$section = '#kulinarikId';
							break;
						default:
							$section = '#homeId';
							break;
					}
					if ($slider_name === 'kulinarik_slider_2') :
						$array2[] = [
							'section' => $section,
							'url' => get_sub_field('url_slug'),
							'title' => get_sub_field('meta_title'),
							'description' => get_sub_field('meta_description'),
							'nthImg' => $index
						];
					else:
						$array[] = [
							'section' => $section,
							'url' => get_sub_field('url_slug'),
							'title' => get_sub_field('meta_title'),
							'description' => get_sub_field('meta_description'),
							'nthImg' => $index
						];
					endif;
					$index++;
				endwhile;
			endif;
		endwhile;
		wp_reset_postdata();
	endif;

	$result = array_merge($array, $array2);
	$result = array_merge($result, $array3);

	return $result;
}

if( function_exists("register_field_group") ) {
	register_field_group(array (
		'id' => 'acf_page-metadata',
		'title' => 'Page Metadata',
		'fields' => array (
			array (
				'key' => 'field_59396656b4afa',
				'label' => 'Page Meta',
				'name' => 'page_meta',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_5939673442faa',
						'label' => 'Section',
						'name' => 'section',
						'type' => 'text',
						'disabled' => true,
						'instructions' => __('Do NOT modify these values!'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_593966a5b4afb',
						'label' => 'Slug',
						'name' => 'url_slug',
						'type' => 'text',
						'instructions' => __('Use only lower case characters without any space.'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_593966dab4afc',
						'label' => 'Meta Title',
						'name' => 'meta_title',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_593966e7b4afd',
						'label' => 'Meta Description',
						'name' => 'meta_description',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => 5,
				'row_limit' => 5,
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-home.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_slider-metadata',
		'title' => 'Metadata',
		'fields' => array (
			array (
				'key' => 'field_59230e328f362',
				'label' => 'Slider Meta',
				'name' => 'slider_meta',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_5923e93d7f0ff',
						'label' => 'Slug',
						'name' => 'url_slug',
						'type' => 'text',
						'instructions' => __('Use only lower case characters without any space.'),
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_59230e458f363',
						'label' => 'Meta Title',
						'name' => 'meta_title',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_59230e518f364',
						'label' => 'Meta Description',
						'name' => 'meta_description',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'cycloneslider',
					'order_no' => 0,
					'group_no' => 0,
				),
				array (
					'param' => 'post',
					'operator' => '!=',
					'value' => '119',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_post-metadata',
		'title' => 'Post: Metadata',
		'fields' => array (
			array (
				'key' => 'field_59478e3bedc78',
				'label' => 'Meta Title',
				'name' => 'meta_title',
				'type' => 'text',
				'instructions' => 'Leave this field blank if you want to use the post\'s title as meta title.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_59478e8fedc79',
				'label' => 'Meta Description',
				'name' => 'meta_description',
				'type' => 'textarea',
				'instructions' => 'Leave this field blank, if you want to use the post\'s excerpt as meta description.',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

function my_load_field($field) {
	$field['disabled'] = true;
	return $field;
}

add_filter("acf/prepare_field/key=field_5939673442faa", "my_load_field");
add_filter("acf/prepare_field/name=section", "my_load_field");