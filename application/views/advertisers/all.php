<div id="results">

<table><th>CHOOSE A MAGAZINE TO SEE ASSOCIATED ADVERTISERS</th></table>
<table>	
	<tr>
		<th>SHORT NAME</th>
		<th>LONG NAME</th>
		<th>MARKET</th>
		<th>ACTIVE ADVERTISERS</th>
		<th>ADVERTISERS PAST DUE</th>
		<th>MAG STATUS</th>
	</tr>
	<?php 
		foreach($mags->result() AS $row){
			$short_name = $row->short_name;
			echo "<tr><td><a href='";
			echo base_url();
			echo "advertisers/mag/".$row->short_name."'>".$row->short_name."</a></td><td>".$row->name."</td><td>".$row->market."</td>";
			echo "<td>".$advertisers[$short_name]."</td><td>".$past_due[$short_name]."</td><td>".$row->status."</td>";
			echo "</tr>";

		}

	 ?>
	

</table>
</div>