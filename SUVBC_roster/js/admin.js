jQuery(function ($) {

	$('#save').click(function(){

		var formCount = $('form#roster_suvbc .admin_input').length,
			formData = [];

		
		for(var q=0; q<formCount; q++){
			getFormData = $('form#roster_suvbc .admin_input:eq('+ q +')').val();
		 		formData.push(getFormData);

		}
		var form_id    = formData[0],
			form_num   = formData[1],
			form_name  = formData[2],
			form_pos   = formData[3],
			form_class = formData[4],
			form_ht    = formData[5],
			form_img   = formData[6],
			form_bio   = formData[7];


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
			success: function(response){
				$('.target').html('Player added');
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
	
	$('#edit').click(function(){

		var inputCount = $('form#roster_suvbc .admin_input').length;
		var newData = [];

		var pl_ID = $('table#admin_roster tbody tr.selectedPlayer td.eqid').html();
		console.log('player id ' + pl_ID);

		for(var m=0; m<inputCount; m++){
			v = $('form#roster_suvbc .admin_input:eq('+ m +')').val();
		 		newData.push(v);
		}

		var plyID    = newData[0],
			plyNum   = newData[1],
			plyName  = newData[2],
			plyPos   = newData[3],
			plyClass = newData[4],
			plyHt    = newData[5],
			plyImg   = newData[6],
			plyBio   = newData[7];
			console.log(plyID);
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
				success: function(response){
					$('.target').html(response);
					$('table#admin_roster tr').css('background', 'none');
					$('form#roster_suvbc .admin_input').val('');
					window.location.reload();

				}


			})



	})


	$('#delete').click(function(){

		var ss = $('.selectedPlayer td:last').html();

		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'suvbc_delete_player',
				deleteID: ss,

			},
			success: function(response){
				$('.target').html('Player deleted!');
				$('table#admin_roster tbody tr#'+  response + ' ').remove();
				$('form#roster_suvbc .admin_input').val('');
				window.location.reload();


			}
		})
	})



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