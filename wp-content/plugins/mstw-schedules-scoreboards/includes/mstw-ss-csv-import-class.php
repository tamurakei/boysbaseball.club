<?php
/* ------------------------------------------------------------------------
 * 	CSV Schedule & Scoreboard Importer Class
 *		- Modified from CSVImporter by Denis Kobozev (d.v.kobozev@gmail.com)
 *		- All rights flow through under GNU GPL.
 *
 *	MSTW Wordpress Plugins (http://shoalsummitsolutions.com)
 *	Copyright 2014-15 Mark O'Donnell (mark@shoalsummitsolutions.com)
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.

 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program. If not, see <http://www.gnu.org/licenses/>.
 *--------------------------------------------------------------------------*/
 
	class MSTW_SS_ImporterPlugin {
		var $defaults = array(
			'csv_post_title'      => null,
			'csv_post_post'       => null,
			'csv_post_type'       => null,
			'csv_post_excerpt'    => null,
			'csv_post_date'       => null,
			'csv_post_tags'       => null,
			'csv_post_categories' => null,
			'csv_post_author'     => null,
			'csv_post_slug'       => null,
			'csv_post_parent'     => 0,
		);

		var $log = array();

		//
		// process_option checks/cleans up the $_POST values
		//
		function process_option( $name, $default, $params, $is_checkbox ) {
			//checkboxes which if unchecked do not return values in $_POST
			if ( $is_checkbox and !array_key_exists( $name, $params ) ) {
				$params[ $name ] = $default;	
			}
			
			if ( array_key_exists( $name, $params ) ) {
				$value = stripslashes( $params[ $name ] );
			} elseif ( $is_checkbox ) {
				//deal with unchecked checkbox value
			
			} else {
				$value = null;
			}
			
			return $value;
			
		} //End function process_option()

		//-------------------------------------------------------------
		// Builds the user interface for CSV Import screen
		//
		function form( ) {
			
			// check & cleanup the returned $_POST values
			$submit_value = $this->process_option( 'submit', 0, $_POST, false );
			
			//$opt_sched_id = $this->process_option( 'csv_importer_sched_id', 0, $_POST, false );
				
			$csv_move_logos = $this->process_option( 'csv_move_logos', 0, $_POST, true );
			
			$csv_import_schedule = $this->process_option( 'csv_import_schedule', 0, $_POST, false );
			
			//mstw_log_msg( '$_POST = ' );
			//mstw_log_msg( $_POST );
			
			//
			// THIS IS WHERE WE DO OUR BUSINESS post( )
			//
			if ('POST' == $_SERVER['REQUEST_METHOD']) {
				$this->post( compact( 'submit_value', 'csv_move_logos', 'csv_import_schedule' ) );
			}

			// start form HTML {{{
			?>

			<div class="wrap">
				<?php //echo get_screen_icon(); ?>
				<h2><?php _e( 'Import CSV Files', 'mstw-schedules-scoreboards' ); ?></h2>
				
				<!-- VENUES (LOCATIONS) import form -->
				<form class="add:the-list: validate" method="post" enctype="multipart/form-data" action="">
					<!-- Enter the schedule ID via text ... for now -->
					<table class='form-table'>
						<thead><tr><th><?php echo __( 'Venues (formerly Locations)', 'mstw-schedules-scoreboards' ) ?></th></tr></thead>
						
						<tr>  <!-- CSV file selection field -->
							<td><label for="csv_venues_import"><?php _e( 'Venues/Locations CSV file:', 'mstw-schedules-scoreboards' ); ?></label></td>
							<td><input name="csv_venues_import" id="csv_venues_import" type="file" value="" aria-required="true" /></td>
						</tr>
						<tr> <!-- Submit button -->
						<td colspan="2" class="submit"><input type="submit" class="button" name="submit" value="<?php _e( 'Import Venues', 'mstw-schedules-scoreboards' ); ?>"/></td>
						</tr>
					</table>
				</form>
				
				<!-- SCHEDULES import form -->
				<form class="add:the-list: validate" method="post" enctype="multipart/form-data" action="">
					<!-- Enter the schedule ID via text ... for now -->
					<table class='form-table'>
						<thead><tr><th><?php echo __( 'Schedules', 'mstw-schedules-scoreboards' ) ?></th></tr></thead>
						
						<tr>  <!-- CSV file selection field -->
							<td><label for="csv_schedules_import"><?php _e( 'Schedules CSV file:', 'mstw-schedules-scoreboards' ); ?></label></td>
							<td><input name="csv_schedules_import" id="csv_schedules_import" type="file" value="" aria-required="true" /></td>
						</tr>
						<tr> <!-- Submit button -->
						<td colspan="2" class="submit"><input type="submit" class="button" name="submit" value="<?php _e( 'Import Schedules', 'mstw-schedules-scoreboards' ); ?>"/></td>
						</tr>
					</table>
				</form>
				
				<!-- TEAMS import form -->
				<form class="add:the-list: validate" method="post" enctype="multipart/form-data" action="">
					<table class='form-table'>
						<thead><tr><th><?php echo __( 'Teams', 'mstw-schedules-scoreboards' ) ?></th></tr></thead>
						
						<tr>  <!-- CSV file selection field -->
							<td><label for="csv_teams_import"><?php _e( 'Teams CSV file:', 'mstw-schedules-scoreboards' ); ?></label></td>
							<td><input name="csv_teams_import" id="csv_teams_import" type="file" value="" aria-required="true" /></td>
						</tr>
						
						<tr>
							<td><label for="csv_move_logos"><?php _e( 'Move Team Logos:', 'mstw-schedules-scoreboards') ?></label></td>
							<td><input name="csv_move_logos" id="csv_move_logos" type="checkbox" value="1" />
							<br/>
							<span class='description' ><?php _e( 'If checked, team logo files will be imported from their current locations to the media library. If unchecked, logos files will remain in their current locations. This option is only necessary when moving data to a new WP site.', 'mstw-schedules-scoreboards' ) ?></span>
							</td>	
						</tr>
						
						<tr> <!-- Submit button -->
						<td colspan="2" class="submit"><input type="submit" class="button" name="submit" value="<?php _e( 'Import Teams', 'mstw-schedules-scoreboards' ); ?>"/></td>
						</tr>
					</table>
				</form>
				
				<!-- GAMES import form -->
				<?php
				$schedules_list = mstw_ss_build_schedules_list ( );
				//mstw_log_msg( $schedules_list );
				?>	
								
				<form class="add:the-list: validate" method="post" enctype="multipart/form-data">
					<!-- Enter the schedule ID via text ... for now -->
					<table class='form-table'>
					<thead>
						<tr><th colspan=2>
							<?php _e( 'Games', 'mstw-team-rosters' ) ?>
							<br/>
							<span class='description' style='font-weight: normal'><?php printf( __( 'The importer will use the "schedule-slug" column in the CSV file to assign games to schedules if that column is not empty.%s Otherwise, the game will be assigned to the schedule selected in the "Select Schedule to Import" dropdown. %sOtherwise, the game will be imported but will not be assigned to a schedule, which is generally not a good practice.', 'mstw-schedules-scoreboards' ), '<br/>', '<br/>' ) ?></span>
						</th></tr>
					</thead>
						
					<tbody>
						<tr>  <!-- Team (to import) selection field -->
							<td><label for="csv_import_schedule"><?php _e( 'Select Schedule to Import:', 'mstw-schedules-scoreboards' ) ?></label></td>
							<td>
							<?php 
							$schedules = mstw_ss_build_schedules_list( );
							
							if( $schedules ) {
								//echo "Found schedules - build list";
								?>
								<select name="csv_import_schedule" id="csv_import_schedule">
								<?php foreach ( $schedules as $title => $slug ) { ?>
									<option value=<?php echo $slug ?>><?php echo $title ?> </option>
									
								<?php } ?>
								</select>
							<?php
							}
							else {
								_e( 'No schedules found.', 'mstw-schedules-scoreboards' );
							}
							?>
							
							<br/>
							<span class='description' ><?php _e( 'This schedule will be used as the default if there is no entry for in the game_sched_id column in the imported CSV file.', 'mstw-schedules-scoreboards' ) ?></span>
							</td>
						</tr>
						<tr>  <!-- CSV file selection field -->
							<td><label for="csv_games_import"><?php _e( 'Games CSV file:', 'mstw-schedules-scoreboards' ); ?></label></td>
							<td><input name="csv_games_import" id="csv_games_import" type="file" value="" aria-required="true" /></td>
						</tr>
							
						<tr> <!-- Submit button -->
						<td colspan="2" class="submit"><input type="submit" class="button" name="submit" value="<?php _e( 'Import Games', 'mstw-schedules-scoreboards' ); ?>"/></td>
						</tr>
						
					</tbody>
					
					</table>
				</form>
				
				<!-- SPORTS import form -->
				<form class="add:the-list: validate" method="post" enctype="multipart/form-data">
					<!-- Enter the schedule ID via text ... for now -->
					<table class='form-table'>
						<thead><tr><th><?php echo __( 'Sports', 'mstw-schedules-scoreboards' ) ?></th></tr></thead>
						<tr>  <!-- CSV file selection field -->
							<td><label for="csv_sports_import"><?php _e( 'Sports CSV file:', 'mstw-schedules-scoreboards' ); ?></label></td>
							<td><input name="csv_sports_import" id="csv_sports_import" type="file" value="" aria-required="true" /></td>
						</tr>
						<tr> <!-- Submit button -->
						<td colspan="2" class="submit"><input type="submit" class="button" name="submit" value="<?php _e( 'Import Sports', 'mstw-schedules-scoreboards' ); ?>"/></td>
						</tr>
					</table>
				</form>
			</div><!-- end wrap -->
			<!-- end of form HTML -->
		<?php
		} //End of function form()
		
		/*-------------------------------------------------------------
		 *	Print Message Log
		 *-----------------------------------------------------------*/
		function print_messages() {
	
			if (!empty($this->log)) {

			// messages HTML {{{
	?>

	<div class="wrap">
		<?php if (!empty($this->log['error'])): ?>

		<div class="error">

			<?php foreach ($this->log['error'] as $error): ?>
				<p><?php echo $error; ?></p>
			<?php endforeach; ?>

		</div>

		<?php endif; ?>

		<?php if (!empty($this->log['notice'])): ?>

		<div class="updated fade">

			<?php foreach ($this->log['notice'] as $notice): ?>
				<p><?php echo $notice; ?></p>
			<?php endforeach; ?>

		</div>

		<?php endif; ?>
	</div><!-- end wrap -->

	<?php
			// end messages HTML }}}

				$this->log = array();
			}
		} //End function print_messages()

		/*-------------------------------------------------------------
		 * Handle POST submission
		 *-----------------------------------------------------------*/
		function post( $options ) {
			//mstw_log_msg( 'In post method ... ' );
			//mstw_log_msg( $options );
			//mstw_log_msg( $_FILES );
			//mstw_log_msg( $_POST );
			if ( !$options ) {
				mstw_log_msg( 'Houston, we have a problem in MSTW Schedules & Scoreboards - CSV Import ... no $options' );
				return;
			}
			
			extract( $options );
			//$submit_value -> table to import
			
			switch( $options['submit_value'] ) {
				case __( 'Import Venues', 'mstw-schedules-scoreboards' ):
					//mstw_log_msg( 'In post() method: Importing Venues ...' );
					$file_id = 'csv_venues_import';
					//$msg_str is only used in summary messages
					$msg_str =array( __( 'venue', 'mstw-schedules-scoreboards' ),  __( 'venues', 'mstw-schedules-scoreboards' ) );
					break;
					
				case __( 'Import Schedules', 'mstw-schedules-scoreboards' ):
					//mstw_log_msg( 'In post() method: Importing Schedules ...' );
					$file_id = 'csv_schedules_import';
					
					//$msg_str is only used in summary messages
					$msg_str =array( __( 'schedule', 'mstw-schedules-scoreboards' ),  __( 'schedules', 'mstw-schedules-scoreboards' ) );
					break;
					
				case __( 'Import Teams', 'mstw-schedules-scoreboards' ):
					//mstw_log_msg( 'In post() method: Importing Teams ...' );
					$file_id = 'csv_teams_import';
					// set the directory where logo images will be stored
					// if empty, entries in CSV file will be used as is
					/*if (  isset( $_POST['csv_image_directory'] ) ) {
						$images_dir = $_POST['csv_image_directory'];
					}
					else {
						$images_dir = '';
					}
					*/
					//$msg_str is only used in summary messages
					$msg_str =array( __( 'team', 'mstw-schedules-scoreboards' ),  __( 'teams', 'mstw-schedules-scoreboards' ) );
					break;
					
				case __( 'Import Games', 'mstw-schedules-scoreboards' ):
					//mstw_log_msg( 'In post() method: Importing Games ...' );
					$file_id = 'csv_games_import';
					//$msg_str is only used in summary messages
					$msg_str =array( __( 'game', 'mstw-schedules-scoreboards' ),  __( 'games', 'mstw-schedules-scoreboards' ) );
					// Check that a file has been uploaded			
					break;
					
				case __( 'Import Sports', 'mstw-schedules-scoreboards' ):
					//mstw_log_msg( 'In post() method: Importing Schedules ...' );
					$file_id = 'csv_sports_import';
					
					//$msg_str is only used in summary messages
					$msg_str =array( __( 'sport', 'mstw-schedules-scoreboards' ),  __( 'sports', 'mstw-schedules-scoreboards' ) );
					break;
					
				default:
					mstw_log_msg( 'Error encountered in post() method. $submit_value = ' . $submit_value . '. Exiting' );
					return;
					break;
			}
			
			if ( empty( $_FILES[$file_id]['tmp_name'] ) ) {
				//mstw_log_msg( 'In post() method: Looks like no file has been specified ?' );
				$this->log['error'][] = __( 'Select a CSV file to import. Exiting.', 'mstw-schedules-scoreboards' );
				$this->print_messages();
				return;
			}

			if ( !class_exists( 'MSTW_CSV_DataSource' ) ) {
				require_once 'MSTWDataSource.php';
			}
			
			$time_start = microtime( true );
			$csv = new MSTW_CSV_DataSource;
			
			$file = $_FILES[$file_id]['tmp_name'];
			$this->stripBOM( $file );
			
			//echo '<p> Loading file ' . $_FILES[$file_id]['name'] . ' ... </p>';
			//mstw_log_msg( 'Loading file ' . $_FILES[$file_id]['name'] . ' ... ' );
			// Check that .csv file can be loaded
			if ( !$csv->load( $file ) ) {
				mstw_log_msg( 'Failed to load file. ' . $_FILES[$file_id]['name'] . '. Exiting.' );
				$this->log['error'][] = sprintf( __( 'Failed to load file %s. Exiting.', 'mstw-schedules-scoreboards' ), $_FILES[$file_id]['name'] );
				$this->print_messages( );
				return;
			}

			//var_export( $csv->getHeaders( ) );
			//mstw_log_msg( $csv->getHeaders() );

			// pad shorter rows with empty values
			$csv->symmetrize( );

			// WordPress sets the correct timezone for date functions 
			// somewhere in the bowels of wp_insert_post(). We need 
			// strtotime() to return correct time before the call to
			// wp_insert_post().
			// mstw_set_wp_default_timezone( ); 

			$skipped = 0;
			$imported = 0;
			$comments = 0;
			foreach ( $csv->connect( ) as $csv_data ) {
				//mstw_log_msg( '$csv_data ... ' );
				
				if ( empty( $csv_data ) or !$csv_data ) {
					mstw_log_msg( 'No CSV data. $csv_data is empty.' );
				}
				
				// First try to create the post from the row
				if ( $post_id = $this->create_post( $csv_data, $options, $imported+1 ) ) {
					$imported++;
					//Insert the custom fields, which is most everything
					switch ( $file_id ) {
						case 'csv_venues_import':
							$this->create_venue_fields( $post_id, $csv_data );
							break;
						case 'csv_games_import':
							$this->create_game_fields( $post_id, $csv_data, $options );
							break;
						case 'csv_teams_import':
							$this->create_team_fields( $post_id, $csv_data, $options );
							break;
						case 'csv_schedules_import':
							$this->create_schedule_fields( $post_id, $csv_data );
							break;
						case 'csv_sports_import':
							$this->create_sport_fields( $post_id, $csv_data );
							break;
						default:
							mstw_log_msg( 'Oops, something went wrong with file ID: ' . $file_id );
							break;
					}
				} else {
					$skipped++;
				}
			}

			if ( file_exists($file) ) {
				@unlink( $file );
			}

			$exec_time = microtime( true ) - $time_start;

			if ($skipped) {
				$this->log['notice'][] = sprintf( __( 'Skipped %s %s (most likely due to empty title.)', 'mstw-schedules-scoreboards' ), $skipped, $msg_str[1] );
				//$this->log['notice'][] = "<b>Skipped {$skipped} posts (most likely due to empty title, body and excerpt).</b>";
			}
			
			$this->log['notice'][] = sprintf( __( 'Imported %s %s to database in %.2f seconds.','mstw-schedules-scoreboards' ), $imported, $msg_str[1], $exec_time );
			//$this->log['notice'][] = sprintf("<b>Imported {$imported} posts to {$term->slug} in %.2f seconds.</b>", $exec_time);
			
			$this->print_messages();
		} //End: post()
		
		/*-------------------------------------------------------------
		 *	Build a post from a row of CSV data
		 *-----------------------------------------------------------*/
		function create_post( $data, $options, $cntr ) {
			//extract( $options );
			//mstw_log_msg( 'In create_post() ... $options' );
			//mstw_log_msg( $options );

			$data = array_merge( $this->defaults, $data );
			
			// figure out what custom post type we're importing
			//switch ( $submit_value ) {
			switch( $options['submit_value'] ) {
				case __( 'Import Venues', 'mstw-schedules-scoreboards' ) :
					//mstw_log_msg( ' We are importing venues ... ' );
					$type = 'mstw_ss_venue';
					//this is used to add_action/remove_action below
					$save_suffix = 'venue_meta';
					
					// need a venue title to proceed
					if ( isset( $data['venue_title'] ) && !empty( $data['venue_title'] ) ) {
						$temp_title = $data['venue_title'];
					}
					else { //no title => skip this entry
						mstw_log_msg( 'Skipping entry ... no title' );
						return false;
					}
					
					// slug should come from CSV file; else will default to sanitize_title()
					$temp_slug = ( isset( $data['venue_slug'] ) && !empty( $data['venue_slug'] ) ) ? $data['venue_slug'] : sanitize_title( $temp_title, __( 'No title imported', 'mstw-schedules-scoreboards' ) );;
					break;
					
				case __( 'Import Teams', 'mstw-schedules-scoreboards' ) :
					//mstw_log_msg( ' We are importing teams ... ' );
					$type = 'mstw_ss_team';
					//this is used to add_action/remove_action below
					$save_suffix = 'team_meta';
					
					// team title should come from CSV file; else try to create from team name and mascot
					if ( isset( $data['team_title'] ) && !empty( $data['team_title'] ) ) {
						$temp_title = $data['team_title'];
					}
					else { //no team title => try to create from team name and mascot
						$temp_title = 'No team title';
						if ( isset( $data['team_full_name'] ) ) {
							$temp_title = $data['team_full_name'];
						}
						if ( isset( $data['team_full_mascot'] ) ) {
							$temp_title .= ' ' . $data['team_full_mascot'];
						}
					}
					
					// slug should come from CSV file; else will default to sanitize_title()
					$temp_slug = ( isset( $data['team_slug'] ) && !empty( $data['team_slug'] ) ) ? $data['team_slug'] : sanitize_title( $temp_title, __( 'No title imported', 'mstw-schedules-scoreboards' ) );
					break;
				
				case __( 'Import Sports', 'mstw-schedules-scoreboards' ) :
					//mstw_log_msg( ' We are importing sports ... ' );
					$type = 'mstw_ss_sport';
					//this is used to add_action/remove_action below
					$save_suffix = 'sport_meta';
					
					// team title should come from CSV file; else try to create from team name and mascot
					if ( isset( $data['sport_title'] ) && !empty( $data['sport_title'] ) ) {
						$temp_title = $data['sport_title'];
					}
					else { //no team title => try to create from team name and mascot
						$temp_title = 'No sport title';
						if ( isset( $data['sport_season'] ) && !empty( $data['sport_season'] ) ) {
							$temp_title = $data['sport_season'];
						}
						if ( isset( $data['sport_gender'] ) && !empty( $data['sport_gender'] ) ) {
							$temp_title .= ' ' . $data['sport_gender'];
						}
					}
					
					// slug should come from CSV file; else will default to sanitize_title()
					$temp_slug = ( isset( $data['sport_slug'] ) && !empty( $data['sport_slug'] ) ) ? $data['sport_slug'] : sanitize_title( $temp_title, __( 'No title imported', 'mstw-schedules-scoreboards' ) );
					//mstw_log_msg( 'slug: ' . $temp_slug );
					break;
				
				case __( 'Import Schedules', 'mstw-schedules-scoreboards' ) :
					//mstw_log_msg( ' We are importing schedules ... ' );
					$type = 'mstw_ss_schedule';
					//this is used to add_action/remove_action below
					$save_suffix = 'schedule_meta';
					
					// must have a title; else skip
					if ( isset( $data['schedule_title'] ) && !empty( $data['schedule_title'] ) ) {
						$temp_title = $data['schedule_title'];
					}
					else { //no title => skip this entry
						mstw_log_msg( 'Skipping entry ... no schedule title' );
						return false;
					}
					
					// slug should come from CSV file; else will default to sanitize_title()
					$temp_slug = ( isset( $data['schedule_slug'] ) && !empty( $data['schedule_slug'] ) ) ? $data['schedule_slug'] : sanitize_title( $temp_title, __( 'No title imported', 'mstw-schedules-scoreboards' ) );
					
					break;
					
				case __( 'Import Games', 'mstw-schedules-scoreboards' ) :
					//mstw_log_msg( ' We are importing games ... ' );
					$type = 'mstw_ss_game';
					//this is used to add_action/remove_action below
					$save_suffix = 'game_meta';
						
					// game title should come from CSV file; else create from slug
					if ( isset( $data['game_title'] ) && !empty( $data['game_title'] ) ) {
						$temp_title = $data['game_title'];
					}
					else { //no game title => create from game slug, which we already know exists
						$temp_title = __( 'No title imported', 'mstw-schedules-scoreboards' );
						//$temp_title .= $data['game_slug'];
					}
					
					// If no game slug is provided, create slug from game title
					// slug should come from CSV file; else will default to sanitize_title()
					$temp_slug = ( isset( $data['venue_slug'] ) && !empty( $data['venue_slug'] ) ) ? $data['venue_slug'] : sanitize_title( $temp_title, __( 'No title imported', 'mstw-schedules-scoreboards' ) );
					
					if ( !isset( $data['game_slug'] ) or empty( $data['game_slug'] ) ) {
						// convert title to slug
						$temp_slug = sanitize_title( $temp_title, __( 'No title imported', 'mstw-schedules-scoreboards' ) );
					}
					else {
						$temp_slug = $data['game_slug'];
					}
					
					//
					// Added for compatibility ... __DIR__ was not defined until WP 5.3
					//
					if ( !defined( '__DIR__' ) ) {
					   define( '__DIR__', dirname( __FILE__ ) );
					}
					
					break;
	
				default:
					mstw_log_msg( 'Whoa horsie ... $submit_value = ' . $options['submit_value'] );
					$this->log['error']["type-{$type}"] = sprintf(
						__( 'Unknown import type "%s".', 'mstw-schedules-scoreboards' ), $type );
					return false;
					break;
			}

			// Build the (mostly empty) post
			$new_post = array(
				'post_title'   => convert_chars( $temp_title ),
				'post_content' => '', //wpautop(convert_chars($data['Bio'])),
				'post_status'  => 'publish',
				'post_type'    => $type,
				'post_name'    => $temp_slug,
			);
			
			// create it
			
			remove_action( 'save_post_' . $type, 'mstw_ss_save_' . $save_suffix, 20, 2 );
			$post_id = wp_insert_post( $new_post );
			add_action( 'save_post_' . $type, 'mstw_ss_save_' . $save_suffix, 20, 2 );
			
			return $post_id;
			
		} //End function create_post()

		
		/*-------------------------------------------------------------
		 *	Add the fields from a row of CSV game data to a newly created post
		 *-----------------------------------------------------------*/
		function create_game_fields( $post_id, $data, $options ) {
			//mstw_log_msg( 'in create_game_fields with $options =' );
			//mstw_log_msg( $options );
			
			foreach ( $data as $k => $v ) {
				$k = strtolower( $k );
				switch (  $k ) {
					case 'game_title':
					case 'game_slug':
						//created with the post; nothing else to do here
						break;
						
					// BASIC GAME DATA
					// special handling for checkbox fields
					case 'game_is_final':
					case 'game_is_home_game':
						// have to convert home and empty string to 1 and 0
						$v = ( empty( $v ) ) ? 0 : 1;
						// fallthru is intentional
					case 'game_time_tba':
					case 'game_unix_dtg':

					case 'game_opponent_team': //from team DB
					case 'game_gl_location': //from venues DB - neutral sites
					
					//LEGACY STUFF (DEPRECATED)	
					case 'game_opponent':
					case 'game_opponent_link':						
					case 'game_location':
					case 'game_location_link':
					
					//GAME STATUS STUFF
					case 'game_our_score':
					case 'game_opp_score':
					case 'game_curr_period':
					case 'game_curr_time':
					case 'game_result':	
					
					//MEDIA STUFF
					case 'game_media_label_1':
					case 'game_media_label_2':
					case 'game_media_label_3':
					case 'game_media_url_1':
					case 'game_media_url_2':
					case 'game_media_url_3':
						$ret = update_post_meta( $post_id, $k, $v );
						break;
						
					case 'game_scoreboard':
						if( !empty( $v ) ) {
							//mstw_log_msg( 'CSV Game Scoreboard string: ' . $v );
							$scoreboards = array_filter( str_getcsv( $v, ';', '"' ) );
							$result = wp_set_object_terms( $post_id, $scoreboards, 'mstw_ss_scoreboard', false );
							//mstw_log_msg( $result );
						}
						break;
						
					case 'game_dtg':
						// Need to convert to a UNIX dtg stamp and store
						$k = 'game_unix_dtg';
						$v = strtotime( $v );
						$v = ( $v < 0 or $v === false ) ? current_time( 'timestamp' ) : $v ;
						$ret = update_post_meta( $post_id, $k, $v );
						break;
						
					case 'game_sched_id':
					    // if the 'game_sched_id' value is not empty(in the CSV file) use it; else use the
						//	schedule from the control on the admin screen
						//if( empty( $v ) && array_key_exists( 'csv_import_schedule', $options ) && $options['csv_import_schedule'] ) {
						if( empty( $v ) && array_key_exists( 'csv_import_schedule', $options ) ) {							
							$v = $options['csv_import_schedule'];
						}
						$ret = update_post_meta( $post_id, $k, $v );
							
						break;

					default:
						// bad column header
						mstw_log_msg( 'Unrecognized game data field: ' . $k );
						break;
						
				}
			}
		} //End of function create_game_fields()
		
		//-------------------------------------------------------------
		//	Add the fields from a row of CSV venue data to a newly created post
		//-------------------------------------------------------------
		function create_venue_fields( $post_id, $data ) {

			foreach ( $data as $k => $v ) {
				// anything that doesn't start with csv_ is a custom field
				if (!preg_match('/^csv_/', $k) && $v != '') {
					switch ( strtolower( $k ) ) {
						case 'venue_title':
						case 'venue_slug':
							//created with the post; nothing else to do here
							break;
						case 'venue_street':
						case 'venue_city':	
						case 'venue_state':
						case 'venue_zip':	
						case 'venue_map_url':
						case 'venue_url':
							$k = strtolower( $k );
							$ret = update_post_meta( $post_id, $k, $v );
							break;
						case 'venue_group':
							if( !empty( $v ) ) {
								//mstw_log_msg( 'CSV Venue Group string: ' . $v );
								$venue_groups = array_filter( str_getcsv( $v, ';', '"' ) );
								$result = wp_set_object_terms( $post_id, $venue_groups,'mstw_ss_venue_group', false );
								//mstw_log_msg( $result );
							}
							break;
						default:
							// bad column header
							mstw_log_msg( 'Unrecognized venue data field: ' . $k );
							break;
					}
					
					
				}
			}
		} //End of function create_venue_fields()
		
		//-------------------------------------------------------------
		//	Add the fields from a row of CSV schedule data to a newly created post
		//-------------------------------------------------------------
		function create_schedule_fields( $post_id, $data ) {

			foreach ( $data as $k => $v ) {
				// anything that doesn't start with csv_ is a custom field
				if (!preg_match('/^csv_/', $k) && $v != '') {
					switch ( strtolower( $k ) ) {
						case 'schedule_title':
						case 'schedule_slug':
							//part of creating the post; nothing else needed
							break; 
						case 'schedule_team':
							$k = strtolower( $k );
							$ret = update_post_meta( $post_id, $k, $v );
							break;
						default:
							// bad column header
							mstw_log_msg( 'Unrecognized schedule data field: ' . $k );
							break;
					}
				}
			}
		} //End of function create_schedule_fields()
		
		//-------------------------------------------------------------
		//	Add the fields from a row of CSV sport data to a newly created post
		//-------------------------------------------------------------
		function create_sport_fields( $post_id, $data ) {

			foreach ( $data as $k => $v ) {
				// anything that doesn't start with csv_ is a custom field
				if (!preg_match('/^csv_/', $k) && $v != '') {
					switch ( strtolower( $k ) ) {
						case 'sport_title':
						case 'sport_slug':
							//part of creating the post; nothing else needed
							break; 
						case 'sport_season':
						case 'sport_gender':
							$k = strtolower( $k );
							$ret = update_post_meta( $post_id, $k, $v );
							break;
						default:
							// bad column header
							mstw_log_msg( 'Unrecognized schedule data field: ' . $k );
							break;
					}
				}
			}
		} //End of function create_schedule_fields()
		
		
		//-------------------------------------------------------------
		//	Add the fields from a row of CSV team data to a newly created post
		//-------------------------------------------------------------
		function create_team_fields( $post_id, $data, $options ) {
			
			foreach ( $data as $k => $v ) {
				switch ( strtolower( $k ) ) {
					case 'team_title':
					case 'team_slug':
						//handled when creating the post
						break;
			
					case 'team_full_name':
					case 'team_short_name':	
					case 'team_full_mascot':
					case 'team_short_mascot':	
					case 'team_home_venue':
					case 'team_link':
						$k = strtolower( $k );
						$ret = update_post_meta( $post_id, $k, $v );
						break;
						
					// need some special handling for the logos
					case 'team_logo':
					case 'team_alt_logo':
						//$url will eventually be $v (logos not moved)
						//	or a file in the media library (logos moved)
						$url = '';
						if( !empty( $v ) ) {
							if( array_key_exists( 'csv_move_logos', $options ) and $options['csv_move_logos'] ) {
								//Going to move logos from another server
								//Try to download the logo file
								$temp_logo = download_url( $v );
								
								//Check for download errors
								if( is_wp_error( $temp_logo ) ) {
									mstw_log_msg( "Error downloading: $v" );
									mstw_log_msg( $temp_logo );
								}
								else { //Successfully downloaded file
									$file_array = array( 'name' => basename( $v ),
														'tmp_name' => $temp_logo,
													  );
									//Try to add file to media library & attach to team (CPT)
									$id = media_handle_sideload( $file_array, 0 );
									
									//Check for sideload errors
									if( is_wp_error( $id ) ) {
										mstw_log_msg( "Error loading file to media library: $temp_logo" );
										mstw_log_msg( $id );	
									} 
									else {
										//Successful sideload to media library. Update the team CPT
										$url = wp_get_attachment_url( $id );
										
									} //End: successful sideload to media library
								} //End: successfully downloaded file
							} //End: if( array_key_exists( 'csv_move_logos', $options )
							else {
								$url = $v;	
							}
							
							//Finally we're going to update the DB
							$k = strtolower( $k );
							if( empty( $url ) or mstw_is_valid_url( $url ) ) {
								// url is empty or is valid, so update the DB
								update_post_meta( $post_id, $k, esc_url( $url ) );
								//$ret = update_post_meta( $post_id, $k, $v );
							}
							else {
								mstw_log_msg( 'in mstw_validate_url ... got a bad URL: ' . $url );
								// url is not valid, display an error message (don't update DB)
								$notice .= ' ' . $url;			
								if ( function_exists( 'mstw_add_admin_notice' ) ) {
									mstw_add_admin_notice( 'mstw_admin_messages', 'error', "Invalid url: $url" );
								}
							}
							
						} // End: if( !empty( $v ) )
						break;
						
					default:
						// bad column header
						mstw_log_msg( 'Unrecognized team data field: ' . $k );
						break;
						
				} //End: switch ( strtolower( $k ) )	
			} //End: foreach( $data as $k => $v )
		} //End: create_team_fields( )


		/*-------------------------------------------------------------
		 *	Add the fields from a row of CSV data to a newly created post
		 *-----------------------------------------------------------*/
		function stripBOM($fname) {
			$res = fopen($fname, 'rb');
			if (false !== $res) {
				$bytes = fread($res, 3);
				if ($bytes == pack('CCC', 0xef, 0xbb, 0xbf)) {
					$this->log['notice'][] = 'Getting rid of byte order mark...';
					fclose($res);

					$contents = file_get_contents($fname);
					if (false === $contents) {
						trigger_error('Failed to get file contents.', E_USER_WARNING);
					}
					$contents = substr($contents, 3);
					$success = file_put_contents($fname, $contents);
					if (false === $success) {
						trigger_error('Failed to put file contents.', E_USER_WARNING);
					}
				} else {
					fclose($res);
				}
			} else {
				$this->log['error'][] = 'Failed to open file, aborting.';
			}
		}
	}
?>