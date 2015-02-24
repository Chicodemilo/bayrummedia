<form action="<?php echo base_url(); ?>home/do_delete_mag/<?php echo $data['short_name'] ?>" method="post">
	<table>
		<tr>
			<th>ARE YOU SURE YOU WANT TO DELETE THIS MAGAZINE??</th>
		</tr>
		<tr>
			
			<td><?php echo $data['short_name']; ?></td>
		</tr>
		<tr>
			<td><?php echo $data['name']; ?></td>
		</tr>
	
		<tr>
			<td><input type="submit" value="Delete Magazine"></td>
		</tr>


	</table>
</form>