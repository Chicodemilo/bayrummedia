<script type="text/javascript">

window.onload=function(){

	var current_mag = '<?php echo $this_mag; ?>';

	var mags = document.getElementById('associated_mag_1');

	var long_mags = mags.length;

	for(var i=0; i<long_mags; i++){
		if(mags.options[i].value === current_mag){
			mags.options[i].selected = "true";
			}
		}
	};
</script>

<form action="<?php echo base_url(); ?>advertisers/do_add_ad/<?php echo $this_mag ?>" method="post">
	<table>
		<tr>
			<th>ADD ADVERTISER</th>
		</tr>
	</table>

	<table>
		<tr><th colspan="100%">BASIC INFO</th></tr>
		<tr>
			<td class="righter">NAME:</td>
			<td><input type="text" name="name" required size="50" autofocus> </td>
			<td class="righter">STATUS:</td>
			<td>
				<select name="status" id="status">
					<option value="active" selected="selected">Active</option>
					<option value="inactive">Inactive</option>
				</select>
			</td>
			<td class="righter">SALESPERSON:</td>
			<td>
				<select name="associated_user_id" id="associated_user_id">
					<?php 
						foreach($users AS $row){
							echo "<option value='".$row['id']."'>".$row['first_name']." : ".$row['username']."</option>";
						}
					 ?>
				</select>
			</td>
			<td class="righter">MAGAZINE:</td>
			<td>
				<select name="associated_mag_1" id="associated_mag_1">
					<?php 
						foreach($mags AS $row){
							echo "<option value='".$row['short_name']."'>".$row['short_name']."</option>";
						}
					 ?>
				</select>
			</td>
			</td>
			<td class="righter">BILL TO STREET ADDRESS:</td>
			<td>
				<input type="checkbox" name="bill_to_property" value="Y">
			</td>

		</tr>
		<tr>
			<td></td>
			<td></td>

			<td class="righter">2ND MAGAZINE</td>
			<td>
				<select name="associated_mag_2" id="associated_mag_2">
					<option value="null">None</option>
					<?php 
						foreach($mags AS $row){
							echo "<option value='".$row['short_name']."'>".$row['short_name']."</option>";
						}
					 ?>
				</select>
			</td>
			<td class="righter">3RD MAGAZINE</td>
			<td> 
				<select name="associated_mag_3" id="associated_mag_3">
					<option value="null">None</option>
					<?php 
						foreach($mags AS $row){
							echo "<option value='".$row['short_name']."'>".$row['short_name']."</option>";
						}
					 ?>
				</select>
			</td>
			<td class="righter">MULTIPLE STREET LOCATIONS:</td>
			<td><input type="checkbox" name="multiple_properties" value="Y"> </td>
			<td class="righter">NUMBER OF STREET LOCATIONS:</td>
			<td> <select name="number_of_properties" id="number_of_properties">
				<?php for ($x=1; $x<= 50; $x++){
						echo "<option value='".$x."'>".$x."</option>";
					} ?>
			</select>	
			</td>
		</tr>
	</table>

	
	<table>
		<tr><th colspan="100%">BILLING INFO <span class="small">- LEAVE THIS BLOCK BLANK IF BILLING TO STREET ADDRESS</span></th></tr>
		<tr>
			<td class="righter">CONTACT NAME:</td>
			<td><input type="text" name="billing_contact_name" size="30"></td>
			<td class="righter">BILLING PHONE:</td>
			<td><input type="text" name="billing_phone" size="15"></td>
			<td class="righter">BILLING EMAIL:</td>
			<td><input type="text" name="billing_email" size="20"></td>
		</tr>
		<tr>
			<td class="righter">BILLING ADDRESS:</td>
			<td><input type="text" name="billing_street_address" size="50"></td>
			<td class="righter">BILLING CITY:</td><td><input type="text" name="billing_city" size="25"></td>
			<td class="righter">BILLING STATE:</td><td><input type="text" name="billing_state" size="2" value="TX"></td>
			<td class="righter">BILLING ZIP:</td>
			<td><input type="text" name="billing_zip" size="7"></td>
		</tr>
	</table>
	
	<table>
		<tr><th colspan="100%">STREET INFO</th></tr>
		<tr>
			<td class="righter">LOCATON NAME:</td>
			<td><input type="text" name="property_one_name" size="30"></td>
			<td class="righter">CONTACT NAME:</td>
			<td><input type="text" name="property_one_contact" size="30"></td>
			<td class="righter">PHONE:</td>
			<td><input type="text" name="property_one_phone" size="15"></td>
			<td class="righter">EMAIL:</td>
			<td><input type="text" name="property_one_email" size="20"></td>
		</tr>
		<tr>
			<td class="righter">ADDRESS:</td>
			<td><input type="text" name="property_one_street_address" size="50"></td>
			<td class="righter">CITY:</td><td><input type="text" name="property_one_city" size="25"></td>
			<td class="righter">STATE:</td><td><input type="text" name="property_one_state" size="2" value="TX"></td>
			<td class="righter">ZIP:</td>
			<td><input type="text" name="property_one_zip" size="7"></td>
		</tr>
	</table>

	<table>
	<tr>
		<td><input type="submit" value="Add Advertiser"></td>
	</tr>
	</table>

	<table>
		<tr><th colspan="100%">STREET LOCATION TWO INFO <span class="small">- IF NECESSARY</span></th></tr>
		<tr>
			<td class="righter">LOCATON NAME:</td>
			<td><input type="text" name="property_two_name" size="30"></td>
			<td class="righter">CONTACT NAME:</td>
			<td><input type="text" name="property_two_contact" size="30"></td>
			<td class="righter">PHONE:</td>
			<td><input type="text" name="property_two_phone" size="15"></td>
			<td class="righter">EMAIL:</td>
			<td><input type="text" name="property_two_email" size="20"></td>
		</tr>
		<tr>
			<td class="righter">ADDRESS:</td>
			<td><input type="text" name="property_two_street_address" size="50"></td>
			<td class="righter">CITY:</td><td><input type="text" name="property_two_city" size="25"></td>
			<td class="righter">STATE:</td><td><input type="text" name="property_two_state" size="2" value="TX"></td>
			<td class="righter">ZIP:</td>
			<td><input type="text" name="property_two_zip" size="7"></td>
		</tr>
	</table>


	<table>
		<tr><th colspan="100%">STREET LOCATION THREE INFO <span class="small">- IF NECESSARY</span></th></tr>
		<tr>
			<td class="righter">LOCATON NAME:</td>
			<td><input type="text" name="property_three_name" size="30"></td>
			<td class="righter">CONTACT NAME:</td>
			<td><input type="text" name="property_three_contact" size="30"></td>
			<td class="righter">PHONE:</td>
			<td><input type="text" name="property_three_phone" size="15"></td>
			<td class="righter">EMAIL:</td>
			<td><input type="text" name="property_three_email" size="20"></td>
		</tr>
		<tr>
			<td class="righter">ADDRESS:</td>
			<td><input type="text" name="property_three_street_address" size="50"></td>
			<td class="righter">CITY:</td><td><input type="text" name="property_three_city" size="25"></td>
			<td class="righter">STATE:</td><td><input type="text" name="property_three_state" size="2" value="TX"></td>
			<td class="righter">ZIP:</td>
			<td><input type="text" name="property_three_zip" size="7"></td>
		</tr>
	</table>


	<table>
		<tr><th colspan="100%">STREET LOCATION FOUR INFO <span class="small">- IF NECESSARY</span></th></tr>
		<tr>
			<td class="righter">LOCATON NAME:</td>
			<td><input type="text" name="property_four_name" size="30"></td>
			<td class="righter">CONTACT NAME:</td>
			<td><input type="text" name="property_four_contact" size="30"></td>
			<td class="righter">PHONE:</td>
			<td><input type="text" name="property_four_phone" size="15"></td>
			<td class="righter">EMAIL:</td>
			<td><input type="text" name="property_four_email" size="20"></td>
		</tr>
		<tr>
			<td class="righter">ADDRESS:</td>
			<td><input type="text" name="property_four_street_address" size="50"></td>
			<td class="righter">CITY:</td><td><input type="text" name="property_four_city" size="25"></td>
			<td class="righter">STATE:</td><td><input type="text" name="property_four_state" size="2" value="TX"></td>
			<td class="righter">ZIP:</td>
			<td><input type="text" name="property_four_zip" size="7"></td>
		</tr>
	</table>


	<table>
		<tr><th colspan="100%">STREET LOCATION FIVE INFO <span class="small">- IF NECESSARY</span></th></tr>
		<tr>
			<td class="righter">LOCATON NAME:</td>
			<td><input type="text" name="property_five_name" size="30"></td>
			<td class="righter">CONTACT NAME:</td>
			<td><input type="text" name="property_five_contact" size="30"></td>
			<td class="righter">PHONE:</td>
			<td><input type="text" name="property_five_phone" size="15"></td>
			<td class="righter">EMAIL:</td>
			<td><input type="text" name="property_five_email" size="20"></td>
		</tr>
		<tr>
			<td class="righter">ADDRESS:</td>
			<td><input type="text" name="property_five_street_address" size="50"></td>
			<td class="righter">CITY:</td><td><input type="text" name="property_five_city" size="25"></td>
			<td class="righter">STATE:</td><td><input type="text" name="property_five_state" size="2" value="TX"></td>
			<td class="righter">ZIP:</td>
			<td><input type="text" name="property_five_zip" size="7"></td>
		</tr>
	</table>


	<table>
		<tr><th colspan="100%">STREET LOCATION SIX INFO <span class="small">- IF NECESSARY</span></th></tr>
		<tr>
			<td class="righter">LOCATON NAME:</td>
			<td><input type="text" name="property_six_name" size="30"></td>
			<td class="righter">CONTACT NAME:</td>
			<td><input type="text" name="property_six_contact" size="30"></td>
			<td class="righter">PHONE:</td>
			<td><input type="text" name="property_six_phone" size="15"></td>
			<td class="righter">EMAIL:</td>
			<td><input type="text" name="property_six_email" size="20"></td>
		</tr>
		<tr>
			<td class="righter">ADDRESS:</td>
			<td><input type="text" name="property_six_street_address" size="50"></td>
			<td class="righter">CITY:</td><td><input type="text" name="property_six_city" size="25"></td>
			<td class="righter">STATE:</td><td><input type="text" name="property_six_state" size="2" value="TX"></td>
			<td class="righter">ZIP:</td>
			<td><input type="text" name="property_six_zip" size="7"></td>
		</tr>
	</table>


</form>
