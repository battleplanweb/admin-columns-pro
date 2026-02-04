<?php

/*
Plugin Name: Admin Columns Pro
Version: 7.0.6
Description: Customize columns on the administration screens for post(types), users and other content. Filter and sort content, and edit posts directly from the posts overview. All via an intuitive, easy-to-use drag-and-drop interface.
GitHub Plugin URI: battleplanweb/admin-columns-pro

Requires PHP: 7.4
Requires at least: 5.9
Text Domain: codepress-admin-columns
Domain Path: /languages/
*/


use AC\Vendor\DI\ContainerBuilder;
use ACP\Loader;

if ( ! defined('ABSPATH')) {
    exit;
}

add_filter('pre_http_request', function($preempt, $args, $url) {
    if ($url === 'https://api.admincolumns.com') {
        $body = is_array($args['body']) ? $args['body'] : json_decode($args['body'], true);

        if (isset($body['command']) && $body['command'] === 'activate') {
            $response = array(
                'headers' => array(),
                'body' => '{
                    "activated": true,
                    "message": "You have successfully activated Admin Columns Pro.",
                    "message_type": "success",
                    "activation_key": "B5E0B5F8-DD86-89E6-ACA4-9DD6E6E1A930",
                    "permissions": ["usage", "update"],
                    "renewal_method": "manual",
                    "expiry_date": "2050-01-01 00:00:59"
                }',
                'response' => array(
                    'code' => 200,
                    'message' => 'OK'
                )
            );

            return $response;
        } elseif (isset($body['command']) && $body['command'] === 'subscription_details') {
            $response = array(
                'headers' => array(),
                'body' => '{
                    "status": "active",
                    "expiry_date": "2050-01-01 00:00:59",
                    "renewal_method": "manual",
                    "products": [
                        "admin-columns-pro",
                        "ac-addon-acf",
                        "ac-addon-buddypress",
                        "ac-addon-events-calendar",
                        "ac-addon-gravityforms",
                        "ac-addon-ninjaforms",
                        "ac-addon-jetengine",
                        "ac-addon-metabox",
                        "ac-addon-pods",
                        "ac-addon-types",
                        "ac-addon-woocommerce",
                        "ac-addon-yoast-seo"
                    ],
                    "renewal_discount": 0,
                    "permissions": ["usage", "update"],
                    "activation_key": "B5E0B5F8-DD86-89E6-ACA4-9DD6E6E1A930"
                }',
                'response' => array(
                    'code' => 200,
                    'message' => 'OK'
                )
            );

            return $response;
        }
    }

    return $preempt;
}, 10, 3);

if ( ! is_admin()) {
    return;
}

define('ACP_FILE', __FILE__);
define('ACP_VERSION', '7.0.6');

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Deactivate Admin Columns
 */
deactivate_plugins('codepress-admin-columns/codepress-admin-columns.php');

/**
 * Load Admin Columns
 */
add_action('plugins_loaded', static function () {
    require_once __DIR__ . '/admin-columns/codepress-admin-columns.php';
});

/**
 * Load Admin Columns Pro
 */
add_action('after_setup_theme', static function () {
    require_once __DIR__ . '/vendor/autoload.php';
    require_once __DIR__ . '/api.php';

    $definitions = array_merge(
        require __DIR__ . '/admin-columns/settings/container-definitions.php',
        require __DIR__ . '/settings/container-definitions.php'
    );

    $container = (new ContainerBuilder())
        ->addDefinitions($definitions)
        ->build();

    new Loader($container);
}, 2);

add_action('after_setup_theme', static function () {
    /**
     * For loading external resources like column settings.
     * Can be called from plugins and themes.
     */
    do_action('acp/ready');
}, 5);

