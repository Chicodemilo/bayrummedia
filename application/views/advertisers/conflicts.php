<div id="results">
<table>
	<th class="bad"><span style="font-size: 2em;"><?php  echo $count;?> POTENTIAL CONFLICT(S) FOUND</span></th>
</table>

<table>
	<tr><th>Are Any Of These Advertiser(s) Who You Want To Add?</th></tr>
</table>

<table>
	<tr><th>Name</th>
	<th>Billing Name</th>
	<th>Address</th>
	<th class="bad">Similarity Found</th>
	<?php 
		foreach ($conflicts as $row) {
			echo "<tr>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['billing_contact_name']."</td>";
			echo "<td>".$row['billing_phone']."</td>";
			echo "<td>".$row['condition']."</td>";
			echo "</tr>";
		}
	 ?>
	</tr>
</table>

<table>
	<tr>
		<td>Please make sure the advertiser you want to add is not already in the database.<br><br>Having multiple entries for one account is can really mess things up.<br><br>
		So even if you don't see the new advertiser here, please double check  <a href="<?php echo base_url() ?>advertisers/all" target="blank" style="font-weight:bold; display:inline;">here</a> to make sure they aren't already in the database. <br><br> Thanks!</td>
	</tr>
</table>

<table>
	<th>The advertiser I wanted to add is already in the database.  <a href="<?php echo base_url() ?>advertisers/all" style="font-weight:bold; display:inline;">I don't need to ad a new advertiser</a></th>
</table>

<form action="<?php echo base_url(); ?>advertisers/add_anyway/<?php echo $mag; ?>" method="post">

<table>
	<tr>
		<th>I'm sure it's none of these advertisers.  <input type="submit" value="Add Them"></th>
	</tr>
</table>


		<input type="hidden" name="name" value="<?php echo $entered_data['name'] ?>">
		<input type="hidden" name="status" value="<?php echo $entered_data['status'] ?>">
		<input type="hidden" name="associated_user" value="<?php echo $entered_data['associated_user'] ?>">
		<input type="hidden" name="associated_mag_1" value="<?php echo $entered_data['associated_mag_1'] ?>" >
		<input type="hidden" name="bill_to_property" value="<?php echo $entered_data['bill_to_property'] ?>" >
		<input type="hidden" name="associated_mag_2" value="<?php echo $entered_data['associated_mag_2'] ?>">
		<input type="hidden" name="associated_mag_3" value="<?php echo $entered_data['associated_mag_3'] ?>">
		<input type="hidden" name="multiple_properties" value="<?php echo $entered_data['multiple_properties'] ?>"> 
		<input type="hidden" name="number_of_properties" value="<?php echo $entered_data['number_of_properties'] ?>">	

		<input type="hidden" name="billing_contact_name" value="<?php echo $entered_data['billing_contact_name'] ?>">
		<input type="hidden" name="billing_phone" value="<?php echo $entered_data['billing_phone'] ?>">
		<input type="hidden" name="billing_email" value="<?php echo $entered_data['billing_email'] ?>">
		<input type="hidden" name="billing_street_address" value="<?php echo $entered_data['billing_street_address'] ?>">
		<input type="hidden" name="billing_city" value="<?php echo $entered_data['billing_city'] ?>">
		<input type="hidden" name="billing_state" value="<?php echo $entered_data['billing_state'] ?>">
		<input type="hidden" name="billing_zip" value="<?php echo $entered_data['billing_zip'] ?>">

		<input type="hidden" name="property_one_name" value="<?php echo $entered_data['property_one_name'] ?>">
		<input type="hidden" name="property_one_contact" value="<?php echo $entered_data['property_one_contact'] ?>">
		<input type="hidden" name="property_one_phone" value="<?php echo $entered_data['property_one_phone'] ?>">
		<input type="hidden" name="property_one_email" value="<?php echo $entered_data['property_one_email'] ?>">
		<input type="hidden" name="property_one_street_address" value="<?php echo $entered_data['property_one_street_address'] ?>">
		<input type="hidden" name="property_one_city" value="<?php echo $entered_data['property_one_city'] ?>">
		<input type="hidden" name="property_one_state" value="<?php echo $entered_data['property_one_state'] ?>">
		<input type="hidden" name="property_one_zip" value="<?php echo $entered_data['property_one_zip'] ?>">

		<input type="hidden" name="property_two_name" value="<?php echo $entered_data['property_two_name'] ?>">
		<input type="hidden" name="property_two_contact" value="<?php echo $entered_data['property_two_contact'] ?>">
		<input type="hidden" name="property_two_phone" value="<?php echo $entered_data['property_two_phone'] ?>">
		<input type="hidden" name="property_two_email" value="<?php echo $entered_data['property_two_email'] ?>">
		<input type="hidden" name="property_two_street_address" value="<?php echo $entered_data['property_two_street_address'] ?>" >
		<input type="hidden" name="property_two_city" value="<?php echo $entered_data['property_two_city'] ?>">
		<input type="hidden" name="property_two_state" value="<?php echo $entered_data['property_two_state'] ?>">
		<input type="hidden" name="property_two_zip" value="<?php echo $entered_data['property_two_zip'] ?>">

		<input type="hidden" name="property_three_name" value="<?php echo $entered_data['property_three_name'] ?>">
		<input type="hidden" name="property_three_contact" value="<?php echo $entered_data['property_three_contact'] ?>">
		<input type="hidden" name="property_three_phone" value="<?php echo $entered_data['property_three_phone'] ?>">
		<input type="hidden" name="property_three_email" value="<?php echo $entered_data['property_three_email'] ?>">
		<input type="hidden" name="property_three_street_address" value="<?php echo $entered_data['property_three_street_address'] ?>" >
		<input type="hidden" name="property_three_city" value="<?php echo $entered_data['property_three_city'] ?>">
		<input type="hidden" name="property_three_state" value="<?php echo $entered_data['property_three_state'] ?>">
		<input type="hidden" name="property_three_zip" value="<?php echo $entered_data['property_three_zip'] ?>">

		<input type="hidden" name="property_four_name" value="<?php echo $entered_data['property_four_name'] ?>">
		<input type="hidden" name="property_four_contact" value="<?php echo $entered_data['property_four_contact'] ?>">
		<input type="hidden" name="property_four_phone" value="<?php echo $entered_data['property_four_phone'] ?>">
		<input type="hidden" name="property_four_email" value="<?php echo $entered_data['property_four_email'] ?>">
		<input type="hidden" name="property_four_street_address" value="<?php echo $entered_data['property_four_street_address'] ?>" >
		<input type="hidden" name="property_four_city" value="<?php echo $entered_data['property_four_city'] ?>">
		<input type="hidden" name="property_four_state" value="<?php echo $entered_data['property_four_state'] ?>">
		<input type="hidden" name="property_four_zip" value="<?php echo $entered_data['property_four_zip'] ?>">

		<input type="hidden" name="property_five_name" value="<?php echo $entered_data['property_five_name'] ?>">
		<input type="hidden" name="property_five_contact" value="<?php echo $entered_data['property_five_contact'] ?>">
		<input type="hidden" name="property_five_phone" value="<?php echo $entered_data['property_five_phone'] ?>">
		<input type="hidden" name="property_five_email" value="<?php echo $entered_data['property_five_email'] ?>">
		<input type="hidden" name="property_five_street_address" value="<?php echo $entered_data['property_five_street_address'] ?>" >
		<input type="hidden" name="property_five_city" value="<?php echo $entered_data['property_five_city'] ?>">
		<input type="hidden" name="property_five_state" value="<?php echo $entered_data['property_five_state'] ?>">
		<input type="hidden" name="property_five_zip" value="<?php echo $entered_data['property_five_zip'] ?>">

		<input type="hidden" name="property_six_name" value="<?php echo $entered_data['property_six_name'] ?>">
		<input type="hidden" name="property_six_contact" value="<?php echo $entered_data['property_six_contact'] ?>">
		<input type="hidden" name="property_six_phone" value="<?php echo $entered_data['property_six_phone'] ?>">
		<input type="hidden" name="property_six_email" value="<?php echo $entered_data['property_six_email'] ?>">
		<input type="hidden" name="property_six_street_address" value="<?php echo $entered_data['property_six_street_address'] ?>" >
		<input type="hidden" name="property_six_city" value="<?php echo $entered_data['property_six_city'] ?>">
		<input type="hidden" name="property_six_state" value="<?php echo $entered_data['property_six_state'] ?>">
		<input type="hidden" name="property_six_zip" value="<?php echo $entered_data['property_six_zip'] ?>">



</form>

</div> 