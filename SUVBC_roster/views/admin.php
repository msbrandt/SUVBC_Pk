<?php
?>
	<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form id="roster_suvbc" action="options.php" method="post">
	<span class="target"></span>

		<?php settings_fields( 'suvbc_rotster_group' ); ?>
		<h2><?php _e( 'Add, modifiy, or remover players from the roster section', 'SUVBC_domain' ); ?></h2>
		<h3><?php _e( 'Add new player', 'SUVBC_domain' ); ?></h3>
		<input type="hidden" class="admin_input" id="suvbc_id" value=""/>
		<input type="text" class="admin_input" id="suvbc_number" name="suvbc_number" placeholder="Number" value=""/>

		<input type="text" class="admin_input" id="suvbc_name" name="suvbc_name" placeholder="Name" value=""/>
				
		<select name="suvbc_pos" class="admin_input" id="suvbc_pos">
			<option><?php _e('Position', 'SUVBC_domain' ); ?></option>		
			<option value="MB"><?php _e('Middle', 'SUVBC_domain' ); ?></option>		
			<option value="OH"><?php _e('Outside', 'SUVBC_domain' ); ?></option>		
			<option value="S"><?php _e('Setter', 'SUVBC_domain' ); ?></option>		
			<option value="L"><?php _e('Libero', 'SUVBC_domain' ); ?></option>		
			<option value="DS"><?php _e('Defensive Specilas', 'SUVBC_domain' ); ?></option>
		</select>			
		<select name="suvbc_year" class="admin_input" id="suvbc_year">
			<option><?php _e( 'Year', 'SUVBC_domain' ); ?></option>		
			<option value="FR"><?php _e( 'Freshman', 'SUVBC_domain' ); ?></option>		
			<option value="SO"><?php _e( 'Sophomore', 'SUVBC_domain' ); ?></option>		
			<option value="JR"><?php _e( 'Junior', 'SUVBC_domain' ); ?></option>		
			<option value="SR"><?php _e( 'Senior', 'SUVBC_domain' ); ?></option>		
			<option value="GS"><?php _e( 'Graduate', 'SUVBC_domain' ); ?></option>		
		</select>
		<input type="text" class="admin_input" id="suvbc_ht" name="suvbc_ht" placeholder="Hometown" value=""/>

		<input type="text" class="admin_input" id="suvbc_img" name="suvbc_img" placeholder="Player Image" value="" /><div id="suvbc_browes_media"><?php _e( 'Search Image', 'SUVBC_domain' ); ?>
			</div>

		<textarea rows="10" cols="50" class="admin_input" name="suvbc_bio" placeholder="Player Bio"></textarea>
		<p>
			<input type="button" value="Save" class="suvbc_sub" id="save"/>
		</p>
		<p>
			<input type="button" value="Update" class="suvbc_sub" id="edit"/>
		</p>
		<p>
			<input type="button" value="Delete" class="suvbc_sub" id="delete"/>
		</p>
	</form>

	<div class="display_admin_table">
		<table id="admin_roster" cellpadding="5" cellspacing="5" width="100%">	
			<thead>
				<tr>
					<th><?php _e( '#', 'SUVBC_domain' ); ?></th>
					<th><?php _e( 'Name', 'SUVBC_domain' ); ?></th>
					<th><?php _e( 'Pos.', 'SUVBC_domain' ); ?></th>
					<th><?php _e( 'Cl.', 'SUVBC_domain' ); ?></th>
					<th><?php _e( 'Hometown', 'SUVBC_domain' ); ?></th>
				</tr>
			</thead>
			<tbody>

 			<?php
 			//display table with all players. This will be used to select players from to edit or remove
				global $wpdb;

				$table_name = $wpdb->prefix . 'suvbc_Roster';
				$admin_query = $wpdb->get_results("SELECT * FROM wp_suvbc_Roster ORDER BY player_number"); 
				foreach ($admin_query as $print){
					echo '<tr class="player_suvbc" id="'.$print->player_number.'">';
					echo '<td>'.$print->player_number.'</td>';
					echo '<td>'.$print->player_name.'</td>';
					echo '<td>'.$print->player_position.'</td>';
					echo '<td>'.$print->player_year.'</td>';
					echo '<td>'.$print->player_hometown.'</td>';
					echo '<td class="not_there">'.$print->player_img.'</td>';
					echo '<td class="not_there">'.$print->player_bio.'</td>';
					echo '<td class="eqid">'.$print->player_id.'</td>';
					}
			?>
 
			</tbody>
		</table>	
</div>
<?php
?>