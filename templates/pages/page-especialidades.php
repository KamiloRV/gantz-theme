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
    <?php get_template_part('template-parts/components/breadcrumb', null, ['class' => 'absolute']); ?>
    <!-- Hero -->
    <section class="hero" aria-labelledby="titulo-hero">
        <?php 
        $hero = get_field('hero')['hero'];
        ?>

        <?php if ($hero['imagen']) : ?>
            <div class="hero__imagen">
                <img class="imagen" src="<?php echo esc_url($hero['imagen']['url']) ?>" alt="<?php echo esc_attr($hero['imagen']['alt']) ?>">
            </div>
        <?php endif ?>
        <div class="hero__contenido ">
            <div class="hero__container container">
                <div class="hero__container-inner">
                    <h1 class="hero__titulo" id="titulo-hero"><?php echo esc_html($hero['titulo']) ?></h1>
                    <div class="hero__texto text-pb">
                        <?php echo wp_kses_post($hero['texto']) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Accesos rápidos -->
    <nav class="accesos" aria-labelledby="titulo-accesos" id="accesos">
        <div class="accesos__container container">
            <h2 class="accesos__titulo body-1" id="titulo-accesos">Acceso rápido a las especialidades</h2>
            <?php
            $accesos = get_terms([
                'taxonomy'   => 'tipo-especialidad',
                'hide_empty' => true,
                'parent'     => 0,
            ]);
            ?>
            <?php if ($accesos && !is_wp_error($accesos)) : ?>
                <div class="accesos__especialidades">
                    <?php foreach ($accesos as $acceso) : ?>
                        <div class="acceso-especialidad especialidad">
                            <!-- Título grupo -->
                            <h3 class="especialidad__titulo body-2 body-2-bold text-pi">
                                <?php echo esc_html($acceso->name); ?>
                            </h3>
                            <?php
                            /**
                             * Especialidades de este término
                             */
                            $especialidades = new WP_Query([
                                'post_type'      => 'especialidad',
                                'posts_per_page' => -1,
                                'post_status'    => 'publish',
                                'orderby'        => 'menu_order',
                                'order'          => 'ASC',

                                'tax_query' => [
                                    [
                                        'taxonomy' => 'tipo-especialidad',
                                        'field'    => 'term_id',
                                        'terms'    => $acceso->term_id,
                                    ]
                                ]
                            ]);
                            ?>
                            <?php if ($especialidades->have_posts()) : ?>
                                <ul class="accesos__list">
                                    <?php while ($especialidades->have_posts()) : ?>
                                        <?php $especialidades->the_post(); ?>
                                        <li class="accesos__item">
                                            <a class="accesos__link chip" href="#<?php echo sanitize_title(get_the_title()); ?>"><?php the_title(); ?></a>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Especialidades -->
    <section class="especialidades">
        <?php
        $tiposEspecialidades = get_terms([
            'taxonomy'   => 'tipo-especialidad',
            'hide_empty' => true,
            'parent'     => 0,
        ]);
        ?>
        <div class="especialidades__container container">
            <?php if ($tiposEspecialidades && !is_wp_error($tiposEspecialidades)) : ?>
                <?php foreach ($tiposEspecialidades as $especialidad) : ?>
                    <div class="tipo-especialidad <?php echo $especialidad->slug; ?>">
                        <h2 class="tipo-especialidad__titulo"><?php echo esc_html($especialidad->name); ?></h2>
                        <?php
                        /**
                         * Especialidades de este término
                         */
                        $especialidad = new WP_Query([
                            'post_type'      => 'especialidad',
                            'posts_per_page' => -1,
                            'post_status'    => 'publish',
                            'orderby'        => 'menu_order',
                            'order'          => 'ASC',

                            'tax_query' => [
                                [
                                    'taxonomy' => 'tipo-especialidad',
                                    'field'    => 'term_id',
                                    'terms'    => $especialidad->term_id,
                                ]
                            ]
                        ]);
                        ?>
                        <?php if ($especialidad->have_posts()) : ?>
                            <div class="tipo-especialidad__lista-especialidades lista-especialidades">
                                <?php while ($especialidad->have_posts()) : ?>
                                    <?php $especialidad->the_post(); ?>
                                        <article class="lista-especialidades__especialidad especialidad <?php echo sanitize_title(get_the_title()); ?>" id="<?php echo sanitize_title(get_the_title()); ?>">
                                            <?php if (get_field('imagen')['imagen']) : ?>
                                                <img class="especialidad__imagen" src="<?php echo esc_url(get_field('imagen')['imagen']['url']); ?>" alt="<?php echo esc_attr(get_field('imagen')['imagen']['alt']); ?>">
                                            <?php endif; ?>
                                            <div class="especialidad__contenido">
                                                <h3 class="especialidad__titulo">
                                                    <?php if (get_field('contenido')['icono']) : ?>
                                                        <svg aria-hidden="true" focusable="false">
                                                            <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#' . get_field('contenido')['icono']; ?>" />
                                                        </svg>
                                                    <?php endif; ?>
                                                    <?php the_title(); ?>
                                                </h3>
                                                <div class="especialidad__texto body-2 text-pb">
                                                    <?php echo wp_kses_post(get_field('contenido')['descripcion']) ?>
                                                </div>
                                            </div>
                                        </article>
                                <?php endwhile; ?>
                            </div>
                            <?php wp_reset_postdata(); ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <a class="gantz-btn secondary-btn blue" href="#accesos">↑ Volver arriba</a>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>