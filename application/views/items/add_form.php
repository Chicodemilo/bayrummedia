<form method="post" action="<?php echo base_url();?>items/ad_this/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">
<table>
	<tr>
		<th colspan="13"><h3 style="text-align:left;">Add A New Item To: <span style="color:#6E8B3D;"> <?php echo $ed_data[0]['magazine']; ?> Edition <?php echo $ed_data[0]['edition_number'];  ?></span></h3></th>
		<th><input type="submit" value="Add Item"></th>
	</tr>
	<tr class="s_and_d_head">
		
		<th>STAT</th>
		<th>ADVERTISER</th>
		<th>SOLD</th>
		<th>PAID<br>ITEM</th>
		<th>NUMBER<br>OF<br>PAYMENTS</th>
		<th>SIZE</th>
		<th>PAGE<br>NUM</th>
		<th>NUMBER<br>OF<br>EDITIONS</th>
		<th>PRICE</th>
		<th>NEED<br>CHANGES?</th>
		<th>EASY<br>MED<br>HARD</th>
		<th>NEED<br>PICS?</th>
		<th>DRAFT?</th>
		<th>COMMENTS</th>


	</tr>
	<tr>
		
		<td><select name="status" id="status">
			<option value="WORK" selected>WORK</option>
			<option value="WAIT">WAIT</option>
			<option value="DONE">DONE</option>
		</select></td>
		<td>
			<select name="advertiser" id="advertiser">
				<option value="House">House Page</option>
				<?php  
					foreach ($advertisers_data as $value) {
						echo "<option value='".$value['id']."'>".$value['name']."</option>";
					}


				?>
			</select>

		</td>
		<td><select name="sold" id="sold">
			<option value="Y">Y</option>
			<option value="N">N</option>
		</select></td>
		<td><select name="paid_item" id="paid_item">
			<option value="Y">Y</option>
			<option value="N">N</option>
		</select></td>
		<td><select name="number_of_payments" id="number_of_payments">
				<?php for ($x=1; $x<= 30; $x++){
						echo "<option value='".$x."'>".$x."</option>";
					} ?>
			</select></td></td>
		<td><select name="item_size" id="item_size">
			<option value='0'>0</option>
			<option value='.2'>.2</option>
			<?php 	
					$f = .25;
					for ($x=1; $x<= 12; $x++){
						echo "<option value='".$f."'>".$f."</option>";
						$f = $f + .25;
					} 
			?>
		</select></td>
		 <td><select name="page_number" id="page_number">
		 		<option value="0">Not Sure</option>
				<?php for ($x=1; $x<= 64; $x++){
						echo "<option value='".$x."'>".$x."</option>";
					} ?>
			</select></td>
			<td>
				<select name="number_of_editions" id="number_of_editions">
					<?php for ($j=1; $j<= 30; $j++){echo "<option value='".$j."'>".$j."</option>"; } ?>
				</select>
			</td>
			<td><input type="text" name="price" id="price" size="25" placeholder="DO NOT Enter The $ Sign"></td>
		<td><select name="need_changes" id="need_changes">
			<option value="Y">Y</option>
			<option value="N">N</option>
		</select></td>
		<td><select name="emh" id="emh">
			<option value="EASY">EASY</option>
			<option value="MED" selected>MED</option>
			<option value="HARD">HARD</option>
		</select>
		</td>
		<td><select name="need_pics" id="need_pics">
			<option value="Y">Y</option>
			<option value="N">N</option>
		</select></td>
	
		<td><select name="draft_made" id="draft_made">
			<option value="Y">Y</option>
			<option value="N" selected>N</option>
		</select></td>

		<td><textarea name="comments" id="comments" cols="40" rows="3"></textarea></td>

	</tr>
</table>	

</form>