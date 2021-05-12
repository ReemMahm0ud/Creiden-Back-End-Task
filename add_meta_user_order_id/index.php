<?php
/*
Plugin Name: Woocommerce Add Meta User Last Order Plugin
Plugin URI: 
Description: This plugin code for adding user meta data field for last order
Version: 1.0.0
Author: user
Author URI: 
License: 
Text Domain: 
*/
//$wpdb->show_errors(); $wpdb->print_error();


//function to get last order id with delivered status using WP_query
function  last_id (){
    $args = array('post_status'=>'Delivered',
                 'posts_per_page'=>1,
                 'orderby'=>'ID',
                 'orderby'=>'DESC');
    $query= WP_Query($args);
    $order_id= $query->posts[0]->ID;

    return $order_id;
}

//function to save/update the values of custom fields to user meta
function save_extra_user_profile_fields_last_id( $user_id ) {
    if(!current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta($user_id, 'last_order_id',$id=last_id() );
}



//function to add the field to the WordPress user’s profile page
function extra_user_profile_last_id( $user ) { 
    $user_id = $user->ID;
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.0.js"></script>
    <table class="form-table">
        <tr>
            <td>Last Order Id</td>
            <td><input type="number" name="last_order_id"autocomplete="off" disabled="disabled" >
            </td>
        </tr>
    </table>
    <script type="text/javascript">
        $('input').addClass('regular-text');
        $('input[name=last_order_id]').val('<?php echo get_the_author_meta('last_order_id', $user->ID); ?>');
    </script>
<?php 
}


//hook the functions to the pages
add_action( 'show_user_profile', 'extra_user_profile_last_id' );
add_action( 'edit_user_profile', 'extra_user_profile_last_id' );

add_action( 'personal_options_update', 'save_extra_user_profile_fields_last_id' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields_last_id' );
