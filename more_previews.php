<?php
	include_once( '../../../wp-load.php' );
	include_once( './common.php' );

	if( isset( $_GET[ 'offset' ] )
		&& isset( $_GET[ 'per_page' ] )
		&& isset( $_GET[ 'categories' ] ) 
	)
	{ 
		echo GetPreviews( $_GET[ 'offset' ], $_GET[ 'per_page' ], $_GET[ 'categories' ], 'new_block' );
	}
	else{
		echo "";
	}

	if( isset( $_GET[ 'get_post_preview' ] ) )
	{ 
		echo GetPostByID( $_GET[ 'get_post_preview' ] )->GetPostPreviewHTML();
	}
	else{
		echo "";
	}

	if( isset( $_GET[ 'get_post_maximized' ] ) )
	{ 
		echo GetPostByID( $_GET[ 'get_post_maximized' ], true )->GetMazimizedPostHTML();
	}
	else{
		echo "";
	}	
?>