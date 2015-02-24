<form action="<?php echo base_url(); ?>advertisers/find_ad" method="post">

	<table>
		<tr>
				<td width="130">Search By Name:</td>
				<td width="250"><input type="text" name="ad_search" id="ad_search" size="50"></td>
				<td><input type="submit" value="Search"></td>
		</tr>
	</table>

</form>


<table>
	<tr>
		<td width="33%"><a href="<?php echo base_url(); ?>advertisers/see_all_advertisers">SEE ALL ADVERTISERS</a></td>
	</tr>
</table>