<?php
/**
 * Arras Theme Header
 *
 * Displays everything from begining to <div id="container">
 *
 * @package Arras
 *
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
		<?php if ( !file_exists(ABSPATH . 'favicon.ico') ) : ?>
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/images/favicon.ico" />
		<?php else: ?>
		<link rel="shortcut icon" href="<?php echo home_url() ?>/favicon.ico" />
		<?php endif; ?>

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
			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php if (arras_get_option( 'logo' ) != 0 ) :
				arras_add_custom_logo();
			else: ?>
				<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
			<?php endif; ?>
			</a>
		</div>
		<div class="sidebar headerwidgets">
			<ul class="xoxo">
				<?php if ( dynamic_sidebar('Header Widgets') ) ; ?>
			</ul>
		</div>
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
