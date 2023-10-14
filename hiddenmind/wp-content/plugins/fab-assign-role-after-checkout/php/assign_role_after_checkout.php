<?php

function assign_role_after_checkout( $order_id ) {
	
	// obtener la orden a partir del id
    $order = wc_get_order( $order_id );
	
	// Get the user ID associated with the order
    $user_id = $order->get_user_id();
	// category_slug - categoria de suscripciones
	$required_category_slug = 'subscriptions';

	$desired_attribute_name_for_role = 'subscription_role';
	$desired_attribute_name_for_duration = 'subscription_duration';
	
	// role que otorga la subscrition y duracion de la suscripcion
	$role; $duration;



	// iterar sobre los items de la orden
	foreach ($order->get_items() as $item_id => $item) {

		$product = $item->get_product();
    		if ($product) {
			$categories = $product->get_category_ids();

			foreach ($categories as $category_id) {
				// Get the category details
				$category = get_term($category_id, 'product_cat');
				if($category){
					$category_slug = $category->slug;
					if($category_slug === $required_category_slug){ 

        					// Get the attributes for the product
       			 			$attributes = $product->get_attributes();

        					foreach ($attributes as $attribute_name => $attribute) {
            						$attribute_value = $attribute['value'];

									if ($attribute_name === $desired_attribute_name_for_role) {
										$role=$attribute_value;

										// Add the user role to the user
										$user = new WP_User( $user_id );
										$user->add_role( $role );
									}
									if ($attribute_name === $desired_attribute_name_for_duration) {
										$duration=$attribute_value;

										// schedule a cron
										//schedule_cron_subscrition_ending_time($user, $role, $duration);
										schedule_cron_subscription_ending_time($user_id, $role, $duration);
									}
        					}

					}
				}
			}
		}
	}
}

function remove_subscription_role_callback($user_id, $role) {
    // Remove the role from the user
    $user = new WP_User($user_id);
    $user->remove_role($role);
}

function schedule_cron_subscription_ending_time($user_id, $role, $duration) {
    // Calculate the timestamp when the role should be removed
    $end_timestamp = strtotime("+{$duration} seconds");

    // Schedule the cron event
    wp_schedule_single_event($end_timestamp, 'remove_subscription_role', array($user_id, $role));
}

function after_checkout_with_status_on_hold( $order_id ) {
	assign_role_after_checkout( $order_id );
}

function after_checkout_with_status_processing( $order_id ) {
	assign_role_after_checkout( $order_id );
}



add_action('remove_subscription_role', 'remove_subscription_role_callback', 10, 2);



add_action( 'woocommerce_order_status_processing', 'after_checkout_with_status_processing' ); 
add_action( 'woocommerce_order_status_completed', 'assign_role_after_checkout' );
add_action( 'woocommerce_order_status_on-hold', 'after_checkout_with_status_on_hold' );





?>