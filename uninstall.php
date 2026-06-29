<?php
/**
 * Runs automatically when the plugin is deleted via the WordPress admin.
 * Removes sync relationship data left behind on all subsites.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

$site_ids = get_sites(array('fields' => 'ids', 'number' => 0));

foreach ($site_ids as $site_id) {
    switch_to_blog($site_id);

    $wpdb->delete(
        $wpdb->postmeta,
        array('meta_key' => '_tk_master_product_id'),
        array('%s')
    );

    restore_current_blog();
}
