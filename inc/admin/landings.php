<?php

/**
 * =====================================================
 * LANDINGS
 * =====================================================
 *
 * Las landings son páginas normales de WordPress
 * que utilizan el template:
 *
 * templates/template-landing.php
 *
 * Beneficios:
 *
 * - URLs raíz:
 *   gantz.cl/mi-landing
 *
 * - SEO nativo de páginas
 *
 * - Gestión separada desde el menú "Landings"
 *
 * - No aparecen en el listado normal de páginas
 *
 * =====================================================
 */


/**
 * =====================================================
 * MENÚ ADMINISTRACIÓN
 * =====================================================
 */
add_action('admin_menu', function () {

    add_menu_page(
        'Landings',
        'Landings',
        'edit_pages',
        'landings',
        'gantz_landings_page',
        'dashicons-cover-image',
        25
    );

});


/**
 * =====================================================
 * LISTADO DE LANDINGS
 * =====================================================
 */
function gantz_landings_page()
{

    $landings = get_posts([
    'post_type'      => 'page',
    'posts_per_page' => -1,
    'post_status'    => [
        'publish',
        'draft',
        'pending',
        'future',
        'private',
        'trash'
    ],
    'meta_key'       => '_wp_page_template',
    'meta_value'     => 'templates/template-landing.php',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

    ?>

    <div class="wrap">

        <h1 class="wp-heading-inline">
            Landings
        </h1>

        <a
            href="<?php echo esc_url(
                admin_url('admin.php?action=gantz_create_landing')
            ); ?>"
            class="page-title-action"
        >
            Añadir Landing
        </a>

        <hr class="wp-header-end">

        <table class="wp-list-table widefat striped">

            <thead>
                <tr>
                    <th>Título</th>
                    <!-- <th>Tipo</th> -->
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                <?php if ($landings): ?>

                    <?php foreach ($landings as $landing): ?>

                        <?php

                        /* $tipo = get_field(
                            'tipo_landing',
                            $landing->ID
                        ); */

                        $status_labels = [
                            'publish' => 'Publicada',
                            'draft'   => 'Borrador',
                            'pending' => 'Pendiente',
                            'future'  => 'Programada',
                            'private' => 'Privada',
                            'trash'   => 'Papelera',
                        ];

                        ?>

                        <tr>

                            <td>
                                <?php echo esc_html(
                                    $landing->post_title ?: '(Sin título)'
                                ); ?>
                            </td>

                            <!-- <td>
                                <?php echo esc_html(
                                    $tipo ?: '-'
                                ); ?>
                            </td> -->

                            <td>
                                <?php
                                echo esc_html(
                                    $status_labels[$landing->post_status]
                                    ?? $landing->post_status
                                );
                                ?>
                            </td>

                            <td>

                                <a
                                    href="<?php echo esc_url(
                                        get_edit_post_link(
                                            $landing->ID
                                        )
                                    ); ?>"
                                >
                                    Editar
                                </a>

                                |

                                <a
                                    href="<?php echo esc_url(
                                        get_permalink(
                                            $landing->ID
                                        )
                                    ); ?>"
                                    target="_blank"
                                >
                                    Ver
                                </a>

                                | 
                                
                                <a 
                                    href="<?php echo esc_url( 
                                        get_delete_post_link( 
                                            $landing->ID, '', true 
                                        ) 
                                    ); ?>" 
                                    onclick="return confirm('¿Eliminar esta landing?');" style="color:#b32d2e;" > 
                                    Eliminar 
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="4">
                            No hay landings creadas.
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <?php
}


/**
 * =====================================================
 * CREAR LANDING
 * =====================================================
 *
 * Crea una página borrador
 * y le asigna automáticamente
 * el template Landing.
 *
 * Luego redirige al editor.
 *
 * =====================================================
 */
add_action('admin_action_gantz_create_landing', function () {

    if (!current_user_can('edit_pages')) {
        wp_die('No tienes permisos.');
    }

    $post_id = wp_insert_post([
        'post_type'   => 'page',
        'post_status' => 'draft',
        'post_title'  => '',
    ]);

    if (!$post_id) {
        wp_die('No fue posible crear la landing.');
    }

    update_post_meta(
        $post_id,
        '_wp_page_template',
        'templates/template-landing.php'
    );

    wp_safe_redirect(
        admin_url(
            'post.php?post=' .
            $post_id .
            '&action=edit'
        )
    );

    exit;
});


/**
 * =====================================================
 * OCULTAR LANDINGS
 * DEL LISTADO NORMAL DE PÁGINAS
 * =====================================================
 */
add_action('pre_get_posts', function ($query) {

    global $pagenow;

    if (
        !is_admin() ||
        !$query->is_main_query()
    ) {
        return;
    }

    if (
        $pagenow !== 'edit.php'
    ) {
        return;
    }

    if (
        $query->get('post_type') !== 'page'
    ) {
        return;
    }

    $meta_query = $query->get('meta_query');

    if (!is_array($meta_query)) {
        $meta_query = [];
    }

    $meta_query[] = [
        'relation' => 'OR',
        [
            'key'     => '_wp_page_template',
            'compare' => 'NOT EXISTS',
        ],
        [
            'key'     => '_wp_page_template',
            'value'   => 'templates/template-landing.php',
            'compare' => '!=',
        ],
    ];

    $query->set(
        'meta_query',
        $meta_query
    );
});