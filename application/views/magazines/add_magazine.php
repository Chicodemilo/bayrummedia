<form action="<?php echo base_url(); ?>home/do_add_mag" method="post">
	<table>
		<tr>
			<td width="15%">Short Name:</td>
			<td><input type="text" name="short_name" placeholder="example: GSAR" style="width : 90%" required></td>
		</tr>
		<tr>
			<td width="15%">Long Name:</td>
			<td><input type="text" name="long_name" placeholder="example: Greater San Angelo Renter" style="width : 90%" required></td>
		</tr>
		<tr>
			<td width="15%">Market:</td>
			<td><input type="text" name="market" placeholder="example: Abilene" style="width : 90%" required></td>
		</tr>
		<tr>
			<td>Edition Lifespan:</td>
			<td>
				<select name="lifespan" id="lifespan">
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
		<!-- <tr>
			<td>Edition Life In Weeks:</td>
			<td><input type="text" name="weeks_of_life" placeholder="example: 52" style="width : 90%" required></td>
		</tr>
		<tr>
			<td>Weeks Of Production:</td>
			<td><input type="text" name="in_production_weeks" placeholder="example: 13" style="width : 90%" required></td>
		</tr>
		<tr> -->
			<td>Status:</td>
			<td>
				<select name="status">
					<option value="Active">Active</option>
					<option value="Inactive">Inactive</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="15%"></td><td><input type="submit" value="Add Magazine"></td>
		</tr>


	</table>
</form>