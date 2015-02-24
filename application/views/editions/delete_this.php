<form action="<?php echo base_url(); ?>editions/do_delete_ed/<?php echo $data['edition_number'] ?>/<?php echo $data['magazine'] ?>" method="post">
	<table>
		<tr>
			<th>ARE YOU SURE YOU WANT TO DELETE THIS EDITION??</th>
		</tr>
		<tr>
			
			<td><?php echo $data['edition_number']; ?></td>
		</tr>
		<tr>
			<td><?php echo $data['edition_name']; ?></td>
		</tr>
	
		<tr>
			<td><input type="submit" value="Delete Edition"></td>
		</tr>


	</table>
</form>