jQuery(function($){	
	var slide = 0;
	//get total number of slides 
	var total_slides = $('ul.page_main_content_suvbc li').size();

	var navigation_count = 0;
	//count number of slides, then place correct amount of squares on slider nav bar
	function slider_navigation(){
		var slider_position = $('ul.slider_position_suvbc');
		
		for (x=0; x < total_slides; x++){
			var fillin_dots = "<li class='nav_pos_button_suvbc id='b" + x + "''></li>";
			$(slider_position).append(fillin_dots); 
		}

	}


	
	slider_navigation();
	// Change slider image when square is click 
	$('ul.slider_position_suvbc li.nav_pos_button_suvbc').click(function(){
		var squ_index = $(this).index() -1;
		$('ul.page_main_content_suvbc li').fadeOut('slow');

		$('ul.page_main_content_suvbc li:eq(' + squ_index + ')').fadeIn('slow');
		$('li.nav_pos_button_suvbc:eq(' + squ_index + ')').css('background', '#EA7809');
		$('li.nav_pos_button_suvbc').not('li.nav_pos_button_suvbc:eq(' + squ_index + ')').css('background', '#aaa')	

		slide = squ_index;



	})
	//add color to correct starting square
	var last_slide = $('ul.page_main_content_suvbc li:last').index();
	$('li.nav_pos_button_suvbc:eq(' + last_slide + ')').css('background', '#EA7809');	
	//action to change to next slide
	function next_slide(){
		//hide current image 
		$('ul.page_main_content_suvbc li').stop().fadeOut('slow');
		//show next image in line based on index 
		$('ul.page_main_content_suvbc li:eq(' + slide + ')').stop().fadeIn('slow');


		$('li.nav_pos_button_suvbc').not('li.not:eq(' + navigation_count + ')').stop().css('background', '#aaa');
		$('li.nav_pos_button_suvbc:eq(' + navigation_count + ')').stop().css('background', '#EA7809');	
		
		//set slide back to start when last slide is reached 
		if(slide >= total_slides -1){
			slide = 0;
			navigation_count = 0;
		}else{
			slide ++;
			navigation_count ++;
		}

	}
	//action to go back a slide 
	function prev_slide(){
	//hide current showing slide 
		$('ul.page_main_content_suvbc li').stop().fadeOut();
	//show previos image based on index
		$('ul.page_main_content_suvbc li:eq(' + (slide -2) + ')').stop().fadeIn();


		$('li.nav_pos_button_suvbc').not('li.not:eq(' + (navigation_count-2) + ')').stop().css('background', '#aaa');
		$('li.nav_pos_button_suvbc:eq(' + (navigation_count-2) + ')').stop().css('background', '#EA7809');	
		
	// set slide back to start when count go past 0
		if(slide <= 0){
			slide = 2;
			navigation_count = 2;
		}else{
			slide --;
			navigation_count --;
		}

	}

	//set next_slide function to be automatice, change slides every 7.5 seconds 
	var suvcb_interval = setInterval(next_slide, 7500);
	
	//fire next_slide when right button is clicked. Restart intervals 
	$('#right_suvbc').on("click", function(){
		next_slide();
		clearInterval(suvcb_interval);
		suvcb_interval = setInterval(next_slide, 7500);
	});
	//fire prevos_slide when left button is clicked. Restart intervals 
	
	$('#left_suvbc').on("click", function(){
		prev_slide();
		clearInterval(suvcb_interval);
		suvcb_interval = setInterval(next_slide, 7500);

	})
	//stop interval when hovering over slider nav bar. Restart when done hovering 

	$('.slider_button_suvbc').hover(function(){
		clearInterval(suvcb_interval);
	},function(){
		suvcb_interval = setInterval(next_slide, 7500);
	})


})
