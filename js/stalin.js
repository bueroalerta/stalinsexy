var path_to_theme = "/wp-content/themes/stalincustom/";

var images_loaded_dom_ready = false;

var mobile_device = false;

/** Function count the occurrences of substring in a string;
 * @param {String} string   Required. The string;
 * @param {String} subString    Required. The string to search for;
 * @param {Boolean} allowOverlapping    Optional. Default: false;
 */
function occurrences(string, subString, allowOverlapping){

    string+=""; subString+="";
    if(subString.length<=0) return string.length+1;

    var n=0, pos=0;
    var step=(allowOverlapping)?(1):(subString.length);

    while(true){
        pos=string.indexOf(subString,pos);
        if(pos>=0){ n++; pos+=step; } else break;
    }
    return(n);
}

function remove_loading_wrap( $container ){
	$('.loading_wrap').fadeOut( 1500, function(){
		$container.css( 'z-index', 0 );
	});
}

function scrollpos() { 
return { 
	'x': window.pageXOffset ? window.pageXOffset : document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft,
	'y': window.pageYOffset ? window.pageYOffset : document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop 
}};

function fix_the_horse_bubble(){
	var frame_size = parseInt( $(".ss_footer_bubble").css("width"), 10 );
	// The math: for the 734px the right font size is 3em;
	$(".ss_footer_bubble p").css( "font-size", ( frame_size / 734 ) * 2 + "em" );

	var horse_height = parseInt( $(".ss_footer_horse img").css("height"), 10 );
	$(".ss_footer_bubble").css( "min-height", horse_height * 2 / 3 + "px" );

	var quote_size = parseInt( $(".ss_footer_bubble p").css("height"), 10 );
	if( quote_size < horse_height * 2 / 3 )
		$(".ss_footer_bubble p").css( "margin-top", ( (horse_height * 2 / 3 - quote_size ) /2.4 ) + "px" );
}

function bind_button_events( $masonry_container ){
    // The "CLOSE" button thing
    $('.ss_reviews_wrapper .halt_close').click( function(){
    	var $to_close = $(this).parent().parent();
    	$to_close.fadeOut( '200', function(){
    		$to_close.remove();
    		$masonry_container.masonry('reload');
    	});
    });

    // The "MAXIMIZE" button thing
    $('.ss_reviews_wrapper .max').click( function(){
    	var $title_to_copy = $(this).parent().find( 'span' ).text();
    	var $to_fade = $(this).parent().parent();
    	var $get_color_from = $(this).parent().parent().find( '.ss_review_preview' );

    	$('.max_container').css( 'background-color', $get_color_from.css( 'background-color' ) );
    	$('.max_container').attr( 'postid', $to_fade.attr( 'id' ) );
    	$('.max_container .ss_review_toolbar span').text( $title_to_copy );

    	$to_fade.fadeOut( 300, function(){
    		$('.max_container').fadeIn( 300 );
    	});

    	// Alright, at this point we have the maximized empty window. Let's call ajax
    	postid = $('.max_container').attr( 'postid' ).match(/\d+$/)[0];

		$.ajax({
			url: path_to_theme + 'more_previews.php',
			//type: "GET",
			dataType: 'html',
			data: "get_post_maximized=" + postid,
			success: function(data){
				if( data == "" )
				{
					//todo: try to make it gently
					alert( "no data!" );
				}
				else
				{
					$(".max_container").append( data );
				}
			},
	    	error: function( xhr, status, errorThrown )
		    {
		    	//todo: try to make it gently
		    	alert( "error!" );
		    }
		});
    });

    // The "MINIMIZE" button thing
    $('.ss_reviews_wrapper .min').click( function(){
    	var $to_min = $(this).parent().parent();

    	// Let's get the title
		var title = $(this).parent().find('span').text();
		var postid = $to_min.attr( 'postid' );

		$to_min.css( 'width', 150 );
    	$to_min.find( '.ss_review_preview' ).slideUp( 400 );
    	$to_min.find( '.ss_review_toolbar_button' ).fadeOut( 400 );	 	


    	var where_to = ( scrollpos().y + $(window).height() - $('.ss_reviews_wrapper').offset().top - 40 ) + 'px';

    	$to_min.animate({left:'0px', top: where_to}, function(){
    		//setTimeout( function(){
    			$to_min.remove();
				$('.min_container').append( '<div class="ss_min_wrap" id="post' + postid
					+ '" postid="' + postid
					+ '"><div class="ss_review_toolbar"><span>'
					+ title + '</span>' + '</div></div>' );
    			$masonry_container.masonry('reload');

		    	// bind event to the newly added objects
		    	$('#post' + postid).click( function(){
		    		postid = $(this).attr( 'postid' );

					$.ajax({
					     url: path_to_theme + 'more_previews.php',
					     //type: "GET",
					     dataType: 'html',
					     data: "get_post_preview=" + postid,
					     success: function(data){
							if( data == "" )
							{
								//todo: try to make it gently
								alert( "no data!" );
							}
							else
							{
								$(".ss_reviews_wrapper").append( data );
								var $container = $('.ss_reviews_wrapper');
								$container.imagesLoaded( function(){
									$container.masonry('reload', function(){
										shorten_titles();
										bind_button_events( $container );
										//todo: this is ugly. 
										$('html, body').animate(
											{ scrollTop: parseInt( $('.ss_footer').offset().top, 10 ) },
											1000,
											'swing',
											function(){
												$('html, body').animate(
													{ scrollTop: parseInt( $('#preview' + postid ).offset().top, 10 ) },
													500 ); }
											);
									});
								});
							}
					     },
			 	    	 error: function( xhr, status, errorThrown ){
			 	    	 	//todo: try to make it gently
			 	    		alert( "error!" );
			 	    	 }
					});

					$(this).remove();

		    	});
    		//}, 2000 );
    	});
    });
}

function shorten_titles(){
	var min_button_width = $('.ss_reviews_wrapper .ss_review_toolbar .min').width();
	var max_button_width = $('.ss_reviews_wrapper .ss_review_toolbar .max').width();
	var close_button_width = $('.ss_reviews_wrapper .ss_review_toolbar .halt_close').width();
	var spacer_width = $('.ss_reviews_wrapper .ss_review_toolbar .spacer').width();

	$('.ss_reviews_wrapper .ss_review_toolbar span').each( function(){
		// Get the whole toolbar width
		var span_width = 
			$(this).parent().width() 	- min_button_width - max_button_width
										- close_button_width - 10 /* span margin-left */
										- spacer_width - 10 /* custom margin from the right, available for change only here*/;

		$(this).width( span_width );
	});
}

$(document).ready( function(){
	var mobilePattern = window.matchMedia("screen and (max-device-width: 480px)");
	if( mobilePattern.matches )
		mobile_device = true;
	else
		mobile_device = false;
/*
	alert( 'hoy: ' + $('.ss_smartphone').css( 'display' ) + 'screen.width: ' +
			screen.width + 'screen.height: ' + screen.height );
*/
	// The MASONRY thing
    var $container = $('.ss_reviews_wrapper');

    // Bind the three Windows 95 buttons
    bind_button_events( $container );

	// todo: make it work only on pages with comments!
	avatars_fit();

	// initialize the postsloaded attribute in "MORE" button
	$(".ss_more_button").attr( 'postsloaded', $(".ss_review_preview").length );

	// The close button in maximized window
	$('.max_container .halt_close').click( function(){
		$('.max_container').fadeOut( 300, function(){
			var postid = $('.max_container').attr( 'postid' );
			$( '#' + postid ).fadeIn( 300, function(){
				$('html, body').animate({
			        scrollTop: parseInt( $( '#' + postid ).offset().top, 10 )
			    }, 1000);
			});
		});
		$('.max_container .ss_review_toolbar').nextAll().remove();
	});

	// "MORE" button function
	$( ".ss_more_button" ).click( function(){
		$(".ss_more_button span").text( "Жди, блядина..." );
		var catid = $(this).attr('catid');

		$.ajax({
		     url: path_to_theme + 'more_previews.php',
		     //type: "GET",
		     dataType: 'html',
		     data: "offset=" + $(".ss_more_button").attr( 'postsloaded') + "&per_page=24&categories='" + catid + "'",
		     success: function(data){
				if( data == "" )
				{
					$(".ss_more_button span").text( "НЕ ВИДИТЕ? У НАС ОБЕД!" );
				}
				else
				{
					$(".ss_more_button").attr( 'postsloaded',
												parseInt( $(".ss_more_button").attr( 'postsloaded'), 10 ) +
												occurrences( data, '"ss_review_wrap' ) );
					$(".ss_reviews_wrapper").append( data );
					$container.imagesLoaded( function(){
						shorten_titles();
						$container.masonry('reload');
						bind_button_events( $container );
						$(".ss_more_button span").text( "ДАЙ МНЕ ЕЩЁ" );
					});
				}
		     },
 	    	 error: function( xhr, status, errorThrown ){
 	    		$(".ss_more_button span").text( "ДАЙ МНЕ ЕЩЁ" );
 	    	 }
		});
	});

	// The MASONRY thing
    var gutter = 40;
    var min_width = 300;
    var one_column_style = false;

    $container.imagesLoaded( function(){
    	$container.css( 'z-index', -100 );

        $container.masonry({
            itemSelector : '.ss_review_wrap',
            gutterWidth: gutter,
            isAnimated: true,
              columnWidth: function( containerWidth ) {
              	var box_width = 0;
              	var one_column_style;
              	if( !mobile_device ){
	                box_width = (((containerWidth - 3*gutter)/4) | 0) ;

	                if (box_width < min_width) {
	                    box_width = (((containerWidth - 2*gutter)/3) | 0);
	                }

	                if (box_width < min_width) {
	                    box_width = (((containerWidth - gutter)/2) | 0);
	                }

	                if (box_width < min_width) {
	                    box_width = containerWidth;
	                    one_column_style = true;
	                }
	            }
	            else
	            {
	            	box_width = containerWidth;
	            	one_column_style = true;
	            }

	            $('.ss_review_wrap').width( box_width );

	            if( !one_column_style )
	                $('.double').width( $('.double').width() * 2 +  gutter );
                
                return box_width;
              }
        });
        shorten_titles();
        setTimeout( remove_loading_wrap( $container ), 500 );
    });
});

function avatars_fit()
{
	$(".comment-author img").each( function(){
		$(this).css( "height", 50 );
		$(this).css( "width", 'auto' );
	});
}

function do_dynamical_thing()
{
	fix_the_horse_bubble();
	shorten_titles();
}

$(window).load(function() {
	do_dynamical_thing();
});

$(window).resize(function() {
	do_dynamical_thing();
});
/*
$(document).waitForImages( function(){
	if( !images_loaded_dom_ready )
	{
		images_loaded_dom_ready = true;
		return;
	}

	remove_loading_wrap();
});
*/