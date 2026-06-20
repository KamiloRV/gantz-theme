<?php get_template_part('template-parts/header'); ?>

<?php 
// Variables reutilizables para el footer
$site_name = get_field('ajustes_name', 'option');
$directory_uri = get_template_directory_uri();
$home_url = esc_url(home_url('/'));
$logo = get_field('ajustes_logo', 'option')['url'];
?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb'); ?>
    <!-- Hero/Recientes -->
    <section class="noticias-recientes" aria-labelledby="titulo-noticias-recientes">
        <div class="noticias-recientes__container container">
            <div class="noticias-recientes__contenido">
                <div class="noticias-recientes__header">
                    <h1 class="noticias-recientes__titulo">Noticias</h1>
                    <div class="noticias-recientes__subheader">
                        <h2 class="noticias-recientes__subtitulo">Más recientes</h2>
                        <p class="noticias-recientes__fecha body-2 body-2-bold text-pb">
                            <?php echo ucfirst(wp_date('l, d \d\e F \d\e Y')); ?>
                        </p>
                    </div>
                </div>
                <div class="noticias-recientes__lista">
                    <?php
                    $args = [
                        'post_type'      => 'noticia',
                        'posts_per_page' => 3,
                        'post_status'    => 'publish',
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ];

                    $noticias = new WP_Query($args);

                    if ($noticias->have_posts()) : $count = 0; ?>
                    
                    <?php while ($noticias->have_posts()) : 
                        $noticias->the_post(); 
                        $terms = get_the_terms(get_the_ID(), 'categoria'); 
                        $category = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : 'Sin categoría';?>
                    
                            <article class="noticias-recientes__noticia noticia<?php echo $count === 0 ? '--destacada' : ''; ?>">
                                <a href="<?php the_permalink(); ?>" class="noticia__link">
                                    <img class="noticia__imagen" src="<?php echo esc_url(get_field('imagen')['url']); ?>" alt="<?php echo esc_attr(get_field('imagen')['alt']); ?>">
                                    <div class="noticia__texto">
                                        <h3 class="noticia__titulo body-1 body-bold text-mw"><?php the_title(); ?></h3>
                                        <div class="noticia__extracto body-2 body-2-bold text-mw">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                    <span class="noticia__categoria nota text-py"><?php echo esc_html($category); ?></span>
                                </a>
                            </article>
                            <?php $count++; ?>
                        <?php endwhile; ?>
                        <?php wp_reset_postdata(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Archivo -->
    <section class="archivo-noticias" id="archivo-noticias">
        <?php
            add_filter(
            'posts_search',
            'gantz_busqueda_noticias',
            10,
            2
        );

        function gantz_busqueda_noticias(
            $search_sql,
            $query
        ) {

            global $wpdb;

            if (
                is_admin()
                || !$query->get('gantz_noticias_search')
            ) {
                return $search_sql;
            }

            $search = $query->get('s');

            if (empty($search)) {
                return $search_sql;
            }

            $like = '%' . $wpdb->esc_like($search) . '%';

            $extra_search = $wpdb->prepare(
                "
                OR EXISTS (
                    SELECT 1
                    FROM {$wpdb->term_relationships} tr
                    INNER JOIN {$wpdb->term_taxonomy} tt
                        ON tr.term_taxonomy_id = tt.term_taxonomy_id
                    INNER JOIN {$wpdb->terms} t
                        ON tt.term_id = t.term_id
                    WHERE tr.object_id = {$wpdb->posts}.ID
                    AND t.name LIKE %s
                )

                OR EXISTS (
                    SELECT 1
                    FROM {$wpdb->postmeta} pm
                    WHERE pm.post_id = {$wpdb->posts}.ID
                    AND pm.meta_key IN (
                        'bajada',
                        'detalle'
                    )
                    AND pm.meta_value LIKE %s
                )
                ",
                $like,
                $like
            );

            // insertar dentro del search existente
            $search_sql = preg_replace(
                '/\)\s*$/',
                $extra_search . ')',
                $search_sql
            );

            return $search_sql;
        }
        /**
         * Parámetros
         */
        $search = $_GET['buscar'] ?? '';

        $categorias_activas = [];

        if (!empty($_GET['categoria'])) {

            $categorias_activas = explode(
                ',',
                sanitize_text_field($_GET['categoria'])
            );
        }

        $paged = get_query_var('paged')
            ? get_query_var('paged')
            : 1;

        /**
         * Categorías
         */
        $categorias = get_terms([
            'taxonomy'   => 'categoria',
            'hide_empty' => true,
        ]);

        /**
         * Query
         */
        $posts_per_page = wp_is_mobile() ? 2 : 2;

        $args = [
            'post_type'      => 'noticia',
            'post_status'    => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged'          => $paged,
            's'              => $search,
            'gantz_noticias_search' => true,
        ];

        /**
         * Filtro categoría
         */
        if (!empty($categorias_activas)) {

                $args['tax_query'] = [
                    [
                        'taxonomy' => 'categoria',
                        'field'    => 'slug',
                        'terms'    => $categorias_activas,
                        'operator' => 'IN',
                    ]
                ];
            }

        $query = new WP_Query($args);
        ?>
        <div class="archivo-noticias__container container">
            <div class="archivo-noticias__contenido">
                <h2 class="archivo-noticias__titulo">Archivo de noticias</h2>
                <!-- Filtros -->
                <div class="archivo-noticias__filtros filtros">
                    <!-- Buscar -->
                    <form class="filtros-form" method="GET" action="<?php echo esc_url(get_permalink() . '#archivo-noticias'); ?>">
                        <?php if (!empty($categoria)) : ?>
                            <input type="hidden" name="categoria" value="<?php echo esc_attr(implode(',', $categorias_activas)); ?>">
                        <?php endif; ?>

                        <div class="gantz-search">
                            <input class="gantz-search__input body-2 text-mb" type="search" name="buscar" placeholder="¿Buscas algo en particular?" value="<?php echo esc_attr($search); ?>">
                            <button class="gantz-search__submit" type="submit" aria-label="Buscar">
                                <svg aria-hidden="true" focusable="false">
                                    <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#search'); ?>" />
                                </svg>
                            </button>
                        </div>
                    </form>
                    <!-- Categorías -->
                    <div class="filtros-categorias">
                        <div class="filtros-categorias__header">
                            <h3 class="filtros-categorias__titulo body-1">Filtrar por categorías</h3>
                            <a class="filtros-categorias__clear body-2 <?php echo empty($categorias_activas) ? 'active' : ''; ?>" 
                                href="<?php echo esc_url(get_permalink() . '#archivo-noticias'); ?>">
                                <svg aria-hidden="true" focusable="false">
                                    <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#settings'); ?>" />
                                </svg>
                                Limpiar Filtros
                            </a>
                        </div>
                        <!-- <h3 class="filtros-categorias__titulo body-1">Filtrar por categorías</h3> -->
                        <?php if ($categorias && !is_wp_error($categorias)) : ?>
                            <ul class="filtros-categorias__list">
                                <!-- <li class="filtros-categorias__item">
                                    <a class="filtros-categorias__link chip <?php echo empty($categorias_activas) ? 'active' : ''; ?>" 
                                        href="<?php echo esc_url(remove_query_arg(['categoria', 'buscar']) . '#archivo-noticias'); ?>">
                                        Todas
                                    </a>
                                </li> -->
                                <?php foreach ($categorias as $cat) : ?>
                                    <?php
                                    $slug = $cat->slug;

                                    // ¿Está activa?
                                    $is_active = in_array(
                                        $slug,
                                        $categorias_activas
                                    );

                                    // Clonar array actual
                                    $nuevas_categorias = $categorias_activas;

                                    // Toggle
                                    if ($is_active) {
                                        $nuevas_categorias = array_diff(
                                            $nuevas_categorias,
                                            [$slug]
                                        );
                                    } else {
                                        $nuevas_categorias[] = $slug;
                                    }

                                    // Limpiar duplicados
                                    $nuevas_categorias = array_unique(
                                        $nuevas_categorias
                                    );

                                    // URL final
                                    $url = add_query_arg(
                                        'categoria',
                                        implode(',', $nuevas_categorias),
                                        get_post_type_archive_link('noticia')
                                    ) . '#archivo-noticias';

                                    ?>
                                    <li class="filtros-categorias__item">
                                        <a class="filtros-categorias__link chip <?php echo $is_active ? 'active' : ''; ?>" href="<?php echo esc_url($url); ?>">
                                            <?php echo esc_html($cat->name); ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- GRID -->
                <div class="archivo-noticias__grid">
                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) :
                            $query->the_post();

                            $imagen = get_field('imagen');

                            $terms = get_the_terms(
                                get_the_ID(),
                                'categoria'
                            );
                        ?>
                            <article class="archivo-noticias__noticia noticia">
                                <a class="noticia__card" href="<?php the_permalink(); ?>">
                                    <img class="noticia__imagen" src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>">
                                    <div class="noticia__info">
                                        <h3 class="noticia__titulo body-2 body-2-bold text-pb"><?php the_title(); ?></h3>
                                        <span class="noticia__categoria nota text-pb">
                                            <?php if ($terms && !is_wp_error($terms)) : ?>
                                                <?php echo esc_html($terms[0]->name); ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </a>
                            </article>
                        <?php endwhile; ?>
                        
                    <?php endif; ?>
                    <!-- PAGINACIÓN -->
                    <?php wp_reset_postdata(); ?>
                </div>
                <!-- <div class="archivo-noticias__paginacion paginacion body-2 text-pi">
                    <?php
                    echo paginate_links([
                        'total'   => $query->max_num_pages,
                        'current' => $paged,
                        'mid_size' => 1,
                        'prev_text' => '← Anterior',
                        'next_text' => 'Siguiente →',
                    ]);
                    ?>
                </div> -->
                <?php if ($query->max_num_pages > 1) : ?>
                    <div class="gantz-paginador">
                        <?php
                        $current = max(1, $paged);
                        $total   = $query->max_num_pages;

                        /**
                         * Prev
                         */
                        if ($current > 1) {
                            $prev_url = add_query_arg(
                                array_filter([
                                    'buscar'    => $search,
                                    'categoria' => $categorias_activas,
                                ]),
                                get_pagenum_link($current - 1)
                            ) . '#archivo-noticias';
                        } else {
                            $prev_url = '#';
                        }
                        ?>

                        <a class="gantz-paginador__prev body-2 text-pb <?php echo $current === 1 ? 'is-disabled' : ''; ?>" href="<?php echo esc_url($prev_url); ?>">
                            ← Anterior
                        </a>

                        <?php for ($i = 1; $i <= $total; $i++) : ?>
                            <?php
                            $page_url = add_query_arg(
                                array_filter([
                                    'buscar'    => $search,
                                    'categoria' => $categorias_activas,
                                ]),
                                get_pagenum_link($i)
                            ) . '#archivo-noticias';
                            ?>

                            <a class="gantz-paginador__number body-1 body-bold text-pi <?php echo $i === $current ? 'is-active' : ''; ?>" href="<?php echo esc_url($page_url); ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php
                        /**
                         * Next
                         */
                        if ($current < $total) {
                            $next_url = add_query_arg(
                                array_filter([
                                    'buscar'    => $search,
                                    'categoria' => $categorias_activas,
                                ]),
                                get_pagenum_link($current + 1)
                            ) . '#archivo-noticias';
                        } else {
                            $next_url = '#';
                        }
                        ?>

                        <a class="gantz-paginador__next body-2 text-pb <?php echo $current === $total ? 'is-disabled' : ''; ?>" href="<?php echo esc_url($next_url); ?>">
                            Siguiente →
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<script>
    const input = document.querySelector('.gantz-search__input');

    input.addEventListener('search', function () {

        if (this.value !== '') {
            return;
        }

        const url = new URL(window.location.href);

        url.searchParams.delete('buscar');

        window.location.href = url.toString();
    });
</script>
<?php get_template_part('template-parts/footer'); ?>