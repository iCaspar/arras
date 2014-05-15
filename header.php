<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php wp_title( '' ); ?></title>

		<?php if ( ! class_exists('All_in_One_SEO_Pack') && ! class_exists('Platinum_SEO_Pack') ) : ?>
			<meta name="description" content="<?php if ( is_single() ) {
        single_post_title('', true);
    	} else {
        bloginfo('name'); echo " - "; bloginfo('description');
    	} ?>" />
	  <?php endif; ?>

		<?php if ( is_search() || is_author() ) : ?>
			<meta name="robots" content="noindex, nofollow" />
		<?php endif ?>

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

		<?php if ( !file_exists(ABSPATH . 'favicon.ico') ) : ?>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico" />
		<?php else: ?>
			<link rel="shortcut icon" href="<?php echo home_url() ?>/favicon.ico" />
		<?php endif; ?>

		<meta name="viewport" content="width=1000" />

		<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />

		<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>> 

	<?php arras_above_top_menu(); ?>	
	
	<?php if( wp_nav_menu( array( 'echo' => false, 'theme_location' => 'top-menu', 'fallback_cb' => '' ) ) ): ?>
	<nav id="top-menu" class="clearfix">
	<?php	wp_nav_menu( array( 
			'sort_column' => 'menu_order', 
			'container_id' => 'top-menu-content', 
			'theme_location' => 'top-menu',
			'menu_class' => 'sf-menu menu clearfix',
			'fallback_cb' => ''
			)
		); ?>
	</nav>
	<?php endif; ?>

	<?php arras_below_top_menu(); ?>

<header id="header">
	<div id="branding" class="clearfix">
	<div class="logo">
		<?php if ( is_home() || is_front_page() ) : ?>
		<h1 class="blog-name"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2 class="blog-description"><?php bloginfo('description'); ?></h2>
		<?php else: ?>
		<span class="blog-name"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></span>
		<span class="blog-description"><?php bloginfo('description'); ?></span>
		<?php endif ?>
	</div>
	<div id="searchbar"><?php get_search_form() ?></div>
	</div><!-- #branding -->
</header><!-- #header -->

<?php arras_above_nav() ?>
<nav id="nav">
	<div id="nav-content" class="clearfix">
	<?php 
	if ( function_exists('wp_nav_menu') ) {
		wp_nav_menu( array( 
			'sort_column' => 'menu_order', 
			'menu_class' => 'sf-menu menu clearfix', 
			'theme_location' => 'main-menu', 
			'fallback_cb' => 'arras_nav_fallback_cb' 
		) );
	}
	arras_beside_nav(); 
	?>
	</div><!-- #nav-content -->
</nav><!-- #nav -->
<?php arras_below_nav() ?>

<div id="wrapper">
	
	<?php arras_above_main() ?>
  
	<div id="main" class="clearfix">
    <div id="container" class="clearfix">
