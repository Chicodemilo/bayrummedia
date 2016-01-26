<div id="results">
<table>
	<tr>
		<th><span style="font-size: 2em; color: #A2CD5A;">ALL NOTES </span><span style="font-size: 2em; color:#6E8B3D;"> FOR <?php echo $mag; ?></span></th>
	</tr>
</table>


<table>
	<tr class="s_and_d_head">
		<th>USER</th>
		<th>BUSINESS</th>
		<th>CONTACT</th>
		<th>EMAIL</th>
		<th>PHONE</th>
		<th>NOTES</th>
		<th>DO THIS</th>
		<th>ON DATE</th>
		<!-- <th>EDIT</th> -->
		<th style="font-size:.8em;">WARNING:<br>DELETES<br>IMMEDIATELY</th>
	</tr>
	<form action='<?php echo base_url(); ?>home/edit_notes_all_users/<?php echo $mag; ?>' method="post" id="notes_form">
	<tr><td colspan="8"><input type="submit" value="SUBMIT NOTE EDITS"></td></tr>
	<!-- ***************************  START STYLING SCRIPT  *************************** -->

	<script type='text/javascript'>
		
		window.onload=function(){
			//******* THIS IS TO SUBMIT THE FORM AFTER A FEW MINUTES ******************//
			function submit_form(){
				document.getElementById("notes_form").submit();
			}

			if(document.getElementById("notes_form")){
				setTimeout(submit_form, 300000);
			}

			//******* HERE IS THE STYLING ******************//
			var x = '<?php echo count($all_notes); ?>';

			for (var i = 1; i <= x; i++) {

				var do_what = document.getElementById('do_what'+i+'_value');
				var do_what_value = do_what.value;
				var do_what_select = document.getElementById('do_what'+i);
				var do_what_select_length = do_what_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= do_what_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(do_what_select.options[j].value === do_what_value){
						do_what_select.options[j].selected = 'true';
						break;
					}
				}
				if(do_what_value == 'CALL'){do_what_select.className = 'select_purple';}
				if(do_what_value == 'GO BY'){do_what_select.className = 'select_yellow';}
				if(do_what_value == 'EMAIL'){do_what_select.className = 'select_green';}
				if(do_what_value == 'MEET'){do_what_select.className = 'select_red';}
				if(do_what_value == 'WAIT'){do_what_select.className = 'select_blue';}
				
			};

			var z = '<?php echo count($all_notes); ?>';

			for (var i = 1; i <= z; i++) {
				
				var associated_user = document.getElementById('associated_user'+i+'_value');

				var associated_user_value = associated_user.value;
				var associated_user_select = document.getElementById('associated_user'+i);
				var associated_user_select_length = associated_user_select.length;
				// alert(paid_item_select_length);

				for(var j = 0; j <= associated_user_select_length; j++){
				// 	// alert(j);
				// 	// alert(j+select.options[j].value+status_value);
					if(associated_user_select.options[j].value === associated_user_value){
						associated_user_select.options[j].selected = 'true';
						break;
					}
				}
				
			};

		}
	</script>
<!-- ***************************  END STYLING SCRIPT  *************************** -->

<!-- ***************************  START PHP ITEM LAYOUT   *************************** -->

	<?php 
		$i = 1;

		foreach($all_notes AS $row){

			echo "<tr class='s_and_d_body'>";
			echo "<input type='hidden' name='id".$row['id']."' value='".$row['id']."' id='id".$row['id']."'>";

			echo "<td>";
			// echo $row['associated_user'];
			// echo "<input type='text' name='associated_user".$row['id']."' value='".$row['associated_user']."' id='associated_user".$row['id']."'>";
			echo "<input type='hidden' value='".$row['associated_user']."' id='associated_user".$i."_value'>";
			echo "<select name='associated_user".$row['id']."' id='associated_user".$i."' class=''>";
			
			foreach($users AS $user_row){
				echo "<option value='".$user_row['username']."'>".$user_row['username']."</option>";
			}


			echo "</select>";
			echo "</td>";

			echo "<input type='hidden' name='associated_user_id".$row['id']."' value='".$row['associated_user_id']."' id='associated_user_id".$row['id']."'>";

			echo "<td>";
			echo "<input type='text' value='".$row['business']."' name='business".$row['id']."'  class='note_input' required>";
			echo "</td>";

			echo "<td>";
			echo "<input type='text' value='".$row['contact_name']."' name='contact_name".$row['id']."'  class='note_input'>";
			echo "</td>";

			echo "<td>";
			echo "<input type='text' value='".$row['contact_email']."' name='contact_email".$row['id']."'  class='note_input'>";
			echo "</td>";

			echo "<td>";
			echo "<input type='text' value='".$row['contact_phone']."' name='contact_phone".$row['id']."'  class='note_input'>";
			echo "</td>";

			echo "<td><textarea name='comments".$row['id']."' id='comments' class='notes_boxsizingBorder' rows='3' cols='50'>".$row['notes']."</textarea></td>";

			echo "<td>";
			echo "<input type='hidden' value='".$row['do_what']."' id='do_what".$i."_value'>
				 	<select name='do_what".$row['id']."' id='do_what".$i."' class=''>
				 		<option value='CALL'>CALL</option>
				 		<option value='GO BY'>GO BY</option>
				 		<option value='EMAIL'>EMAIL</option>
				 		<option value='MEET'>MEET</option>
				 		<option value='WAIT'>WAIT</option>
				 	 </select>";
			echo "</td>";

			echo "<td>";
			echo "<input type='text' value='".$row['do_something_on']."' name='do_something_on".$row['id']."'  class='date-picker' id='datepicker".$i."'>";
			echo "</td>";

			echo "<td><a href='".base_url()."home/delete_note_all_users/".$mag."/".$row['id']."' class='link_small'>DELETE</a></td>";
			echo "</tr>";

			$i += 1;
			
		}

	 ?>

	</form>
</table>
<!-- ***************************  END PHP ITEM LAYOUT   *************************** -->

<table><tr>
	<td><a href="<?php echo base_url();?>home/notes/<?php echo $mag;?>">SEE YOUR NOTES FOR <?php echo $mag; ?></a></td>
</tr></table>
</div>
<script>
	
	var picker = new Pikaday({ field: $('#date-picker')[0] });

	var counter = <?php echo $i ?>;

	for (var x = 0; x < counter; x++) {
		var picker_next = new Pikaday({ field: $('.date-picker')[x] });
	};

	
</script>