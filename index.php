<?php
/**
 * @package WordPress
 * @subpackage sudo
 * @since sudo v3.0
 * 
 * IMPORTANT: This theme does not comply with WordPress themes requirements 2016-01-15
 */?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<?php if ( is_paged () || is_archive() || is_search() ) : ?>
		<meta name="robots" content="noindex,follow" />
	<?php endif ?>
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body>
<header>

<?php if ( is_home() || is_archive() || is_search() ) : ?>

	<h1 class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?>: <?php bloginfo( 'description' ); ?></a>
	</h1>

<?php else: ?>

	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?>: <?php bloginfo( 'description' ); ?></a>

<?php endif; ?>

</header>

<?php if ( is_home() || is_archive() || is_search() ) : ?>

<?php foreach(posts_by_year() as $year => $posts) : ?>

<h2 class="archive-year"><?php echo $year; ?></h2>

<ul class="archive">

<?php foreach($posts as $post) : setup_postdata($post); ?>

	<li>

		<a href="<?php esc_url( the_permalink() ); ?>" title="<?php echo ( get_the_title() ); ?>"><?php the_title(); ?></a>

	</li>

<?php endforeach; ?>

</ul>

<?php endforeach; ?>

<?php endif; ?>

<?php if ( is_single() ) : ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<article>

	<header>

		<time class="article-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php the_time( 'F d, Y' ) ?></time>

		<?php edit_post_link( 'Editar' ); ?>

		<h1><?php the_title(); ?></h1>

		<?php comments_popup_link( 'Comentar', '1 comentario', '% comentarios' ); ?>

	</header>

	<?php the_content(); ?>

</article>

<?php comments_template(); ?>

<?php endwhile; endif; ?>

<?php endif ?>

<?php if ( is_404() ) : ?>

<h2>404</h2>

<?php endif; ?>

<footer>

	<p class="copyright">Copyright <?php echo date('Y') ?> <?php bloginfo( 'name' ); ?></p>

	<a class="go-top" href="#" title="Ir arriba">Ir arriba</a>

</footer>

<?php wp_enqueue_script( 'prism', get_template_directory_uri() . '/prism.js', '', '0.0.1' ); ?>

<?php wp_footer(); ?>

</body>
</html>