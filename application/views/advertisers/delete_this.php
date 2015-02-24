<form action="<?php echo base_url(); ?>advertisers/do_delete_ad/<?php echo $mag ?>/<?php echo $delete_this['id'] ?>" method="post">
	<table>
		<tr>
			<th class="bad" colspan="2">ARE YOU SURE YOU WANT TO DELETE THIS ADVERTISER???!!?!</th>
		</tr>
		<tr>
			<td class="indif" colspan="2">A BETTER CHOICE MAY BE TO MARK THEM AS 'INACTIVE' WITH THE <a style="display:inline; font-weight:bold; padding:4px;" href="<?php echo base_url(); ?>advertisers/edit_this/<?php echo $mag.'/'.$delete_this['id']; ?>" >EDIT</a> FEATURE</td>
		</tr>

		<tr>
			<td colspan="2"><input type="submit" value="Delete Advertiser"></td>
		</tr>

		<?php 
			// $x = count($delete_this);

			// for($i = 0; $i <= $x; $i++){
			// 	echo 	"<tr>
			// 				<td>".$delete_this[$i]."</td>
			// 			</tr>
			// 			";
			// }

			foreach ($delete_this as $key => $value) {
				echo 	"<tr>
			 				<td class='righter' width='20%'>".$key.":</td><td class='bolder'>".$value."</td>
						</tr>
						";
			}
		 ?>
	</table>
</form>