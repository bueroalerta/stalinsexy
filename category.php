<?php
	include_once( get_template_directory() . '/common.php' );

	get_header();
?>

<h1>
	<?php
		single_cat_title( '', false );
	?>
</h1>

<div class="ss_reviews_wrapper">
<?php
	echo GetPreviews( 0, 24, get_query_var('cat') );
?>
</div>

<div class="ss_more">
	<div class="ss_temp">
		<div class="ss_more_button" catid=<?php echo "\"" + get_query_var('cat') + "\"" ?> ><span>ДАЙ МНЕ ЕЩЁ</span></div>
	</div>
</div>

<div class="loading_wrap">
	<div class="box">Loading...</div>
</div>

<?php
	get_footer();
?>