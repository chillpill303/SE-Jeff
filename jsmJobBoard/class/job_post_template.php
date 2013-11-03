<?php
/**
 * Template Name: Job Posting
 *
 * Print posts of a Custom Post Type.
 */
 
 /* for now this file must be put in the themes/twentythirteen directory or whichever theme your are using.  Because of restriction 
 *by turing and other issues I can't figure out this is how is is done for now.
 * Jeff Mattson 11/2/2013
 */
 
global $more; //for More...
get_header(); 

?>

    <div id="container">
        <div id="content">
	<?php 
        $type = 'job_posting';
        $args = array (
         	'post_type' => $type,
         	'post_status' => 'publish',
         	'paged' => $paged,
         	'posts_per_page' => 10,
         	'ignore_sticky_posts'=> 1
        	);
        	
        $temp = $wp_query; // assign ordinal query to temp variable for later use  
        $wp_query = null;
        $wp_query = new WP_Query($args); 
        if ( $wp_query->have_posts() ) :
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
            
		$more = 0;//supposed to create the More... Does nothing as far as I can tell
                echo '<span style="color:#5A5A5A; font-size:30px; text-decoration:underline;">'; 
                the_title();
                echo '</span>'; 
                echo '<div class="entry-content" style="color:#5A5A5A;">';
	?>

		<table>
			<tr>
				<th><span style="font-size:16px; font-weight:bold;">Job Description</span></th>
			</tr>
			<tr>
				<td> <?php the_content("More..."); ?> </td>
			</tr>
			<tr>
				<th><span style="font-size:16px; font-weight:bold;">Job Requirements</span></th>
			</tr>
			<tr>
				<td> <?php echo str_replace("\n", '<br />', get_post_meta( $post->ID, 'job_requirements', true)); 
?> </td>		
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td><span style="font-size:16px; font-weight:bold;">Start Date</span></td><td><?php echo get_post_meta( $post->ID, 'start_date', true);?></td>
				<td><span style="font-size:16px; font-weight:bold;">End Date</span></td><td><?php echo get_post_meta( $post->ID, 'end_date', true);?></td>
			</tr>
			<tr>
				<td><span style="font-size:16px; font-weight:bold;">Contact</span></td><td></td>
			</tr>
               	</table>
	</div>
<?php
            endwhile;
        else :
            echo '<h2>Not Found</h2>';
            get_search_form();
        endif;
        $wp_query = $temp;
?>
        </div><!-- #content -->
    </div><!-- #container -->

<?php get_sidebar(); ?>

<script type='text/javascript' src='http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-includes/js/admin-bar.min.js?ver=3.6.1'></script>
<script type='text/javascript' src='http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-includes/js/jquery/jquery.masonry.min.js?ver=2.1.05'></script>
<script type='text/javascript' src='http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-content/themes/twentythirteen/js/functions.js?ver=2013-07-18'></script>
	<script type="text/javascript">
		(function() {
			var request, b = document.body, c = 'className', cs = 'customize-support', rcs = new RegExp('(^|\\s+)(no-)?'+cs+'(\\s+|$)');

			request = true;

			b[c] = b[c].replace( rcs, ' ' );
			b[c] += ( window.postMessage && request ? ' ' : ' no-' ) + cs;
		}());
	</script>
	<div id="wpadminbar" class="nojq nojs" role="navigation">
			<a class="screen-reader-shortcut" href="#wp-toolbar" tabindex="1">Skip to toolbar</a>
			<div class="quicklinks" id="wp-toolbar" role="navigation" aria-label="Top navigation toolbar." tabindex="0">
				<ul id="wp-admin-bar-root-default" class="ab-top-menu">
		<li id="wp-admin-bar-wp-logo" class="menupop"><a class="ab-item"  aria-haspopup="true" href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/about.php" title="About WordPress"><span class="ab-icon"></span></a><div class="ab-sub-wrapper"><ul id="wp-admin-bar-wp-logo-default" class="ab-submenu">
		<li id="wp-admin-bar-about"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/about.php">About WordPress</a>		</li></ul><ul id="wp-admin-bar-wp-logo-external" class="ab-sub-secondary ab-submenu">
		<li id="wp-admin-bar-wporg"><a class="ab-item"  href="http://wordpress.org/">WordPress.org</a>		</li>
		<li id="wp-admin-bar-documentation"><a class="ab-item"  href="http://codex.wordpress.org/">Documentation</a>		</li>
		<li id="wp-admin-bar-support-forums"><a class="ab-item"  href="http://wordpress.org/support/">Support Forums</a>		</li>
		<li id="wp-admin-bar-feedback"><a class="ab-item"  href="http://wordpress.org/support/forum/requests-and-feedback">Feedback</a>		</li></ul></div>		</li>
		<li id="wp-admin-bar-site-name" class="menupop"><a class="ab-item"  aria-haspopup="true" href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/">MoonBase</a><div class="ab-sub-wrapper"><ul id="wp-admin-bar-site-name-default" class="ab-submenu">
		<li id="wp-admin-bar-dashboard"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/">Dashboard</a>		</li></ul><ul id="wp-admin-bar-appearance" class="ab-submenu">
		<li id="wp-admin-bar-themes"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/themes.php">Themes</a>		</li>
		<li id="wp-admin-bar-customize" class="hide-if-no-customize"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/customize.php?url=http%3A%2F%2Fturing.cs.plymouth.edu%2F%7Ejsmattson%2Fsoftware%2Fwordpress%2F">Customize</a>		</li>
		<li id="wp-admin-bar-widgets"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/widgets.php">Widgets</a>		</li>
		<li id="wp-admin-bar-menus"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/nav-menus.php">Menus</a>		</li>
		<li id="wp-admin-bar-header"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/themes.php?page=custom-header">Header</a>		</li></ul></div>		</li>
		<li id="wp-admin-bar-updates"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/update-core.php" title="2 Theme Updates"><span class="ab-icon"></span><span class="ab-label">2</span><span class="screen-reader-text">2 Theme Updates</span></a>		</li>
		<li id="wp-admin-bar-comments"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/edit-comments.php" title="0 comments awaiting moderation"><span class="ab-icon"></span><span id="ab-awaiting-mod" class="ab-label awaiting-mod pending-count count-0">0</span></a>		</li>
		<li id="wp-admin-bar-new-content" class="menupop"><a class="ab-item"  aria-haspopup="true" href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/post-new.php" title="Add New"><span class="ab-icon"></span><span class="ab-label">New</span></a><div class="ab-sub-wrapper"><ul id="wp-admin-bar-new-content-default" class="ab-submenu">
		<li id="wp-admin-bar-new-post"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/post-new.php">Post</a>		</li>
		<li id="wp-admin-bar-new-media"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/media-new.php">Media</a>		</li>
		<li id="wp-admin-bar-new-page"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/post-new.php?post_type=page">Page</a>		</li>
		<li id="wp-admin-bar-new-job_posting"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/post-new.php?post_type=job_posting">Job Posting</a>		</li>
		<li id="wp-admin-bar-new-user"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/user-new.php">User</a>		</li></ul></div>		</li></ul><ul id="wp-admin-bar-top-secondary" class="ab-top-secondary ab-top-menu">
		<li id="wp-admin-bar-search" class="admin-bar-search"><div class="ab-item ab-empty-item" tabindex="-1"><form action="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/" method="get" id="adminbarsearch"><input class="adminbar-input" name="s" id="adminbar-search" type="text" value="" maxlength="150" /><input type="submit" class="adminbar-button" value="Search"/></form></div>		</li>
		<li id="wp-admin-bar-my-account" class="menupop with-avatar"><a class="ab-item"  aria-haspopup="true" href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/profile.php" title="My Account">Howdy, jeffreysmattson<img alt='' src='http://1.gravatar.com/avatar/7df05fdadcd3dbcef3bb1ba25c516a68?s=16&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D16&amp;r=G' class='avatar avatar-16 photo' height='16' width='16' /></a><div class="ab-sub-wrapper"><ul id="wp-admin-bar-user-actions" class="ab-submenu">
		<li id="wp-admin-bar-user-info"><a class="ab-item" tabindex="-1" href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/profile.php"><img alt='' src='http://1.gravatar.com/avatar/7df05fdadcd3dbcef3bb1ba25c516a68?s=64&amp;d=http%3A%2F%2F1.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D64&amp;r=G' class='avatar avatar-64 photo' height='64' width='64' /><span class='display-name'>jeffreysmattson</span></a>		</li>
		<li id="wp-admin-bar-edit-profile"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-admin/profile.php">Edit My Profile</a>		</li>
		<li id="wp-admin-bar-logout"><a class="ab-item"  href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-login.php?action=logout&#038;_wpnonce=667354cd0a">Log Out</a>		</li></ul></div>		</li></ul>			</div>
						<a class="screen-reader-shortcut" href="http://turing.cs.plymouth.edu/~jsmattson/software/wordpress/wp-login.php?action=logout&#038;_wpnonce=667354cd0a">Log Out</a>
</div>
</div> 
</html>
