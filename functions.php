<?php
/**
 * @package WordPress
 * @subpackage sudo
 * @since sudo v3.0
 */

	// theme setup
	function sudo_setup() {
		add_theme_support( 'automatic-feed-links' );
	}
	add_action( 'after_setup_theme', 'sudo_setup' );

	// enqueue styles and scripts
	function sudo_scripts_styles() {

		// comment response
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

		wp_enqueue_style( 'sudo-style', get_stylesheet_uri(), array(), '20160115' );

	}
	add_action( 'wp_enqueue_scripts', 'sudo_scripts_styles' );

	// page title
	function sudo_wp_title( $title, $sep ) {
		global $paged, $page;

		if ( is_feed() )
			return $title;

		$title .= get_bloginfo( 'name' );

		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";

		// add a page number when needed
		if ( $paged >= 2 || $page >= 2 )
			$title = "$title $sep página " . max( $paged, $page );

		return $title;
	}

	add_filter( 'wp_title', 'sudo_wp_title', 10, 2 );

	// clean up the <head>
	function removeHeadLinks() {
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'wp_generator');
	}
	add_action('init', 'removeHeadLinks');

	// remove wp version
	add_filter( 'the_generator', '__return_null' );

	// Group posts by year
	// Taken from: https://wordpress.org/support/topic/list-all-posts-on-a-page-split-them-by-year
	function posts_by_year() {
	  $years = array();
	  $posts = get_posts(array(
	    'numberposts' => -1,
	    'orderby' => 'post_date',
	    'order' => 'DESC',
	    'post_type' => 'post',
	    'post_status' => 'publish'
	  ));

	  foreach($posts as $post) {
	    $years[date('Y', strtotime($post->post_date))][] = $post;
	  }

	  krsort($years);

	  return $years;
	}

	// custom comment list markup
	function comment_markup($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
	?>
		<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
			<div class="comment-meta">
				<strong class="comment-author"><?php echo get_comment_author_link(); ?></strong>
		<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation">En espera de moderación.</em>
		<?php endif; ?>

				<a class="comment-date" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><?php echo human_time_diff( get_comment_date('U'), current_time('timestamp') ); ?> atrás</a>
			</div>
		<?php if ($comment->comment_parent != '0') : ?>
		<span class="mention"><span class="at">@</span><a href="<?php $commentparent = get_comment($comment->comment_parent); $commentparentpage = get_page_of_comment($commentparent) ; echo htmlspecialchars( get_comment_link( $commentparent, array('page' => $commentparentpage) ) ) ?>"><?php echo $commentparent->comment_author; ?></a></span>
		<?php endif; ?>
		<?php comment_text(); ?>
		<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		<?php edit_comment_link( 'Editar', '', '' ); ?>

		<?php if ( 'div' != $args['style'] ) : ?>

		</div>
		<?php endif; ?>
	<?php
	}

?>