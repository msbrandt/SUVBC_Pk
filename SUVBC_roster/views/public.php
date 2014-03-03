<?php 
function suvbc_add_shortcode(){
	//get all select players infromation from suvbc_Roster table 
	global $wpdb;
	$table_name = $wpdb->prefix . 'suvbc_Roster';
	$display_query = $wpdb->get_results("SELECT * FROM wp_suvbc_Roster ORDER BY player_number");
	


?>
<table id="player_table_suvbc">
	<thead>
		<tr>
			<th><?php _e( '#', 'SUVBC_domain' ); ?></th>
			<th><?php _e( 'name', 'SUVBC_domain' ); ?></th>
			<th><?php _e( 'Pos', 'SUVBC_domain' ); ?></th>
			<th><?php _e( 'CL', 'SUVBC_domain' ); ?></th>
			<th><?php _e( 'Hometown', 'SUVBC_domain' ); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php 
	foreach ( $display_query as $display ) {
		echo '<tr class="display_player_suvbc" id="'.$display->player_number.'">';
		echo '<td>'.$display->player_number.'</td>';
		echo '<td>'.$display->player_name.'</td>';
		echo '<td>'.$display->player_position.'</td>';
		echo '<td>'.$display->player_year.'</td>';
		echo '<td>'.$display->player_hometown.'</td>';
		echo '<td class="not_there">'.$display->player_id.'</td>';
		echo '<td class="not_there">'.$display->player_img.'</td>';
		echo '<td class="not_there">'.$display->player_bio.'</td>';
		echo '</tr>';
	}
	?>
	</tbody>
<div class="clear"></div>
	
</table>
<div id="player_info_suvbc">
	<div id="image_padding_suvbc">
		<ul id="player_image_suvbc">
			<li id="img_placeholder_suvbc"><h1>Click on a player to see their image and bio</h1></li>
			
		</ul>
	</div>
<div class="clear"></div>
	
	<div id="bio_padding_suvbc">
		<div id="player_bio_suvbc">
			<div class="page_padding_suvbc">
				Player Bio
			</div>
		</div>
	</div>
<?php
}
//type [SUVBC_Roster] in roster comments to add roster to main page 
add_shortcode( 'SUVBC_Roster', 'suvbc_add_shortcode' ); 

?>