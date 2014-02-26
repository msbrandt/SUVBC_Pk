<?php	
	function suvbc_showcase_slider(){
		global $post; 

		$postID = $post->ID;
		$argsX = array(
			'post_type' => 'suvbc_img',
			'numberposts' => -1
			);
		$x = -1;
		$arrImages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $postID );
		if ($arrImages) {
			$arrKey = array_keys($arrImages);

			foreach ($arrImages as $attachment) {
				$x += 1;
				$imgInfoArr = array(
					'desc' => $attachment->post_content,
					'capt' => $attachment->post_excerpt
				);
			
				$xNum = $arrKey[$x];
				
				$decsp = $imgInfoArr['desc'];
				$capt = $imgInfoArr['capt'];
				
				$sImgURL = wp_get_attachment_url($xNum);
				
				echo '<li class=slide_suvbc style="background: url('.$sImgURL.') no-repeat; background-size: cover; background-position: center ">';
				echo '<div class="slide_dec_suvbc"><h2>'.$capt.'</h2><h3>'.$decsp.'</h3></div></li>';

			}
		}

}
?>