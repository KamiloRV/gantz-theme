<?php
/* =============================================================================
        REPEATER AREAS VALIDATION
============================================================================= */
/* Validar repeater areas */
add_filter(
    'acf/validate_value/name=descripciones',
    'gantz_validar_areas_unicas',
    10,
    4
);

function gantz_validar_areas_unicas($valid, $value, $field, $input) {

    // Si ya hay un error previo
    if ($valid !== true) {
        return $valid;
    }

    // Si no hay datos
    if (empty($value) || !is_array($value)) {
        return $valid;
    }

    $areas_usadas = [];

    foreach ($value as $row) {

        // nombre del subcampo taxonomía
        $area = $row['field_6a0fee6c42da3'];

        if (!$area) {
            continue;
        }

        // si ya existe -> error
        if (in_array($area, $areas_usadas)) {

            return 'No puedes seleccionar la misma área más de una vez.';
        }

        $areas_usadas[] = $area;
    }

    return $valid;
}