<div id="results">
<table>
	<th><span style="font-size: 2em;"><?php  echo $count;?> ADVERTISERS FOUND</span></th>
</table>
<table>
	<tr>
		<th>NAME</th>
		<th>ID</th>
		<th>SALESPERSON</th>
		<th>MAGAZINE 1</th>
		<th>MAGAZINE 2</th>
		<th>MAGAZINE 3</th>
		<th>IS PAST DUE</th>
		<th>STATUS</th>

	</tr>
	<?php 

		foreach($advertisers AS $row){
			echo "<tr><td>".$row['name']."</td>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['associated_user']."</td>";
			echo "<td>".$row['associated_mag_1']."</td>";
			echo "<td>".$row['associated_mag_2']."</td>";
			echo "<td>".$row['associated_mag_3']."</td>";

			if($row['is_past_due'] == 'Y'){
				echo "<td class='bad'><span class='bad'>Past Due</span></td>";
			}else{
				echo "<td class='good'><span class='good'>Current</span></td>";
			}

			if($row['status'] == 'active'){
				echo "<td class='good'><span class='good'>Active</span></td>";
			}else{
				echo "<td class='bad'><span class='bad'>Inactive</span></td>";
			}

			echo "</tr>";

		}

	 ?>
	

</table>
</div> 