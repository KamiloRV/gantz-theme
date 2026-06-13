<?php get_template_part('template-parts/header'); ?>

<main class="page-noticias">
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb', null, ['class' => 'absolute']); ?>
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

        $categoria = $_GET['categoria'] ?? '';

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
        $posts_per_page = wp_is_mobile() ? 10 : 15;

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
        if (!empty($categoria)) {

            $args['tax_query'] = [
                [
                    'taxonomy' => 'categoria',
                    'field'    => 'slug',
                    'terms'    => $categoria,
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
                    <form class="filtros-form" method="GET" action="#archivo-noticias">
                        <?php if (!empty($categoria)) : ?>
                            <input type="hidden" name="categoria" value="<?php echo esc_attr($categoria); ?>">
                        <?php endif; ?>

                        <div class="filtros-form__search">
                            <input class="filtros-form__sinput body-2 text-mb" type="search" name="buscar" placeholder="¿Buscas algo en particular?" value="<?php echo esc_attr($search); ?>">
                        </div>
                    </form>
                    <!-- Categorías -->
                    <div class="filtros-categorias">
                        <h3 class="filtros-categorias__titulo body-1">Filtrar por categorías</h3>
                        <?php if ($categorias && !is_wp_error($categorias)) : ?>
                            <ul class="filtros-categorias__list">
                                <li class="filtros-categorias__item">
                                    <a class="filtros-categorias__link chip <?php echo empty($categoria) ? 'active' : ''; ?>" href="<?php echo esc_url(remove_query_arg(['categoria', 'buscar']) . '#archivo-noticias'); ?>">
                                        Todas
                                    </a>
                                </li>
                                <?php foreach ($categorias as $cat) : ?>
                                    <li class="filtros-categorias__item">
                                        <a class="filtros-categorias__link chip <?php echo $categoria === $cat->slug ? 'active' : ''; ?>" href="<?php echo esc_url(
                                                add_query_arg(
                                                    'categoria',
                                                    $cat->slug,
                                                    get_post_type_archive_link('noticia')
                                                )
                                            . '#archivo-noticias'); ?>"
                                        >
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
                        <!-- PAGINACIÓN -->
                        <div class="noticias-paginacion">

                            <?php
                            echo paginate_links([
                                'total'   => $query->max_num_pages,
                                'current' => $paged,
                                'mid_size' => 1,
                                'prev_text' => '← Anterior',
                                'next_text' => 'Siguiente →',
                            ]);
                            ?>

                        </div>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php get_template_part('template-parts/footer'); ?>