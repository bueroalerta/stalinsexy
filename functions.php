<?php
	add_theme_support( 'post-thumbnails' );

	function StalinCustomComment($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		$says = [ 'говорит', 'пишет', 'пукает' ];

		extract($args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}

		echo '<' . $tag . ' ';
		comment_class( empty( $args['has_children'] ) ? '' : 'parent' );
		echo ' id="comment-' . comment_ID() . '">';
		if( $args['style'] != 'div' )
			echo '<div id="div-comment-' . comment_ID() . '" class="comment-body">';
		echo '<div class="comment-author vcard">';
		if ( $args['avatar_size'] != 0 )
			echo get_avatar( $comment, $args['avatar_size'] );

		printf( __( '<cite class="fn">%s</cite>' ), get_comment_author_link() );
		if( count( $says ) ) {
			$rand_says = rand( 0, count( $says ) - 1 );
			echo '<span class="says"> ' . $says[ $rand_says ] . ':</span>';
		}
		else {
			echo '<span class="says"> говорит:</span>';	
		}
		echo '</div>'; // <div class="comment-author vcard">

		if ( $comment->comment_approved == '0' ){
			echo '<em class="comment-awaiting-moderation">Твой коммент на модерации, мудила!</em><br/>';	
		}

		echo 	'<div class="comment-meta commentmetadata"><a href="' .
				htmlspecialchars( get_comment_link( $comment->comment_ID ) ) . '">';
		printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() );
		echo '</a>';
		edit_comment_link( __( 'хочу исправить!' ), '  ', '' );
		echo '</div>';
		comment_text();
		echo '<div class="reply">';
		comment_reply_link( array_merge( $args, array( 	'add_below' => $add_below,
														'depth' => $depth,
														'max_depth' => $args['max_depth'] ) ) );
		echo  '</div>'; // <div class="reply">
		if ( $args['style'] != 'div' )
			echo '</div>'; // <div class="comment-body">
	}

?>
