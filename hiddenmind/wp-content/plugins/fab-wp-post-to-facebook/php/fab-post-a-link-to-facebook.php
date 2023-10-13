<?php
// Hook into the 'publish_post' action to trigger the function when a new post is published.
add_action('publish_post', 'fab_publish_link_post_to_facebook');

function fab_publish_link_post_to_facebook($post_id) {
    $logManager = new LoggerManager();
    $log = $logManager->getLogger_log_to_file();
    $function_id = "FUNCTION -> fab_publish_link_post_to_facebook - ";

    // Check if this is not a revision.
    if (!wp_is_post_revision($post_id)) {

        $post_link = get_permalink($post_id);  

        // Initialize the Facebook SDK with your app credentials.
        $fb = new Facebook\Facebook([
            'app_id' => FAB_APP_ID,
            'app_secret' => FAB_APP_SECRET,
            'default_graph_version' => FAB_DEFAULT_GRAPH_VERSION, // Use the appropriate version
        ]);

        // Create a Facebook API request to post to a Page.
        try {
            $response = $fb->post('/' . FAB_PAGE_ID . '/feed', [
                'link' => $post_link, // Replace with your post URL
            ], FAB_ACCESS_TOKEN);
            
            // Handle success or error as needed.
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            $errorMessage = $e->getMessage();
            $log_string = function_id . "Caught exception: " . $errorMessage;
            log_it($log_string);

        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // Handle SDK errors.
            $errorMessage = $e->getMessage();
            $log_string = function_id . "Caught exception: " . $errorMessage;
            log_it($log_string);
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $log_string = function_id . "Caught exception: " . $errorMessage;
            log_it($log_string);        }
    }
}
function log_it($log_string){
    if ( defined( 'LOGGER_MANAGER_AVAILABLE' ) ) {
        $log->error($log_string);
    }else {
        echo $log_string;
    }
}
?>