<?php get_header(); ?>

<?php
$post_id = get_the_ID();
//echo "Post ID: " . $post_id . "<br>";
//echo "Course ID (id_visual_systems): " . get_field('id_visual_systems') . "<br>";
//echo "SELECT * FROM {$wpdb->prefix}custom_visualsystems_appointments WHERE course_id = '".get_field('id_visual_systems')."' ORDER BY date ASC";
$appointments = $wpdb->get_results("SELECT appointment_id, start_date, end_date, room, location, places_left FROM {$wpdb->prefix}custom_visualsystems_appointments WHERE course_id = '".get_field('id_visual_systems')."' AND parent_id = 0 ORDER BY start_date ASC", ARRAY_A);
if($appointments){
?>
<main class="single-post" id="main-content">
	<div style='height: 200px;'></div>
	<div class='single-body bg-light'>
		<table>
			<thead>
				<tr>
					<th>
						Datum
					</th>
					<th>
						Tijd
					</th>
					<th>
						Dag
					</th>
					<th>
						Locatie
					</th>
					<th>
						Vrije plaatsen
					</th>
					<th>			
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($appointments as $a){
					$sibling_dates = $wpdb->get_results("SELECT start_date FROM {$wpdb->prefix}custom_visualsystems_appointments WHERE parent_id = '{$a['appointment_id']}' ORDER BY start_date ASC", ARRAY_A);
					$dates = date("d-m-Y", $a['start_date']);
					foreach($sibling_dates as $sd){
						$dates .= " en ".date("d-m-Y", $sd['start_date']);
					}
					?>
					<tr>
						<td width="300">
		                    <?php echo $dates; ?>
		                </td>
		                <td>
		                    <?php echo date("H:i", $a['start_date'])." - ".date("H:i", $a['end_date']); ?>
		                </td>
		                <td>
		                    <?php echo date_i18n("l", $a['start_date']); ?>
		                </td>
		                <td>
		                    <?php echo ($a['room'] != "") ? $a['room'] : $a['location']; ?>
		                </td>
		                <td>
		                    <?php echo ($a['places_left'] > 0) ? $a['places_left'] : 0; ?>
		                </td>
					</tr>                
					<?php
				}
				//print_r($appointments);
				?>
			</tbody>
		</table>
	</div>
</main>
<?php
}
?>
<?php get_footer(); ?>