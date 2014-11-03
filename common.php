<?php

/*
 	This is the class containing description for the
	post preview, whether it is a feature article,
	or a generic post
*/
class SSPostPreview
{
	var $title;
	var $preview_text;
	var $category_id;
	var $category_name;
	var $image_url;
	var $permalink;
	var $postid;
	var $fulltextHTML;

	function __construct( $title, $preview_text, $category_id, $category_name, $image_url, $permalink, $postid, $AuxClasses )
	{
		$this->title = $title;
		$this->preview_text = $preview_text;
		$this->category_id = $category_id;
		$this->category_name = $category_name;
		$this->image_url = $image_url;
		$this->permalink = $permalink;
		$this->postid = $postid;
		$this->AuxClasses = $AuxClasses;
	}

	function setFullTextHTML( $fulltextHTML )
	{
		$this->fulltextHTML = $fulltextHTML;
	}

	function GetPostPreviewHTML()
	{
		$out = 	'<div class="ss_review_wrap ' . $this->AuxClasses . '" id="preview' . $this->postid .'" postid="' . $this->postid .
				'"><div class="ss_review_toolbar"><span>' . $this->title .'</span>' . 
				'<div class="ss_review_toolbar_button halt_close"><img src="' . get_template_directory_uri() .
				'/img/close.png" /></div>' .
				'<div class="ss_review_toolbar_button spacer"></div>' .
				'<div class="ss_review_toolbar_button max"><img src="' . get_template_directory_uri() .
				'/img/max.png" /></div>' .
				'<div class="ss_review_toolbar_button min"><img src="' . get_template_directory_uri() . 
				'/img/min.png" /></div>' .
				'</div><div class="ss_review_preview">' .
				'<img src="' . $this->image_url . '" />' .
				'<p>' . '<a href=?cat=' . $this->category_id . '><p class="ss_review_preview_cat"><b>' .
				$this->category_name . '</b></p></a>' .
				'<a href="' . $this->permalink . '"><p class="ss_review_preview_title"><b>' . $this->title . '</b></p>' .
				'<p class="ss_review_preview_text">' . $this->preview_text . '</a></p></div></div>';
		return $out;
	}

	function GetMazimizedPostHTML()
	{
		$out = 	'<div class="ss_review scrollable"><span class="ss_review_title">' .
				$this->title . '</span><p>' . $this->fulltextHTML . '</p></div>';
		return $out;
	}
}

function GetPostByID( $PostID, $GetHTML = false )
{
	$needed_post = get_post( $PostID, ARRAY_A);

	$title = $needed_post[ 'post_title' ];
	$categories = wp_get_post_categories( $PostID );
	$cat = get_category( $categories[ 0 ] );

	$category_name = $cat->name;
	$category_id = $cat->term_id;

	$permalink = $needed_post[ 'guid' ];
  	$image_url = wp_get_attachment_image_src(
  						get_post_thumbnail_id( $PostID ),
  						'single-post-thumbnail' );
  	$preview_text = nl2br( strip_tags( substr( 	$needed_post[ 'post_content' ], 0,
  												strpos( $needed_post[ 'post_content' ], '<!--more' ) ) ) );
  	//$preview_text = $needed_post[ 'post_content' ];

	$size_values =  get_post_meta( $PostID, 'size', false );
	foreach ( $size_values as $size ) {
		$AuxClasses = $AuxClasses . ' ' . $size;
	}

	$to_ret = new SSPostPreview( 	$title, $preview_text, $category_id,
  								$category_name, $image_url[ 0 ], $permalink,
  								$PostID, $AuxClasses );
	if( $GetHTML )
		$to_ret->setFullTextHTML( nl2br( $needed_post[ 'post_content' ] ) );

	return $to_ret;
/*
  	$title = get_the_title( $PostID );
  	$preview_text = nl2br( strip_tags( get_the_content( '' ) ) );
  	$category = get_the_category( $post->ID );
  	$category_name = $category[ 0 ]->name;
  	$image_url = wp_get_attachment_image_src(
  						get_post_thumbnail_id( $post->ID ),
  						'single-post-thumbnail' );
  	$permalink = get_permalink( $post->ID );

		$post_obj = new SSPostPreview( 	$title, $preview_text, $category[ 0 ]->cat_ID,
  									$category_name, $image_url[ 0 ], $permalink, $post->ID );
*/
}

function GetPreviews( $Offset = 0, $PostsPerPage = 24, $Categories = '95, 2', $AuxClasses = '' )
{
	$publish_flag = false;
	$HTMLResult = "";

	$Reviews = [];

	// Let's get many posts and see what we can do
	$args = array( 	'posts_per_page' => $PostsPerPage,
					'offset' => $Offset,
					'orderby' => 'date',
					'order' => 'desc',
					'category' => $Categories );

	$ss_posts = get_posts( $args );
	foreach ( $ss_posts as $post ) : 
		setup_postdata( $post );

	  	$title =  $post->post_title;
	  	$preview_text = nl2br( strip_tags( get_the_content( '' ) ) );
	  	$category = get_the_category( $post->ID );
	  	$category_name = $category[ 0 ]->name;
	  	$image_url = wp_get_attachment_image_src(
	  						get_post_thumbnail_id( $post->ID ),
	  						'single-post-thumbnail' );
	  	$permalink = get_permalink( $post->ID );

  		$size_values =  get_post_meta( $post->ID, 'size', false );
  		foreach ( $size_values as $size ) {
    		$AuxClasses = $AuxClasses . ' ' . $size;
  		}

  		$post_obj = new SSPostPreview( 	$title, $preview_text, $category[ 0 ]->cat_ID,
	  									$category_name, $image_url[ 0 ], $permalink, $post->ID, $AuxClasses );

	  	// Each time we have to check if it's the right time to publish the previews
//	  	if( $HTMLResult == "" ) // let's initialize
//	  		$HTMLResult = '<div class="ss_reviews_columns ' . $AuxClasses . '">';

  		$HTMLResult = $HTMLResult . $post_obj->GetPostPreviewHTML();

  		$AuxClasses = "";
	endforeach; 
	wp_reset_postdata();

//	if( $HTMLResult != "" ) // let's finalize
//		$HTMLResult = $HTMLResult . '</div>';

	return $HTMLResult;
}

?>