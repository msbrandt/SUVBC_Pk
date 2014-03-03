jQuery(function ($) {

	var mcm_count = $('.mcm_input').size(),
		infoArray=[];
	
	//Save a player when the user clickes save
	$('#mcm_bnt').click(function(){
		//get user input from admin form 
		for(var x=0; x<mcm_count; x++){
			var u = $('.mcm_input:eq(' + x + ')').val();

			infoArray.push(u);
		}
		//user input ( image source, player name, player award information )
		var mcm_img  = infoArray[0],
			mcm_name = infoArray[1],
			mcm_dec  = infoArray[2];
		//ajax stuff
		$.ajax({
			url:  ajaxurl,
			type: 'POST',
			data: {
				action: 'mcm_slider_fet',
				mcm_img: mcm_img,
				mcm_name: mcm_name,
				mcm_dec: mcm_dec,
			},
			//add new player to active table and display message 
			success: function(response){
				$('table#active_mcm tbody').append(response);
				$('#mcm_response').show().html('Player added').delay(5000).fadeOut();

				$('.mcm_input').val('');
				window.location.reload();

			}

		})
	})

	//Highlight and select player to delete
	$('table#active_mcm tr').click(function(){
		var thatt = $(this);
		var that = $(this).attr('id');
		thatt.css('background', '#EA7809');
		$('table#active_mcm tr').not(thatt).css('background', 'none');
		var xxm = $('table#active_mcm tr#' + that + ' td').size();

		var bbm = [];
		//get all of selected play's informatino (name, image, decription)
		for (var q = 0; q<xxm; q++){
			mcm = $('table#active_mcm tr#' + that + ' td:eq('+q+')').html();
			bbm.push(mcm)
		}
		$('.mcm_input:eq(1)').val(bbm[0]);
		$('.mcm_input:eq(2)').val(bbm[2]);
		
		//delete player click action 		
		$('#mcm_bntD').click(function(){
			//confirm user wants to delete user 
			var suvbc_mcm_confirm = confirm('Do you want to delete this player?');

			if (suvbc_mcm_confirm){
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'mcm_slider_delete',
						mcm_clicked: that,
					},
					success: function(response){
						$('#mcm_response').html('Player deleted');
						window.location.reload();

					}
				})
			}
		});
	})//end of highlight and select action

	//have media library uploader show up when button is clicked 
	$('#mcm_img_button').click(function(e) {
    	var suvbc_mcm_media_button = $(this);
    	e.preventDefault();

    	custom_uploader = wp.media.frames.file_frame = wp.media({
    		title: 'Choose Image',
    		button: {text: 'Save Image'},
    		multiple: false
    	});
    	custom_uploader.on('select', function(){
    		attachment = custom_uploader.state().get('selection').first().toJSON();
    		var id = suvbc_mcm_media_button.attr('id');
 			$('input[name="'+id+'"]').val(attachment.url);
            $('#'+id+'-preview').attr( 'src', attachment.url );

            $('#mcm_image').val(attachment.url);
    	})
    	custom_uploader.open();
    });
})

