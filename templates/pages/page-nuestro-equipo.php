<?php get_template_part('template-parts/header'); ?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb', null, ['class' => 'absolute']); ?>
    <?php /* Hero */ ?>
    <section class="hero" aria-labelledby="titulo-hero">
        <div class="hero__contenido container">
            <h1 class="hero__titulo text-py" id="titulo-hero"><?php echo esc_html(get_field('hero_titulo') ?? 'Nuestro equipo'); ?></h1>
            <p class="hero__texto body-bold text-mw">
                <?php echo esc_html(get_field('hero_texto')); ?>
            </p>
            <?php 
            $heroimagen = get_field('hero_imagen');
            if ($heroimagen) : ?>
                <img class="hero__imagen" src="<?php echo esc_url(get_field('hero_imagen')['url']); ?>" alt="<?php echo esc_attr(get_field('hero_imagen')['alt']); ?>">
            <?php endif ?>
        </div>
    </section>
    
    <?php /* Accesos Rapidos */ ?>
    <nav class="accesos" aria-labelledby="titulo-accesos">
        <div class="accesos__container container">
            <h2 class="accesos__titulo label" id="titulo-accesos">Acceso rápido a los equipos</h2>
            <?php
            $accesos = get_terms([
                'taxonomy'   => 'area',
                'hide_empty' => true,
                'parent'     => 0,
            ]);
            ?>

            <?php if ($accesos && !is_wp_error($accesos)) : ?>
                <ul class="accesos__list">
                    <?php foreach ($accesos as $acceso) : ?>
                        <li class="accesos__item">
                            <a class="accesos__link chip" href="#<?php echo esc_attr($acceso->slug); ?>">
                                <?php echo esc_html($acceso->name); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </nav>

    <?php /* Expertos */ ?>

    <?php

    /**
     * Obtiene descripción personalizada de un área
     */
    function gantz_get_area_description($term_id, $areas_descripcion) {
        if (!$areas_descripcion) {
            return '';
        }

        foreach ($areas_descripcion as $item) {

            $area_acf = $item['area'];

            if (
                $area_acf &&
                $area_acf->term_id === $term_id
            ) {
                return $item['descripcion'];
            }
        }

        return '';
    }

    /**
     * Verifica si un área tiene descripción
     */
    function gantz_has_area_description($term_id, $areas_descripcion) {
        return !empty(
            gantz_get_area_description(
                $term_id,
                $areas_descripcion
            )
        );
    }

    /**
    * Renderiza cards de expertos
    */
    function gantz_render_expertos($query, $class = '') {

        if (!$query->have_posts()) {
            return;
        }

        /**
         * Cantidad de expertos
         */
        $count = $query->post_count;

        /**
         * Clases automáticas layout
         */
        $layout_class = '';

        if ($count === 7) {

            $layout_class = 'expertos__grid--7';

        } elseif ($count === 6) {

            $layout_class = 'expertos__grid--6';

        } else {

            $layout_class = 'expertos__grid--full';
        }
        ?>

        <div class="expertos__grid <?php echo esc_attr($layout_class . ' ' . $class); ?>">

            <?php while ($query->have_posts()) :
                $query->the_post();

                $imagen = get_field('imagen_imagen');
                $cargo  = get_field('info_cargo');
            ?>

                <article
                    class="experto-card"
                    itemscope
                    itemtype="https://schema.org/Person"
                    id="experto-<?php the_ID(); ?>"
                >

                    <?php if ($imagen) : ?>
                        <img
                            class="experto-card__imagen"
                            src="<?php echo esc_url($imagen['url']); ?>"
                            alt="<?php echo esc_attr($imagen['alt']); ?>"
                        >
                    <?php endif; ?>

                    <div class="experto-card__contenido">

                        <h3
                            class="experto-card__nombre body-1 body-bold text-pb"
                            itemprop="name"
                        >
                            <?php the_title(); ?>
                        </h3>

                        <?php if ($cargo) : ?>
                            <p
                                class="experto-card__cargo text-pb"
                                itemprop="jobTitle"
                            >
                                <?php echo esc_html($cargo); ?>
                            </p>
                        <?php endif; ?>

                    </div>

                </article>

            <?php endwhile; ?>

        </div>

        <?php
        wp_reset_postdata();
    }

    /**
     * Query expertos por área
     */
    function gantz_get_expertos_query($term_ids) {

        return new WP_Query([
            'post_type'      => 'experto',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => [
                [
                    'taxonomy'         => 'area',
                    'field'            => 'term_id',
                    'terms'            => $term_ids,
                    'include_children' => false,
                ]
            ]
        ]);
    }
    ?>

    <?php
    $areas = get_terms([
        'taxonomy'   => 'area',
        'hide_empty' => true,
        'parent'     => 0,
    ]);

    $areas_descripcion = get_field(
        'areas_descripciones'
    );

    $director_tecnico = get_term_by(
        'slug',
        'director-tecnico',
        'area'
    );
    ?>

    <?php if ($areas && !is_wp_error($areas)) : ?>

        <?php foreach ($areas as $area) : ?>

            <section
                class="expertos"
                id="<?php echo esc_attr($area->slug); ?>"
            >

                <div class="expertos__contenido container">

                    <?php
                    $descripcion_area = gantz_get_area_description(
                        $area->term_id,
                        $areas_descripcion
                    );
                    ?>

                    <!-- HEADER ÁREA -->
                    <header class="expertos__header">

                        <h2 class="expertos__titulo">
                            <?php echo esc_html($area->name); ?>
                        </h2>

                        <?php if (!empty($descripcion_area)) : ?>

                            <div class="expertos__descripcion">

                                <?php
                                $descripcion_formateada = wpautop(
                                    $descripcion_area
                                );

                                $descripcion_formateada = str_replace(
                                    '<p>',
                                    '<p class="expertos__descripcion-parrafo body-2 text-pb">',
                                    $descripcion_formateada
                                );

                                echo wp_kses_post(
                                    $descripcion_formateada
                                );
                                ?>

                            </div>

                        <?php endif; ?>

                    </header>

                    <?php
                    /**
                     * Expertos principales
                     */
                    $terms_ids = [$area->term_id];

                    if (
                        $area->slug === 'equipo-clinico'
                        && $director_tecnico
                    ) {
                        $terms_ids[] =
                            $director_tecnico->term_id;
                    }

                    $expertos_principales =
                        gantz_get_expertos_query(
                            $terms_ids
                        );

                    $grid_class = '';

                    if (
                        !gantz_has_area_description(
                            $area->term_id,
                            $areas_descripcion
                        )
                    ) {
                        $grid_class = 'pb-0';
                    }

                    gantz_render_expertos(
                        $expertos_principales,
                        $grid_class
                    );
                    ?>

                    <?php
                    /**
                     * SUBÁREAS NIVEL 1
                     */
                    $subareas = get_terms([
                        'taxonomy'   => 'area',
                        'hide_empty' => true,
                        'parent'     => $area->term_id,
                    ]);
                    ?>

                    <?php if ($subareas && !is_wp_error($subareas)) : ?>

                        <?php foreach ($subareas as $subarea) : ?>

                            <?php
                            // director técnico ya aparece arriba
                            if (
                                $subarea->slug ===
                                'director-tecnico'
                            ) {
                                continue;
                            }

                            $descripcion_subarea =
                                gantz_get_area_description(
                                    $subarea->term_id,
                                    $areas_descripcion
                                );
                            ?>

                            <section
                                class="expertos-subarea"
                                id="<?php echo esc_attr($subarea->slug); ?>"
                            >

                                <!-- HEADER SUBÁREA -->
                                <header class="expertos-subarea__header">

                                    <h3 class="expertos-subarea__titulo">
                                        <?php echo esc_html($subarea->name); ?>
                                    </h3>

                                    <?php if (!empty($descripcion_subarea)) : ?>

                                        <div class="expertos__descripcion">

                                            <?php
                                            $descripcion_formateada = wpautop(
                                                $descripcion_subarea
                                            );

                                            $descripcion_formateada = str_replace(
                                                '<p>',
                                                '<p class="expertos__descripcion-parrafo body-2 text-pb">',
                                                $descripcion_formateada
                                            );

                                            echo wp_kses_post(
                                                $descripcion_formateada
                                            );
                                            ?>

                                        </div>

                                    <?php endif; ?>

                                </header>

                                <?php
                                /**
                                 * Expertos subárea
                                 */
                                $expertos_subarea =
                                    gantz_get_expertos_query([
                                        $subarea->term_id
                                    ]);

                                $grid_class = '';

                                if (
                                    !gantz_has_area_description(
                                        $subarea->term_id,
                                        $areas_descripcion
                                    )
                                ) {
                                    $grid_class = 'pb-0';
                                }

                                gantz_render_expertos(
                                    $expertos_subarea,
                                    $grid_class
                                );
                                ?>

                                <?php
                                /**
                                 * SUBÁREAS NIVEL 2
                                 */
                                $sub_subareas = get_terms([
                                    'taxonomy'   => 'area',
                                    'hide_empty' => true,
                                    'parent'     => $subarea->term_id,
                                ]);
                                ?>

                                <?php if ($sub_subareas && !is_wp_error($sub_subareas)) : ?>

                                    <?php foreach ($sub_subareas as $sub_subarea) : ?>

                                        <?php
                                        $descripcion_sub_subarea =
                                            gantz_get_area_description(
                                                $sub_subarea->term_id,
                                                $areas_descripcion
                                            );
                                        ?>

                                        <section
                                            class="expertos-subarea expertos-subarea--nested"
                                            id="<?php echo esc_attr($sub_subarea->slug); ?>"
                                        >

                                            <!-- HEADER SUB SUBÁREA -->
                                            <header class="expertos-subarea__header">

                                                <h4 class="expertos-subarea__titulo">
                                                    <?php echo esc_html($sub_subarea->name); ?>
                                                </h4>

                                                <?php if (!empty($descripcion_sub_subarea)) : ?>

                                                    <div class="expertos__descripcion">

                                                        <?php
                                                        $descripcion_formateada = wpautop(
                                                            $descripcion_sub_subarea
                                                        );

                                                        $descripcion_formateada = str_replace(
                                                            '<p>',
                                                            '<p class="expertos__descripcion-parrafo body-2 text-pb">',
                                                            $descripcion_formateada
                                                        );

                                                        echo wp_kses_post(
                                                            $descripcion_formateada
                                                        );
                                                        ?>

                                                    </div>

                                                <?php endif; ?>

                                            </header>

                                            <?php
                                            /**
                                             * Expertos sub subárea
                                             */
                                            $expertos_sub_subarea =
                                                gantz_get_expertos_query([
                                                    $sub_subarea->term_id
                                                ]);

                                            $grid_class = '';

                                            if (
                                                !gantz_has_area_description(
                                                    $sub_subarea->term_id,
                                                    $areas_descripcion
                                                )
                                            ) {
                                                $grid_class = 'pb-0';
                                            }

                                            gantz_render_expertos(
                                                $expertos_sub_subarea,
                                                $grid_class
                                            );
                                            ?>

                                        </section>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </section>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </section>

        <?php endforeach; ?>

    <?php endif; ?>
</main>

<?php get_template_part('template-parts/footer'); ?>