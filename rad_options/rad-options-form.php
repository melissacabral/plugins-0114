<div class="wrap">
	<h2>Company Information</h2>

	<form method="post" action="options.php">
		<?php //connect this form to the settings we registered in the plugin
		settings_fields( 'rad_options_group' ); 
		//get the current values to pre-fill the form
		$values = get_option( 'rad_options' );
		?>
		<p>
			<label>Company Phone Number</label>
			<input type="tel" name="rad_options[phone]" class="regular-text" 
			value="<?php echo $values['phone'] ?>">
		</p>

		<p>
			<label>Customer Service Email</label>
			<input type="email" name="rad_options[email]" class="regular-text" 
			value="<?php echo $values['email'] ?>">
		</p>

		<p>
			<label>Company Mailing Address</label>
			<textarea name="rad_options[address]" class="code"><?php 
				echo $values['address'] ?></textarea>
		</p>

		<?php submit_button( 'Save Rad Options!' ); ?>

	</form>
</div>