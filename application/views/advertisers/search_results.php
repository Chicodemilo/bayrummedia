<div id="results">
<table>
	<th><span style="font-size: 2em;"><?php  echo $count;?> ADVERTISERS FOR SEARCH: <?php  echo $query;?></span></th>
</table>
<table>
	<tr>
		<th>NAME</th>
		<th>SALESPERSON</th>
		<th>MAG 1</th>
		<th>MAG 2</th>
		<th>MAG 3</th>
		<th></th>
		<th></th>
		<th></th>

	</tr>
	<?php 
		foreach($advertisers AS $row){
			echo "<tr><td>".$row['name']."</td><td>".$row['associated_user']."</td>";
			echo "<td>".$row['associated_mag_1']."</td>";
			echo "<td>".$row['associated_mag_2']."</td>";
			echo "<td>".$row['associated_mag_3']."</td>";


			echo "<td><a href='";
			echo base_url();
			echo "advertisers/edit_this/".$row['associated_mag_1']."/".$row['id']."'>edit</a></td><td><a href='";
			echo base_url();
			echo "advertisers/delete_this/".$row['associated_mag_1']."/".$row['id']."'>delete</a>";

			if($row['is_past_due'] == 'Y'){
				echo "<td class='bad'><span class='bad'>Past Due</span></td>";
			}else{
				echo "<td class='good'><span class='good'>Current</span></td>";
			}

			echo "</tr>";

		}

	 ?>
	

</table>

<form action="<?php echo base_url(); ?>advertisers/find_ad" method="post">

	<table>
		<tr>
				<td width="130">Search By Name:</td>
				<td width="250"><input type="text" name="ad_search" id="ad_search" size="50"></td>
				<td><input type="submit" value="Search"></td>
		</tr>
	</table>

</form>
</div> 