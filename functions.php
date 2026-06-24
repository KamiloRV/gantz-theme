<?php

defined('ABSPATH') || exit;

/**
 * Core
 */
require_once get_template_directory() . '/inc/setup.php';
require_once get_template_directory() . '/inc/assets.php';
require_once get_template_directory() . '/inc/security.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/templates.php';
require_once get_template_directory() . '/inc/helpers.php';

/**
 * SCF
 */
/* require_once get_template_directory() . '/inc/scf/ctp.php';
require_once get_template_directory() . '/inc/scf/options.php';
require_once get_template_directory() . '/inc/scf/tax.php';
require_once get_template_directory() . '/inc/scf/gdc.php'; */

/**
 * Admin
 */
require_once get_template_directory() . '/inc/admin/landings.php';
require_once get_template_directory() . '/inc/admin/columns.php';
require_once get_template_directory() . '/inc/admin/filters.php';
require_once get_template_directory() . '/inc/admin/permissions.php';

/**
 * Validaciones
 */
require_once get_template_directory() . '/inc/validation/phone.php';
require_once get_template_directory() . '/inc/validation/prefooter.php';
require_once get_template_directory() . '/inc/validation/repeaters.php';

/**
 * Integrations
 */
require_once get_template_directory() . '/inc/integrations/contact-form-7.php';

/**
 * Newsletter
 */
require_once get_template_directory() . '/inc/newsletter/install.php';
require_once get_template_directory() . '/inc/newsletter/admin.php';
require_once get_template_directory() . '/inc/newsletter/ajax.php';
require_once get_template_directory() . '/inc/newsletter/cf7.php';