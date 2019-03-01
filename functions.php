<?php
/**
 * madrigalinside functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package madrigalinside
 */

if ( ! function_exists( 'madrigalinside_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function madrigalinside_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on madrigalinside, use a find and replace
		 * to change 'madrigalinside' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'madrigalinside', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'madrigalinside' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'madrigalinside_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'madrigalinside_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function madrigalinside_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'madrigalinside_content_width', 640 );
}
add_action( 'after_setup_theme', 'madrigalinside_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function madrigalinside_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'madrigalinside' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'madrigalinside' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'News', 'madrigalinside' ),
		'id'            => 'mi-news-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'madrigalinside' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Events', 'madrigalinside' ),
		'id'            => 'mi-events-sidebar',
		'description'   => esc_html__( 'Add widgets here.', 'madrigalinside' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'madrigalinside_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function madrigalinside_scripts() {
	wp_enqueue_style( 'madrigalinside-style', get_stylesheet_uri() );

	wp_enqueue_script( 'madrigalinside-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'madrigalinside-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'madrigalinside_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// custom

function madrigalinside_newswidget_render($events = false, $limit = 5) {
	global $EventPost;
	if ($limit <= 0) {
		$limit = 5;
	}

	$query = null;
	$boilerplate;
	$ids = [];

	if ($events) {
		$more = 'Weitere Events anzeigen';
		$category_id = get_cat_ID( 'events' );
		$query = new WP_Query(array( 'category_name' => 'events', 'posts_per_page' => $limit ));
		$boilerplate = array(
			'container' => '
				<div class="event_loop" id="event_loop">%list%
				</div><!-- .events_loop -->',
			'item' => '
				<div class="event_item">
					<a href="%link%">
						%thumbnail%
						<h5>%title%</h5>
					</a>
					%cat%
					%excerpt%
					%date%
				</div><!-- .events_item -->'
		);
	} else {
		$more = 'Weitere News anzeigen';
		$category_id = get_cat_ID( 'news' );
		$query = new WP_Query(array( 'category_name' => 'news', 'posts_per_page' => $limit));
		$boilerplate = array(
			'container' => '
				<div class="news_loop" id="news_loop">%list%
				</div><!-- .news_loop -->',
			'item' => '
				<div class="news_item">
					<a href="%link%">
						%thumbnail%
						<h5>%title%</h5>
					</a>
					%cat%
					%excerpt%
				</div><!-- .news_item -->'
		);
	}



	if ($query->have_posts()) {

		$category_link = get_category_link( $category_id );

		$list = '';
		while ($query->have_posts()) {
			$query->the_post();
			$currentID = get_the_ID();
			array_push($ids, $currentID);
			$list .= str_replace(
					apply_filters('madrigalinside_news_item_scheme_entities', array(
						'%link%',
						'%thumbnail%',
						'%title%',
						'%cat%',
						'%excerpt%',
						'%date%'
		                	)), apply_filters('madrigalinside_news_item_scheme_values', array(
		            			'#post-' . $currentID,
		            			'',
		            			get_the_title(),
		            			'',
						'',
						$events? $EventPost->get_singledate($EventPost->retreive($currentID), '', null): ''
		            		)), $boilerplate['item']
				);
		}
		$widget = str_replace(
			apply_filters('madrigalinside_news_container_scheme_entities', array(
				'%list%'
			)), apply_filters('madrigalinside_news_container_scheme_values', array(
				$list
			)), $boilerplate['container']
		);
		echo $widget;
		echo '<a href="' . esc_url( $category_link ) . '" >' . $more . '</a>';
	}
	wp_reset_postdata();
	return $ids;
}

function madrigalinside_newsevents_render($news = [], $events = []) {
	$ids = array_unique(array_merge($news, $events));
	$query = new WP_Query(array('post__in' => $ids));
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		}
		$query->the_posts_navigation();
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
	wp_reset_postdata();
}



function madrigalinside_news_render() {
	global $EventPost;
	
	if (have_posts()) {
		$boilerplate = array('container' => '
				<div class="news_loop" id="news_loop">%list%
				</div><!-- .news_loop -->',
			'item' => '
				<div class="news_item">
					<a href="%news_link%">
						%news_thumbnail%
						<h5>%news_title%</h5>
					</a>
					%news_cat%
					%news_excerpt%
				</div><!-- .news_item -->');
		$list = '';
		while ( have_posts() ) {
			the_post();
			if (empty($EventPost->retreive(get_the_ID())->start)) {
				$list .= str_replace(
					apply_filters('madrigalinside_news_item_scheme_entities', array(
						'%news_link%',
						'%news_thumbnail%',
						'%news_title%',
						'%news_cat%',
						'%news_excerpt%'
		                	)), apply_filters('madrigalinside_news_item_scheme_values', array(
		            			'#post-' . get_the_ID(),
		            			'',
		            			get_the_title(),
		            			'',
						'',
		            		)), $boilerplate['item']
				);
			}
		}
		$news = str_replace(
			apply_filters('madrigalinside_news_container_scheme_entities', array(
				'%list%'
			)), apply_filters('madrigalinside_news_container_scheme_values', array(
				$list
			)), $boilerplate['container']
		);
		echo $news;
		// reset loop;
		rewind_posts();
	}
}

function madrigalinside_eventpost_settings($settings) {
	$settings['linksamepage'] = true;
	return $settings;
}

function madrigalinside_nav_breadcrumb() {
 
 $delimiter = '&raquo;';
 $home = 'Home'; 
 $before = '<span class="current-page">'; 
 $after = '</span>'; 
 
 if ( !is_home() && !is_front_page() || is_paged() ) {
 
 echo '<nav class="breadcrumb">Sie sind hier: ';
 
 global $post;
 $homeLink = get_bloginfo('url');
 echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
 
 if ( is_category()) {
 global $wp_query;
 $cat_obj = $wp_query->get_queried_object();
 $thisCat = $cat_obj->term_id;
 $thisCat = get_category($thisCat);
 $parentCat = get_category($thisCat->parent);
 if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
 echo $before . single_cat_title('', false) . $after;
 
 } elseif ( is_day() ) {
 echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
 echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
 echo $before . get_the_time('d') . $after;
 
 } elseif ( is_month() ) {
 echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
 echo $before . get_the_time('F') . $after;
 
 } elseif ( is_year() ) {
 echo $before . get_the_time('Y') . $after;
 
 } elseif ( is_single() && !is_attachment() ) {
 if ( get_post_type() != 'post' ) {
 $post_type = get_post_type_object(get_post_type());
 $slug = $post_type->rewrite;
 echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
 echo $before . get_the_title() . $after;
 } else {
 $cat = get_the_category(); $cat = $cat[0];
 echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
 echo $before . get_the_title() . $after;
 }
 
 } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
 $post_type = get_post_type_object(get_post_type());
 echo $before . $post_type->labels->singular_name . $after;
 

 } elseif ( is_attachment() ) {
 $parent = get_post($post->post_parent);
 $cat = get_the_category($parent->ID); $cat = $cat[0];
 echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
 echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
 echo $before . get_the_title() . $after;
 
 } elseif ( is_page() && !$post->post_parent ) {
 echo $before . get_the_title() . $after;
 
 } elseif ( is_page() && $post->post_parent ) {
 $parent_id = $post->post_parent;
 $breadcrumbs = array();
 while ($parent_id) {
 $page = get_page($parent_id);
 $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
 $parent_id = $page->post_parent;
 }
 $breadcrumbs = array_reverse($breadcrumbs);
 foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
 echo $before . get_the_title() . $after;
 
 } elseif ( is_search() ) {
 echo $before . 'Ergebnisse für Ihre Suche nach "' . get_search_query() . '"' . $after;
 
 } elseif ( is_tag() ) {
 echo $before . 'Beiträge mit dem Schlagwort "' . single_tag_title('', false) . '"' . $after;

 } elseif ( is_404() ) {
 echo $before . 'Fehler 404' . $after;
 }
 
 if ( get_query_var('paged') ) {
 if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
 echo ': ' . __('Seite') . ' ' . get_query_var('paged');
 if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
 }

function madrigalinside_set_post_views($postID) {
    $count_key = 'wpb_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
 
 echo '</nav>';
 
 } 
} 
