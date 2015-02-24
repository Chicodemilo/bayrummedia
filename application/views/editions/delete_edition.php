<div id="results">
<table>
	<tr>
		<th><?php echo $mag; ?>: CHOOSE AN EDITION NUMBER TO DELETE</th>
	</tr>
</table>
<table>
	<tr>
		<th>EDITION NUMBER</th>
		<th>EDITION NAME</th>
		<th>FIRST DAY</th>
		<th>FINAL DAY</th>
		<th>STATUS</th>
	</tr>
	<?php 
		foreach($editions->result() AS $row){
			echo "<tr><td><a href='";
			echo base_url();
			echo "editions/delete_this/".$row->edition_number."/".$mag."'>".$row->edition_number."</a></td><td>".$row->edition_name."</td><td>".$row->edition_first_month."</td><td>".$row->edition_final_month."</td>";
			echo "<td>".$row->edition_status."</td>";
			echo "</tr>";

		}

	 ?>
	

</table>
</div> 
