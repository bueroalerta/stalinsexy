<?php
	include_once( get_template_directory() . '/common.php' );

	get_header();

?>

<div class="loading_wrap">
	<div class="box">Loading...</div>
</div>

<div class="ss_reviews_wrapper">
		<?
				echo GetPreviews();
		?>
</div>

<div class="ss_more">
	<div class="ss_temp">
		<div class="ss_more_button" catid="95, 2" postsloaded="0"><span>ДАЙ МНЕ ЕЩЁ</span></div>
	</div>
</div>

<?php 

//echo $bbb.GetPostPreviewHTML();
//echo GetPostAttrsByID( 691 ).GetPostPreviewHTML();

get_footer(); ?>