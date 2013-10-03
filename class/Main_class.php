<?php
/**
 * Plugin Name: Jeff Job Board
 * Plugin URI: http://turing.cs.plymouth.edu/~jsmattson
 * Description: This pluggin provides the user with a job postings board.
 * Version: 1.0
 * Author: Jeff Mattson
 * Author URI: http://turing.cs.plymouth.edu/~jsmattson
 * License: GPL2
 */
 
 /*  Copyright 2012  Garrett Grimm  (email : garrett@grimmdude.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class set {
	
	public function __construct(){
		
		//this is just an interesting way to get code into a post or a page might be usefull.
		add_shortcode('testHtml', array($this, 'testShortCode'));
		
		//creates the settings option and contains the form for options
		add_action( 'admin_menu', array($this, 'my_plugin_menu'));
		
		//the action that creates the custom post type
		add_action( 'init', array($this, 'create_post_type')); 
		
		add_filter( 'request', array($this, 'add_cpt_to_feed'));
		
	//	if (is_admin(){ then admin code to allow only the admin to use this function
		add_action('admin_init', array($this, 'register_mysettings'));
	
	}

	//creates the settup options in the admin side of things.  Creates the add options page.
	public function my_plugin_menu() {
		add_options_page( 'Jeff Job Board', 'Job Board', 'manage_options', 'my-unique-identifier', array($this, 'my_plugin_options') );
	}
	
	//table creation function we want wordpress to call this function when the admin installes the plugin.  Use the register_activation_hook() for that.
	public function jal_install() {
		global $wpdb;
		$table_name = $wpdb->prefix . "adminJobBoard";
	}
	
	//register the settings for the admin to set here.
	public function register_mysettings(){
		register_setting('admin-settings-group', 'new_option_name');
	}
	
	//this is where the actual form code goes for the admin options page.  Database calls can be placed here to store settings. Need more infor on that.
	public function my_plugin_options() {
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		//this sets the Max admin alowable post time expiration date
		?>
        <div class="wrap">
		<?php	
		screen_icon(); 
		?>
        <h2>Jeff Job Board</h2>
        <form method="post" action="options.php">
        <?php
		settings_fields("admin-settings-group");
		do_settings_fields ('Jeff Job Board', 'admin-settings-group');//first parameter is for the name of the page.
		?>
        <table class="form-table">
        	<tr valign="top">
            	<th scope="row">Name</th>
            	<td><input type="text" name="new_option_name" value="<?php echo get_option('new_option_name'); ?>" /></td>
            </tr>
         </table>	
        <?php
		submit_button();
	}

	//just testing out the shortcode when [testHtml] is placed in a post or page it prints out this.
	public function testShortCode(){
		echo '<h1>Jeff Job Board</h1><br /><p>Jobs are updated every day.</p>';
	}
	
	//this function creats a custom post option in the admin menu called Job Posting
	public function create_post_type() {
		
		//register_post_type puts it all together. Google all the options
		register_post_type( 'job_posting',
			array(
				'labels' => array(
					'name' => __( 'Job Posting' ),
					'singular_name' => __( 'Job Postings' )
				),
			'public' => true,
			'has_archive' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'map_meta_cap' => true,
			'taxonomies' => array('category', 'page'),
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt','post-formats'),
			)
		);
	}
	
	// Add a Custom Post Type to a feed. This Function does nothing right now.
	public function add_cpt_to_feed( $qv ) {
		if ( isset($qv['feed']) && !isset($qv['post_type']) )
			$qv['post_type'] = array('post', 'job_posting');
		return $qv;
	}
	 
	
}
?>
