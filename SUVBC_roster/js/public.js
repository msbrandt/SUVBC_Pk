jQuery(function($){
	//get amount of player in the roster
	var roster_length = $('table#player_table_suvbc tbody tr.display_player_suvbc').size();
	//shange the color of font when hovering over players 
	$('table#player_table_suvbc tbody tr.display_player_suvbc').hover(function(){
		var suvbc_hover = $(this);
		$(suvbc_hover).addClass('hi');
	},function(){
		var suvbc_hover = $(this);

		suvbc_hover.removeClass('hi');
	});

	//get and post all player images 
	for(var x=0; x<roster_length; x++){
		img_src = $('table#player_table_suvbc tbody tr:eq(' + x + ') td:eq(6)').html();
		img_src_li = '<li class="playerImg"><img src="'+ img_src + '" /></li>'
		$('ul#player_image_suvbc').append(img_src_li);
	}

	//show player image and information when row is clicked on
	$('table#player_table_suvbc tbody tr.display_player_suvbc').click(function(){
	 	$('ul#player_image_suvbc li#img_placeholder_suvbc').remove();
	 	$('#player_bio_suvbc').fadeIn();
	 	var that = $(this),
	 		thatthat = that.index(),
	 		playerBio = that.children(':eq(7)').html();

	 	that.addClass('hic');
 		$('table#player_table_suvbc tbody tr.display_player_suvbc').not(that).removeClass('hic');

 		$('ul#player_image_suvbc li').not($('ul#player_image_suvbc li:eq(' + thatthat + ')')).fadeOut(750);
	 	$('ul#player_image_suvbc li:eq(' + thatthat + ')').stop().fadeIn(750);

	 	$('#player_bio_suvbc .page_padding_suvbc').html(playerBio);

 	});

})