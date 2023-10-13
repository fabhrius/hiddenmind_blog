<?php

function fab_add_open_graph_tags() {
    if (is_single()) {
        // Get the post title, excerpt, URL, and featured image URL
        $post_title = get_the_title();
        $post_excerpt = get_the_excerpt();
        $post_url = get_permalink();
        $post_image = get_the_post_thumbnail_url();

        // Output Open Graph tags
        echo '<meta property="og:title" content="' . esc_attr($post_title) . '" />' . "\n";
        echo '<meta property="og:description" content="' . esc_attr($post_excerpt) . '" />' . "\n";
        echo '<meta property="og:url" content="' . esc_url($post_url) . '" />' . "\n";
        echo '<meta property="og:image" content="' . esc_url($post_image) . '" />' . "\n";
        echo '<meta property="og:type" content="article" />' . "\n";
        echo '<meta property="fb:app_id" content="270407812571567" />' . "\n";
    }
}
add_action('wp_head', 'fab_add_open_graph_tags');

?>