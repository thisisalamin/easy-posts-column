<?php
/**
 * Query Data from Database
 */
class Query_Data{

    /**
     * The length of the excerpt.
     *
     * @var int
     */
    private $excerpt_length = 20;

    /**
     * Constructor method.
     * Initializes the shortcode and hooks.
     */
    public function __construct(){
        add_shortcode( 'query_data', array( $this, 'query_data' ) );
    }

    /**
     * Get the length of the excerpt.
     *
     * @return int The length of the excerpt.
     */
    public function get_excerpt_length(){
        return $this->excerpt_length;
    }

    /**
     * Query data from the database and display the results.
     *
     * @return string The HTML output of the queried data.
     */
    public function query_data(){
        ob_start();
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 10,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        add_filter('excerpt_length', array( $this, 'get_excerpt_length' ),999 );

        $query = new WP_Query( $args );
        if( $query->have_posts() ){
            while( $query->have_posts() ){
                $query->the_post();
                // Link to the post title
                echo '<h2><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
                echo '<p>' . get_the_excerpt() . '</p>';
            }
        }
        remove_filter('excerpt_length', array( $this, 'set_excerpt_length' ),999 );
        
        wp_reset_postdata();
        return ob_get_clean();
    }
}