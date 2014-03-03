<?php	
	function suvbc_showcase_slider(){
		global $post; 

		$postID = $post->ID;
		//pull all posts that where added to showcase slider section 
			$argsX = array(
				'post_type' => 'suvbc_img',
				'numberposts' => -1
			);
		$x = -1;
		//get all attachemnts and meta data from these posts
		$arrImages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $postID );
		if ($arrImages) {
			$arrKey = array_keys($arrImages);
			//select only decription and catption 
			foreach ($arrImages as $attachment) {
				$x += 1;
				$imgInfoArr = array(
					'desc' => $attachment->post_content,
					'capt' => $attachment->post_excerpt
				);
				//get slide urls
				$xNum = $arrKey[$x];
				
				$decsp = $imgInfoArr['desc'];
				$capt = $imgInfoArr['capt'];
				
				//select attachment image
				$sImgURL = wp_get_attachment_url($xNum);

				//display in image slider as a listed item 
				echo '<li class=slide_suvbc style="background: url('.$sImgURL.') no-repeat; background-size: cover; background-position: center ">';
				echo '<div class="slide_dec_suvbc"><h2>'.$capt.'</h2><h3>'.$decsp.'</h3></div></li>';

			}
		}

}
?>