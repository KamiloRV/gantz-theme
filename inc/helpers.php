<?php
/* =============================================================================
        HELPERS
============================================================================= */
/**
 * Formatea números de teléfono chilenos.
 *
 * @param  string $phone  Número crudo (con o sin +56)
 * @return array {
 *     @type string $raw        Solo dígitos, sin código de país
 *     @type string $type       'mobile' | 'landline' | 'unknown'
 *     @type string $formatted  Número con espacios (ej: "9 1234 5678")
 *     @type string $e164       Formato internacional (ej: "+56912345678")
 * }
 */
function gantz_parse_phone_cl( $phone ) {

    // Deja solo dígitos
    $clean = preg_replace( '/\D/', '', $phone );

    // Quita el prefijo 56 si viene completo (ej: 56912345678)
    if ( strlen( $clean ) === 11 && str_starts_with( $clean, '56' ) ) {
        $clean = substr( $clean, 2 );
    }

    $result = [
        'raw'       => $clean,
        'type'      => 'unknown',
        'formatted' => $clean,
        'e164'      => '+56' . $clean,
    ];

    // Celular: empieza en 9 y tiene 9 dígitos
    if ( preg_match( '/^9\d{8}$/', $clean ) ) {
        $result['type']      = 'mobile';
        $result['formatted'] = preg_replace( '/^(\d)(\d{4})(\d{4})$/', '$1 $2 $3', $clean );

    // Fijo: empieza en 2-7 y tiene 9 dígitos
    } elseif ( preg_match( '/^[2-7]\d{8}$/', $clean ) ) {
        $result['type']      = 'landline';
        $result['formatted'] = preg_replace( '/^(\d{2})(\d{3})(\d{4})$/', '$1 $2 $3', $clean );
    }

    return $result;
}



/* Prueba para Breadcrumb */
function gantz_get_menu_parent($menu_location = 'primary') {

    $locations = get_nav_menu_locations();

    if (!isset($locations[$menu_location])) {
        return null;
    }

    $menu_id = $locations[$menu_location];
    $items   = wp_get_nav_menu_items($menu_id);

    if (!$items) {
        return null;
    }

    $current_id = get_the_ID();

    foreach ($items as $item) {

        // Buscar item del menú que apunta a esta página
        if ((int) $item->object_id === $current_id) {

            // Si tiene parent en el menú
            if ($item->menu_item_parent) {

                foreach ($items as $parent) {

                    if ((int) $parent->ID === (int) $item->menu_item_parent) {

                                                return [
                            'label'  => $parent->title,
                            'nolink' => true,
                        ];
                    }
                }
            }
        }
    }

    return null;
}