<?php 
function display_mcm(){
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'mcm_slider_fet';
	
	$display_query = $wpdb->get_results("SELECT * FROM ".$table_name." ");
?>

<div id="featured_suvbc">
	<ul id="mcm_feat_suvbc">
		<?php foreach( $display_query as $res ){ ?>
		<li>
			<div id="suvbc_pic-<?php echo $res->mcm_id; ?>"class="featured_player_img_suvbc">
				<img src="<?php echo $res->mcm_image; ?>" alt="suvbc_image<?php echo $thumb_suvbc->mcm_id; ?>" />
			</div>
			<div class="featured_player_bio_suvbc">
				<div id="suvbc_bio-<?php echo $res->mcm_id; ?>" class="page_padding_suvbc suvbc_mcm_bio">
					<?php echo $res->mcm_dec; ?>
				</div>
			</div>
		</li>
		<?php }; ?>

	</ul>
	<div class="clear"></div>
	<div id="mcm_thumbs_container">

	<ul id="mcm_thumbs">
		<?php foreach( $display_query as $thumb_suvbc ){ ?>
				
		<li id="<?php echo $thumb_suvbc->mcm_id; ?>"><img src="<?php echo $thumb_suvbc->mcm_image; ?>" alt="suvbc_image_thumb<?php echo $thumb_suvbc->mcm_id; ?>" /></li>
		<?php }; ?>

	</ul>
	<div class="clear"></div>

</div>

</div>
<?php

	}
add_shortcode( 'mcm', 'display_mcm' ); 
?>