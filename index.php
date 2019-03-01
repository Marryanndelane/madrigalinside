<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package madrigalinside
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;
			?>
			<div id="news" class="news">
				<div class="headline">News</div>
				<?php $mi_news = madrigalinside_newswidget_render(); ?>
			</div>
			<div id="events" class="events">
				<div class="headline">Events</div>
				<?php $mi_events = madrigalinside_newswidget_render(true); ?>
			</div>
			<?php
			madrigalinside_newsevents_render($mi_news, $mi_events);
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
