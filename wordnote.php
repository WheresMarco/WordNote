<?php
/*
Plugin Name: WordNote
Plugin URI: http://wheresmar.co/wordnote/
Description: Simple way to make notes on the WordPress dashboard.
Version: 2.0
Author: Marco Hyyryläinen
Author URI: http://wheresmar.co
*/

// If get POST by the plugin
if ($_POST['note']) {
	require_once('../../../wp-config.php');
	update_option("wordnote", htmlentities($_POST['note'], ENT_QUOTES, 'UTF-8'));
	die();
} else {

	// Create the function to output the form as a Dashboard Widget
	function wordnote_dashboard_widget_function() {
		echo "<div id=\"wordnote\">\n";
		echo "<textarea name=\"note\" id=\"note\" style=\"width: 100%; height: 100px\">".get_option("wordnote", "Leave a note.")."</textarea><br />\n";
		echo "<button value=\"Save\" id=\"wordnote-submit\" class=\"button\" style=\"float: right;\" />Save</button><br />\n";
		echo "</div>\n";
	} 

	// Create the function use in the action hook
	function wordnote_add_dashboard_widgets() {
		wp_add_dashboard_widget('wordnote_dashboard_widget', 'WordNote', 'wordnote_dashboard_widget_function');	
	} 

	// JavaScript for the form on the dashboard
	function wordnote_javascript() {
	?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript">
	    	$(document).ready(function(){
	    		$("#wordnote-submit").click(function() {
	    			var note = $("#note").val();
	    			$("#wordnote-submit").html('Saving...');

	    			$.ajax({
						type: "POST",
						url: "/WordNote/wp-content/plugins/wordnote/wordnote.php",
						data: { note: note + ' ' }
					}).done(function( msg ) {
						$("#wordnote-submit").html('Saved');
					});
				});
	    	});
	    </script>
	<?php
	}

	// Hook into WordPress-header on dashboard for JavaScript & hook into the 'wp_dashboard_setup' action to register the form function
	add_action('admin_footer-index.php', 'wordnote_javascript');
	add_action('wp_dashboard_setup', 'wordnote_add_dashboard_widgets' );
}
?>