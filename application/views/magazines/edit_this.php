
<script type="text/javascript">

window.onload=function(){
	
	// window.alert("hello cleveland!");
	
	var status = '<?php echo $data['status']; ?>';

	var lifespan = '<?php echo $data['lifespan']; ?>';

	var life = document.getElementById('lifespan_select');

	var long_life = life.length;

	var stat = document.getElementById('status_select');

	var long_stat = stat.length;


	for(var i=0; i<long_life; i++){
		// window.alert(life.options[i].value+' '+lifespan);  //for testing

		if(life.options[i].value === lifespan){
			life.options[i].selected = "true";
		}
	}

	for(var x=0; x< long_stat; x++){
		// window.alert(stat.options[x].value+' '+status);  //for testing
		if(stat.options[x].value === status){
			stat.options[x].selected = "true";
		}
		
	}

};




</script>

<form action="<?php echo base_url(); ?>home/do_edit_mag" method="post">
	<table>
		<tr>
			<td width="15%">Short Name:</td>
			<td><input type="hidden" name="short_name" placeholder="example: GSAR" style="width : 90%" value="<?php echo $data['short_name']; ?>">You Can't Edit The Short Name: <?php echo $data['short_name']; ?></td>
		</tr>
		<tr>
			<td width="15%">Long Name:</td>
			<td><input type="text" name="long_name" placeholder="example: Greater San Angelo Renter" style="width : 90%" value="<?php echo $data['name']; ?>" required></td>
		</tr>
		<tr>
			<td width="15%">Market:</td>
			<td><input type="text" name="market" placeholder="example: Abilene" style="width : 90%" value="<?php echo $data['market']; ?>" required></td>
		</tr>
		<tr>
			<td>Edition Lifespan:</td>
			<td>
				<select name="lifespan" id="lifespan_select">
					<option value="Annual">Annual</option>
					<option value="Semiannual">Semiannual</option>
					<option value="Quarterly">Quarterly</option>
					<option value="Monthly">Monthly</option>
					<option value="4 Weeks">4 Weeks</option>
					<option value="2 Weeks">2 Weeks</option>
					<option value="1 Week">1 Week</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Edition Life In Weeks:</td>
			<td><?php echo $data['weeks_of_life']; ?></td>
		</tr>
		<tr>
			<td>Weeks Of Production</td>
			<td><?php echo $data['in_production_weeks']; ?></td>
		</tr>
		<tr>
		<tr>
			<td>Status:</td>
			<td>
				<select name="status" id="status_select">
					<option value="Active" id="active">Active</option>
					<option value="Inactive" id="inactive">Inactive</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="15%"><input type="hidden" name="id" value="<?php echo $data['id']; ?>"><input type="hidden" name="old_name" value="<?php echo $data['short_name']; ?>"></td><td><input type="submit" value="Edit Magazine"></td>
		</tr>
		


	</table>
</form>

