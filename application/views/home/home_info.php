
<div class='center'>
	<table>
		<tr>
			<th>IN PRODUCTION PUBLICATIONS</th>
			<th>NOTES</th>
			<th>LIVE DATE</th>
			<th>STATUS</th>
			<th>PAGE COUNT</th>
			<th>SALES TO DATE</th>
		</tr>
		<?php 
			if($prod_mags != "N"){
				foreach($prod_mags AS $row){
				echo "<tr><td><a href='";
				echo base_url();
				echo "items/all/".$row[0]['magazine']."/".$row[0]['id']."'>".$row[0]['magazine']." ".$row[0]['edition_name']."</a></td>";
				echo "<td><a href='";
				echo base_url();
				echo "home/notes/".$row[0]['magazine']."'>".$row[0]['magazine']." NOTES"."</a></td>";
				echo "<td>".$row[0]['edition_first_month']."</td>";
				echo "<td>".$row[0]['edition_status']."</td><td>".$row[0]['page_total']."</td><td>$".$row[0]['sold_total'];
				echo "</tr>";
				}

			}

		 ?>
	</table>

	<table>
		<tr>
			<th>LIVE PUBLICATIONS</th>
			<th>NOTES</th>
			<th>DEAD DATE</th>
			<th>STATUS</th>
			<th>PAGE COUNT</th>
			<th>SALES</th>
		</tr>
		<?php 
			foreach($live_mags AS $row){
				echo "<tr><td><a href='";
				echo base_url();
				echo "items/all/".$row['mag']."/".$row['id']."'>".$row['mag']." ".$row['edition_name']."</a></td>";
				echo "<td><a href='";
				echo base_url();
				echo "home/notes/".$row['mag']."'>".$row['mag']." NOTES"."</a></td>";
				echo "<td>".$row['edition_final_month']."</td>";
				echo "<td>".$row['edition_status']."</td><td>".$row['page_total']."</td><td>$".$row['sold_total'];
				echo "</tr>";

			}

		 ?>
	</table>
</div>