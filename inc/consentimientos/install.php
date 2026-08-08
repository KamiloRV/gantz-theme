<?php

defined('ABSPATH') || exit;

/**
 * Crea o actualiza la tabla de consentimientos.
 */
function consent_forms_create_table()
{
    global $wpdb;

    $table_name = $wpdb->prefix . 'consent_forms';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table_name} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        formulario VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        autorizacion_terceros TINYINT(1) DEFAULT NULL,
        consentimiento_tratamiento TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) {$charset_collate};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    dbDelta($sql);
}

/**
 * Instala o actualiza la estructura de Consentimientos.
 *
 * Si cambias la tabla en el futuro,
 * aumenta la versión (0.1 -> 0.2).
 */
function consent_forms_install()
{
    $version = '0.1';

    if (
        get_option('consent_forms_version')
        !== $version
    ) {

        consent_forms_create_table();

        update_option(
            'consent_forms_version',
            $version
        );
    }
}

add_action(
    'init',
    'consent_forms_install'
);