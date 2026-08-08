<?php

defined('ABSPATH') || exit;

add_action(
    'wpcf7_before_send_mail',
    'gantz_cf7_guardar_consentimiento'
);

function gantz_cf7_guardar_consentimiento($contact_form)
{
    $submission = WPCF7_Submission::get_instance();

    if (!$submission) {
        return;
    }

    $data = $submission->get_posted_data();
    $form_title = $contact_form->title();

    /**
     * Formulario de Comentarios:
     * dos checkboxes (autorización + consentimiento)
     */
    if ($form_title === 'Comentarios') {

        $email = sanitize_email($data['correo'] ?? '');

        if (!$email) {
            return;
        }

        $autorizacion = !empty($data['autorizacion-datos-terceros']) ? 1 : 0;
        $consentimiento = !empty($data['consentimiento-tratamiento-datos']) ? 1 : 0;

    /**
     * Formulario de Contacto:
     * un solo checkbox de consentimiento
     */
    } elseif ($form_title === 'Contacto') {

        $email = sanitize_email($data['correo'] ?? '');

        if (!$email) {
            return;
        }

        $autorizacion = null;
        $consentimiento = !empty($data['consentimiento-tratamiento-datos']) ? 1 : 0;

    } else {
        return;
    }

    global $wpdb;

    $wpdb->insert(
        $wpdb->prefix . 'consent_forms',
        [
            'formulario'                  => $form_title,
            'email'                       => $email,
            'autorizacion_terceros'       => $autorizacion,
            'consentimiento_tratamiento'  => $consentimiento,
        ]
    );
}