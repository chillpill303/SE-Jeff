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
    it under ehe terms of the GNU General Public License as published by
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
define('JSM_JOB', __FILE__);
define('JSM_JOB_PATH', plugin_dir_path(__FILE__));

require JSM_JOB_PATH . 'class/main_class.php';
require JSM_JOB_PATH . 'class/admin_setting_class.php';

//create the page for the plugin
register_activation_hook( __FILE__, array('set', 'create_page'));

//removes the page when plugin deactivated
register_deactivation_hook( __FILE__, array('set', 'remove_plugin_page'));

new Set();
new Admin_setting(); 
?>
