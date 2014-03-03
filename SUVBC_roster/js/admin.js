jQuery(function ($) {
//save players action 
	$('#save').click(function(){
		//cont how many inputs their is 
		var formCount = $('form#roster_suvbc .admin_input').length,
			formData = [];

		//pull all of user input from form 
		for(var q=0; q<formCount; q++){
			getFormData = $('form#roster_suvbc .admin_input:eq('+ q +')').val();
		 		formData.push(getFormData);

		}
		//user input 
		var form_id    = formData[0],  //auto incrementing id
			form_num   = formData[1],  // number
			form_name  = formData[2],  // name
			form_pos   = formData[3],  // position
			form_class = formData[4],  // Year 
			form_ht    = formData[5],  // Hometown
			form_img   = formData[6],  // Image
			form_bio   = formData[7];  // Bio

		//ajax request
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'suvbc_save_player',
				form_id: form_id,
				form_num: form_num,
				form_name: form_name,
				form_pos: form_pos,
				form_class: form_class,
				form_ht: form_ht,
				form_img: form_img,
				form_bio: form_bio,				
			},
			//on sucess, add player to table and give the user a response 
			success: function(response){
				$('.target').html('Player added').delay(5000).fadeOut();
				$('table#admin_roster tbody').append(response);
				$('form#roster_suvbc .admin_input').val('');

			}
		})
		return false;
	});

	//get entire row and information of selected player, fills in inputs with that data
	$('table#admin_roster tbody tr.player_suvbc').click(function(){
		var trcount = $('form#roster_suvbc .admin_input').length;
		var player = $(this),			
			player_num = player.attr('id'),
			playerArray =[];
		//make selected rows background color orange
		player.addClass('selectedPlayer').css('background', '#EA7809');
		$('table#admin_roster tbody tr.player_suvbc').not($(player)).css('background', 'none');

		for(var t=0; t<trcount; t++){
			getText = $('table#admin_roster tbody tr#' + player_num + ' td:eq(' + t + ')').html();
			$('form#roster_suvbc .admin_input:eq(' + (t+1) + ')').val(getText);
			playerArray.push(getText);
		}	

	})
	//edit players actions 
	$('#edit').click(function(){

		//get number of inputs
		var inputCount = $('form#roster_suvbc .admin_input').length;
		var newData = [];

		//selected player's ID
		var pl_ID = $('table#admin_roster tbody tr.selectedPlayer td.eqid').html();

		//get all input text from form 
		for(var m=0; m<inputCount; m++){
			v = $('form#roster_suvbc .admin_input:eq('+ m +')').val();
		 		newData.push(v);
		}

		var plyID    = newData[0], //incromented ID
			plyNum   = newData[1], //number
			plyName  = newData[2], //name
			plyPos   = newData[3], //position
			plyClass = newData[4], //year
			plyHt    = newData[5], //hometown
			plyImg   = newData[6], //image
			plyBio   = newData[7]; //bio

			$.ajax({
				url: ajaxurl,
				type: 'POST',
				data: {
					action: 'suvbc_edit_player',
					plyNum: plyNum,
					plyName: plyName,
					plyPos: plyPos,
					plyClass: plyClass,
					plyHt: plyHt,
					plyImg: plyImg,
					plyBio: plyBio,
					pl_ID: pl_ID,
				},
				//if a field has been changed, update it in table and reload the page
				success: function(response){
					$('.target').html('Player Updated').delay(5000).fadeOut();
					$('table#admin_roster tr').css('background', 'none');
					$('form#roster_suvbc .admin_input').val('');
					window.location.reload();

				}


			})



	})

	// Delete player actoon 
	$('#delete').click(function(){
		//get hidden ID
		var suvbc_roster_confirm = confirm('Do you want to delete this player?');
		var ss = $('.selectedPlayer td:last').html();
		if (suvbc_roster_confirm){		
			$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'suvbc_delete_player',
						deleteID: ss,

					},
					//Remove deleted player form table 
					success: function(response){
						$('.target').html('Player deleted!').delay(5000).fadeOut();
						$('table#admin_roster tbody tr#'+  response + ' ').remove();
						$('form#roster_suvbc .admin_input').val('');
						window.location.reload();


					}
		})
		}
	})


// Open wordpress media uploader when search image is clicked 
    $('#suvbc_browes_media').click(function(e) {
    	var suvbc_media_button = $(this);
    	e.preventDefault();

    	custom_uploader = wp.media.frames.file_frame = wp.media({
    		title: 'Choose Image',
    		button: {text: 'Save Image'},
    		multiple: false
    	});
    	custom_uploader.on('select', function(){
    		attachment = custom_uploader.state().get('selection').first().toJSON();
    		var id = suvbc_media_button.attr('id');
 			$('input[name="'+id+'"]').val(attachment.url);
            $('#'+id+'-preview').attr( 'src', attachment.url );

            $('#suvbc_img').val(attachment.url);
    	})
    	custom_uploader.open();
    });

})