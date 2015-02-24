<div id="signup_form">
<h3>Create An Account</h3>
<fieldset>
	<legend>Personal Information</legend>
	<?php 
		echo form_open('login/create_member');
		$opts = 'placeholder="First Name"';
		echo form_input('first_name', set_value('first_name'), $opts);
		$opts = 'placeholder="Last Name"';
		echo form_input('last_name', set_value('last_name'), $opts);
		$opts = 'placeholder="Email Address"';
		echo form_input('email', set_value('email'), $opts);

	 ?>
</fieldset>

<fieldset>
	<legend>Login Info</legend>
	<?php 
		$opts = 'placeholder="Username"';
		echo form_input('username', set_value('username'), $opts);
		$opts = 'placeholder="Password"';
		echo form_password('password', set_value('password'), $opts);
		$opts = 'placeholder="Confirm Password"';
		echo form_password('password2', set_value('password2'), $opts);

		echo form_submit('submit', 'Create Account');
	 ?>
	 <?php 
	 	echo validation_errors('<p class="error">**');
	  ?>
</fieldset>
</div>