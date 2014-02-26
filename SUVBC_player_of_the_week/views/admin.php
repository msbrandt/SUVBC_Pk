<?php
	
?>
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form id="mcm_input" action="options.php" method="post">
		<span id="mcm_response"></span>
		<?php settings_fields( 'suvbc_mcm_group' ); ?>
		<h2><?php _e( 'Add or remove players from mcm slider', 'SUVBC_domain'); ?></h2>

		<input type='text' id="mcm_image" class="mcm_input" name="mcm_file" placeholder="Add picture"><div id="mcm_img_button">Browse</div>
		<input type='text' class="mcm_input" name="mcm_name" placeholder="Player">
		<textarea cols="45" rows="10" class="mcm_input" name="mcm_info" placeholder="Add decription"></textarea>
		<input type="button" class="mcm_bnt" id="mcm_bnt"value="Save" />
		<input type="button" class="mcm_bnt" id="mcm_bntD"value="Delete" />
	</form>

	<table id="active_mcm">
		<h2><?php _e( 'Active mcm', 'SUVBC_domain' ); ?> </h2>

		<tbody id="mcm_slide">
			<?php 
				global $wpdb;

				$table_name = $wpdb->prefix . 'mcm_slider_fet';

				$admin_mcm_query = $wpdb->get_results("SELECT * FROM " . $table_name . " "); 

				foreach ($admin_mcm_query as $vac) {
					echo '<tr id="' . $vac->mcm_id . '">';
					echo '<td>' . $vac->mcm_name . '</td>';
					echo '<td class="not_there_suvbc">' . $vac->mcm_image . '</td>';
					echo '<td class="not_there_suvbc">' . $vac->mcm_dec . '</td>';
					echo '</tr>';
		
				}
			?>
		</tbody>
	</table>