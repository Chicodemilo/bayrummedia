<div id="results">
<table>
	<tr>
		<th><span style="font-size: 2em; color: #A2CD5A;">LAYOUT TABLE </span><span style="font-size: 2em; color:#6E8B3D;"> <?php echo $ed_data[0]['magazine']; ?> Edition <?php echo $ed_data[0]['edition_number'];  ?> : <?php echo $ed_data[0]['edition_name'] ?></span></th>
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
						$bar_width = ($their_sales*100)/$all_sales;
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
		
		<th>PAGE</th>
		<th>SIZE</th>
		<th>ADVERTISER</th>
		<!-- <th>PRICE</th>
		<th>COMMENTS</th> -->
	</tr>
	


	<?php 

		foreach($items AS $row){

			echo "<tr class='s_and_d_body'>";
			echo "<td>".$row['page_number']."</td>";
			echo "<td>".$row['advertiser']."</td>";
			echo "<td>".$row['item_size']."</td>";
			// echo "<td>".$row['price']."</td>";
			// echo "<td>".$row['comments']."</td>";
			echo "</tr>";
			
		}

	 ?>
	<table><tr>
	<td><a href="<?php echo base_url();?>items/all_small/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">CONDENSED VIEW</a></td>
	<td><a href="<?php echo base_url();?>items/all/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">EXPANDED VIEW</a></td>
	<td><a href="<?php echo base_url();?>items/layout_table/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">PAGE LAYOUT VIEW</a></td>
	<td><a href="<?php echo base_url();?>items/billing_table/<?php echo $ed_data[0]['magazine']; ?>/<?php echo $ed_data[0]['id']; ?>">BILLING SHEET VIEW</a></td>
	</tr></table>
		
</div>