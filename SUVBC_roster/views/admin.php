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
			<option>Position</option>		
			<option value="MB">Middle</option>		
			<option value="OH">Outside</option>		
			<option value="S">Setter</option>		
			<option value="L">Libero</option>		
			<option value="DS">Defensive Specilas</option>
		</select>			
		<select name="suvbc_year" class="admin_input" id="suvbc_year">
			<option>Year</option>		
			<option value="FR">Freshman</option>		
			<option value="SO">Sophomore</option>		
			<option value="JR">Junior</option>		
			<option value="SR">Senior</option>		
			<option value="GS">Graduate</option>		
		</select>
		<input type="text" class="admin_input" id="suvbc_ht" name="suvbc_ht" placeholder="Hometown" value=""/>

		<input type="text" class="admin_input" id="suvbc_img" name="suvbc_img" placeholder="Player Image" value="" /><div id="suvbc_browes_media">Search Image</div>

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
					<th>#</th>
					<th>Name</th>
					<th>Pos.</th>
					<th>Cl.</th>
					<th>Hometown</th>
				</tr>
			</thead>
			<tbody>

 			<?php
				global $wpdb;

				$table_name = $wpdb->prefix . 'suvbc_Roster';
				$admin_query = $wpdb->get_results("SELECT * FROM wp_suvbc_Roster"); 
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