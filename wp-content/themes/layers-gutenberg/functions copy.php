<?php
/**
 * ferrotec functions and definitions
 *
 * @package ferrotec
 */

remove_filter('acf_the_content', 'wpautop');
add_filter( 'wpseo_canonical', '__return_false' );
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');

add_filter('relevanssi_stemmer', 'relevanssi_simple_english_stemmer');
add_filter('relevanssi_remove_punctuation', 'savemyhyphens_1', 9);
function savemyhyphens_1($a) {
$a = str_replace( array('-','/'), array('myHYPHEN','mySLASH'), $a);
return $a;
}

add_filter('relevanssi_remove_punctuation', 'savemyhyphens_2', 11);
function savemyhyphens_2($a) {
$a = str_replace(array('myHYPHEN','mySLASH'), array('-','/'), $a);
return $a;
}


add_filter('post_limits', 'postsperpage');
function postsperpage($limits) {
	if (is_search()) {
		global $wp_query;
		$wp_query->query_vars['posts_per_page'] = 10;
	}
	return $limits;
}
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset($content_width)) {
	$content_width = 640; /* pixels */
}


if ( ! function_exists('ferrotec_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ferrotec_setup () {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ferrotec, use a find and replace
		 * to change 'ferrotec' to the name of your theme in all the template files
		 */
		load_theme_textdomain('ferrotec', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');
		add_theme_support('woocommerce');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(array(
			'primary' => __('Primary Menu', 'Ferrotec'),
			'mobile' => __('Mobile Menu', 'Ferrotec'),
			'footer'  => __('Footer Links', 'Ferrotec'),
		));

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support('post-formats', array(
			'aside',
			'image',
			'video',
			'quote',
			'link',
		));

		// Set up the WordPress core custom background feature.
		add_theme_support('custom-background', apply_filters('ferrotec_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)));
	}
endif; // ferrotec_setup
add_action('after_setup_theme', 'ferrotec_setup');
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ferrotec_widgets_init () {
	register_sidebar(array(
		'name'          => __('Sidebar Blog', 'ferrotec'),
		'id'            => 'sidebar-blog',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	));
	register_sidebar( array(
		'name'          => 'Seals Login Sidebar',
		'id'            => 'seals_login-sidebar',
		'description' => __( 'vf-Seals login area.', 'ferrotec' ),

//		'before_widget' => '<div>',
//		'after_widget'  => '</div>',
//		'before_title'  => '<h2 class="rounded">',
//		'after_title'   => '</h2>',
	) );

}

add_action('widgets_init', 'ferrotec_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function themes_scripts () {
	wp_enqueue_style('themes-style', get_stylesheet_uri());
	wp_enqueue_script(
		'bootstrap-js',
		get_template_directory_uri() . '/js/bootstrap.js',
		array('jquery'),
		'',
		false
	);
	wp_enqueue_script(
		'themes-scripts',
		get_template_directory_uri() . '/js/scripts.js',
		array('jquery','tablesort'),
		'',
		true
	);
	wp_enqueue_script('themes-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true);
	wp_enqueue_script('tablesort', get_template_directory_uri() . '/js/jquery.tablesorter.min.js', array('jquery'),'',true);
	wp_enqueue_script('thermalrecommender', get_template_directory_uri() . '/js/tsrec.js', array('jquery'),'',true);

	wp_enqueue_script('themes-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}

add_action('wp_enqueue_scripts', 'themes_scripts');

   function raphael_scripts () {
   	if ( is_page_template( 'page-teproducts.php' ) ) {
   	    wp_enqueue_script(
   	      'raphael',
   	      get_template_directory_uri() . '/js/raphael-min.js',
   	      array('jquery'),
   	      '',
   	      false
   	    );
   	    wp_enqueue_script(
   	      'graphs',
   	      get_template_directory_uri() . '/js/g.ferrotec.js',
   	      array('raphael'),
   	      '',
   	      false
   	    );  
   	}
  }
  
  add_action('wp_enqueue_scripts', 'raphael_scripts');


add_filter('user_can_richedit', create_function('', 'return false;'), 50);

function auc_create_post_type () {
	register_post_type('auc_block', array(
		'labels'            => array(
			'name'               => __('Block'),
			'singular_name'      => _x('Block', 'singular name'),
			'add_new'            => _x('Add New', 'Block'),
			'all_items'          => __('All Blocks'),
			'add_new_item'       => __('Add New Block'),
			'edit_item'          => __('Edit Block'),
			'new_item'           => __('New Block'),
			'view_item'          => __('View Blocks'),
			'search_items'       => _x('Search Blocks', 'plural'),
			'not_found'          => _x('No Block found', 'plural'),
			'not_found_in_trash' => _x('No Block found in Trash', 'plural'),
			'parent_item_colon'  => '',
		),
		'public'            => true,
		'has_archive'       => true,
		'rewrite'           => false, //array( 'slug' => 'press-coverage' ),
		'show_in_nav_menus' => false,
		'supports'          => array('author', 'title', 'editor', 'thumbnail', 'revisions'),
	));

	register_post_type('auc_events', array(
		'labels'            => array(
			'name'               => __('Events'),
			'singular_name'      => _x('Event', 'singular name'),
			'add_new'            => _x('Add New', 'Events'),
			'all_items'          => __('All Events'),
			'add_new_item'       => __('Add New Events'),
			'edit_item'          => __('Edit Events'),
			'new_item'           => __('New Events'),
			'view_item'          => __('View Events'),
			'search_items'       => _x('Search Events', 'plural'),
			'not_found'          => _x('No events found', 'plural'),
			'not_found_in_trash' => _x('No events found in Trash', 'plural'),
			'parent_item_colon'  => '',
		),
		'public'            => true,
		'has_archive'       => true,
		'rewrite'           => false, //array( 'slug' => 'press-coverage' ),
		'show_in_nav_menus' => false,
		'supports'          => array('author', 'title', 'editor', 'thumbnail', 'revisions'),
	));
	register_post_type('auc_press', array(
		'labels'            => array(
			'name'               => __('Press Releases'),
			'singular_name'      => _x('Press Release', 'singular name'),
			'add_new'            => _x('Add New', 'Press Releases'),
			'all_items'          => __('All Press Releases'),
			'add_new_item'       => __('Add New Press Releases'),
			'edit_item'          => __('Edit Press Releases'),
			'new_item'           => __('New Press Releases'),
			'view_item'          => __('View Press Releases'),
			'search_items'       => _x('Search Press Releases', 'plural'),
			'not_found'          => _x('No press releases found', 'plural'),
			'not_found_in_trash' => _x('No press releases found in Trash', 'plural'),
			'parent_item_colon'  => '',
		),
		'public'            => true,
		'has_archive'       => true,
		'rewrite'           => array( 'slug' => 'pr' ),
		'show_in_nav_menus' => false,
		'supports'          => array('author', 'title', 'editor', 'thumbnail', 'revisions', 'excerpt'),
	));
	register_post_type('auc_news', array(
		'labels'            => array(
			'name'               => __('News'),
			'singular_name'      => _x('News', 'singular name'),
			'add_new'            => _x('Add New', 'News'),
			'all_items'          => __('All News'),
			'add_new_item'       => __('Add New News'),
			'edit_item'          => __('Edit News'),
			'new_item'           => __('New News'),
			'view_item'          => __('View News'),
			'search_items'       => _x('Search News', 'plural'),
			'not_found'          => _x('No news found', 'plural'),
			'not_found_in_trash' => _x('No news found in Trash', 'plural'),
			'parent_item_colon'  => '',
		),
		'public'            => true,
		'has_archive'       => true,
		'rewrite'           => false, //array( 'slug' => 'press-coverage' ),
		'show_in_nav_menus' => false,
		'supports'          => array('author', 'title', 'editor', 'thumbnail', 'revisions', 'excerpt'),
	));
	register_post_type('auc_resources', array(
		'labels'            => array(
			'name'               => __('Resources'),
			'singular_name'      => _x('Resource', 'singular name'),
			'add_new'            => _x('Add New', 'press coverage'),
			'all_items'          => __('All Resources'),
			'add_new_item'       => __('Add New Resource'),
			'edit_item'          => __('Edit Resource'),
			'new_item'           => __('New Resource'),
			'view_item'          => __('View Resource'),
			'search_items'       => _x('Search Resources', 'plural'),
			'not_found'          => _x('No Resources found', 'plural'),
			'not_found_in_trash' => _x('No Resources found in Trash', 'plural'),
			'parent_item_colon'  => '',
		),
		'public'            => true,
		'has_archive'       => false,
		'rewrite'           => array('slug' => 'resources', 'with_front' => false),
		//'publicly_queryable' => false,
		'show_in_nav_menus' => false,
		//'menu_icon' => get_stylesheet_directory_uri() . '/img/ui/world.png',
		'supports'          => array('author', 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes'),
		//'taxonomies' => array( 'post_tag'),
	));
}

add_action('init', 'auc_create_post_type');

function new_excerpt_more ($more) {
	return '... <div class="excerpt-more"><a class="btn btn-more-link" href="' . get_permalink(get_the_ID()) . '">' . __('More', 'ferrotec') . '</a></div>';
}

add_filter('excerpt_more', 'new_excerpt_more');
function new_read_more ($more) {
	return '<div class="excerpt-more"><a class="btn btn-more-link" href="' . get_permalink(get_the_ID()) . '">' . __('More', 'ferrotec') . '</a></div>';
}

add_filter('the_content_more_link', 'new_read_more');

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function cc_mime_types ($mimes) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter('upload_mimes', 'cc_mime_types');

function custom_nav_menu_item_title ($id, $item) {
	$title = sanitize_title_with_dashes($item->attr_title);

	return $title;
}

function show_block_function ($atts, $content = null) {
    $a = shortcode_atts( array(
        'id' => '',
    ), $atts );
	$output = '';
	$queried_post = get_post($a['id']);
	if ($queried_post){
		$output = $queried_post->post_content;
	}
	return $output;
}

add_shortcode('show_block', 'show_block_function');

function get_the_content_by_id($post_id) {
  $page_data = get_page($post_id);
  if ($page_data) {
    return $page_data->post_content;
  }
  else return false;
}

function show_menu ($atts, $content = null) {
    extract(shortcode_atts(array( 'id' => null, 'wrapper' => null ), $atts));
	return wp_nav_menu(
	 array( 
	   'menu' => $id,
	   'container' => $wrapper, 
	   'echo' => false
	 )
	);
}

add_shortcode('show_menu', 'show_menu');


function show_block_template($id) {
	$output = '';
	$queried_post = get_post($id);
	if ($queried_post){
		$output = $queried_post->post_content;
	}
	return $output;
}


function show_recent_news ($atts, $content = null) {
    $a = shortcode_atts( array(
        'items' => -1,
    ), $atts );
	$output = '';
	$query  = new WP_Query(
		array(
			'post_type'      => 'auc_news',
			'order_by'       => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $a['items']
		)
	);
	if ($query->have_posts()) :
		$output .= '<h4>News</h4>';
		$output .= '<ul class="recent-news">';
		while ($query->have_posts()) : $query->the_post();
			$output .= '<li class="news-item">';
			$output .= '<p class="main">' . (get_post_type() == 'auc_news' ? 'NEWS: ' : 'PR: ') . '<date>' . get_the_date() . '</date> <a href="' . (get_post_type() == 'auc_news' ? get_field('news_url') : get_the_permalink()) . '">';
			$output .= get_the_title() . '</a></p></li>';
		endwhile;
		$output .= '</ul>';
	endif;
	wp_reset_postdata();

	return $output;
}

add_shortcode('show_recent_news', 'show_recent_news');
function show_recent_pr ($atts, $content = null) {
    $a = shortcode_atts( array(
        'items' => -1,
    ), $atts );
	$output = '';
	$query  = new WP_Query(
		array(
			'post_type'      => 'auc_press',
			'order_by'       => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $a['items']
		)
	);
	if ($query->have_posts()) :
		$output .= '';
		while ($query->have_posts()) : $query->the_post();
			$output .= '<div class="row recent-news"><div class="col-xs-2 news-item">';
			$output .= '' . (get_post_type() == 'auc_news' ? 'NEWS: ' : '') . '<date>' . get_the_date() . '</date></div><div class="col-xs-10"><p class="main"><a href="' . (get_post_type() == 'auc_news' ? get_field('news_url') : get_the_permalink()) . '">';
			$output .= get_the_title() . '</a></p></div></div>';
		endwhile;
		$output .= '<p class="main">&nbsp;</p>';
	endif;
	wp_reset_postdata();

	return $output;
}

add_shortcode('show_recent_pr', 'show_recent_pr');

function show_events_webinars ($atts, $content = null) {
	$output  = '';
	$counter = 0;
	$today   = date('Ymd');
	$query   = new WP_Query(
		array(
			'post_type'      => 'ferrotec_events',
			'meta_key'       => 'start_date',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
			'posts_per_page' => 2,
			'meta_query'     => array(
				array(
					'key'     => 'end_date',
					'compare' => '>=',
					'value'   => $today,
				)
			)
		)
	);
	if ($query->have_posts()) :
		$output .= '<h4>Events &amp; Webinars</h4>';
		$output .= '<ul class="upcoming-events">';
		while ($query->have_posts()) : $query->the_post();
			$startdateformatstring = "M d";
			$enddateformatstring   = "d, Y";
			$starttimestamp        = strtotime(get_field('start_date'));
			$endtimestamp          = strtotime(get_field('end_date'));
			if (date('m', $starttimestamp) != date('m', $endtimestamp)) {
				$startdateformatstring = " M d";
				$enddateformatstring   = "M d, Y";
			}
			if (date('Y', $starttimestamp) != date('Y', $endtimestamp)) {
				$startdateformatstring = "M d, Y";
				$enddateformatstring   = "M d, Y";
			}
			if ($starttimestamp == $endtimestamp) {
				$eventdateformatted = date_i18n("M d, Y", $endtimestamp);
			} else {
				$eventdateformatted = date_i18n($startdateformatstring, $starttimestamp) . " - " . date_i18n($enddateformatstring, $endtimestamp);
			}
			$counter ++;
			$output .= '<li class="event-item">';
			$output .= '<p>EVENT: <date>' . $eventdateformatted . '</date><br><a href="' . get_field('promotional_url') . '">';
			$output .= get_the_title() . '</a></p></li>';
		endwhile;
		$output .= '</ul>';
	endif;
	wp_reset_postdata();
	$query = new WP_Query(
		array(
			'post_type'      => 'ferrotec_resources',
			'posts_per_page' => 3 - $counter,
			'meta_key'       => 'category',
			'meta_value'     => 'webinar',
		)
	);
	if ($query->have_posts()) :
		$output .= '<ul class="upcoming-webinars">';
		while ($query->have_posts()) : $query->the_post();
			$output .= '<li class="webinar-item">';
			$output .= '<p>WEBINAR: <date>' . get_the_date() . '</date><br><a href="' . get_field('resource_url') . '">';
			$output .= get_the_title() . '</a></p></li>';
		endwhile;
		$output .= '</ul>';
	endif;
	wp_reset_postdata();

	return $output;
}

add_shortcode('show_events_and_webinars', 'show_events_webinars');

function show_resource_accordion ($atts, $content = null) {
	$field_key = "field_54d56916f101e";
	$field     = get_field_object($field_key);
	if ($field) {
		$terms = $field['choices'];
		if (isset($terms['analyst'])) {
			unset($terms['analyst']);
		}
	}
	$ids     = get_field('resource_links', false, false);
	$counter = 0;
	$output  = '';
	if ($ids) :

		ob_start(); ?>
		<h3>Resources</h3>
		<div class="panel-group" id="resources-accordion" role="tablist" aria-multiselectable="true">
			<?php foreach ($terms as $k => $v) :
				$resources = new WP_Query(array(
					'post_type'      => 'ferrotec_resources',
					'posts_per_page' => - 1,
					'meta_key'       => 'category',
					'meta_value'     => $k,
					'post__in'       => $ids,
				));
				if ($resources->have_posts()) :
					$counter ++;
					?>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading-<?php echo $k; ?>">
							<h4 class="panel-title"><a class="<?php echo($counter == 1 ? '' : 'collapsed'); ?>"
							                           data-toggle="collapse"
							                           data-parent="#resources-accordion"
							                           href="#<?php echo $k; ?>"
							                           aria-expanded="<?php echo($counter == 1 ? 'true' : 'false'); ?>"
							                           aria-controls="<?php echo $k ?>">
									<!--span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span--> <?php echo $v . 's' ?></a>
							</h4>
						</div>
						<div id="<?php echo $k ?>"
						     class="panel-collapse collapse <?php echo($counter == 1 ? 'in' : ''); ?>"
						     role="tabpanel"
						     aria-labeledby="heading-<?php echo $k ?>">
							<div class="panel-body">
								<ul class="resource-listing">
									<?php while ($resources->have_posts()) : $resources->the_post(); ?>
										<li>
											<?php if (get_field('gated')) : ?>
												<form action="<?php echo site_url('/register') ?>" method="post">
													<input type="hidden" name="res_id" value="<?php the_ID() ?>">
													<input type="hidden" name="res_name" value="<?php the_title(); ?>">
													<input type="hidden" name="res_type" value="<?php echo $k; ?>">
													<button type="submit"><?php the_title(); ?></button>
												</form>
											<?php else : ?>
												<?php if (in_array($k, array('webinar', 'video'))) : ?>
													<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
												<?php else : ?>
													<a href="<?php the_field('resource_url'); ?>"
													   target="_blank"><?php the_title(); ?></a>
												<?php endif ?>
											<?php endif ?>
										</li>
									<?php endwhile;
									wp_reset_query(); ?>
								</ul>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endif;

	return ob_get_clean();
}

add_shortcode('show_resource_accordion', 'show_resource_accordion');

class head_walker_nav_menu extends Walker_Nav_Menu {
	static $menu_name = '';

	// add classes to ul sub-menus
	function start_lvl (&$output, $depth = 0, $args = array()) {
		// depth dependent classes
		$indent        = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
		$display_depth = ($depth + 1); // because it counts the first submenu as 0
		$classes       = array(
			'sub-menu',
			($display_depth >= 2 ? 'sub-sub-menu' : 'dropdown-menu sub-menu-' . self::$menu_name),
			'menu-depth-' . $display_depth
		);
		$class_names   = implode(' ', $classes);
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// add main/sub classes to li's and links
	function start_el (&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
		if (0 == $depth) {
			self::$menu_name = custom_nav_menu_item_title($id, $item);
		}

		// depth dependent classes
		$menu_item_title   = custom_nav_menu_item_title($id, $item);
		$depth_classes     = array(
			($depth == 0 ? 'main-menu-item dropdown ' : 'sub-menu-item'),
			'menu-item-depth-' . $depth,
		);
		$depth_class_names = esc_attr(implode(' ', $depth_classes));

		// passed classes
		$classes     = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

		// build html
		$output .= $indent;
		$output .= '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// link attributes
		$attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes = ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= ( ! empty($item->url) && $item->url != '#') ? ' href="' . esc_attr($item->url) . '"' : '';
		$attributes .= ' class="menu-link ' . ($depth == 2 ? 'menu-item-icon' : '') . '"';

		$item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters('the_title', $item->title, $item->ID),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

}

class footer_walker_nav_menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	function start_lvl (&$output, $depth = 0, $args = array()) {
		// depth dependent classes
		$indent        = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
		$display_depth = ($depth + 1); // because it counts the first submenu as 0
		$classes       = array(
			'sub-menu',
			'menu-depth-' . $display_depth
		);
		$class_names   = implode(' ', $classes);
		// build html
		$output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}

	// add main/sub classes to li's and links
	function start_el (&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;
		$indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent

		// depth dependent classes
		$menu_item_title   = custom_nav_menu_item_title($id, $item);
		$depth_classes     = array(
			($depth == 0 ? 'col-sm-7ths' : 'sub-menu-item')
		);
		$depth_class_names = esc_attr(implode(' ', $depth_classes));

		// passed classes
		$classes     = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

		// build html
		$output .= $indent;
		$output .= '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';

		// link attributes
		$attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
		$attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
		$attributes .= ( ! empty($item->url) && $item->url != '#') ? ' href="' . esc_attr($item->url) . '"' : '';

		$item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters('the_title', $item->title, $item->ID),
			$args->link_after,
			$args->after
		);

		// build html
		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);

	}

}
class walker_mobile_nav_menu extends Walker_Nav_Menu {
	static $menu_name='';
	  
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
	    // depth dependent classes
	    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
	    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
	    $classes = array(
	        'sub-menu',
	        ( $display_depth >=2 ? 'sub-sub-menu' : 'dropdown-menu'. self::$menu_name ),
	        'menu-depth-' . $display_depth
	        );
	    $class_names = implode( ' ', $classes );
	    // build html
	    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
	}
  

}
function add_query_vars_filter( $vars ){
  $vars[] = "model";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

add_filter("gform_field_value_resource_id", "populate_resource_id");
function populate_resource_id ($value) {
	$res_id = sanitize_text_field($_REQUEST['res_id']);

	return $res_id;
}

add_filter("gform_field_value_resource_name", "populate_resource_name");
function populate_resource_name ($value) {
	$res_name = sanitize_text_field($_REQUEST['res_name']);

	return $res_name;
}

add_filter("gform_field_value_resource_type", "populate_resource_type");
function populate_resource_type ($value) {
	$res_type = sanitize_text_field($_REQUEST['res_type']);

	return $res_type;
}

/**
 * Display the post content. Optinally allows post ID to be passed
 *
 * @uses the_content()
 *
 * @param int $id                Optional. Post ID.
 * @param string $more_link_text Optional. Content for when there is more text.
 * @param bool $stripteaser      Optional. Strip teaser content before the more text. Default is false.
 */
function the_content_by_id ($post_id = 0, $more_link_text = null, $stripteaser = false) {
	global $post;
	$post = &get_post($post_id);
	setup_postdata($post, $more_link_text, $stripteaser);
	the_content();
	wp_reset_postdata($post);
}

/*function get_the_content_by_id ($post_id = 0, $more_link_text = null, $stripteaser = false) {
	global $post;
	$post = &get_post($post_id);
	setup_postdata($post, $more_link_text, $stripteaser);

	return get_the_content();
	wp_reset_postdata($post);
}
*/
add_filter('comment_form_defaults', 'remove_comment_form_allowed_tags');
function remove_comment_form_allowed_tags ($defaults) {

	$defaults['comment_notes_after'] = '';

	return $defaults;

}

function makeurls($s) {
  $s=str_replace("/","_",$s);
  $s=str_replace(" ","-",$s);
  $s=strtolower($s);
  return $s;	
}
function unmakeurls($s) {
  $s=str_replace("_","/",$s);
  $s=str_replace("-"," ",$s);
  return $s;	
}

function custom_rewrite_products () {
	add_rewrite_tag('%instruct%', '([^&]+)');
	add_rewrite_tag('%family%', '([^&]+)');
	add_rewrite_tag('%ambTemp%', '([^&]+)');
	add_rewrite_tag('%coldTemp%', '([^&]+)');
	add_rewrite_tag('%thermRes%', '([^&]+)');
	add_rewrite_tag('%heatTrans%', '([^&]+)');
	add_rewrite_tag('%multMod%', '([^&]+)');
	add_rewrite_tag('%id%', '([^&]+)');
}

add_action('init', 'custom_rewrite_products');
//include 'product_redirects.php';


function my_acf_format_value_for_api($value, $post_id, $field){
	return str_replace( ']]>', ']]>', apply_filters( 'the_content', $value) );
}
function my_on_init(){
	if(!is_admin()){
		remove_all_filters('acf/format_value_for_api/type=wysiwyg');
		add_filter('acf/format_value_for_api/type=wysiwyg', 'my_acf_format_value_for_api', 10, 3);
	}
}
add_action('init', 'my_on_init');

/**
 * @desc
 * removes protocol prefix from url
 * @param $url
 * @return mixed
 */
function removeProtocolPrefix($url) {
    $disallowed = array('http://', 'https://');
    foreach($disallowed as $d) {
        if(strpos($url, $d) === 0) {
            return str_replace($d, '', $url);
        }
    }
    return $url;
}

// Add specific CSS class by filter
add_filter( 'body_class', 'add_body_class' );
function add_body_class( $classes ) {
  global $post;
  $current_site = sanitize_title_with_dashes(get_bloginfo());
  $classes[] = $current_site;
	if ( is_page() && !$post->post_parent ) {
		$classes[]=$current_site."-".sanitize_title_with_dashes(get_the_title());
  }
	elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = sanitize_title_with_dashes(get_the_title($page->ID));
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) $classes[]=$current_site."-".$crumb;
      $classes[]=$current_site."-".sanitize_title_with_dashes(get_the_title());
    }
    return $classes;
}


require_once('includes/ferrotec_products.php');


function show_ferrofluid_family($atts, $content = null){
    $a = shortcode_atts( array(
        'family' => '',
    ), $atts );
	$output = '';
	$results = new fProducts;
	$pline_set_data = $results->get_ferrofluid_data( $a['family'] );
		if ($pline_set_data){
			$output .= '<div class="indent-lightgrey-bkg">';
			$output .= '<div class="table-responsive">';
			$output .= '<table class="ferrofluid-table table table-striped">';
			$output .= '<thead>';
			$output .= '<tr id="prodTableHead">';
			$output .= '  <th>Ferrofluid Type</th> ';
			$output .= '  <th>Gauss [CGS]</th> ';
			$output .= '  <th>mT [SI]</th> ';
			$output .= '  <th>cP [CGS]</th> ';
			$output .= '  <th>mPa-s [SI]</th> ';
			$output .= '</tr>';
			$output .= '</thead>';
			$output .= '<tbody>';
			foreach ($pline_set_data as $product ){
				if($product->model !== "APG 859"){ // discontinued item
				  $output .= '<tr class="ferrofluid-listing">';
				  $output .= '    <td><a href="'. makeurls($product->model) .'">'. $product->model .'</a></td>';
				  $output .= '    <td>'. $product->sat_Gauss .'</td>';
				  $output .= '    <td>'. $product->sat_mT .'</td>';
				  $output .= '    <td>'. $product->vis_cP .'</td>';
				  $output .= '    <td>'. $product->sat_mPa_s .'</td>';
				  $output .= '</tr>';
				}
			}
			$output .= '</tbody>';
			$output .= '</table>';
			$output .= '</div></div>';
		}
	return $output;
}
add_shortcode('show_ferrofluid', 'show_ferrofluid_family');

function show_thermalelectric_family($atts, $content = null){
    $a = shortcode_atts( array(
        'family' => '',
    ), $atts );
	$output = '';
	$results = new fProducts;
	$pline_set_data = $results->get_module_data( $a['family'] );
	$family_detail = $results->get_family_detail_data( $a['family'] );
		foreach ($family_detail as $family ){
			/*$output .= '<div style="overflow:auto">';
			if ($a['family'] != 14){
			$output .= '<img align=right valign=bottom src="/thermal-site/'. $family->photo1 .'">';
			$output .= '<div id=text_block_c>';
				$output .= '<p>';
				$output .= $family->stdDesc;
				$output .= '</p>';
				$output .= `<p>For questions about specific peltier coolers or to place an order, contact your Ferrotec thermal solutions representative or use the <a href="/products/thermal/modules/teInquiry/"><b>Thermal Solutions Inquiry Form.</b></a></p>`;
				$output .= '</div>';
			}
			$output .= '</div>';*/
			$output .= '<div id="list_display" class="table-responsive">';
			$output .= '<table id=listing class="tablesorter table table-striped" width="100%" border="0" cellpadding="0" cellspacing="0">';
			$output .= '<thead>';
			$header=array('Model Number','I Max','V Max','&Delta;T Max','Qc Max');
			switch($a['family'])
			{
			  case 3:
			  case 11:
			    $header=array_merge($header,array('W1 Dim','W2 Dim','L1 Dim','L2 Dim','Height'));
			    break;
			  case 1:
			  case 2:
			  case 8:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
			    break;
			  case 9:
			    $header=array_merge($header,array('W1 Dim','L1 Dim','L2 Dim','Height'));
			    break;
			  case 4:
			    $header=array_merge($header,array('W1 Dim','W2 Dim','W3 Dim','L1 Dim','L2 Dim','L3 Dim','Height'));
			    break;
			  case 5:
			    $header=array_merge($header,array('W1 Dim','L1 Dim','Height','Inner Diam'));
			    break;
			  case 6:
			    $header=array_merge($header,array('Height','Inner Diam','Outer Diam'));
			    break;
			  case 7:
			    $header=array_merge($header,array('W1 Dim','L1 Dim','Height'));
			    break;
			  case 10:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
			    break;
			  case 12:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
			    break;
			 case 13:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
			    break;
			  case 14:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
			    break;
			  case 15:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height','Type'));
			    break;
			  case 16:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height','Type'));
			    break;
			  case 17:
			    $header=array_merge($header,array('Base W','Base L','Top W','Top L','Height'));
			    break;
			  default:
			  break;
			}
			$output .= '<tr>';
			foreach($header as $th){
				$output .= '<th>'.$th.'</th>';
			}
			$output .= '</tr>';
			$output .= '</thead>';
			$output .= '<tbody>';
			foreach ($pline_set_data as $product ){
				$output .= '<tr>';

				$output .= '  <td class="te-cat-row link"><a href="'. makeurls($product->fullPN) .'">'. $product->fullPN .'</a></td>';
				$output .= '  <td>'. $product->iMax .'</td><td>'. $product->vMax .'</td><td>'. $product->tMax .'</td><td>'. $product->qcMax .'</td>';
				if ($a['family'] == 2 || $a['family'] == 1 || $a['family'] == 9) {
				  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->l2Dim .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 3 || $a['family'] == 11) {
				  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->w2Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->l2Dim .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 4) {
				  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->w2Dim .'</td><td>'. $product->w3Dim .'</td>';
				  $output .= '<td>'. $product->l1Dim .'</td><td>'. $product->l2Dim .'</td><td>'. $product->l3Dim .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 5) {
				  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->hDim .'</td><td>'. $product->idDim .'</td>';
				}
				if ($a['family'] == 6) {
				  $output .= '<td>'. $product->hDim .'</td><td>'. $product->idDim .'</td><td>'. $product->oDim .'</td>';
				}
				if ($a['family'] == 7) {
				  $output .= '<td>'. $product->w1Dim .'</td><td>'. $product->l1Dim .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 8) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 10) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 12) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 13) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 14) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
				}
				if ($a['family'] == 15) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td><td>'. $product->altDescription .'</td>';
				}
				if ($a['family'] == 16) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td><td>'. $product->altDescription .'</td>';
				}
				if ($a['family'] == 17) {
				  $output .= '<td>'. $product->baseW .'</td><td>'. $product->baseL .'</td><td>'. $product->topW .'</td><td>'. $product->topL .'</td><td>'. $product->hDim .'</td>';
				}
				$output .= '</tr>';
			}
			$output .= '</tbody>';
			$output .= '</table>';
			$output .= '</div>';
		}
		$output .= '<div id=disable_screen style="z-index:0;visibility:hidden;display:none;height:100%;width:100%;position:absolute;top:0;left:0;opacity:.50;background-color:#888888;filter:alpha(opacity=50)">';
		$output .= '</div>';
		$output .= '<div id=loading style="z-index:1;visibility:hidden;display:none;border-style:solid;opacity:1.0;padding:15px;position:absolute;text-align:center;background-color:#FFFFFF;width:250;height:60;font-size:24px;font-weight:700;line-height:24px">';
		$output .= 'Updating<br>';
		$output .= 'Recommendation';
		$output .= '</div>';		
	return $output;
}
add_shortcode('show_thermalelectric', 'show_thermalelectric_family');

function show_thermal_family($atts, $content = null){
    $a = shortcode_atts( array(
        'cat' => '',
    ), $atts );
    $args = array(
    	'post_type' => 'product',
    	'nopaging' => TRUE,
    	'tax_query' => array(
	      array(
	        'taxonomy' => 'product_cat',                //(string) - Taxonomy.
	        'field' => 'id',                    //(string) - Select taxonomy term by ('id' or 'slug')
	        'terms' => $a['cat'], 			   //(int/string/array) - Taxonomy term(s).
	        'include_children' => false,           //(bool) - Whether or not to include children for hierarchical taxonomies. Defaults to true.
	      )
	  )
    );
    $results = new WP_Query( $args );
    ob_start();

    if ( $results->have_posts() ) : 
?>

		<ul class="citations-wrapper">
		<?php
			while ( $results->have_posts() ) : $results->the_post();
				get_template_part( 'content', 'thermal' );
			endwhile;
		?>
		</ul>
		<?php
	else :
		get_template_part( 'content', 'none' );
	endif;
	
	$content = ob_get_clean();
	
	return $content;    

}
add_shortcode('show_thermal_family', 'show_thermal_family');


function show_vf_feedthroughs($atts, $content = null){
    $a = shortcode_atts( array(
        'family' => '',
    ), $atts );
	$output = '<form><div class="indent-lightgrey-bkg"><div class="feedthrough-sort"><div class="vf-catalog-rowhead"><h3>Select Imperial, metric, or both</h3></div><a href="#in" class="btn btn-default listingbutton" data-vals=1>Inches</a><a href="#mm" class="btn btn-default listingbutton" data-vals=0>Metric</a><a href="#both" class="btn btn-default listingbutton active" data-vals="all">Both</a></div><div class="row vf-catalog-colheads"><div class="col-sm-3"><div class="drop_title">Shaft Type</div><div class="drop_content"><select name="shaftType" class="formElement" id="shaftType"><option value="all">Select Shaft Type...</option><option value="1">Solid Shaft</option><option value="2">Hollow Shaft</option><option value="all">Show All Solid and Hollow options</option></select></div></div><div class="col-sm-3"><div class="drop_title">Mount Type</div><div class="drop_content"><select name="mount" id="mount" class="formElement"><option value="all">Select Mounting Type...</option><option value="8">Cartridge mount</option><option value="3,4,5,6,7,10">Flange mount</option><option value="1">Nose mount</option><option value="2">Nut mount</option><option value="9">Compliant</option><option value="all">Show All Mount options</option></select></div></div><div class="col-sm-3"><div class="drop_title">Environment</div><div class="drop_content"><select name="environment" class="formElement" id="environment"><option value="all">Filter by Environment</option><option value="2">Standard</option><option value="1">Reactive Gas</option><option value="all">Show All</option></select></div></div><div class="col-sm-3"><div class="drop_title">Temperature</div><div class="drop_content"><select name="temperature" id="temperature" class="formElement"><option value="all">Filter by Temperature</option><option value="0">Standard</option><option value="1">High-Temperature</option><option value="all">Show All</option></select></div></div></div></form><div class="table-responsive"><table id="listing" class="tablesorter table" width="100%" border="0" cellpadding="0" cellspacing="0"><thead><tr id="prodTableHead"><th>Appearance</th> <th>Model Number</th> <th>Part Number</th> <th>Shaft Type</th> <th>Shaft Dimension</th> <th>Mounting Type</th> <th>Fluid</th> </tr></thead><tbody>';
	$results = new fProducts;
     $pline_set_data = $results->get_vfproduct_data('all','all','all-all','all','all','all');
		foreach ($pline_set_data as $product ) {
			$output .= '<tr class="product-listing" style="background-color:white;" data-units="' . $product->unit . '" data-shaft="' . $product->fk_shaftID . '" data-mounting="' . $product->fk_mountingID . '" data-environment="' . $product->fk_fluidID . '" data-temperature="' . $product->f2 . '">';
			$output .= '<td><a href="/products/ferrofluidic-vacuum-rotary-feedthroughs/' . $product->pNum . '"><img src="/wp-content/uploads/sites/2/tmb-vf-' . $product->pNum . '.png" alt="Feedthrough Model ' . $product->mNum . ' (part number ' . $product->pNum . ') image" width="72" height="72" border="0" /></a></td>';
			$output .= '<td class="vf-cat-row link"><a href="/products/ferrofluidic-vacuum-rotary-feedthroughs/' . $product->pNum . '">' . $product->mNum . '</a></td>';
			$output .= '<td class="vf-cat-row">' . $product->pNum . '</td>';
			$output .= '<td class="vf-cat-row">' . $product->shaftTitle . '</td>';
			$units = ($product->unit == 0) ? 'mm' : 'in';
			$output .= '<td class="vf-cat-row">' . $product->d1 . $units . '</td>';
			$output .= '<td class="vf-cat-row">' . $product->mountingTitle . '</td>';
			$output .= '<td class="vf-cat-row">' . $product->fluidTitle . '</td>';
			$output .= '</tr>';
		}
		$output .= '</tbody></table></div></div></form>';		
	return $output;
}
add_shortcode('show_feedthroughs', 'show_vf_feedthroughs');

function menu_set_dropdown( $sorted_menu_items, $args ) {
    $last_top = 0;
    foreach ( $sorted_menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            $sorted_menu_items[$last_top]->classes['dropdown'] = 'dropdown';
        }
    }
    return $sorted_menu_items;
}
add_filter( 'wp_nav_menu_objects', 'menu_set_dropdown', 10, 2 );

function add_class_to_items_link( $atts, $item, $args ) {
  // check if the item has children
  $hasChildren = (in_array('menu-item-has-children', $item->classes) );
  if ($hasChildren) {
    // add the desired attributes:
    $atts['class'] = 'dropdown-toggle';
    $atts['data-toggle'] = 'dropdown';
    $atts['href'] = '#';
    $atts['data-target'] = $item->depth;
  }
  return $atts;
}
add_filter( 'nav_menu_link_attributes', 'add_class_to_items_link', 10, 3 );

function custom_woocommerce_is_purchasable( $purchasable, $product ){
    if( $product->get_price() == 0 ||  $product->get_price() == '')
        $purchasable = true;
    return $purchasable;
}
add_filter( 'woocommerce_is_purchasable', 'custom_woocommerce_is_purchasable', 10, 2 );


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );



function displayFamily($moduleFamily)
  {
    if($moduleFamily == 1){return "Miniature";}
    else if($moduleFamily == 2){return "Single Stage";}
    else if($moduleFamily == 3){return "Two Stage";}
    else if($moduleFamily == 4){return "Three Stage";}
    else if($moduleFamily == 5){return "Center Hole";}
    else if($moduleFamily == 6){return "Round";}
    else if($moduleFamily == 7){return "Multi-hole";}
    else if($moduleFamily == 8){return "High Power";}
    else if($moduleFamily == 9){return "Thin Film";}
    else if($moduleFamily == 10){return "70 Series";}
    else if($moduleFamily == 11){return "TMC Series";}
    else if($moduleFamily == 12){return "Telecom-Grade";}
    else if($moduleFamily == 13){return "Power Generation";}
    else if($moduleFamily == 14){return "General Purpose";}
    else if($moduleFamily == 15){return "Deep Cooling";}
    else if($moduleFamily == 16){return "Special Design";}
    else if($moduleFamily == 17){return "High Performance";}
  }
  
  // HIDES PERFORMANCE CHARTS FOR MULTI-STAGE
  function displayChart($displayChart)
  {
    if($moduleFamily == 1 || 2 || 3 || 4 || 5 || 6 || 7 || 8 || 9 || 10 || 11 || 12 || 13)
    {$displayChart = 0;}
    else
    {$displayChart = 1;}
  }
include 'functions-indexing.php';

/**
 * WordPress register with email only, make it possible to register with email 
 * as username in a multisite installation
 * @param  Array $result Result array of the wpmu_validate_user_signup-function
 * @return Array         Altered result array
 */
function custom_register_with_email($result) {
 
   if ( $result['user_name'] != '' && is_email( $result['user_name'] ) ) {
 
      unset( $result['errors']->errors['user_name'] );
 
   }
 
   return $result;
}
add_filter('wpmu_validate_user_signup','custom_register_with_email');
 
/**
 * Create the function to output the contents of your Dashboard Widget.
 */

function custom_dashboard_widget_content() {
     echo "<p>for multisite change wp_X_options and wp_blogs tables to new urls</p>";
}
add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
  #wpadminbar {
  background-color:green;
}
  </style>';
}
function wpexplorer_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'wpexplorer_dashboard_widget', // Widget slug.
		'Multisite DB migration:', // Title.
		'custom_dashboard_widget_content' // Display function.
	);
}
add_action( 'wp_dashboard_setup', 'wpexplorer_add_dashboard_widgets' );

function the_login_message( $message ) {
        return "<p>Welcome to Ferrotec. Please log in to continue</p>";
}
add_filter( 'login_message', 'the_login_message' );


/*    ------------------ */
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');

function my_login_logo_url() {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return 'Ferrotec';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function my_login_head() {
remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'my_login_head');

/**
* Gravity Forms Custom Activation Template
* http://gravitywiz.com/customizing-gravity-forms-user-registration-activation-page
*/
add_action('wp', 'custom_maybe_activate_user', 9);
function custom_maybe_activate_user() {

    $template_path = STYLESHEETPATH . '/gfur-activate-template/activate.php';
    $is_activate_page = isset( $_GET['page'] ) && $_GET['page'] == 'gf_activation';
    
    if( ! file_exists( $template_path ) || ! $is_activate_page  )
        return;
    
    require_once( $template_path );
    
    exit();
}

function tdrows($elements)
{
    $str = array();
    foreach ($elements as $element) {
    	if ( $element != "&nbsp;" )
        $str[] = $element->nodeValue;
    }
    $str = array_filter( $str );
    $str = implode("|", $str );
    return $str;
}

function convert_table( $contents )
{
    $DOM = new DOMDocument;
    $DOM->loadHTML($contents);
    $formatted = "";
    $items = $DOM->getElementsByTagName('tr');

    foreach ($items as $node) {
        $formatted .= strip_tags(tdrows($node->childNodes)) . " \n\r";
    }
    return $formatted;
}


add_action( 'gform_pre_submission_4', 'pre_submission_handler',11,2 );
function pre_submission_handler( $form ) {
	if ( get_current_blog_id() == 7 ){
	$_POST['input_24'] = convert_table( rgpost( 'input_24' ) ) . "Notes:\n\r" . rgpost( 'input_5');	
	}
    
}



function pippin_change_password_form() {
	global $post;	
		
   	if (is_singular()) :
   		$current_url = get_permalink($post->ID);
   	else :
   		$pageURL = 'http';
   		if ($_SERVER["HTTPS"] == "on") $pageURL .= "s";
   		$pageURL .= "://";
   		if ($_SERVER["SERVER_PORT"] != "80") $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
   		else $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
   		$current_url = $pageURL;
   	endif;		
	$redirect = $current_url;

	ob_start();
	
		// show any error messages after form submission
		pippin_show_error_messages(); ?>
		
		<?php if(isset($_GET['password-reset']) && $_GET['password-reset'] == 'true') { ?>
			<div class="pippin_message success">
				<span><?php _e('Password changed successfully', 'rcp'); ?></span>
			</div>
		<?php } ?>
		<div class="col-sm-6 col-sm-offset-3">
			<h3>Enter your new password</h3>
			<form id="pippin_password_form" method="POST" action="<?php echo $current_url; ?>" style="margin-bottom:15px;">
				<fieldset>
					<div class="form-group">
						<label class="sr-only" for="pippin_user_pass"><?php _e('New Password', 'rcp'); ?></label>
						<input name="pippin_user_pass" id="pippin_user_pass" class="form-control required" type="password" placeholder="New Password"/>
					</div>
					<div class="form-group">
						<label class="sr-only" for="pippin_user_pass_confirm"><?php _e('Password Confirm', 'rcp'); ?></label>
						<input name="pippin_user_pass_confirm" id="pippin_user_pass_confirm" class="form-control required" type="password" placeholder="Confirm Password" />
					</div>
					<div>
						<input type="hidden" name="pippin_action" value="reset-password"/>
						<input type="hidden" name="pippin_redirect" value="<?php echo $redirect; ?>"/>
						<input type="hidden" name="pippin_password_nonce" value="<?php echo wp_create_nonce('rcp-password-nonce'); ?>"/>
						<input class="pull-right" id="pippin_password_submit" type="submit" value="<?php _e('Change Password', 'pippin'); ?>"/>
					</div>
				</fieldset>
			</form>
		</div>
	<?php
	return ob_get_clean();	
}

// password reset form
function pippin_reset_password_form() {
	if(is_user_logged_in()) {
		return pippin_change_password_form();
	}
}
add_shortcode('password_form', 'pippin_reset_password_form');


function pippin_reset_password() {
	// reset a users password
	if(isset($_POST['pippin_action']) && $_POST['pippin_action'] == 'reset-password') {
		
		global $user_ID;
		
		if(!is_user_logged_in())
			return;
			
		if(wp_verify_nonce($_POST['pippin_password_nonce'], 'rcp-password-nonce')) {
			
			if($_POST['pippin_user_pass'] == '' || $_POST['pippin_user_pass_confirm'] == '') {
				// password(s) field empty
				pippin_errors()->add('password_empty', __('Please enter a password, and confirm it', 'pippin'));
			}
			if($_POST['pippin_user_pass'] != $_POST['pippin_user_pass_confirm']) {
				// passwords do not match
				pippin_errors()->add('password_mismatch', __('Passwords do not match', 'pippin'));
			}
			
			// retrieve all error messages, if any
			$errors = pippin_errors()->get_error_messages();
			
			if(empty($errors)) {
				// change the password here
				$user_data = array(
					'ID' => $user_ID,
					'user_pass' => $_POST['pippin_user_pass']
				);
				wp_update_user($user_data);
				// send password change email here (if WP doesn't)
				wp_redirect(add_query_arg('password-reset', 'true', $_POST['pippin_redirect']));
				exit;
			}
		}
	}	
}
add_action('init', 'pippin_reset_password');

if(!function_exists('pippin_show_error_messages')) {
	// displays error messages from form submissions
	function pippin_show_error_messages() {
		if($codes = pippin_errors()->get_error_codes()) {
			echo '<div class="pippin_message error">';
			    // Loop error codes and display errors
			   foreach($codes as $code){
			        $message = pippin_errors()->get_error_message($code);
			        echo '<span class="pippin_error"><strong>' . __('Error', 'rcp') . '</strong>: ' . $message . '</span><br/>';
			    }
			echo '</div>';
		}	
	}
}

if(!function_exists('pippin_errors')) { 
	// used for tracking error messages
	function pippin_errors(){
	    static $wp_error; // Will hold global variable safely
	    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
	}
}

add_filter( 'relevanssi_post_title_before_tokenize', 'rlv_index_product_titles', 10, 2 );
function rlv_index_product_titles( $content, $post ) {
	if ( get_current_blog_id() != 7 ){
			$nohyphenscontent = str_replace( array('-','/') , ' ', $content );
			$content          .= " " . $nohyphenscontent;
	}
	return $content;
}

add_action( 'pre_get_posts', 'change_vf_sort_order'); 
    function change_vf_sort_order($query){
        if( is_post_type_archive( 'product' ) && get_current_blog_id() == 2 && is_main_query() === true && $query->get( 'post_type' ) === 'product' ):
		    $meta_query = array(
		        'relation' => 'AND',
		        'size_clause' => array(
		            'key' => 'd1',
		            'type' => 'numeric'
		        ),
		        'partnumber_clause' => array(
		            'key' => 'pNum',
		            'type' => 'numeric'
		        ), 
		    );
		    $orderby = array( 
		        'meta_value_num' => 'ASC',
		        'partnumber_clause' => 'ASC',
		    );
           $query->set( 'meta_key', 'd1' );
           $query->set( 'meta_query', $meta_query );
           $query->set( 'orderby', $orderby );
        endif;    
    };
