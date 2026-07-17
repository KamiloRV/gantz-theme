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

/**
 * Validación de RUT Chileno para Contact Form 7
 */

add_filter('wpcf7_validate_text*', 'validar_rut_cf7', 20, 2);
add_filter('wpcf7_validate_text', 'validar_rut_cf7', 20, 2);

function validar_rut_cf7($result, $tag) {

    $tag = new WPCF7_FormTag($tag);

    // Campos que deben validarse como RUT
    $campos_rut = array(
        'rut-paciente',
        'rut-cuidador'
    );

    // Si el campo no está en la lista, no hacer nada
    if (!in_array($tag->name, $campos_rut)) {
        return $result;
    }

    $rut = isset($_POST[$tag->name]) ? trim($_POST[$tag->name]) : '';

    if (!validar_rut_chileno($rut)) {
        $result->invalidate(
            $tag,
            'Ingrese un RUT válido. Ejemplo: 12.345.678-5.'
        );
    }

    return $result;
}

function validar_rut_chileno($rut) {

    $rut = strtoupper($rut);
    $rut = preg_replace('/[^0-9K]/', '', $rut);

    if (strlen($rut) < 2) {
        return false;
    }

    $dv = substr($rut, -1);
    $numero = substr($rut, 0, -1);

    $suma = 0;
    $multiplo = 2;

    for ($i = strlen($numero) - 1; $i >= 0; $i--) {

        $suma += intval($numero[$i]) * $multiplo;

        $multiplo++;

        if ($multiplo > 7) {
            $multiplo = 2;
        }
    }

    $dvCalculado = 11 - ($suma % 11);

    switch ($dvCalculado) {
        case 11:
            $dvCalculado = '0';
            break;
        case 10:
            $dvCalculado = 'K';
            break;
        default:
            $dvCalculado = (string)$dvCalculado;
    }

    return $dv === $dvCalculado;
}
