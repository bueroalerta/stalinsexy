<div class="ss_footer">
	<div class="ss_footer_horse">
		<img src=<?php echo "\"" . get_template_directory_uri(); ?>/img/dala.png">
	</div>
	<div class="ss_footer_bubble">
		<p>Знаешь, почему тебе нравятся новые интимные? Потому что ты пидр. Вот почему.</p>
	</div>
</div>

<div class="min_container">
</div>

<div class="max_container" postid="post0">
	<div class="ss_review_toolbar">
		<span>Header</span>
		<div class="ss_review_toolbar_button halt_close">
			<img src=<?php echo "\"" . get_template_directory_uri(); ?>/img/close.png"/>
		</div>
<!--		
		<div class="ss_review_toolbar_button spacer">
		</div>
		<div class="ss_review_toolbar_button max">
			<img src=<?php echo "\"" . get_template_directory_uri() ?>/img/max.png"/>
		</div>
		<div class="ss_review_toolbar_button min">
			<img src=<?php echo "\"" . get_template_directory_uri() ?>/img/min.png"/>
		</div>
-->
	</div>
</div>

<?php
	/*	Goes in footer.php, just before the closing </body> tag.
		Example plugin use: insert PHP code that needs to run after
		everything else, at the bottom of the footer.
		Very commonly used to insert web statistics code,
		such as Google Analytics.
	*/
	wp_footer();
?>
</body>
</html>