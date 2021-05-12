<?php
/*
Plugin Name: Age Plugin
Plugin URI: 
Description: This plugin code for adding extra field in user profile
Version: 1.0.0
Author: user
Author URI: 
License: 
Text Domain: 
*/
//$wpdb->show_errors(); $wpdb->print_error();


//function to add the field to the WordPress user’s profile page
function add_age_field_user_profile ($user){
	$user_id = $user->ID;

	?>

	<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <h3>Extra profile information</h3>
	    <table class="form-table">
        <tr>
            <td>Age</td>
            <td><input type="number" name="age"autocomplete="off">
            </td>
        </tr>
    </table>
    <script type="text/javascript">
        $('input').addClass('regular-text');
        $('input[name=age]').val('<?php echo get_the_author_meta('age', $user->ID); ?>');
    </script>

	<?php	
}

//function to save the values of custom fields to user meta

function save_age_field_user_profile($user_id){
	if(!current_user_can('edit_user', $user_id)){
		return false;
	}
	update_user_meta($user_id,'age', $_POST["age"]);
}

//function to add a column for age field in table users
function new_modify_user_table_bsx( $column ) {
    $column['age'] = 'Age';
    return $column;
}

//function to add the row value of age field in table users
function new_modify_user_table_row_bsx( $val, $column_name, $user_id ) {
    $meta = get_user_meta($user_id);
    switch ($column_name) {
        case 'age' :
            $age = $meta['age'][0];
            return $age;
        default:
    }
    return $val;
}

//add the column and row of age using filters
add_filter( 'manage_users_columns', 'new_modify_user_table_bsx' );
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row_bsx', 10, 3 );


//hook the functions to the pages
add_action('show_user_profile', 'add_age_field_user_profile');
add_action('edit_user_profile', 'add_age_field_user_profile');
add_action('personal_options_update', 'save_age_field_user_profile');
add_action('edit_user_profile_update', 'save_age_field_user_profile');