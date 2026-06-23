<?php

defined('ABSPATH') || exit;

/**
 * Cambia el destinatario de Contact Form 7
 * usando un campo ACF de Opciones.
 */
add_action('wpcf7_before_send_mail', function ($contact_form) {

    $mail = $contact_form->prop('mail');

    switch ($contact_form->id()) {

        /* Contacto */
        case 1511:
            $correo = get_field('formularios_contacto', 'option');
            break;

        /* Comentarios */
        case 1600:
            $correo = get_field('formularios_comentarios', 'option');
            break;

        /* Tarjetas */
        /* case 15:
            $correo = get_field('correo_voluntariado', 'option');
            break; */

        default:
            return;
    }

    if ($correo) {

        $mail['recipient'] = $correo;

        $contact_form->set_properties([
            'mail' => $mail
        ]);
    }
});