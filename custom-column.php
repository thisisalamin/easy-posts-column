<?php

/**
 * Custom Column
 *
 * This class represents a custom column for WordPress posts. It adds a "Views" column to the posts list table in the admin panel,
 * displaying the number of views for each post. It also adds a "Thumbnail" column, displaying the post's thumbnail image.
 *
 * @package Easy_Posts_Column
 */

if (!defined('ABSPATH')) {
    exit;
}

class Custom_Column
{

    private $view_count = 0;

    /**
     * Constructor method.
     * Initializes the custom column by adding necessary hooks and filters.
     */
    public function __construct()
    {
        add_filter('manage_posts_columns', array($this, 'add_column'));
        add_action('manage_posts_custom_column', array($this, 'render_column'), 10, 2);
        add_action('wp_head', array($this, 'count_post_views'));
        add_filter('manage_edit-post_sortable_columns', array($this, 'sort_column'));
        add_filter('manage_posts_columns', array($this, 'add_thumbnail_column'));
        add_action('manage_posts_custom_column', array($this, 'render_thumbnail_column'), 10, 2);
    }

    /**
     * Adds the "Views" column to the posts list table.
     *
     * @param array $columns The existing columns in the posts list table.
     * @return array The modified columns array with the "Views" column added.
     */
    public function add_column($columns)
    {
        $columns['post_views'] = __('Views', 'easy-posts-column');
        return $columns;
    }

    /**
     * Renders the content for the custom column.
     *
     * @param string $column The name of the column being rendered.
     * @param int $post_id The ID of the post being rendered.
     */
    public function render_column($column, $post_id)
    {
        if ($column == 'post_views') {
            echo get_post_meta($post_id, 'post_views', true);
        }
    }

    /**
     * Adds the "Views" column as a sortable column.
     *
     * @param array $columns The existing sortable columns.
     * @return array The modified sortable columns array with the "Views" column added.
     */
    public function sort_column($columns)
    {
        $columns['post_views'] = 'post_views';
        return $columns;
    }

    /**
     * Counts the number of views for the current post.
     * Updates the post meta with the new view count.
     */
    public function count_post_views()
    {
        if (is_single()) {
            $this->view_count = (int) get_post_meta(get_the_ID(), 'post_views', true);
            $this->view_count++;
            update_post_meta(get_the_ID(), 'post_views', $this->view_count);
        }
    }

    /**
     * Adds the "Thumbnail" column to the posts list table.
     *
     * @param array $columns The existing columns in the posts list table.
     * @return array The modified columns array with the "Thumbnail" column added.
     */
    public function add_thumbnail_column($columns)
    {
        $columns['thumbnail'] = __('Thumbnail', 'easy-posts-column');
        return $columns;
    }

    /**
     * Renders the content for the "Thumbnail" column.
     *
     * @param string $column The name of the column being rendered.
     * @param int $post_id The ID of the post being rendered.
     */
    public function render_thumbnail_column($column, $post_id)
    {
        if ($column == 'thumbnail') {
            echo get_the_post_thumbnail($post_id, array(50, 50));
        }
    }
}
