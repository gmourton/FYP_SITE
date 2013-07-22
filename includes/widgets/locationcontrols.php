<div class="widget">
	<div class="inner">
	<!---<form action="locate.php" method="post">--->
		<ul>
			<li>
				<select name="uniquids">
				<?php
					foreach ($uids as $uid => $value) {
						echo '<option value="'. $value .'">'. $value .'</option>';
					}
				?>
			</select>
			</li>
			<!--- <li>
				// <select name="dates">
				// <?php
					// foreach ($test as $t => $v) {
						// echo '<option value="'. $v .'">'. $v .'</option>';
					// }
				// ?>
			// </select>
			// </li>--->
			<li>
			<script>
			  var unavailableDates = <?php echo get_all_location_Data("9dfb68f844434fa9") ?>;
			</script>
				<button onclick="showLocations(unavailableDates)">Show Locations</button> 
			</li>
		</ul>
		<!---</form>--->
	</div>
</div>
