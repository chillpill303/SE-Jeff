<?php
/**
 * Plugin Name: Job Board
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

class Set {
	
	public function __construct(){
	
		//the action that creates the custom post type
		add_action( 'init', array($this, 'create_post_type')); 
	
		//register taxonomy for the custom post
//		register_taxonomy("Jobs", array("job_posting"), array("hierarchical" => true, "label" =>"Job", "singular_label" => "Job", "rewrite" => false));
		
		//this is to add custom fields in the custom post.
		add_action("admin_init", array($this, "admin_init"));

		//redirect to theme file
		add_action("template_redirect", array($this, 'my_theme_redirect'));

		//for changing the page template after it is created.
		add_filter( "single_template", array($this, "get_custom_post_type_template"));

		//for saveing the meta data in the custom post
		add_action( 'save_post', array($this, 'save_meta_post_data'));

	}
	
	
	//this function creats a custom post option in the admin menu called Job Posting
	public function create_post_type() {
		
		//register_post_type puts it all together. Google all the options
		register_post_type( 'job_posting',
			array(
				'labels' => array(
					'name' => __( 'Job Posting' ),
					'singular_name' => __( 'Job Posting' ),
					'add_new_item' => __( 'Add New Job Posting')
				),
			'public' => true,
			'has_archive' => true,
			'show_in_nav_menus' => true,
			'show_ui' => true,
			'map_meta_cap' => true,
		//	'taxonomies' => array('category', 'page'),
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail'),
			)
		);
	}
	
	//function that is called by the add_action to create the custom field in the custom post.
	public function admin_init(){
		add_meta_box("job_requirements-meta",__("Job Requirements","job_requirements"),array( $this, 'job_requirements'), "job_posting", "normal" , "high");
		//for start date and end date
		add_meta_box("start_date-meta", __("Start/End Date", "start_date"), array($this, 'start_date'), "job_posting", 'side', 'high');
	}

	//function that creates the meta box for the Job Requirements.
	public function job_requirements(){
		global $post;
		$custom = get_post_custom($post->ID);
		$job_requirements = get_post_meta( $post->ID, 'job_requirements', true);
		?>
		<!-- <p><label>Job Requirements</label><br /> -->
		<textarea cols="50" rows="5" wrap="virtual" name="job_requirements"> <?php echo esc_attr( $job_requirements ); ?> </textarea></p>
		<?php
		//nonce field to check for later
		wp_nonce_field( 'job_requirements' , 'job_requirements_nonce');

	} 	

	//for the start_date meta box.
	public function start_date(){
		global $post;
		$custom = get_post_custom($post->ID);
		$start_date = get_post_meta($post->ID, 'start_date', true);
		$end_date = get_post_meta($post->ID, 'start_date', true);
		?>
		<p><label>Start Date</label><br />
		<input type="date" name="start_date" value="<?php echo $start_date; ?>"</p>
		<p><label>End Date</label><br />
		<input type="date" name="end_date" value="<?php echo $end_date; ?>"</p> 
		<?php
	}


	//save the new meta box data so it shows on the post
	public function save_meta_post_data($post_id) {
		/*if (! isset( $_POST['job_requirements_nonce'])) {
			return $post_id;
		}

		$nonce = $_POST['job_requirements_nonce'];

		//verify nonce
		if (!wp_verify_nonce($nonce, 'job_requirements')) {
			return $post_id;
		}

		//if autosave form has not been submitted
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}

		//check users permissions
		if ('page' == $_POST['job_posting']) {
			if ( !current_user_can('edit_page', $post_id)) {
				return $post_id;

			} else {
				if (! current_user_can( 'edit_post', $post_id)) {
					return $post_id;
				}
		
		// Sanitize user input.
		$mydata = sanitize_text_field( $_POST['job_requirements']);*/

		//post the job requirements if there are some other wise post none. It looks better.
		global $post;
		if (get_post_meta( $post->ID, 'job_requirements', true) == '') {
			update_post_meta($post->ID, 'job_requirements', 'None.');
			update_post_meta($post->ID, 'start_date', date("Y/m/d"));
			update_post_meta($post->ID, 'end_date', date("Y/m/d"));

		}else {
			update_post_meta($post->ID, 'job_requirements', $_POST["job_requirements"]);
			update_post_meta($post->ID, 'start_date' , $_POST["start_date"]);
			update_post_meta($post->ID, 'end_date' , $_POST["end_date"]);

		}

	//	update_post_meta( $post_id, 'job_requirements', $mydata);
	}
	
	// creates new page when the plugin is activated
	public function create_page() {
		$page_title = 'Job Postings';
		
		$page = get_page_by_title($page_title);
	
		if (!$page) {

			$my_page = array(
				'post_title' => $page_title,
			//	'post_content' => 'This is were the new job posting will end up',
				'post_status' => 'publish',
				'post_type' => 'page',
				'post_author' => 2,
				'post_category' => array(1),
				'comment_status' => 'closed'
			);

			$post_id = wp_insert_post($my_page);
			
		}
	}

	//changes the new page to Job Posting Template
	public function get_custom_post_type_template($single_template) {
	     global $post;
	     if ($post->post_type == 'page') {
		  $single_template = dirname( __FILE__ ) . 'job_post_template.php';
	     }
	     return $single_template;
	}


	// delete new page on removal of plugin deactiation
	public function remove_plugin_page(){
		$page = get_page_by_title('Job Postings');

		wp_delete_post($page->ID, true);
	}
	
	//for template redirect
	function my_theme_redirect() {
	    global $wp;
	    $plugindir = plugin_dir_path( __FILE__ );

	    /*A Specific Custom Post Type
	    if ($wp->query_vars["post_type"] == 'job_posting') {
		$templatefilename = 'job_post_template.php';
		if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
		    $return_template = TEMPLATEPATH . '/' . $templatefilename;
		} else {
		    $return_template = $plugindir . '/pagetemp/' . $templatefilename;
		}
		do_theme_redirect($return_template);

	    //A Custom Taxonomy Page
	    } elseif ($wp->query_vars["taxonomy"] == 'product_categories') {
		$templatefilename = 'taxonomy-product_categories.php';
		if (file_exists(TEMPLATEPATH . '/' . $templatefilename)) {
		    $return_template = TEMPLATEPATH . '/' . $templatefilename;
		} else {
		    $return_template = $plugindir . '/themefiles/' . $templatefilename;
		}
		do_theme_redirect($return_template);*/

	    //A Simple Page
	    if ($wp->query_vars["pagename"] == 'Job Postings') {
		$templatefilename = 'job_post_template.php';
		if (file_exists(get_stylesheet_directory(). '/' . $templatefilename)) {
		    $return_template = get_stylesheet_directory() . '/' . $templatefilename;
		} else {
		    $return_template = $plugindir . '/pagetemp/' . $templatefilename;
		}
		do_theme_redirect($return_template);
	    }
}
}
?>
