<?php
 /* 
    Plugin Name: Add To Orkut
    Plugin URI: http://www.way2wp.com
    Description: Adds a footer link to add the current post to Orkut.
    Author: sribharath.y 
    Version: 3.1 
    Author URI: http://www.way2wp.com 
    */  

/*
Change Log

1.0
  * First public release.
*/ 

function add_to_orkut($data){
	global $post;
	$current_options = get_option('add_to_orkut_options');
	$linktype = $current_options['link_type'];
	switch ($linktype) {
		case "text":
			$data=$data."<a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\" title=\"Add to orkut\">Add to orkut</a></p>";
			break;
		case "image":
			$data=$data."<a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\" title=\"Add to orkut\"><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-orkut/share.gif\"></a></p>";
			break;
		case "both":
			$data=$data."<a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\"><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-orkut/share.gif\"></a><a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\">Add to orkut</a></p>";
			break;
		}
		return $data;
}

function activate_add_to_orkut(){
	global $post;
	$current_options = get_option('add_to_orkut_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype != 'template'){
		add_filter('the_content', 'add_to_orkut', 10);
		add_filter('the_excerpt', 'add_to_orkut', 10);
	}
}

activate_add_to_orkut();

function addtoorkut(){
	global $post;
	$current_options = get_option('add_to_orkut_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype != 'auto'){
		$linktype = $current_options['link_type'];
		switch ($linktype) {
			case "text":
				echo "<p class=\"orkut\"><a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\" title=\"Add to orkut\">Add to orkut</a></p>";
				break;
			case "image":
				echo "<p class=\"orkut\"><a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\" title=\"Add to orkut\"><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-orkut/share.gif\"> </a></p>";
				break;
			case "both":
				echo "<p class=\"orkut\"><a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\"><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-orkut/share.gif\"> </a><a rel=\"nofollow\" href=\"http://promote.orkut.com/preview?nt=orkut.com&tt=".get_the_title($post->ID)."&du=".get_permalink($post->ID)."\" target=\"_blank\">Add to orkut</a></p>";
				break;
			}
		}
}

// Create the options page
function add_to_orkut_options_page() { 
	$current_options = get_option('add_to_orkut_options');
	$link = $current_options["link_type"];
	$insert = $current_options["insertion_type"];
	if ($_POST['action']){ ?>
		<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>
	<?php } ?>
	<div class="wrap" id="add-to-orkut-options">
		<h2>Add to orkut Options</h2>
		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<fieldset>
				<legend>Options:</legend>
				<input type="hidden" name="action" value="save_add_to_orkut_options" />
				<table width="100%" cellspacing="2" cellpadding="5" class="editform">
					<tr>
						<th valign="top" scope="row"><label for="link_type">Link Type:</label></th>
						<td><select name="link_type">
						<option value ="text"<?php if ($link == "text") { print " selected"; } ?>>Text Only</option>
						<option value ="image"<?php if ($link == "image") { print " selected"; } ?>>Image Only</option>
						<option value ="both"<?php if ($link == "both") { print " selected"; } ?>>Image and Text</option>
						</select></td>
					</tr>
					<tr>
						<th valign="top" scope="row"><label for="insertion_type">Insertion Type:</label></th>
						<td><select name="insertion_type">
						<option value ="auto"<?php if ($insert == "auto") { print " selected"; } ?>>Auto</option>
						</select></td>
					</tr>
				</table>
			</fieldset>
			<p class="submit">
				<input type="submit" name="Submit" value="Update Options &raquo;" />
			</p>
		</form>
	</div><br />
<br />
This Template Was Developed By Sribharath of <a href="http://www.way2wp.com">way 2 wordpress</a>
<?php 
}

function add_to_orkut_add_options_page() {
	// Add a new menu under Options:
	add_options_page('Add to orkut', 'Add to orkut', 10, __FILE__, 'add_to_orkut_options_page');
}

function add_to_orkut_save_options() {
	// create array
	$add_to_orkut_options["link_type"] = $_POST["link_type"];
	$add_to_orkut_options["insertion_type"] = $_POST["insertion_type"];
	
	update_option('add_to_orkut_options', $add_to_orkut_options);
	$options_saved = true;
}

add_action('admin_menu', 'add_to_orkut_add_options_page');

if (!get_option('add_to_orkut_options')){
	// create default options
	$add_to_orkut_options["link_type"] = 'text';
	$add_to_orkut_options["insertion_type"] = 'auto';
	
	update_option('add_to_orkut_options', $add_to_orkut_options);
}

if ($_POST['action'] == 'save_add_to_orkut_options'){
	add_to_orkut_save_options();
}

function orkutcss() {
	?>
	<link rel="stylesheet" href="<?php bloginfo('wpurl'); ?>/wp-content/plugins/add-to-orkut/orkut.css" type="text/css" media="screen" />
	<?php
}

add_action('wp_head', 'orkutcss');
?>