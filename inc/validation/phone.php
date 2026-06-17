<?php
/* =============================================================================
        PHONE VALIDATION
============================================================================= */
/* Validar teléfonos chilenos */
add_filter(
    'acf/validate_value/name=telefono',
    'validar_telefono_chileno',
    10,
    4
);

function validar_telefono_chileno($valid,$value,$field,$input) {
    if (!$valid) {
        return $valid;
    }

    // quitar espacios y guiones
    $value = preg_replace('/[\s\-]/', '', $value);

    /**
     * Chile:
     * Celular:
     * +56912345678
     * 912345678
     *
     * Fijo:
     * +56223456789
     * 223456789
     */
    $regex = '/^(\+?56)?(9\d{8}|[2-7]\d{8})$/';

    if (!preg_match($regex, $value)) {

        $valid = 'Ingresa un teléfono chileno válido.';
    }

    return $valid;
}