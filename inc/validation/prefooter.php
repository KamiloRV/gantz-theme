<?php
/* =============================================================================
        PRE-FOOTERS VALIDATION
============================================================================= */
/* Validar prefooters */
add_filter('acf/validate_value/name=assigned_pages', 'validate_unique_pre_footer_pages', 10, 4);

function validate_unique_pre_footer_pages($valid, $value, $field, $input) {

    if (!$valid) {
        return $valid;
    }

    static $used_pages = [];

    if (empty($value) || !is_array($value)) {
        return $valid;
    }

    foreach ($value as $page_id) {

        $page_id = is_array($page_id) ? $page_id['ID'] : $page_id;

        if (isset($used_pages[$page_id])) {
            $page_title = get_the_title($page_id);

            return sprintf(
                'La página "%s" ya está asignada en el pre-footer #%s.',
                $page_title,
                $used_pages[$page_id]
            );
        }

        // detectar en qué fila del repeater está
        preg_match('/row-(\d+)/', $input, $matches);
        $row_number = isset($matches[1]) ? ((int) $matches[1] + 1) : '?';

        $used_pages[$page_id] = $row_number;
    }

    return $valid;
}