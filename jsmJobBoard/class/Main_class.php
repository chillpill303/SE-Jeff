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

class set {
	
	public function __construct(){
		
		//this is just an interesting way to get code into a post or a page might be usefull.
		add_shortcode('testHtml', array($this, 'testShortCode'));
		
		//the action that creates the custom post type
		add_action( 'init', array($this, 'create_post_type')); 
		
		add_filter( 'request', array($this, 'add_cpt_to_feed'));
		
	}
	
	//table creation function we want wordpress to call this function when the admin installes the plugin.  Use the register_activation_hook() for that.
	public function jal_install() {
		global $wpdb;
		$table_name = $wpdb->prefix . "adminJobBoard";
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
