<!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://ogp.me/ns#">

<head>

	<meta charset="<?php bloginfo( 'charset' ); // lets you change the charset from within wp, defaults to UTF8 ?>" />
	
	<!--Forces latest IE rendering engine & chrome frame-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="author" content="Krzysztof Urbański Web Developer" />
	<!-- title & meta handled by the yoast plugin, don't add your own here just activate the plugin -->

	<title><?php wp_title('&#124;', true, 'right'); ?><?php bloginfo('name'); ?> | <?php bloginfo( 'description' ); ?></title>
	
	<!-- favicon & other link Tags -->
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/images/custom_icon.png"/><!-- 114x114 icon for iphones and ipads -->
	<link rel="copyright" href="#copyright" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/style.css" />

	<!-- BEGIN: IE Specific Hacks -->
	<!--[if IE 8]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/ie8.css" media="screen" /><![endif]-->
	<!--[if IE 7]><link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/styles/ie7.css" media="screen" /><![endif]-->
	<!--END: IE Specific Hacks-->
	
	<!--REMOVE this viewport code if you are making a site that is NOT responsive-->
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
 	<!--REMOVE this viewport code if you are making a site that is NOT responsive-->
	
	<?php wp_head(); // wp_head hook for Plugins ~ always keep this just before the /head tag ?>

	<!--SCRIPTS-->
		<script type="text/JavaScript" src="<?php bloginfo('template_url'); ?>/scripts/modernizr.custom.js"></script>
		<script type="text/JavaScript" src="<?php bloginfo('template_url'); ?>/scripts/jquery.easing.1.3.min.js"></script>
		<script type="text/JavaScript" src="<?php bloginfo('template_url'); ?>/scripts/jquery.nicescroll.min.js"></script>
		<script type="text/JavaScript" src="<?php bloginfo('template_url'); ?>/scripts/functions.js"></script>
	<script type="text/javascript">
</script>
</head>

<!--see http://www.mimoymima.com/2010/03/lab/wordpress-body-tag/-->
