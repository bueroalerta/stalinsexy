<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href=<?php echo "\"" . get_template_directory_uri() ?>/lib/bootstrap.3.2.0.css"/>
	<link rel="stylesheet" href=<?php echo "\"" . get_template_directory_uri() ?>/css/stalin.css" type="text/css"/>

	<script src=<?php echo "\"" . get_template_directory_uri() ?>/jquery/jquery.js" type="text/Javascript"></script>
	<script src=<?php echo "\"" . get_template_directory_uri() ?>/lib/jquery.masonry.min.js" type="text/javascript"></script>
	<script src=<?php echo "\"" . get_template_directory_uri() ?>/lib/waitforimages.js" type="text/Javascript"></script>
	<script src=<?php echo "\"" . get_template_directory_uri() ?>/js/stalin.js" type="text/Javascript"></script>

	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'/>
	<link href='http://fonts.googleapis.com/css?family=Arimo&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=VT323' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Ubuntu+Mono&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<title><?php echo get_bloginfo( "name" ) . " | " . get_bloginfo( "description" ); ?></title>
	<?php 
	    /* Always have wp_head() just before the closing </head>
	     * tag of your theme, or you will break many plugins, which
	     * generally use this hook to add elements to <head> such
	     * as styles, scripts, and meta tags.
	     */
	    wp_head();
	 ?>
</head>

<body>

<div class="ss_header">
	<a href="/"><img src=<?php echo "\"" . get_template_directory_uri() ?>/img/mustache.png"/></a>
<!--	
	<div class="ss_logo" data-text="stalin.sexy"><a href="/">stalin.sexy</a></div>
	</div>
-->
</div>