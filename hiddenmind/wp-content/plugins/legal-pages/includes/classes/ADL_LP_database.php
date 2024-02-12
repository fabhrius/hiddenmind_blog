<?php
defined('ABSPATH') || die('You can not access this file directly');

if ( !class_exists('ADL_LP_database') ):
class ADL_LP_database {
    const tableName = 'adl_legal_pages';

    public function __construct() {
        add_action( 'pre_get_posts', array($this, 'remove_legal_page_from_search') );
    }

    function remove_legal_page_from_search( $query ) {
        if ( get_option('adl_lp_misc')['hide_lp_in_search'] ) { // remove legal pages from search.
            if ( ! $query->is_admin && $query->is_search && $query->is_main_query() ) {
                $query->set( 'post__not_in', $this->get_ids() );
            }
        }

    }

    public function get_ids(  ) {
        $ids = [];
        foreach ( $this->get_lp_pages()->posts as $post) { $ids[] = $post->ID; }
        return $ids;
    }


    public function get_lp_pages( $limit = -1 ) {
        return new WP_Query( array(
                            'post_type'  => 'page',
                            'posts_per_page' => (!empty($limit)) ? $limit : -1 ,
                            'meta_query' => array(
                                array(
                                    'key'     => 'is_adl_legal_page',
                                    'value'   => true,
                                    'compare' => '=',
                                ),
                            ),
                        )
                );

    }

    public function get_lp_templates( $limit = -1 ) {
        global $ADL_LP, $wpdb;
        $limit = (!empty($limit) && -1 !==$limit) ? " LIMIT {$limit}" : '';
        $sql1 = 'SELECT * from '.$ADL_LP->template_table_name .$limit;
        return $wpdb->get_results($sql1); // get all legal templates
        
    }

}

endif;