<?php

defined('ABSPATH') || exit;

/**
 * Crea o actualiza la tabla de suscriptores.
 */
function gantz_newsletter_create_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table_name} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        email VARCHAR(255) NOT NULL,
        source VARCHAR(100) DEFAULT 'newsletter',
        consentido TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql);
}

/**
 * Instala o actualiza la estructura de Newsletter.
 *
 * Si cambias la tabla en el futuro,
 * aumenta la versión (1.0 -> 1.1).
 */
function gantz_newsletter_install()
{
    $version = '0.2';

    if (
        get_option('gantz_newsletter_version')
        !== $version
    ) {

        gantz_newsletter_create_table();

        update_option(
            'gantz_newsletter_version',
            $version
        );
    }
}

add_action(
    'init',
    'gantz_newsletter_install'
);