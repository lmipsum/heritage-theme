<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('heritage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'heritage')
  ));

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', array('caption', 'comment-form', 'comment-list', 'gallery', 'search-form'));

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar(array(
    'name'          => __('Primary', 'heritage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ));

/*
  register_sidebar(array(
    'name'          => __('Footer', 'heritage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ));
*/

	//register_widget(__NAMESPACE__ . '\\opening_hours_widget');
	//register_widget(__NAMESPACE__ . '\\reservation_widget');
	//register_widget(__NAMESPACE__ . '\\subscription_widget');
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Custom Widgets
 */
Class opening_hours_widget extends \WP_Widget {
	function __construct() {
		parent::__construct( 'opening_hours_widget', __( 'Opening Hours', 'heritage' ), array( 'description' => __( 'Opening Hours', 'heritage' ) ) );
	}

	function widget( $args, $instance ) {
		$day_names_full = array(
			__( 'Sunday', 'heritage' ),
			__( 'Monday', 'heritage' ),
			__( 'Tuesday', 'heritage' ),
			__( 'Wednesday', 'heritage' ),
			__( 'Thursday', 'heritage' ),
			__( 'Friday', 'heritage' ),
			__( 'Saturday', 'heritage' )
		);

		$day_names_short = array(
			__( 'Sun', 'heritage' ),
			__( 'Mon', 'heritage' ),
			__( 'Tue', 'heritage' ),
			__( 'Wed', 'heritage' ),
			__( 'Thu', 'heritage' ),
			__( 'Fri', 'heritage' ),
			__( 'Sat', 'heritage' )
		);

		$before_widget = '<div class="widget col-xs-12 col-lg-5" id="offnungszeiten">';
		$after_widget = '</div>';
		$title = $instance['title'];

		$html = $before_widget;
		if ( !empty( $title ) ) $html .= '<div><h3 class="title text-uppercase">' . $title . '</h3></div>';

		$pods_opening_hours = pods( 'pods_opening_hours', array('limit' => -1) );
		$locations = $pods_opening_hours->field( 'location' );
		if ( ! empty( $locations ) ) {
			foreach ( $locations as $loc ) {
				$html .= '<div class="col-xs-6"><table class="table">';
				$html .= '<thead><tr><th class="text-uppercase">' . ( $loc == 0 ? 'Restaurant' : 'Bar' ) . '</th></tr></thead>';
				$opening_hours = pods( 'pods_opening_hours', array( 'limit' => -1, 't.location LIKE "%' . $loc . '%"' ) );
				$html .= '<tbody>';
				while ( $opening_hours->fetch() ) {
					$days = $opening_hours->field( 'days' );
					$day_names = sizeof( $days ) > 1 ? $day_names_short : $day_names_full;
					$html .= '<tr><td>' . preg_replace_callback( '/\d+/', function( $m ) use( $day_names ) {
						return $day_names[$m[0]];
					}, implode( '-', $days ) ) . '</td> ';
					$html .= '<td>' . $opening_hours->display( 'from' ) . ' - ' . $opening_hours->display( 'until' ) . '</td></tr>';
				}
				$html .= '</tbody>';
				$html .= '</table></div>';
			}
		}

		$html .= $after_widget;
		echo $html;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
?>
	<p>
		<label for="<?= $this->get_field_id('title'); ?>"><?php _e( 'Title', 'heritage' ); ?></label>
		<input class="widefat" id="<?= $this->get_field_id('title'); ?>" name="<?= $this->get_field_name('title'); ?>" type="text" value="<?= $title; ?>" />
	</p>
<?php 
	}
}

Class reservation_widget extends \WP_Widget {
	function __construct() {
		parent::__construct('reservation_widget', __( 'Reservation', 'heritage' ), array( 'description' => __( 'Reservation', 'heritage' )));
	}

	function widget( $args, $instance ) {
		$before_widget = '<div class="widget col-xs-12 col-lg-3" id="reservierung">';
		$after_widget = '</div>';
		$title = $instance['title'];
		$phone = $instance['phone'];
		$link = $instance['link'];
		$email = $instance['email'];

		$html = $before_widget;
		if ( !empty( $title ) ) $html .= '<div><h3 class="title text-uppercase">' . $title . '</h3></div>';
		$html .= '<div class="text-center">';
		if ( !empty( $phone ) ) $html .= '<p class="lead">' . $phone . '</p>';
		if ( !empty( $link ) ) $html .= '<a href="' . $link . '" target="_blank" class="btn btn-primary" role="button">' . __( 'Online-Reservation', 'heritage' ) . '</a>';
		if ( !empty( $email ) ) $html .= '<p class="info-email"><a href="mailto:' . $email . '">' . $email . '</a></p>';
		$html .= '</div>';
		$html .= $after_widget;
		echo $html;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['link'] = strip_tags( $new_instance['link'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		return $instance;
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$phone = isset( $instance['phone'] ) ? esc_attr( $instance['phone'] ) : '';
		$link = isset( $instance['link'] ) ? esc_attr( $instance['link'] ) : '';
		$email = isset( $instance['email'] ) ? esc_attr( $instance['email'] ) : '';
?>
	<p>
		<label for="<?= $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'heritage' ); ?></label>
		<input class="widefat" id="<?= $this->get_field_id( 'title' ); ?>" name="<?= $this->get_field_name( 'title' ); ?>" type="text" value="<?= $title; ?>" />
	</p>
	<p>
		<label for="<?= $this->get_field_id( 'phone' ); ?>"><?php _e( 'Phone', 'heritage' ); ?></label>
		<input class="widefat" id="<?= $this->get_field_id( 'phone' ); ?>" name="<?= $this->get_field_name( 'phone' ); ?>" type="text" value="<?= $phone; ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Online-Reservation', 'heritage' ); ?> Link</label>
		<input class="widefat" id="<?= $this->get_field_id( 'link' ); ?>" name="<?= $this->get_field_name( 'link' ); ?>" type="text" value="<?= $link; ?>" />
	</p>
	<p>
		<label for="<?php echo $this->get_field_id( 'email' ); ?>"><?php _e( 'E-Mail', 'heritage' ); ?></label>
		<input class="widefat" id="<?= $this->get_field_id( 'email' ); ?>" name="<?= $this->get_field_name( 'email' ); ?>" type="text" value="<?= $email; ?>" />
	</p>
<?php
	}
}

Class subscription_widget extends \WP_Widget {
	function __construct() {
		parent::__construct('subscription_widget', __( 'Subscription', 'heritage' ), array( 'description' => __( 'Subscription', 'heritage' )));
	}

	function widget( $args, $instance ) {
		$before_widget = '<div class="widget col-xs-12 col-lg-3" id="verpassen">';
		$after_widget = '</div>';
		$title = $instance['title'];

		$html = $before_widget;
		if ( !empty( $title ) ) $html .= '<div><h3 class="title text-uppercase">' . $title . '</h3></div>';
		$html .= '<div class="text-center">';
		// IT'S JUST A PLACEHOLDER
		$html .= '<p>Lorem ipsum dolor sit amet adipiscing elit aenean vommodo ligula eget dolo</p>';
		$html .= '<input class="email" type="email" placeholder="E-Mail"/><input type = "button" class="send"/>';
		// END OF PLACEHOLDER
		$html .= '</div>';
		$html .= $after_widget;
		echo $html;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
?>
	<p>
		<label for="<?= $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'heritage' ); ?></label>
		<input class="widefat" id="<?= $this->get_field_id( 'title' ); ?>" name="<?= $this->get_field_name( 'title' ); ?>" type="text" value="<?= $title; ?>" />
	</p>
<?php
	}
}

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, array(
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
		is_singular()
  ));

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
  wp_enqueue_style('sage/css', Assets\asset_path('styles/main.css'), false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
//add_action('wp_enqueue_scripts',  '\\assets', 100);
