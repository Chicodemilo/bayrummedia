<div id="results">
<table>
	<th>CHOOSE A MAGAZINE TO SEE EDITIONS</th>
</table>
<table>
	<tr>
		<th>SHORT NAME</th>
		<th>NOTES</th>
		<th>LONG NAME</th>
		<th>MARKET</th>
		<th>LIFESPAN</th>
		<th>LIFE IN WEEKS</th>
		<th>WEEKS IN PRODUCTION</th>
		<th>STATUS</th>
	</tr>
	<?php 
		foreach($mags->result() AS $row){
			echo "<tr><td><a href='";
			echo base_url();
			echo "editions/all/".$row->short_name."'>".$row->short_name." Editons</a></td>";
			echo "<td><a href='";
			echo base_url();
			echo "home/notes/".$row->short_name."'>".$row->short_name." Notes</a></td>";
			echo "<td>".$row->name."</td><td>".$row->market."</td>";
			echo "<td>".$row->lifespan."</td><td>".$row->weeks_of_life."</td><td>".$row->in_production_weeks."</td><td>".$row->status."</td>";
			echo "</tr>";
		}

	 ?>
	

</table>
</div>