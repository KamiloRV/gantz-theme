<?php defined('ABSPATH') || exit;

/**
 * template-parts/components/breadcrumb.php
 *
 * Breadcrumb automático sin plugins.
 * No se muestra en la página de inicio.
 *
 * Uso:
 * get_template_part(
 *     'template-parts/components/breadcrumb'
 * );
 */

// No mostrar en home
if (is_front_page()) {
    return;
}

$directory_uri = get_template_directory_uri();

$items = [];

/**
 * Inicio
 */
$items[] = [
    'label' => '',
    'url'   => home_url('/'),
    'icon'  => true,
];

/**
 * ─────────────────────────────────────────
 * SINGLES
 * ─────────────────────────────────────────
 */


if (is_singular()) {

    $post_type = get_post_type();
    $obj       = get_post_type_object($post_type);

    /**
     * POSTS / CPTS
     */
    if ($post_type !== 'page') {

        /**
         * POSTS normales
         * page-noticias.php manual
         *
         * Resultado:
         * Inicio > Novedades > Noticias > Post
         */

        $secciones_novedades = [
            'galeria-de-fotos'  => 'galeria-de-fotos',
            'noticia'        => 'noticias',
            'newsletter'     => 'newsletters',
            'galeria-videos' => 'galeria-de-videos',
        ];

        if (isset($secciones_novedades[$post_type])) {

            /**
             * Novedades
             * (solo menú, no página real)
             */
            $items[] = [
                'label'  => 'Novedades',
                'nolink' => true,
            ];

            /**
             * Noticias
             */
            $pagina = get_page_by_path($secciones_novedades[$post_type]);

            if ($pagina) {

                $items[] = [
                    'label' => get_the_title(
                        $pagina
                    ),
                    'url'   => get_permalink(
                        $pagina
                    ),
                ];
            }

        } else {

            /**
             * CPT archives
             */
            $archive_url = get_post_type_archive_link(
                $post_type
            );

            if ($archive_url) {

                $items[] = [
                    'label' => $obj->labels->name,
                    'url'   => $archive_url,
                ];
            }
        }

        /**
         * Taxonomías
         */
        $taxonomies = get_object_taxonomies(
            $post_type,
            'objects'
        );

        foreach ($taxonomies as $tax) {

            // Solo jerárquicas y públicas
            if (
                !$tax->hierarchical ||
                !$tax->public
            ) {
                continue;
            }

            $terms = get_the_terms(
                get_the_ID(),
                $tax->name
            );

            if (
                $terms &&
                !is_wp_error($terms)
            ) {

                $term = $terms[0];

                /**
                 * Padre del término
                 */
                if ($term->parent) {

                    $parent = get_term(
                        $term->parent,
                        $tax->name
                    );

                    if (
                        $parent &&
                        !is_wp_error($parent)
                    ) {

                        $items[] = [
                            'label' => $parent->name,
                            'url'   => get_term_link(
                                $parent
                            ),
                        ];
                    }
                }

                /**
                 * Término actual
                 */
                $items[] = [
                    'label' => $term->name,
                    'url'   => get_term_link(
                        $term
                    ),
                ];

                break;
            }
        }
    }

    /**
     * PÁGINAS
     */
    if ($post_type === 'page') {

        
        $slug = get_post_field(
            'post_name',
            get_the_ID()
        );

        if (
            in_array(
                $slug,
                [
                    'galeria-de-fotos',
                    'galeria-de-videos'
                ]
            )
        ) {

            $items[] = [
                'label'  => 'Novedades',
                'nolink' => true,
            ];

            /* $items[] = [
                'label'  => 'Galería',
                'nolink' => true,
            ]; */
        }

        elseif ($slug === 'newsletters') {

            $items[] = [
                'label'  => 'Novedades',
                'nolink' => true,
            ];
        } else {
            /**
             * Parent virtual desde menú
             */
            $menu_parent = gantz_get_menu_parent(
                'header'
            );

            if ($menu_parent) {
                $items[] = $menu_parent;
            }
        }

        /**
         * Padres reales
         */
        $ancestors = array_reverse(
            get_post_ancestors(
                get_the_ID()
            )
        );

        foreach ($ancestors as $ancestor_id) {

            $items[] = [
                'label' => get_the_title(
                    $ancestor_id
                ),
                'url'   => get_permalink(
                    $ancestor_id
                ),
            ];
        }
    }

    /**
     * Página actual
     */
    $items[] = [
        'label'   => get_the_title(),
        'current' => true,
    ];
}

/**
 * ─────────────────────────────────────────
 * TAXONOMÍAS
 * ─────────────────────────────────────────
 */
elseif (
    is_category() ||
    is_tag() ||
    is_tax()
) {

    $term = get_queried_object();

    /**
     * Blog manual
     */
    if (
        is_category() ||
        is_tag() ||
        is_tax()
    ) {

        $pagina_novedades = get_page_by_path(
            'novedades'
        );

        if ($pagina_novedades) {

            $items[] = [
                'label' => get_the_title(
                    $pagina_novedades
                ),
                'url'   => get_permalink(
                    $pagina_novedades
                ),
            ];
        }

        $pagina_noticias = get_page_by_path(
            'noticias'
        );

        if ($pagina_noticias) {

            $items[] = [
                'label' => get_the_title(
                    $pagina_noticias
                ),
                'url'   => get_permalink(
                    $pagina_noticias
                ),
            ];
        }
    }

    /**
     * Término padre
     */
    if (!empty($term->parent)) {

        $parent = get_term(
            $term->parent,
            $term->taxonomy
        );

        if (
            $parent &&
            !is_wp_error($parent)
        ) {

            $items[] = [
                'label' => $parent->name,
                'url'   => get_term_link(
                    $parent
                ),
            ];
        }
    }

    /**
     * Término actual
     */
    $items[] = [
        'label'   => $term->name,
        'current' => true,
    ];
}

/**
 * ─────────────────────────────────────────
 * ARCHIVES
 * ─────────────────────────────────────────
 */
elseif (is_post_type_archive()) {

    $obj = get_queried_object();

    $items[] = [
        'label'   => $obj->labels->name,
        'current' => true,
    ];
}

/**
 * SEARCH
 */
elseif (is_search()) {

    $items[] = [
        'label'   => sprintf(
            __('Resultados para: "%s"', 'mi-tema'),
            get_search_query()
        ),
        'current' => true,
    ];
}

/**
 * 404
 */
elseif (is_404()) {

    $items[] = [
        'label'   => __('Página no encontrada', 'mi-tema'),
        'current' => true,
    ];
}

/**
 * No renderizar si solo existe Home
 */
if (count($items) <= 1) {
    return;
}

$breadcrumb_class = $args['class'] ?? '';
?>

<nav
    class="gantz-breadcrumb <?php echo esc_attr($breadcrumb_class); ?>"
    aria-label="Ruta de navegación"
>

    <div class="container">

        <ol
            class="bc-list"
            itemscope
            itemtype="https://schema.org/BreadcrumbList"
        >

            <?php foreach ($items as $position => $item) :

                $is_current = !empty($item['current']);
                $is_icon    = !empty($item['icon']);
                $has_url    = !empty($item['url']) && !$is_current;
            ?>

                <li
                    class="bc-item<?php echo $is_current ? ' bc-item-current' : ''; ?>"
                    itemprop="itemListElement"
                    itemscope
                    itemtype="https://schema.org/ListItem"
                >

                    <?php if ($has_url) : ?>

                        <a
                            href="<?php echo esc_url($item['url']); ?>"
                            class="bc-link"
                            itemprop="item"
                        >

                            <?php if ($is_icon) : ?>

                                <svg
                                    class="bc-home-icon"
                                    aria-hidden="true"
                                    focusable="false"
                                >
                                    <use href="<?php echo esc_attr($directory_uri); ?>/assets/images/icons.svg#home" />
                                </svg>

                                <span
                                    class="sr-only"
                                    itemprop="name"
                                >
                                    Inicio
                                </span>

                            <?php else : ?>

                                <span
                                    class="body-2-bold"
                                    itemprop="name"
                                >
                                    <?php echo esc_html($item['label']); ?>
                                </span>

                            <?php endif; ?>

                        </a>

                    <?php else : ?>

                        <?php if ($is_icon) : ?>

                            <svg
                                class="bc-home-icon"
                                aria-hidden="true"
                                focusable="false"
                            >
                                <use href="<?php echo esc_attr($directory_uri); ?>/assets/images/icons.svg#home" />
                            </svg>

                            <span
                                class="sr-only"
                                itemprop="name"
                            >
                                Inicio
                            </span>

                        <?php else : ?>

                            <span
                                class="bc-nolink body-2-bold"
                                itemprop="name"
                                aria-current="page"
                            >
                                <?php echo esc_html($item['label']); ?>
                            </span>

                        <?php endif; ?>

                    <?php endif; ?>

                    <meta
                        itemprop="position"
                        content="<?php echo esc_attr($position + 1); ?>"
                    >

                </li>

            <?php endforeach; ?>

        </ol>

    </div>

</nav>