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
    <section class="hero">
        <?php if (get_field('hero_imagen')) : ?>
            <img class="hero__imagen" src="<?php echo esc_url(get_field('hero_imagen')['url']); ?>" alt="<?php echo esc_attr(get_field('hero_imagen')['alt']); ?>">
        <?php endif ?>
        <div class="hero__contenido container">
            <h1 class="hero__titulo">
                <?php echo esc_html(get_field('hero_titulo')) ?? 'Nuestra causa'; ?>
            </h1>
            <div class="hero__texto">
                <?php echo wp_kses_post(get_field('hero_texto')); ?>
            </div>
        </div>
    </section>
    <div class="separador body-bold">
        <div class="separador__texto container">
            <?php echo wp_kses_post(get_field('hero_separador_texto')); ?>
        </div>
    </div>
    <section class="historia container" itemscope itemtype="https://schema.org/Person">
        <?php $himages = get_field('historia_imagenes');
        if ($himages) : ?>
            <div class="historia__imagenes">
                <?php foreach ($himages as $index => $image) : ?>
                    <img class="historia__imagen<?php echo $index === 0 ? '--destacada' : ''; ?>" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
                <?php endforeach ?>
            </div>
        <?php endif ?>
        <div class="historia__contenido">
            <h2 class="historia__titulo"><?php echo esc_html(get_field('historia_titulo')) ?></h2>
            <div class="historia__texto body-2 text-pb">
                <?php echo wp_kses_post(get_field('historia_texto')) ?>
            </div>
        </div>
    </section>
    <section class="mision-vision">
        <div class="container">
            <div class="mision-vision__imagen">
                <?php $myvimage = get_field('misionvision_imagen');
                if ($myvimage) : ?>
                    <div class="mision-vision__imagen">
                        <img class="imagen" src="<?php echo esc_url($myvimage['url']) ?>" alt="<?php echo esc_attr($myvimage['alt']) ?>">
                    </div>
                <?php endif ?>
            </div>
            <div class="mision-vision__contenido contenido body-2">
                <div class="contenido__mision mision">
                    <h2 class="mision__titulo">
                        <svg class="mision__icon" aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#' . 'partnerheart'); ?>" />
                        </svg>
                        <?php echo esc_html(get_field('misionvision_mision_titulo')) ?>
                    </h2>
                    <div class="mision_texto text-pb">
                        <?php echo wp_kses_post(get_field('misionvision_mision_texto')) ?>
                    </div>
                </div>
                <div class="contenido__vision vision">
                    <h2 class="vision__titulo">
                        <svg class="vision__icon" aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#' . 'familyhome'); ?>" />
                        </svg>
                        <?php echo esc_html(get_field('misionvision_vision_titulo')) ?>
                    </h2>
                    <div class="vision_texto text-pb">
                        <?php echo wp_kses_post(get_field('misionvision_vision_texto')) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="transparencia container">
        <div class="transparencia__header">
            <h2 class="transparencia__titulo"><?php echo esc_html(get_field('transparencia_titulo')) ?></h2>
            <p class="body-bold text-pb"><?php echo esc_html(get_field('transparencia_texto')) ?></p>
        </div>
        <div class="transparencia__contenido contenido">
            <?php $timages = get_field('transparencia_contenido_imagenes');
            if ($timages) : ?>
                <div class="transparencia__imagenes">
                    <?php foreach ($timages as $index => $image) : ?>
                        <img class="imagen" src="<?php echo esc_url($image['url']) ?>" alt="<?php echo esc_attr($image['alt']) ?>">
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <div class="contenido__container">
                <h3 class="contenido__titulo"><?php echo esc_html(get_field('transparencia_contenido_titulo')) ?></h3>
                <div class="contenido__texto body-2 text-pb">
                    <?php echo wp_kses_post(get_field('transparencia_contenido_texto')) ?>
                </div>
                <?php
                get_template_part(
                    'template-parts/components/button',
                    null,
                    [
                        'field_prefix' => 'transparencia_contenido_boton',
                        'class' => 'gantz-btn secondary-btn blue'
                    ]
                );
                ?>
            </div>
        </div>
    </section>
    <section class="liderazgo">
        <div class="container">
            <div class="liderazgo__contenido">
                <h2 class="liderazgo__titulo"><?php echo esc_html(get_field('liderazgo_titulo')) ?></h2>
                <div class="liderazgo__texto body-2 text-pb">
                    <?php echo wp_kses_post(get_field('liderazgo_texto')) ?>
                </div>
            </div>
            <?php
            $limagen = get_field('liderazgo_imagen');
            ?>
            <?php if ($limagen) : ?>
                <div class="liderazgo__imagen">
                    <img class="imagen" src="<?php echo esc_url($limagen['url']) ?>" alt="<?php echo esc_attr($limagen['alt']) ?>">
                </div>
            <?php endif ?>
        </div>
    </section>
    <section class="equipo container">
        <?php $eimagen = get_field('equipo_imagen');
        if ($eimagen) : ?>
            <div class="equipo__imagen">
                <img class="imagen" src="<?php echo esc_url($eimagen['url']) ?>" alt="<?php echo esc_attr($eimagen['alt']) ?>">
            </div>
        <?php endif ?>
        <div class="equipo__contenido contenido">
            <div class="contenido__contenedor">
                <h2 class="equipo__titulo"><?php echo wp_kses_post(get_field('equipo_titulo')) ?></h2>
                <div class="equipo__texto body-2 text-pb">
                    <?php echo wp_kses_post(get_field('equipo_texto')) ?>
                </div>
            </div>
            <?php
            get_template_part(
                'template-parts/components/button',
                null,
                [
                    'field_prefix' => 'equipo_boton',
                    'class' => 'gantz-btn secondary-btn blue'
                ]
            );
            ?>
        </div>
    </section>
    <section class="hitos">
        <div class="hitos__contenedor container">
            <h2 class="hitos__titulo"><?php echo esc_html(get_field('hitos_titulo')) ?></h2>
            <?php 
            $hitos = get_field('hitos_lista')
            ?>
            <?php if ($hitos) : ?>
                <ol class="hitos__lista lista">
                    <?php foreach ($hitos as $hito) : ?>
                        <li class="lista__item">
                            <article class="lista-card">
                                <h3 class="lista-card__titulo">
                                    <?php echo esc_html($hito['titulo']); ?>
                                </h3>
                                <p class="lista-card__texto body-2 body-2-bold text-pb">
                                    <?php echo wp_kses_post($hito['texto']); ?>
                                </p>
                            </article>
                        </li>
                    <?php endforeach ?>
                </ol>
            <?php endif ?>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>