<?php

defined('ABSPATH') || exit;

/**
 * Agrega al newsletter los correos enviados
 * desde el formulario de contacto cuando
 * el usuario selecciona "Sí, me quiero suscribir".
 */
add_action(
    'wpcf7_mail_sent',
    'gantz_cf7_newsletter_subscribe'
);

function gantz_cf7_newsletter_subscribe($contact_form)
{
    /**
     * Solo ejecutar en el formulario "Contacto".
     */
    if (
        $contact_form->title() !== 'Contacto'
    ) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();

    if (!$submission) {
        return;
    }

    $data = $submission->get_posted_data();

    /**
     * Verificar si el usuario marcó:
     * "Sí, me quiero suscribir"
     */
    if (
        empty($data['suscribirse'])
        || !in_array(
            'Sí, me quiero suscribir',
            (array) $data['suscribirse'],
            true
        )
    ) {
        return;
    }

    /**
     * Campo email del formulario.
     */
    $email = sanitize_email(
        $data['correo'] ?? ''
    );

    if (!$email) {
        return;
    }

    /**
     * Guardar en la base de newsletter.
     * La selección del radio "Sí, me quiero suscribir"
     * es en sí misma el consentimiento explícito.
     */
    gantz_add_subscriber(
        $email,
        'contacto',
        true
    );
}