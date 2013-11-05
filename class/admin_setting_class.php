<?php

class Admin_Setting {

	public function __construct(){

		add_action( 'admin_menu', array($this, 'my_plugin_menu'));
		
		//if (is_admin(){ then admin code to allow only the admin to use this function
		add_action('admin_init', array($this, 'register_mysettings'));
	
	}	
	
	//creates the settup options in the admin side of things.  Creates the add options page.
	public function my_plugin_menu() {
		add_options_page( 'Jeff Job Board', 'Job Board', 'manage_options', 'my-unique-identifier', array($this, 'my_plugin_options') );
	}
	

	//register the settings for the admin to set here.
	public function register_mysettings(){
		register_setting('admin-settings-group', 'new_option_name');
		register_setting('admin-settings-group', 'plugin_options');
	}

	//dropdown list max time expiration
	public function setting_dropdown_fn() {
		$options = get_option('plugin_options');
		$items = array("1 Month", "2 Months", "3 Months", "4 Months", "5 Months", "6 Months", "7 Months", "8 Months", "9 Months", "10 Months", "11 Months", "1 Year");
		echo "<select id='drop_down1' name='plugin_options[dropdown1]'>";
		foreach($items as $item) {
			$selected = ($options['dropdown1']==$item) ? 'selected="selected"' : '';
			echo "<option value='$item' $selected>$item</option>";
		}
		echo "</select>";
	}
	
	//this is where the actual form code goes for the admin options page.  Database calls can be placed here to store settings. Need more infor on that.
	public function my_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		?>
        	<div class="wrap">
		<?php	
		screen_icon(); 
		?>
        	<h2>Job Board</h2>
        	<form method="post" action="options.php">
        	<?php
		settings_fields("admin-settings-group");
		do_settings_fields ('Jeff Job Board', 'admin-settings-group');//first parameter is for the name of the page.
		?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Max Post Exp Length</th>
				<td><?php $this->setting_dropdown_fn(); ?></td>
			</tr>
		</table>	
		<?php
			submit_button();
		}
}
?>
