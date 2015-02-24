<form action="<?php echo base_url(); ?>editions/do_add_ed/<?php echo $mag; ?>" method="post">
	<table>
		<tr>
			<td>Magazine:</td>
			<td><?php echo $mag; ?></td>
		</tr>
		<tr>
			<td width="15%">Edition Number:</td>
			<td><input type="text" name="edition_number" value="<?php echo $ed_suggestion; ?>" style="width : 90%" required></td>
		</tr>
		<!-- <tr>
			<td width="15%">Edition Name:</td>
			<td><input type="text" name="edition_name" placeholder="example: March 2071 - February 2072" style="width : 90%" required></td>
		</tr> -->
		<tr>
			<td width="15%">Edition First Day:</td>
			<td><input type="date" name="edition_first_month" value="<?php echo $ed_start_suggestion; ?>"style="width : 90%" placeholder="mm/dd/yyyy" required></td>
		</tr>
		<tr>
			<td>Copy Data From Previous Edition:</td>
			<td>
				<select name="copy_info" id="copy_info">
					<option value="Yes" selected="selected">Yes</option>
					<option value="No">No</option>
				</select>
			</td>
		</tr>
		<!-- <tr>
			<td width="15%">Edition Final Day:</td>
			<td><input type="date" name="edition_final_month" style="width : 90%" required></td>
		</tr>
		<tr>
			<td width="15%">Status:</td>
			<td>
				<select name="edition_status" id="status">
					<option value="Future">Future</option>
					<option value="Live">Live</option>
					<option value="In Production">In Production</option>
					<option value="Dead">Dead</option>
				</select>
			</td>
		</tr> -->
		<tr>
			<td width="15%"></td><td><input type="submit" value="Add Edition"></td>
		</tr>


	</table>

</form>