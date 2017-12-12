<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>" charset="<?php bloginfo('charset'); ?>" />

<?php if ( is_search() || is_author() ) : ?>
<meta name="robots" content="noindex, nofollow" />
<?php endif ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<meta name="viewport" content="width=device-width" />

<?php
wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish/superfish.js', array( 'jquery' ), '2011-12-01' );
wp_enqueue_script( 'hoverIntent', get_template_directory_uri() . '/js/superfish/hoverIntent.js', array( 'jquery' ), '2011-12-01' );

if ( is_singular() ) {
	wp_enqueue_script('comment-reply');
	wp_enqueue_script('jquery-validate', get_template_directory_uri() . '/js/jquery.validate.min.js', array( 'jquery' ), null, false);
}

?>

<?php wp_head(); ?>
</head>

<body <?php arras_body_class() ?>>
<script type="text/javascript">
//<![CDATA[
(function(){
var c = document.body.className;
c = c.replace(/no-js/, 'js');
document.body.className = c;
})();
//]]>
</script>
<?php arras_body() ?>

<?php if ( has_nav_menu('top-menu' ) ): ?>
<div id="top-menu" class="secondary-nav">
<?php arras_above_top_menu() ?>
	<?php wp_nav_menu( array(
			'sort_column' => 'menu_order', 
			'menu_class' => 'sf-menu menu clearfix', 
			'theme_location' => 'top-menu',
			'container' => 'nav',
			'fallback_cb' => false
		) ); ?>
<?php arras_below_top_menu() ?>
</div>
<?php endif; ?>

<div id="header" class="page-header">
	<div id="branding" class="site-banner">
	<div class="logo">
        <?php the_custom_logo(); ?>
        <?php if ( is_home() || is_front_page() ) : ?>
		<h1 class="blog-name"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
		<h2 class="blog-description"><?php bloginfo('description'); ?></h2>
		<?php else: ?>
		<span class="blog-name"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></span>
		<span class="blog-description"><?php bloginfo('description'); ?></span>
		<?php endif ?>
	</div>
	<div id="searchbar"><?php get_search_form() ?></div>
	</div>
</div>

<?php arras_above_nav() ?>
<div id="nav" class="primary-nav">
	<div id="main-nav-wrap" class="main-nav-wrap">
	<?php wp_nav_menu( array(
			'sort_column' => 'menu_order', 
			'menu_class' => 'sf-menu menu clearfix', 
			'theme_location' => 'main-menu',
			'container' => 'nav',
			'fallback_cb' => 'arras_nav_fallback_cb' 
		) );
	arras_beside_nav(); ?>
	</div>
</div>
<?php arras_below_nav() ?>

<div id="wrapper" class="wrap">
	
	<?php arras_above_main() ?>
  
	<div id="main" class="main">
    <div id="container" class="primary-content-container">
