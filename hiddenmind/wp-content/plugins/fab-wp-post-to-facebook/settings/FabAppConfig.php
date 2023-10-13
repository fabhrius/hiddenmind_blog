<?php

class FabAppConfig {

    private $app_id = '270407812571567';
    private $app_secret = '877fc74012a6d6d7ec64167c439f44e5';
    private $default_graph_version = 'v18.0'; // Use the appropriate version

    private $page_id = '124969817355822';
    private $access_token = 'EAAD17zmc4a8BO3ivZBf1kzZCeP4vlQZCNLUR1WPsLZB6EDp99dF3emDDmSTDUHcHx5KhRgrlexFyimOzZAbDZB2FbAiEqkv8bSOZBFixgu5YRaquRoddDmZAZAfJ2fXT1l4kqQ2RLyHYZChu5rW2guQO0wienTDd4O0Y2x1ZCUy7j5Qy7cfiiF7QZBsYkjk0qzAuZA5kTLZAWUjMcZD';



    // GETTERS AND SETTERS
    
    // function set_app_id($app_id) {
    //     $this->app_id = $app_id;
    // }
    function get_app_id() {
        return $this->app_id;
    }

    // function set_app_secret($app_secret) {
    //     $this->app_secret = $app_secret;
    // }
    function get_app_secret() {
        return $this->app_secret;
    }

    // function set_default_graph_version($default_graph_version) {
    //     $this->default_graph_version = $default_graph_version;
    // }
    function get_default_graph_version() {
        return $this->default_graph_version;
    }

    // function set_page_id($page_id) {
    //     $this->page_id = $page_id;
    // }
    function get_page_id() {
        return $this->page_id;
    }

    // function set_access_token($access_token) {
    //     $this->access_token = $access_token;
    // }
    function get_access_token() {
        return $this->access_token;
    }

    
}

?>