<?php

/**
 * Plugin Name: ALA Last Modification Column
 * Plugin URI: https://andreluizabdalla.com
 * Description: Add "Last modification" column for yous pages and posts.
 * Version: 0.1
 * Author: André Luiz Abdalla
 * Author URI: https://andreluizabdalla.com
 * License: GPL2
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

function ala_custom_add_last_modified_column($columns)
{
    $columns['last_modified'] = 'Última Modificação';
    return $columns;
}
add_filter('manage_pages_columns', 'ala_custom_add_last_modified_column');

function custom_show_last_modified_column($column_name, $post_id)
{
    if ($column_name === 'last_modified') {
        $modified_date = get_post_modified_time('Y-m-d H:i:s', true, $post_id);
        echo esc_html($modified_date);
    }
}
add_action('manage_pages_custom_column', 'custom_show_last_modified_column', 10, 2);


function ala_custom_make_last_modified_column_sortable($sortable_columns)
{
    $sortable_columns['last_modified'] = 'modified';
    return $sortable_columns;
}
add_filter('manage_edit-page_sortable_columns', 'ala_custom_make_last_modified_column_sortable');


function ala_custom_orderby_last_modified_column($query)
{
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    $orderby = $query->get('orderby');

    if ($orderby === 'modified') {
        $query->set('orderby', 'modified');
    }
}
add_action('pre_get_posts', 'ala_custom_orderby_last_modified_column');
