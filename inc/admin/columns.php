
<?php
/* =============================================================================
        COLUMNAS
============================================================================= */
/* =========================================================
 * COLUMNAS EXPERTOS
 * =======================================================*/
add_filter(
    'manage_experto_posts_columns',
    function ($columns) {

        $new_columns = [];

        foreach ($columns as $key => $label) {

            // Imagen antes del título
            if ($key === 'title') {
                $new_columns['imagen'] = 'Foto';
            }

            $new_columns[$key] = $label;

            // Área después del título
            if ($key === 'title') {
                $new_columns['area'] = 'Área';
            }
        }

        return $new_columns;
    }
);

/* =========================================================
 * COLUMNAS ESPECIALIDADES
 * =======================================================*/

add_filter(
    'manage_especialidad_posts_columns',
    function ($columns) {

        $new_columns = [];

        foreach ($columns as $key => $label) {

            $new_columns[$key] = $label;

            if ($key === 'title') {
                $new_columns['tipo-especialidad'] = 'Tipo de Especialidad';
            }
        }

        return $new_columns;
    }
);


/* =========================================================
 * CONTENIDO COLUMNAS
 * =======================================================*/

add_action(
    'manage_posts_custom_column',
    function ($column, $post_id) {

        /**
         * IMAGEN EXPERTO
         */
        if ($column === 'imagen') {

            $imagen = get_field(
                'imagen_imagen',
                $post_id
            );

            if (!empty($imagen['ID'])) {

                echo wp_get_attachment_image(
                    $imagen['ID'],
                    [60, 60],
                    false,
                    [
                        'style' => '
                            width:60px;
                            height:60px;
                            object-fit:cover;
                            border-radius:999px;
                        '
                    ]
                );

            } else {

                echo '—';
            }
        }

        /**
         * ÁREA
         */
        if ($column === 'area') {

            $terms = get_the_terms(
                $post_id,
                'area'
            );

            if (
                empty($terms)
                || is_wp_error($terms)
            ) {
                echo '—';
                return;
            }

            echo esc_html(
                implode(
                    ', ',
                    wp_list_pluck($terms, 'name')
                )
            );
        }

        /**
         * TIPO ESPECIALIDAD
         */
        if ($column === 'tipo-especialidad') {

            $terms = get_the_terms(
                $post_id,
                'tipo-especialidad'
            );

            if (
                empty($terms)
                || is_wp_error($terms)
            ) {
                echo '—';
                return;
            }

            echo esc_html(
                implode(
                    ', ',
                    wp_list_pluck($terms, 'name')
                )
            );
        }

    },
    10,
    2
);