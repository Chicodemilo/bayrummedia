<div id="results">
<table>
	<tr>
		<th><span style="font-size: 2em;"><?php echo $editions[0]['magazine']; ?></span></th>
	</tr>
</table>

<table>
	<tr>
		<th>EDITION NUMBER</th>
		<th>EDITION NAME</th>
		<th>FIRST DAY</th>
		<th>FINAL DAY</th>
		<th>PAGE TOTAL</th>
		<th>SALES TOTAL</th>
		<th>STATUS</th>
	</tr>
	<?php 


		foreach($editions AS $row){
			
			echo "<tr><td><a href='".base_url()."items/all/".$row['magazine']."/".$row['id']."' >".$row['edition_number']."</a></td><td>".$row['edition_name']."</td><td>".$row['edition_first_month']."</td><td>".$row['edition_final_month']."</td><td>".$row['page_total']."</td><td>$".$row['sold_total']."</td><td>".$row['edition_status']."</td></tr>";

		}

	 ?>
	

</table>
</div>