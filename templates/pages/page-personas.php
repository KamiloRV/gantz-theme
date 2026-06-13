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
        $hero = get_field('hero');
        ?>
        <?php if ($hero['imagen']) : ?>
            <div class="hero__imagen">
                <img class="imagen" src="<?php echo esc_url($hero['imagen']['url']) ?>" alt="<?php echo esc_attr($hero['imagen']['alt']) ?>">
            </div>
        <?php endif ?>
        <div class="hero__contenido ">
            <div class="hero__container container">
                <div class="hero__container-inner">
                    <div class="hero__header">
                        <h1 class="hero__titulo" id="titulo-hero"><?php echo esc_html($hero['titulo']) ?></h1>
                        <div class="hero__texto body-bold text-pb">
                            <?php echo wp_kses_post($hero['descripcion']['texto']) ?>
                        </div>
                    </div>
                    <div class="hero__body">
                        <p class="hero__nota nota text-pb"><?php echo esc_html($hero['descripcion']['nota']) ?></p>
                        <div class="hero__botones">
                            <!-- Repeater botones -->
                            <?php 
                            $botones = $hero['descripcion']['botones'];
                            ?>
                            <?php foreach ($botones as $boton): ?>
                                <?php
                                get_template_part(
                                    'template-parts/components/button',
                                    null,
                                    [
                                        'data' => $boton['boton'],
                                        'class' => 'gantz-btn'
                                    ]
                                );
                                ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php /* Accesos Rapidos */ ?>
    <nav class="accesos" aria-labelledby="titulo-accesos">
        <div class="accesos__container container">
            <h2 class="accesos__titulo label" id="titulo-accesos">Acceso rápido a otras formas de apoyar</h2>
            <ul class="accesos__list">
                <?php
                $accesos = [];

                $soap = get_field('soap');

                if (
                    !empty($soap['status'])
                    && !empty($soap['contenido']['titulo'])
                ) {
                    $accesos[] = $soap['contenido']['titulo'];
                }

                $giftcards = get_field('giftcards');

                if (!empty($giftcards['contenido']['titulo'])) {
                    $accesos[] = $giftcards['contenido']['titulo'];
                }
                ?>
                <?php foreach ($accesos as $acceso): ?>
                    <li class="accesos__item">
                        <a class="accesos__link chip" href="#<?php echo sanitize_title($acceso); ?>">
                            <?php echo esc_html($acceso); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </nav>
    <!-- Tarjetas Solidarias -->
    <!-- <section class="tarjetas" id="tarjetas">
        <h1>Tarjetas Solidarias</h1>
    </section> -->
    <!-- SOAP -->
    <?php if (get_field('soap')['status'] === true): ?>
        <section class="soap" id="<?php echo sanitize_title(get_field('soap')['contenido']['titulo']); ?>" aria-labelledby="titulo-soap">
            <?php 
            $soap = get_field('soap');
            ?>
            <div class="soap__container container">
                <div class="soap__container-inner">
                    <div class="soap__header header">
                        <div class="header__contenido">
                            <h2 class="sopa__titulo" id="titulo-soap">
                                <?php echo esc_html($soap['contenido']['titulo']); ?>
                            </h2>
                            <div class="soap__texto text-pb">
                                <?php echo wp_kses_post($soap['contenido']['texto']); ?>
                            </div>
                        </div>
                        <div class="header__colaborador colaborador">
                            <p class="colaborador__rotulo rotulo-pequeno text-pb">Colabora</p>
                            <?php if (!empty($soap['imagen'])): ?>
                                <img class="colaborador__imagen" src="<?php echo esc_url($soap['imagen']['url']); ?>" alt="<?php echo esc_attr($soap['imagen']['alt']); ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="soap__contenido">
                        <div class="soap__disponibles disponibles">
                            <h3 class="disponibles__titulo"><?php echo esc_html($soap['seguros']['titulo']); ?></h3>
                            <?php if (!empty($soap['seguros']['lista'])): ?>
                                <ul class="disponibles__lista">
                                    <?php foreach ($soap['seguros']['lista'] as $item): ?>
                                        <li class="disponibles__item-card item-card label nota text-pb">
                                            <div class="item-card__icono">
                                                <svg aria-hidden="true" focusable="false">
                                                    <use href="<?php echo esc_url($soap['seguros']['iconos']['url']) . '#' . $item['icono']; ?>" />
                                                </svg>
                                            </div>
                                            <?php echo esc_html($item['seguro']); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($soap['opciones']['lista'])): ?>
                            <div class="soap__opciones opciones">
                                <?php foreach ($soap['opciones']['lista'] as $opcion): ?>
                                    <div class="opciones__opcion">
                                        <p class="opciones__nombre body-1 body-bold text-pb"><?php echo esc_html('Opción ' . $opcion['nombre']); ?></p>
                                        <?php
                                        get_template_part(
                                            'template-parts/components/button',
                                            null,
                                            [
                                                'data' => $opcion['boton'],
                                                'class' => 'gantz-btn secondary-btn blue'
                                            ]
                                        );
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif ?>
    <!-- Giftcards -->
    <section class="giftcards" id="<?php echo sanitize_title(get_field('giftcards')['contenido']['titulo']); ?>" aria-labelledby="titulo-giftcards">
        <?php 
        $giftcards = get_field('giftcards');
        ?>
        <div class="giftcards__container container">
            <div class="giftcards__container-inner">
                <div class="giftcards__header header">
                    <div class="header__contenido">
                        <h2 class="sopa__titulo" id="titulo-giftcards">
                            <?php echo esc_html($giftcards['contenido']['titulo']); ?>
                        </h2>
                        <div class="giftcards__texto text-pb">
                            <?php echo wp_kses_post($giftcards['contenido']['texto']); ?>
                        </div>
                    </div>
                    <div class="header__colaborador colaborador">
                        <p class="colaborador__rotulo rotulo-pequeno text-pb">Colabora</p>
                        <?php if (!empty($giftcards['imagen'])): ?>
                            <img class="colaborador__imagen" src="<?php echo esc_url($giftcards['imagen']['url']); ?>" alt="<?php echo esc_attr($giftcards['imagen']['alt']); ?>">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="giftcards__contenido">
                    <div class="giftcards__comercios comercios">
                        <h3 class="comercios__titulo"><?php echo esc_html($giftcards['comercios']['titulo']); ?></h3>
                        <?php if (!empty($giftcards['comercios']['lista'])): ?>
                            <ul class="comercios__lista">
                                <?php foreach ($giftcards['comercios']['lista'] as $item): ?>
                                    <li class="comercios__item item label nota text-pb">
                                        <img class="item__logo" src="<?php echo esc_url($item['logo']['url']); ?>" alt="<?php echo esc_attr($item['logo']['alt']); ?>">
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>