<form action="<?php echo base_url(); ?>editions/do_edit_ed/<?php echo $data['edition_number'] ?>/<?php echo $data['magazine'] ?>" method="post">
	<table>
		<tr>
			<td>Magazine:</td>
			<td><?php echo $data['magazine'] ?></td>
		</tr>
		<tr>
			<td>Edition Name:</td>
			<td><?php echo $data['edition_name'] ?> : Edtion Name Is Set By Start Date</td>
		</tr>
		<tr>
			<td width="15%">Edition Number:</td>
			<td><input type="text" name="edition_number" value="<?php echo $data['edition_number'] ?>" style="width : 90%" required></td>
		</tr>
		<tr>
			<td width="15%">Edition First Day:</td>
			<td><input type="date" name="edition_first_month" style="width : 90%" value="<?php echo $data['edition_first_month'] ?>" required></td>
		</tr>
		</tr>
	
		<tr>
			<td><input type="hidden" name="id" value="<?php echo $data['id'] ?>"><input type="submit" value="Edit Edition"></td>
		</tr>


	</table>
</form>