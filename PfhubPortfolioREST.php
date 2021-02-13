<?php

class PfhubPortfolioREST{
    
    /**
     * Initializes this class. Creates a REST call and also overrides the PfhubPortfolio page shortcode for rest calls.
     *
     * @param void
     *
     * @return void
     */
    public static function init(){
        add_action('rest_api_init', function () {
            register_rest_route( 'portfolio-gallery-api', 'items/(?P<id>\d+)', array(
                'methods'  => 'GET',
                'callback' => [__CLASS__, 'galleryItems']
            ));
            
            self::removePfhubShortcodes();
        });
    }
    
    /**
     * Returns the portfolio items in JSON format, from a given gallery by numeric id. 
     *
     * @param array $data
     *
     * @return WP_REST_Response
     */
    public static function galleryItems($data) {
        global $wpdb;
        
        //the id for the gallery
        $id = $data['id'];

        $query = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}pfhub_portfolio_images WHERE grid_id = '%d' ORDER BY ordering ASC", $id);

        $images = $wpdb->get_results($query);
        
        
        if (empty($images)) {
            return new WP_Error( 'empty_gallery', 'there are no images in this gallery', array('status' => 404) );
        }

        $response = new WP_REST_Response($images);
        $response->set_status(200);

        return $response;
    }
    
    /**
     * Renders an HTML tag as replacement for the normal PfhubPortfolio page shortcode output. (But only for the WP REST API)
     *
     * @param array $id_arr.  Contains key "id", which is what is used.
     *
     * @return string
     */
    public static function newRESTAction( $id_arr ){
        //gallery id
        $id = $id_arr["id"];
        
        return "<pfhub-portfolio pfhub_id=\"{$id}\" id=\"pfhub_portfolio_portfolio_{$id}\" />";
    }

    /**
     * Does the actual job of replacing the PfhubPortfolio shortcode content and replacing it with the output of method "newRESTAction"
     *
     * @param void
     *
     * @return void
     */
    public static function removePfhubShortcodes() {
        remove_shortcode( 'pfhub_portfolio_portfolio' );
        
        add_shortcode('pfhub_portfolio_portfolio', [__CLASS__, 'newRESTAction'] );
    }
}
