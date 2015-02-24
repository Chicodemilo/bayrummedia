
<script type="text/javascript">

window.onload=function(){
	
	var status = "<?php echo $edit_this['status']; ?>";
	var stat = document.getElementById('status_select');
	var long_stat = stat.length;
	for(var x=0; x< long_stat; x++){
		// window.alert(stat.options[x].value+' '+status);  //for testing
		if(stat.options[x].value === status){
			stat.options[x].selected = "true";
		}
	}	


	var number_of_properties = "<?php echo $edit_this['number_of_properties']; ?>";
	// window.alert(number_of_properties);
	var num_of_prop_id = document.getElementById('number_of_properties');
	var long_num = num_of_prop_id.length;
	for(var x=0; x< long_num; x++){
		// window.alert(number_of_properties);
		// window.alert(num_of_prop_id.options[x].value+' '+number_of_properties);  //for testing
		if(num_of_prop_id.options[x].value === number_of_properties){
			num_of_prop_id.options[x].selected = "true";
		}
	}


	var associated_user = "<?php echo $edit_this['associated_user_id']; ?>";
	// window.alert(associated_user);
	var ass_user_id = document.getElementById('associated_user');
	var long_num = ass_user_id.length;
	for(var x=0; x< long_num; x++){
		if(ass_user_id.options[x].value === associated_user){
			ass_user_id.options[x].selected = "true";
		}
	}


	var associated_mag_1 = "<?php echo $edit_this['associated_mag_1']; ?>";
	var ass_mag_1_id = document.getElementById('associated_mag_1');
	var long_num = ass_mag_1_id.length;
	for(var x=0; x< long_num; x++){
		if(ass_mag_1_id.options[x].value === associated_mag_1){
			ass_mag_1_id.options[x].selected = "true";
		}
	}


	var associated_mag_2 = "<?php echo $edit_this['associated_mag_2']; ?>";
	var ass_mag_2_id = document.getElementById('associated_mag_2');
	var long_num = ass_mag_2_id.length;
	for(var x=0; x< long_num; x++){
		if(ass_mag_2_id.options[x].value === associated_mag_2){
			ass_mag_2_id.options[x].selected = "true";
		}
	}


	var associated_mag_3 = "<?php echo $edit_this['associated_mag_3']; ?>";
	var ass_mag_3_id = document.getElementById('associated_mag_3');
	var long_num = ass_mag_3_id.length;
	for(var x=0; x< long_num; x++){
		if(ass_mag_3_id.options[x].value === associated_mag_3){
			ass_mag_3_id.options[x].selected = "true";
		}
	}


	var bill_to_property = "<?php echo $edit_this['bill_to_property']; ?>";
	var bill_to_id = document.getElementById('bill_to_property');
	if(bill_to_property == 'Y'){
		bill_to_id.checked = 'checked';
	}else{
		bill_to_id.checked = '';
	}



	var multiple_properties = "<?php echo $edit_this['multiple_properties']; ?>";
	var mult_prop_id = document.getElementById('multiple_properties');
	if(multiple_properties == 'Y'){
		mult_prop_id.checked = 'checked';
	}else{
		mult_prop_id.checked = '';
	}



	var split_payment_evenly = "<?php echo $edit_this['split_payment_evenly']; ?>";
	var split_pay_id = document.getElementById('split_payment_evenly');
	if(split_payment_evenly == 'Y'){
		split_pay_id.checked = 'checked';
	}else{
		split_pay_id.checked = '';
	}


	var is_past_due = "<?php echo $edit_this['is_past_due']; ?>";
	var is_past_due_id = document.getElementById('is_past_due');
	if(is_past_due == 'Y'){
		is_past_due_id.checked = 'checked';
	}else{
		is_past_due_id.checked = '';
	}

};
</script>

<form action="<?php echo base_url(); ?>advertisers/do_edit_ad/<?php echo $mag ?>/<?php echo $edit_this['id'] ?>" method="post">
	<table>
		<tr>
			<td class="indif" colspan="2">MAKE YOUR CHANGES BELOW</td>
		</tr>

		<tr>
			<td colspan="2"><input type="submit" value="Submit Edits"></td>
		</tr>

		<?php 
			// $x = count($delete_this);

			// for($i = 0; $i <= $x; $i++){
			// 	echo 	"<tr>
			// 				<td>".$delete_this[$i]."</td>
			// 			</tr>
			// 			";
			// }

			foreach ($edit_this as $key => $value) {
				if($key == 'id'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'>".$value."</td></tr>";
					echo "<input type='hidden' name='id' value='".$value."'>";
				}elseif($key == 'status'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><select name='status' id='status_select'>
					<option value='active' selected='selected'>Active</option>
					<option value='inactive'>Inactive</option>
					</select></td></tr>";
				}elseif($key == 'associated_user_id'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'>".$value."</td></tr>";
					echo "<input type='hidden' name='associated_user_id' value='".$value."'>";
				}elseif($key == 'bill_to_property'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><input type='checkbox' id='bill_to_property' name='bill_to_property' value='Y' checked=''></td></tr>";
				}elseif($key == 'multiple_properties'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><input type='checkbox' id='multiple_properties' name='multiple_properties' value='Y' checked=''></td></tr>";
				}elseif($key == 'split_payment_evenly'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><input type='checkbox' id='split_payment_evenly' name='split_payment_evenly' value='Y' checked=''></td></tr>";
				}elseif($key == 'is_past_due'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><input type='checkbox' id='is_past_due' name='is_past_due' value='Y' checked=''></td></tr>";
				}elseif($key == 'number_of_properties'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><select name='number_of_properties' id='number_of_properties'>";
					for ($x=1; $x<= 50; $x++){
						echo "<option value='".$x."'>".$x."</option>";
					}
					echo "</select></td></tr>";
				}elseif($key == 'associated_user'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><select name='associated_user' id='associated_user'>";
					foreach($users AS $row){
							echo "<option value='".$row['id']."'>".$row['first_name']." : ".$row['username']."</option>";
					}
					echo "</select></td></tr>";
				}elseif($key == 'associated_mag_1'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><select name='associated_mag_1' id='associated_mag_1'>";
					echo "<option value=NULL>None</option> ";
					foreach($mags AS $row){
							echo "<option value='".$row['short_name']."'>".$row['short_name']."</option>";
						}
					echo "</select></td></tr>";
				}elseif($key == 'associated_mag_2'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><select name='associated_mag_2' id='associated_mag_2'>";
					echo "<option value=NULL>None</option> ";
					foreach($mags AS $row){
							echo "<option value='".$row['short_name']."'>".$row['short_name']."</option>";
						}
					echo "</select></td></tr>";
				}elseif($key == 'associated_mag_3'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><select name='associated_mag_3' id='associated_mag_3'>";
					echo "<option value=NULL>None</option> ";
					foreach($mags AS $row){
							echo "<option value='".$row['short_name']."'>".$row['short_name']."</option>";
						}
					echo "</select></td></tr>";
				}elseif($key == 'notes'){
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><textarea name='".$key."' rows='4' cols='71'>".$value."</textarea></td></tr>";
				}
				else{
					echo "<tr><td class='righter' width='20%'>".$key.":</td><td class='bolder'><input type='text' name='".$key."' value='".$value."' size='100%'></td></tr>";
				}
			}
		 ?>
	</table>
</form>