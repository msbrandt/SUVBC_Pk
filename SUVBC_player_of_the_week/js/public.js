jQuery(function($){
	//hide all images and decriptions besides the first one
	$('.featured_player_img_suvbc').not(':first').hide();
	$('.featured_player_bio_suvbc').not(':first').hide();
	
	//display correct image and bio depending on who the user clicked on 
	$('ul#mcm_thumbs li').click(function(){
		var mcm_index = $(this).index();
		$('.featured_player_img_suvbc').stop().fadeOut(500);
		$('.featured_player_img_suvbc:eq(' + mcm_index + ')').stop().fadeIn(500);
		
		$('.featured_player_bio_suvbc').not('.featured_player_bio_suvbc:eq(' + mcm_index + ')').stop().fadeOut(500);
		$('.featured_player_bio_suvbc:eq(' + mcm_index + ')').stop().fadeIn(500);
	});


})