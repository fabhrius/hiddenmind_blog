<?php


// Hook into the 'publish_post' action to trigger the function when a new post is published.
add_action('publish_post', 'fab_post_to_facebook');

function fab_post_to_facebook($post_id) {
    // Check if this is not a revision.
    if (!wp_is_post_revision($post_id)) {
        // Get the post object.
        
        // Extract the post title, first image, and excerpt.
        /*

        $post = get_post($post_id);

        $post_title = $post->post_title;
        $post_excerpt = $post->post_excerpt;
        
        // Get the first image attached to the post.
        $post_thumbnail_id = get_post_thumbnail_id($post_id);
        $post_thumbnail_url = wp_get_attachment_url($post_thumbnail_id);

        */


        $post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full'); // 'full' is the image size

        $post_title = get_the_title($post_id);
        $post_excerpt = get_the_excerpt($post_id);
        $post_link = get_permalink($post_id);
    

        // Create the content to post on Facebook.
        //$facebook_content = get_permalink($post_id);
        //$facebook_content = "A new Post was just published : " . get_permalink($post_id);
        //$facebook_content = $post_title . "\n" . $post_excerpt . "\n" . $post_thumbnail_url . "\n" . "see more : " . get_permalink($post_id);
        //$facebook_content = $post_title . "\n" . $post_excerpt . "\n" . $post_thumbnail_url . "\n" . "see more at : " . "https://hiddenmind.elementfx.com/anamilia/";
        
        // Include the Facebook SDK.
        //require_once plugin_dir_path(__FILE__) . 'Facebook/autoload.php';

        // Initialize the Facebook SDK with your app credentials.
        $fb = new Facebook\Facebook([
            'app_id' => '270407812571567',
            'app_secret' => '877fc74012a6d6d7ec64167c439f44e5',
            'default_graph_version' => 'v18.0', // Use the appropriate version
        ]);

        // Set the access token obtained from your Facebook App.
        $access_token = 'EAAD17zmc4a8BO3ivZBf1kzZCeP4vlQZCNLUR1WPsLZB6EDp99dF3emDDmSTDUHcHx5KhRgrlexFyimOzZAbDZB2FbAiEqkv8bSOZBFixgu5YRaquRoddDmZAZAfJ2fXT1l4kqQ2RLyHYZChu5rW2guQO0wienTDd4O0Y2x1ZCUy7j5Qy7cfiiF7QZBsYkjk0qzAuZA5kTLZAWUjMcZD';

        // Create a Facebook API request to post to a Page.
        try {

            // $response = file_get_contents('https://graph.facebook.com/vX.Y/page-id/feed?access_token=your-access-token&message=your-message');
            // var_dump($response);



            $response = $fb->post('/124969817355822/feed', [
                'name' => $post_title,
                'picture' => $post_thumbnail_url,
                'message' => $post_excerpt,
                'link' => $post_link, // Replace with your post URL
            ], $access_token);

            // Get the response data if needed.
            $graphNode = $response->getGraphNode();
            
            // Handle success or error as needed.
        } catch (Facebook\Exceptions\FacebookResponseException $e) {
            // Handle API errors.
            $response = $e->getResponse();
            //var_dump($response); 

            $errorMessage = $e->getMessage();
            echo "Caught exception: " . $errorMessage;
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            // Handle SDK errors.
            $errorMessage = $e->getMessage();
            echo "Caught exception: " . $errorMessage;
        } catch (Exception $e) {
            // Handle other exceptions
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>