 <div id="results">
<table>
	<th><span style="font-size: 2em;"><?php  echo $count;?> ADVERTISERS FOR <?php  echo $mag;?></span></th>
</table>
<table>
	<tr>
		<th>NAME</th>
		<th>SALESPERSON</th>
		<th>BILLING<br>CONTACT</th>
		<th>BILLING<br>PHONE</th>
		<th>BILLING<br>EMAIL</th>
		<th># OF<br>PROPERTIES</th>
		<th>PROPERTY<br>ONE NAME</th>
		<th>PROPERTY<br>ONE CONTACT</th>
		<th>PROPERTY<br>ONE PHONE</th>
		<th style="min-width:200px">NOTES</th>
		<th></th>
		<th></th>
		<th>PAST<br>DUE</th>

	</tr>
	<?php 
		foreach($advertisers AS $row){
			echo "<tr class='s_and_d_body'><td>".$row['name']."</td><td>".$row['associated_user']."</td>";
			echo "<td>".$row['billing_contact_name']."</td><td>".$row['billing_phone']."</td>";

			echo "<td> <a href='mailto:".$row['billing_email']."' class='mailto' >".$row['billing_email']."</a></td><td>".$row['number_of_properties']."</td>";
			echo "<td>".$row['property_one_name']."</td><td>".$row['property_one_contact']."</td>";
			echo "<td>".$row['property_one_phone']."</td>";
			echo "<td>".$row['notes']."</td>";
			
			echo "<td><a href='";

			echo base_url();
			echo "advertisers/edit_this/".$mag."/".$row['id']."' class='small_link'>edit</a><td><a href='";
			echo base_url();
			echo "advertisers/delete_this/".$mag."/".$row['id']."' class='small_link'>delete</a>";

			if($row['is_past_due'] == 'Y'){
				echo "<td class='bad'><span class='bad'>Past Due</span></td>";
			}else{
				echo "<td class='good'><span class='good'>Current</span></td>";
			}

			echo "</tr>";

		}

	 ?>
	

</table>
</div> 