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

                $tarjetas = get_field('tarjetas');

                if (!empty($tarjetas['titulo'])) {
                    $accesos[] = $tarjetas['titulo'];
                }

                $celebracs = get_field('hero_titulo', 1952);

                if (!empty($celebracs)) {
                    $accesos[] = $celebracs;
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
    <section class="tarjetas" id="<?php echo sanitize_title(get_field('tarjetas')['titulo']); ?>" aria-labelledby="titulo-tarjetas">
        <div class="tarjetas__container container">
            <div class="tarjetas__header">
                <h1 class="tarjetas__titulo"><?php echo esc_html($tarjetas['titulo']); ?></h1>
                <p class="body-1 body-bold text-pb"><?php echo esc_html($tarjetas['subtitulo']); ?></p>
            </div>
            <div class="tarjetas__imagen">
                <?php if (!empty($tarjetas['imagen'])): ?>
                    <img src="<?php echo esc_url($tarjetas['imagen']['url']); ?>" alt="<?php echo esc_attr($tarjetas['imagen']['alt']); ?>">
                <?php endif; ?>
                <div class="tarjetas__disclaimer">
                    <?php if (!empty($tarjetas['disclaimer'])): ?>
                        <p class="disclaimer__texto body-2 text-pb"><?php echo esc_html($tarjetas['disclaimer']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tarjetas__pasos">
                <div class="tarjetas__paso paso--1">
                    <svg class="paso__icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48"><mask id="a" width="48" height="48" x="0" y="0" maskUnits="userSpaceOnUse" style="mask-type:alpha"><path fill="#d9d9d9" d="M0 0h48v48H0z"/></mask><g mask="url(#a)"><path fill="#2e3e80" d="M3.273 39.167q-1.31 0-2.291-.975Q0 37.217 0 35.917V7.75q0-1.3.982-2.275.981-.975 2.29-.975h37.092q1.309 0 2.29.975t.982 2.275v12.946H3.273v15.22h21.763v3.25zm0-26h37.09V7.75H3.274zM38.182 43.5V37h-6.546v-3.25h6.546v-6.5h3.273v6.5H48V37h-6.545v6.5z"/></g></svg>
                    <div class="paso__texto body-2 text-pb">
                        <?php echo wp_kses_post($tarjetas['paso1']['texto']); ?>
                        <?php if (!empty($tarjetas['paso1']['opciones'])): ?>
                        <ul class="body-2-bold">
                            <?php foreach ($tarjetas['paso1']['opciones'] as $index => $opcion): ?>
                                <li>
                                    <?php if (!empty($opcion['pdf'])): ?>
                                        <a href="<?php echo esc_url($opcion['pdf']['url']); ?>" target="_blank">
                                            <?php echo esc_html($opcion['titulo']); ?>
                                        </a>
                                    <?php elseif (!empty($opcion['tarjetas'])): ?>
                                        <button class="open-gallery" data-gallery="tarjetas-<?php echo $index; ?>">
                                            <?php echo esc_html($opcion['titulo']); ?>
                                        </button>
                                    <?php else: ?>
                                        <span><?php echo esc_html($opcion['titulo']); ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="tarjetas__paso paso--2">
                    <svg class="paso__icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48"><mask id="a" width="48" height="48" x="0" y="0" maskUnits="userSpaceOnUse" style="mask-type:alpha"><path fill="#d9d9d9" d="M0 0h48v48H0z"/></mask><g mask="url(#a)"><path fill="#2e3e80" d="M27.273 27.68q-2.728 0-4.637-1.928t-1.909-4.682 1.91-4.681q1.908-1.928 4.636-1.928 2.727 0 4.636 1.928t1.91 4.681-1.91 4.682Q30 27.68 27.273 27.68M9.818 35.39q-1.35 0-2.31-.97a3.2 3.2 0 0 1-.963-2.334V10.055q0-1.364.962-2.335.96-.97 2.311-.97h34.91q1.35 0 2.31.97A3.2 3.2 0 0 1 48 10.055v22.03q0 1.365-.961 2.335-.962.97-2.312.97zm5.455-3.304h24q0-2.314 1.581-3.91 1.583-1.598 3.873-1.598V15.563q-2.29 0-3.872-1.598-1.582-1.597-1.582-3.91h-24q0 2.313-1.582 3.91-1.582 1.598-3.873 1.598v11.015q2.29 0 3.873 1.597 1.582 1.598 1.582 3.91M41.455 42H3.273q-1.35 0-2.311-.971A3.2 3.2 0 0 1 0 38.695V13.36h3.273v25.336h38.182z"/></g></svg>
                    <div class="paso__texto body-2 text-pb">
                        <?php echo wp_kses_post($tarjetas['paso2']['texto']); ?>
                        <ul class="body-2-bold">
                            <li>Nombre: <?php echo esc_html($tarjetas['paso2']['cuenta']['nombre']); ?></li>
                            <li>RUT: <?php echo esc_html($tarjetas['paso2']['cuenta']['rut']); ?></li>
                            <li>Banco: <?php echo esc_html($tarjetas['paso2']['cuenta']['banco']); ?></li>
                            <li>Tipo de cuenta: <?php echo esc_html($tarjetas['paso2']['cuenta']['tipo']); ?></li>
                            <li>N° de cuenta: <?php echo esc_html($tarjetas['paso2']['cuenta']['numero']); ?></li>
                            <li>Comentario: <?php echo esc_html($tarjetas['paso2']['cuenta']['comentario']); ?></li>
                        </ul>
                    </div>
                </div>
                <div class="tarjetas__paso paso--3">
                    <svg class="paso__icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48"><mask id="a" width="48" height="48" x="0" y="0" maskUnits="userSpaceOnUse" style="mask-type:alpha"><path fill="#d9d9d9" d="M0 0h48v48H0z"/></mask><g mask="url(#a)"><path fill="#2e3e80" d="M21.818 20.574 3.273 8.775v25.013h27.273v3.262H3.436q-1.364 0-2.4-1.006T0 33.788V5.513q0-1.25.982-2.257.981-1.006 2.29-1.006h37.092q1.254 0 2.263 1.006 1.01 1.005 1.01 2.257v13.05h-3.273V8.775zm0-3.48L40.364 5.512H3.273zm19.2 28.656q-3.054 0-5.127-2.175t-2.073-5.22v-12.18q0-1.794 1.282-3.072t3.136-1.278q1.8 0 3.055 1.278t1.255 3.072v12.506h-3.273v-12.67q0-.597-.246-1.06-.245-.462-.79-.462a.95.95 0 0 0-.846.463q-.3.462-.3 1.06v12.452q0 1.794 1.09 3.154 1.092 1.359 2.837 1.359 1.636 0 2.673-1.278 1.035-1.278 1.036-3.018V27.97H48v10.712q0 2.937-2.018 5.003t-4.964 2.066M3.273 8.775V5.513v28.275z"/></g></svg>
                    <div class="paso__texto body-2 text-pb">
                        <?php echo wp_kses_post($tarjetas['paso3']['texto']); ?>
                    </div>
                </div>
            </div>
            <div class="tarjetas__aviso text-pb">
                <?php echo wp_kses_post($tarjetas['aviso']); ?>
            </div>
        </div>
    </section>
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
    <!-- CTA Celebra con Sentido -->
    <section class="celebra-con-sentido" aria-labelledby="titulo-celebra" id="<?php echo sanitize_title(get_field('hero_titulo', 1952)); ?>">
        <?php
        ?>
        <div class="celebra-con-sentido__container">
            <?php if (get_field('hero_imagen', 1952)): ?>
                <img class="celebra-con-sentido__imagen" src="<?php echo esc_url(get_field('hero_imagen', 1952)['url']); ?>" alt="<?php echo esc_attr(get_field('hero_imagen', 1952)['alt']); ?>">
            <?php endif; ?>
            <div class="celebra-con-sentido__contenido">
                <h2 class="celebra-con-sentido__titulo" id="titulo-celebra"><?php echo esc_html(get_field('hero_titulo', 1952)); ?></h2>
                <p class="body-1 body-bold text-pb"><?php echo esc_html(get_field('cta_subtitulo', 1952)); ?></p>
                <div class="celebra-con-sentido__texto body-2 text-pb">
                    <?php echo wp_kses_post(get_field('cta_texto', 1952)); ?>
                </div>
                <?php
                $boton = get_field('cta', 1952)['boton'];
                get_template_part(
                    'template-parts/components/button',
                    null,
                    [
                        'data' => $boton,
                        'class' => 'gantz-btn secondary-btn blue'
                    ]
                );
                ?>
            </div>
        </div>
    </section>

    <!-- Galerias -->
    <?php if (!empty($tarjetas['paso1']['opciones'])): ?>
        <?php foreach ($tarjetas['paso1']['opciones'] as $index => $opcion): ?>
            <?php if (!empty($opcion['tarjetas'])): ?>
                <div class="gallery-container" id="tarjetas-<?php echo $index; ?>" style="display:none;">
                    <?php foreach ($opcion['tarjetas'] as $i => $item): ?>
                        <?php
                            $imagen = $item['imagen'];
                            $link   = $item['pdf']['url'] ?? '';
                            $desc = $link ? '<a href="' . esc_url($link) . '" target="_blank" class="glightbox-link">Ver más</a>' : '';
                        ?>
                        <a href="<?php echo esc_url($imagen['url']); ?>" 
                        class="glightbox"
                        data-gallery="tarjetas-<?php echo $index; ?>">
                            <img src="<?php echo esc_url($imagen['sizes']['thumbnail']); ?>" 
                                alt="<?php echo esc_attr($imagen['alt']); ?>">
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        GLightbox({
            selector: '.glightbox'
        });
    });

    document.querySelectorAll('.open-gallery').forEach(button => {
        button.addEventListener('click', () => {
            const galleryId = button.dataset.gallery;
            const container = document.getElementById(galleryId);
            
            if (!container) return;

            const links = container.querySelectorAll('.glightbox');
            if (!links.length) return;

            const lightbox = GLightbox({
                elements: Array.from(links).map(el => ({
                    href: el.getAttribute('href'),
                    title: el.dataset.title || '',
                    gallery: galleryId
                }))
            });

            lightbox.open();
        });
    });
</script>
<?php get_template_part('template-parts/footer'); ?>