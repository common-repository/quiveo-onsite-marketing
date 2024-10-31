<?php
/*
Plugin name: Quiveo OnsiteMarketing.
Plugin URI: https://quiveo.de/
Description: Quiveo OnsiteMarketin Plugin
Author: Quiveo GmbH
Version: 1.1
Author URI: http://quiveo.de/
*/

function quiveo_osm_add_script_in_footer($name) {
	$opt_name = 'quiveo_osm_project_id';
	$opt_val = get_option( $opt_name );
	$script = '<script lang="application/javascript">
    (function(d, s, id){
        var quiveo_project_id = '.get_option( $opt_name ).';
        var url = "https://system.quiveo.de/visitor/index/preload?id=";
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)){ return; }
        js = d.createElement(s); js.id = id;
        js.src = url + quiveo_project_id;
        fjs.parentNode.insertBefore(js, fjs);
    }(document, "script", "quiveoPreload"));
</script>';
	echo $script;
}
add_action( 'get_footer', 'quiveo_osm_add_script_in_footer' );

/**
 * Adding admin options menu
 */
 
if ( is_admin() ){ // admin actions
  add_action( 'admin_menu', 'quiveo_osm_admin_menu' );
  add_action( 'admin_init', 'quiveo_osm_register_mysettings' );
} else {
  // non-admin enqueues, actions, and filters
}

function quiveo_osm_register_mysettings() {
	register_setting( 'quiveo_osm_options_group', 'quiveo_osm_project_id' );
}

function quiveo_osm_admin_menu() {
	add_options_page( 'Quiveo OnsiteMarketing', 'Quiveo OnsiteMarketing', 'manage_options', 'quiveo_osm', 'quiveo_osm_options' );
}

function quiveo_osm_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	$opt_name = 'quiveo_osm_project_id';
    $opt_val = get_option( $opt_name );
	$hidden_field_name = 'quiveo_osm_submit_hidden';
	
	 // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $opt_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );

        // Put a "settings saved" message on the screen ?>
		<div class="updated"><p><strong><?php _e('Settings saved.'); ?></strong></p></div> <?php
    }
	?>
	<div class="wrap">
        <h2><?php echo __('Quiveo OnsiteMarketing') ?></h2>
        <form name="form1" method="post" action="">
			<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			<p><?php _e("Project ID" ); ?> 
				<input type="text" name="<?php echo $opt_name ?>" value="<?php echo $opt_val; ?>" size="20">
			</p><hr />
			<p class="submit">
				<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
			</p>
		</form>
		<p>You need to create an Account on <a href="https://www.quiveo.de" target="_blank">www.quiveo.de</a> and create your project.
		Simply apply your project ID from the created project here in wordpress and the plugin is activated.</p>
		<hr />
		
<h1>Quiveo Onsite Marketing Tool</h1>
<h2>Why you need Quiveo?</h2>
<ul>
<li>Did you ever asked yourself why so many visitors are going to leave your website without any conversion?</li>
<li>Don't you know how to track the success of marketing campaigns?</li>
<li>Would you like to know how to increase your conversion rate with a great marketing tool called Quiveo?</li>
</ul>

<h2>What can you achieve with Quiveo?</h2>
<ul>
<li>Our tool gives you the ability to display and style custom popups (e.g. popups, content) to special visitors and visitorgroups.</li>
<li>Get newsletter subscriptions</li>
<li>Make intelligent redirects</li>
<li>Track your success rates on buttons, images which are clickable</li>
</ul>

<h2>How it works?</h2>
<ul>
<li>You can easily setup your project by integrating the JavaScript-snippet on your website - easy setup within 5 minutes</li>
<li>Select 30 themes and customize them according to your needs</li>
<li>Decide when you like to display the playout to your visitors: On leave (Exit-Intent), on scrolling (Scroll-Level-Detection), Trigger of Elements and much more</li>
<li>You can manage your participants by our newsletter integration APIs like MailChimp, Cleverreach and GetResponse</li>
<li>Track your success by extensive statistics given</li>
</ul>

<h2>Subscribe today – you won't regret it!</h2>
<ul>
<li>You can use 14 days trial without any risk</li>
<li>We are offering specialized packages for each business unit, depending on your needs and visitor load per month</li>
<li>Extensive online documentation as well as help videos are available</li>
<li>Easy account management: Upgrade your package at any time</li>
<li>Newsletter integration APIs available – additionally, you can export your participants as csv</li>
</ul>

<p>More information on our website: <a href="https://www.quiveo.de" target="_blank">www.quiveo.de</a></p>
<p>Subscribe to the 14 days trial stage: <a href="https://www.quiveo.de/demo.html" target="_blank">www.quiveo.de/demo.html</a></p>
    </div> <?php
}