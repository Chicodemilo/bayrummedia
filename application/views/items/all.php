<div id="results">
<table>
	<tr>
		<th><span style="font-size: 2em; color: #A2CD5A;">SOLD &amp; DESIGNED </span><span style="font-size: 2em; color:#6E8B3D;"> <?php echo $ed_data[0]['magazine']; ?> Edition <?php echo $ed_data[0]['edition_number'];  ?> : <?php echo $ed_data[0]['edition_name'] ?></span></th>
	</tr>
</table>

<table>
	<tr>
		<td>Total<br>Sold: $<?php echo $ed_data[0]['sold_total'] ?></td>
		<td>Total<br>Pages: <?php echo $ed_data[0]['page_total'] ?></td>
		<td>Total<br>Paid Pages: <?php echo $totals['paid_page_total'] ?></td>
		<td>	
			<table class="inner_table">
				<tr>
					<td>total items:</td>
					<td><?php echo $totals['all_items_total'] ?></td>
				</tr>
				<tr>
					<td>need work:</td>
					<td><?php echo $totals['need_work_total'] ?></td>
				</tr>
				<tr>
					<td>waiting on something:</td>
					<td><?php echo $totals['wait_total'] ?></td>
				</tr>
				<tr>
					<td>items done:</td>
					<td><?php echo $totals['done_total'] ?></td>
				</tr>
			</table>
			

		</td>
		<td>Ave Paid<br>Item Size: <?php echo $totals['ave_size'] ?></td>
		<td>Ave Paid<br>Item Price: $<?php echo $totals['average_price']; ?></td>
		<td width="50%">
			<table class="inner_table">
				<td>sales person</td>
				<td style="min-width:50px">% of tot sales</td>
				<td>total sales</td>
				<td>sales average</td>
				<td>total items</td>
				
				<?php 

					$all_sales = $ed_data[0]['sold_total'];

					foreach ($totals['individual_sales_totals'] as $key => $value) {
						$their_sales = $value['total_sales'];

						if($all_sales <= 0){
							$bar_width = 0;
						}else{
							$bar_width = ($their_sales*100)/$all_sales;
						}
						
						$bar_width = round($bar_width);


						echo "<tr><td>";
						echo $key."</td><td>";
						echo "<div class='bars' style='width:".$bar_width."%'>".$bar_width."%</div>";
						echo "</td><td>$".$value['total_sales']."</td><td>$".$value['sales_ave']."</td><td>".$value['total_items'];
						echo "</td></tr>";
					}
				 ?>
			</table>
		</td>
	</tr>
</table>

<table>
	<tr class="s_and_d_head">
		
		<th>STAT</th>
		<th>ADVERTISER</th>
		<th>SOLD</th>
		<th>PAID<br>ITEM</th>
		<th>SIZE</th>
		<th>PAGE<br>NUM</th>
		<th>NUMBER<br>OF<br>EDITIONS</th>
		<th>PRICE</th>
		<th>LAST ED<br>PRICE</th>
		<th>NEED<br>CHANGES?</th>
		<th>EASY<br>MED<br>HARD</th>
		<th>NEED<br>PICS?</th>
		<th>DRAFT?</th>
		<th style="min-width:250px">COMMENTS</th>
		<th>SALES PERSON</th>
		<!-- <th>EDIT</th> -->
		<th style="font-size:.8em;">WARNING:<br>DELETES<br>IMMEDIATELY</th>
	</tr>
	<form action='<?php echo base_url(); ?>items/edit_this/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>/expanded' method="post" id="items_form">

	<!-- ***************************  START STYLING SCRIPT  *************************** -->

	<script type='text/javascript'>
		window.onload=function(){

			//******* THIS IS TO SUBMIT THE FORM AFTER A FEW MINUTES ******************//
			function submit_form(){
				document.getElementById("items_form").submit();
			}

			if(document.getElementById("items_form")){
				setTimeout(submit_form, 300000);
			}


			//******* HERE IS THE STYLING ******************//
			var x = '<?php echo count($items); ?>';
			// window.alert(x);

			for (var i = 1; i <= x; i++) {
				var status = document.getElementById('status_'+i+'_value');
				var status_value = status.value;
				var select = document.getElementById('status'+i);
				var select_length = select.length;
				// alert(status_value);

				for(var j = 0; j <= select_length; j++){
					// alert(j);
					// alert(j+select.options[j].value+status_value);
					if(select.options[j].value === status_value){
						select.options[j].selected = 'true';
						break;
					}
				}
				if(status_value == 'WORK'){select.className = 'select_red';}
				if(status_value == 'WAIT'){select.className = 'select_yellow'}



				var sold = document.getElementById('sold_'+i+'_value');
				var sold_value = sold.value;
				var sold_select = document.getElementById('sold'+i);
				var sold_select_length = sold_select.length;
				// alert(status_value);

				for(var j = 0; j <= sold_select_length; j++){
					// alert(j);
					// alert(j+select.options[j].value+status_value);
					if(sold_select.options[j].value === sold_value){
						sold_select.options[j].selected = 'true';
						break;
					}
				}
				if(sold_value == 'N'){sold_select.className = 'select_red';}
				if(sold_value == 'NY'){sold_select.className = 'select_yellow'}


				var paid_item = document.getElementById('paid_item_'+i+'_value');
				var paid_item_value = paid_item.value;
				var paid_item_select = document.getElementById('paid_item'+i);
				var paid_item_select_length = paid_item_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= paid_item_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(paid_item_select.options[j].value === paid_item_value){
						paid_item_select.options[j].selected = 'true';
						break;
					}
				}
				if(paid_item_value == 'Y'){paid_item_select.className = 'select_green';}


				var item_size = document.getElementById('item_size_'+i+'_value');
				var item_size_value = item_size.value;
				var item_size_select = document.getElementById('item_size'+i);
				var item_size_select_length = item_size_select.length;
				// alert(number_of_eds_select_length);

				for(var j = 0; j <= item_size_select_length; j++){
					// alert(j);
					// alert(j+number_of_eds_select.options[j].value+number_of_eds_value);
					if(item_size_select.options[j].value === item_size_value){
						item_size_select.options[j].selected = 'true';
						break;
					}
				}


				var page_number = document.getElementById('page_number_'+i+'_value');
				var page_number_value = page_number.value;
				var page_number_select = document.getElementById('page_number'+i);
				var page_number_select_length = page_number_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= page_number_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(page_number_select.options[j].value === page_number_value){
						page_number_select.options[j].selected = 'true';
						break;
					}
				}


				var number_of_eds = document.getElementById('number_of_eds_'+i+'_value');
				var number_of_eds_value = number_of_eds.value;
				var number_of_eds_select = document.getElementById('number_of_eds'+i);
				var number_of_eds_select_length = number_of_eds_select.length;
				// alert(number_of_eds_select_length);

				for(var j = 0; j <= number_of_eds_select_length; j++){
					// alert(j);
					// alert(j+number_of_eds_select.options[j].value+number_of_eds_value);
					if(number_of_eds_select.options[j].value === number_of_eds_value){
						number_of_eds_select.options[j].selected = 'true';
						break;
					}
				}


				var current_number_of_eds = document.getElementById('current_number_of_eds_'+i+'_value');
				var current_number_of_eds_value = current_number_of_eds.value;
				var current_number_of_eds_select = document.getElementById('current_number_of_eds'+i);
				var current_number_of_eds_select_length = current_number_of_eds_select.length;
				// alert(number_of_eds_select_length);

				for(var j = 0; j <= current_number_of_eds_select_length; j++){
					// alert(j);
					// alert(j+number_of_eds_select.options[j].value+number_of_eds_value);
					if(current_number_of_eds_select.options[j].value === current_number_of_eds_value){
						current_number_of_eds_select.options[j].selected = 'true';
						break;
					}
				}


				var need_changes = document.getElementById('need_changes_'+i+'_value');
				var need_changes_value = need_changes.value;
				var need_changes_select = document.getElementById('need_changes'+i);
				var need_changes_select_length = need_changes_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= need_changes_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(need_changes_select.options[j].value === need_changes_value){
						need_changes_select.options[j].selected = 'true';
						break;
					}
				}
				if(need_changes_value == 'Y'){need_changes_select.className = 'select_red';}


				var emh = document.getElementById('emh_'+i+'_value');
				var emh_value = emh.value;
				var emh_select = document.getElementById('emh'+i);
				var emh_select_length = emh_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= emh_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(emh_select.options[j].value === emh_value){
						emh_select.options[j].selected = 'true';
						break;
					}
				}
				if(emh_value == 'HARD'){emh_select.className = 'select_red';}
				if(emh_value == 'MED'){emh_select.className = 'select_yellow';}
				if(emh_value == 'EASY'){emh_select.className = 'select_green';}



				var need_pics = document.getElementById('need_pics_'+i+'_value');
				var need_pics_value = need_pics.value;
				var need_pics_select = document.getElementById('need_pics'+i);
				var need_pics_select_length = need_pics_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= need_pics_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(need_pics_select.options[j].value === need_pics_value){
						need_pics_select.options[j].selected = 'true';
						break;
					}
				}
				if(need_pics_value == 'Y'){need_pics_select.className = 'select_yellow';}


				var draft_made = document.getElementById('draft_made_'+i+'_value');
				var draft_made_value = draft_made.value;
				var draft_made_select = document.getElementById('draft_made'+i);
				var draft_made_select_length = draft_made_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= draft_made_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(draft_made_select.options[j].value === draft_made_value){
						draft_made_select.options[j].selected = 'true';
						break;
					}
				}
				if(draft_made_value == 'Y'){draft_made_select.className = 'select_green';}
				
			};



		}
	</script>
<!-- ***************************  END STYLING SCRIPT  *************************** -->

<!-- ***************************  START PHP ITEM LAYOUT   *************************** -->

	<?php 
		$i = 1;

		foreach($items AS $row){

			echo "<tr class='s_and_d_body'>";
			echo "<input type='hidden' value='".$row['id']."' id='id' name='id".$row['id']."'>";

			echo "<td>
				<input type='hidden' value='".$row['status']."' id='status_".$i."_value' >

				<select name='status".$row['id']."' id='status".$i."' class=''>
					<option value='WORK'>WORK</option>
					<option value='WAIT'>WAIT</option>
					<option value='DONE'>DONE</option>
				 </select></td>";

			echo "<td>".$row['advertiser']."</td>";

			echo "<td>
				<input type='hidden' value='".$row['sold']."' id='sold_".$i."_value'>

				<select name='sold".$row['id']."' id='sold".$i."' class=''>
					<option value='Y'>Y</option>
					<option value='N'>N</option>
					<option value='NY'>Not Yet</option>
				 </select></td>";

			echo "<td>
				<input type='hidden' value='".$row['paid_item']."' id='paid_item_".$i."_value'>

				<select name='paid_item".$row['id']."' id='paid_item".$i."' class=''>
					<option value='Y'>Y</option>
					<option value='N'>N</option>
				 </select></td>";

			$size_type = gettype($row['item_size']);
			echo "<td>

				<input type='hidden' value='".$row['item_size']."' id='item_size_".$i."_value'>
				<select name='item_size".$row['id']."' id='item_size".$i."' class='select_tiny'>
					<option value='0.00'>0</option>
					<option value='0.20'>.20</option>
					<option value='0.25'>.25</option>
					<option value='0.50'>.50</option>
					<option value='0.75'>.75</option>
					<option value='1.00'>1.00</option>
					<option value='1.25'>1.25</option>
					<option value='1.50'>1.50</option>
					<option value='1.75'>1.75</option>
					<option value='2.00'>2.00</option>
					<option value='2.25'>2.25</option>
					<option value='2.50'>2.50</option>
					<option value='2.75'>2.75</option>
					<option value='3.00'>3.00</option>
					";

			echo  	"</select>
					</td>";


			echo "<td>
				<input type='hidden' value='".$row['page_number']."' id='page_number_".$i."_value'>

				<select name='page_number".$row['id']."' id='page_number".$i."' class=''>
					<option value='0'>?</option>";

					for ($x=1; $x<= 64; $x++){
						echo "<option value='".$x."'>".$x."</option>";}
					
			echo "</select></td>";

			echo "<td>";

			echo "<input type='hidden' value='".$row['current_number_of_eds']."' id='current_number_of_eds_".$i."_value' >

				<select name='current_number_of_eds".$row['id']."' id='current_number_of_eds".$i."' class='select_tiny'>";

					for ($x=1; $x<= 30; $x++){
						echo "<option value='".$x."'>".$x."</option>";}
					
			echo "</select> of ";


			echo "<input type='hidden' value='".$row['number_of_eds']."' id='number_of_eds_".$i."_value' >

				<select name='number_of_eds".$row['id']."' id='number_of_eds".$i."' class='select_tiny'>";

					for ($x=1; $x<= 30; $x++){
						echo "<option value='".$x."'>".$x."</option>";}
					
			echo "</select>";

			echo "</td>";



			echo "<td>";
			echo "$<input type='text' value='".$row['price']."' name='price".$row['id']."' size='9' style='display:inline; padding:5px; font-size:1em;'>";
			echo "</td>";

			echo "<td>$".$row['last_year_price']."</td>";

			echo "<td>
				<input type='hidden' value='".$row['need_changes']."' id='need_changes_".$i."_value'>

				<select name='need_changes".$row['id']."' id='need_changes".$i."' class=''>
					<option value='Y'>Y</option>
					<option value='N'>N</option>
				 </select></td>";


			echo "<td>
				<input type='hidden' value='".$row['emh']."' id='emh_".$i."_value'>

				<select name='emh".$row['id']."' id='emh".$i."' class=''>
					<option value='EASY'>EASY</option>
					<option value='MED' >MED</option>
					<option value='HARD'>HARD</option>
				 </select></td>";


			echo "<td>
				<input type='hidden' value='".$row['need_pics']."' id='need_pics_".$i."_value'>

				<select name='need_pics".$row['id']."' id='need_pics".$i."' class=''>
					<option value='Y'>Y</option>
					<option value='N'>N</option>
				 </select></td>";


		 	echo "<td>
				<input type='hidden' value='".$row['draft_made']."' id='draft_made_".$i."_value'>

				<select name='draft_made".$row['id']."' id='draft_made".$i."' class=''>
					<option value='Y'>Y</option>
					<option value='N'>N</option>
				 </select></td>";


			echo "<td><textarea name='comments".$row['id']."' id='comments' class='boxsizingBorder' rows='5'>".$row['comments']."</textarea></td>";

			echo "<td>".$row['associated_user']."</td>";

			echo "<td><a href='".base_url()."items/delete/".$ed_data[0]['magazine']."/".$ed_data[0]['id']."/".$row['id']."' class='link_small'>DELETE</a></td>";
			echo "</tr>";

			$i += 1;
			
		}

	 ?>
		<tr><td><input type="submit"></td></tr>
	</form>
</table>
<!-- ***************************  END PHP ITEM LAYOUT   *************************** -->

<!-- ***************************  START NEW ITEM INSERT   *************************** -->
<form method="post" action="<?php echo base_url();?>items/ad_this/<?php echo $items[0]['mag']; ?>/<?php echo $items[0]['ed_id']; ?>">
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
			<option value="NY">Not Yet</option>
		</select></td>
		<td><select name="paid_item" id="paid_item">
			<option value="Y">Y</option>
			<option value="N">N</option>
		</select></td>
		<td><select name="number_of_payments" id="number_of_payments">
				<?php for ($x=1; $x<= 30; $x++){
						echo "<option value='".$x."'>".$x."</option>";
					} ?>
			</select></td>
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
		 		<option value="0">?</option>
				<?php for ($x=1; $x<= 64; $x++){
						echo "<option value='".$x."'>".$x."</option>";
					} ?>
			</select></td>
			<td>
				<select name="number_of_eds" id="number_of_eds">
					<?php for ($j=1; $j<= 30; $j++){echo "<option value='".$j."'>".$j."</option>"; } ?>
				</select>
				<input type="hidden" name="current_number_of_eds" id="current_number_of_eds" value="1">
				</td>
			<td>$<input type="text" name="price" id="price" size="10" placeholder="NO '$'" style='display:inline; padding:3px;'> </td>
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
			<option value="N" selected>N</option>
		</select></td>
		<td><select name="draft_made" id="draft_made">
			<option value="Y">Y</option>
			<option value="N" selected>N</option>
		</select></td>

		<td><textarea name="comments" id="comments" class="boxsizingBorder" rows="3" style="min-width:270px"></textarea></td>

	</tr>
</table>	
<!-- ***************************  END NEW ITEM INSERT   *************************** -->
</form>
<table><tr>
	<td><a href="<?php echo base_url();?>items/all_small/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">CONDENSED VIEW</a></td>
	<td><a href="<?php echo base_url();?>items/all/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">EXPANDED VIEW</a></td>
	<td><a href="<?php echo base_url();?>items/layout_table/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">PAGE LAYOUT VIEW</a></td>
	<td><a href="<?php echo base_url();?>items/billing_table/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">BILLING SHEET VIEW</a></td>
</tr></table>
</div>