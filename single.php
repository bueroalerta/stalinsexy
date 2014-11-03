<?php
	/*
 	* The Template for displaying all single posts
 	*/

 	// Construct the header
	get_header();
?>

<?php
	// Start the Loop.
	while ( have_posts() ) : the_post();

		/*
		 * Include the post format-specific template for the content. If you want to
		 * use this in a child theme, then include a file called called content-___.php
		 * (where ___ is the post format) and that will be used instead.
		 */
		echo "<div class=\"ss_review\">";
		echo "<span class=\"ss_review_title\">" . get_the_title() . "</span>";
		the_content( '' );

		//echo "<p class=\"ss_review_text\">" . nl2br( strip_tags( get_the_content( '' ), "<img><a><p>" ) ) . "</p>";
		/*
		echo "<p class=\"ss_review_text\">";
		the_content( '' );
		echo "</p>";
		*/
		echo "</div>";

		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}

	endwhile;
?>

<?php
	get_footer();
?>