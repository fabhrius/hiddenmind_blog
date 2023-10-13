<?php

// Hook into the 'publish_post' action to trigger the function when a new post is published.
add_action('publish_post', 'update_access_token');


function update_access_token() {
    // Get the last token from the database
    $old_token = get_token_from_db();

    $page_id = 124969817355822;

    // Check if the old token is still valid (you may need to implement this logic)
    // if (is_token_valid($old_token)) {
        // Call for a new token
        $url = "https://graph.facebook.com/{$page_id}?fields=access_token&access_token={$old_token}";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);

        if ($resp === false) {
            // Handle cURL error
            echo "cURL Error: " . curl_error($curl);
        } else {
            // Save the new token to the database
            $obj = json_decode($resp, true);

            if (isset($obj['access_token'])) {
                $new_token = $obj['access_token'];
                save_token_to_db($new_token);
                echo "New token obtained and saved: {$new_token}";
            } else {
                echo "Failed to obtain a new token. Response: " . $resp;
            }
        }

        curl_close($curl);
    //} else {
    //     echo "The old token is no longer valid.";
    // }
}


    function save_token_to_db($new_token){

        require_once(plugin_dir_path(__FILE__) . '../classes/LoggerManager.php');

        $logger_manager = new LoggerManager();
        $log = $logger_manager->getLogger_log_to_file();

        $msg = 'nuevo token = ' . $new_token;
        $log->info($msg);

    }

    function get_token_from_db(){
        return 'EAAD17zmc4a8BOwAmn0JwPfvhXf3G2Fc8C4FzcifAwy6ZBVy2QCdR30uZCivywWbhfFFTJ69yNgt8dZBWhytQZCHRrnITOpCwsWlE2uuk63ZAyOrhQ9M4jZCRf2Hr0YV9aLcKuvzXmbvf7MSxE8ng9tzl9kbtLf7JVbwPNEjf3dei4FveydaCBxTM4i3BUVhb7z';
    }

?>