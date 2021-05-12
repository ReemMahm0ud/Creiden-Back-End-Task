<?php
/*
Plugin Name: Woocommerce Delivered Statuses Plugin
Plugin URI: 
Description: This plugin code for adding new statuses (delivered)
Version: 1.0.0
Author: user
Author URI: 
License: 
Text Domain:
*/
//$wpdb->show_errors(); $wpdb->print_error();


//function to register the new statues
function register_delivered_order_status(){
    register_post_status('wc-delivered', array(
        'label' => 'Delivered',
        'public' => true,
        'exclude_from_sarch' => false,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Delivered (%s)','Delivered (%s)')
    ));
}

//function to add to list of WC order statuses
function add_delivered_to_order_statuses($order_statuses){
    $new_order_statuses = array();
    
    //add new order status after completed
    foreach ($order_statuses as $key => $status){
        $new_order_statuses[$key]=$status;

        if('wc-completed'===$key){
            $new_order_statuses['wc-delivered'] = 'Delivered';
        }
    }

    return $new_order_statuses;
}


// add a bulk option (to select muliple order and change the status fo all of them)
function add_to_bulk_actions_orders() {
    global $post_type;

    if( 'shop_order' == $post_type ) {
        ?>
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery('<option>').val('mark_delivered').text('<?php _e( 'Change Status to Delivered' ); ?>').appendTo("select[name='action']");
                    jQuery('<option>').val('mark_delivered').text('<?php _e( 'Change Status to Delivered' ); ?>').appendTo("select[name='action2']");
                });
            </script>
        <?php
    }
}

//add the bulk option to the list
add_action( 'admin_footer', 'add_to_bulk_actions_orders' );

//add the register of the status to the init stage
add_action('init', 'register_delivered_order_status');

//add the status to the list
add_filter('wc_order_statuses','add_delivered_to_order_statuses');