<?php get_template_part('template-parts/header'); ?>

<?php 
// Variables reutilizables para el footer
$site_name = get_field('ajustes_name', 'option');
$directory_uri = get_template_directory_uri();
$home_url = esc_url(home_url('/'));
$logo = get_field('ajustes_logo', 'option')['url'];

$hero_slides = get_field('hero_slide'); // Slides del hero, con campos ACF tipo repeater
$images_banners = get_field('banners_banner'); // Slides para sección de banners (Eventos y campañas), con campos ACF tipo repeater

$social_links = [
    'instagram' => [ 
        'url' => get_field('socials_ig_url', 'option'),
        'label' => get_field('socials_ig_label', 'option') ?: 'Síguenos en Instagram',
        'icon' => $directory_uri . '/assets/images/icons.svg#instagram'
    ],
    'youtube' => [ 
        'url' => get_field('socials_yt_url', 'option'),
        'label' => get_field('socials_yt_label', 'option') ?: 'Ver nuestro canal de Youtube',
        'icon' => $directory_uri . '/assets/images/icons.svg#youtube'
    ],
    'linkedin' => [ 
        'url' => get_field('socials_lin_url', 'option'),
        'label' => get_field('socials_lin_label', 'option') ?: 'Conoce nuestro perfil de LinkedIn',
        'icon' => $directory_uri . '/assets/images/icons.svg#linkedin'
    ],
    'facebook' => [  
        'url' => get_field('socials_fb_url', 'option'),
        'label' => get_field('socials_fb_label', 'option') ?: 'Visita nuestra página de Facebook',
        'icon' => $directory_uri . '/assets/images/icons.svg#facebook'
    ],
    'tiktok' => [ 
        'url' => get_field('socials_tiktok_url', 'option'),
        'label' => get_field('socials_tiktok_label', 'option') ?: 'Interactúa con nuestro Tik Tok',
        'icon' => $directory_uri . '/assets/images/icons.svg#tiktok'
    ],
];
?>

<main>
    <section class="hero" aria-label="Presentación principal">
        <div class="slider" id="heroSlider" data-autoplay="5000" aria-live="polite">
            <?php foreach ($hero_slides as $index => $slide) :

                $is_first  = $index === 0;
                $visible   = $slide['colapsar']['visible'] ?? false;
                $tipo      = $slide['tipo'];
                $imagen    = $slide['imagen'];
                $titulo    = $slide['titulo']       ?? '';
                $texto     = $slide['texto']        ?? '';
                $gdatos    = $slide['datos']       ?? [];
                $bg_color  = $slide['bgcolor']     ?? [];

                /* Boton */
                $cta       = $slide['boton']      ?? [];
                $cta_icon  = $cta['icono']      ?? '';
                $cta_icon_url  = $directory_uri . '/assets/images/icons.svg#' . $cta['icono']      ?? '';
                $cta_texto = $cta['texto']      ?? '';
                $cta_tipo  = $cta['tipo']       ?? '';
                $cta_dir   = $cta['direccion']  ?? '';
                $cta_url   = $cta['url']        ?? '';
                $cta_link  = $cta['link']       ?? '';
                $cta_mail  = $cta['mail']       ?? '';
                $cta_tel   = $cta['tel']        ?? '';

                $datos = $slide['dato'] ?? '';

                if ($tipo === 'cta' && $visible === 'on') : ?>
                    <div class="slide<?php echo $is_first ? ' is-active' : ''; ?> <?php echo ($bg_color === 'white-bg') ? esc_attr($bg_color) : ''; ?>" aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>" role="group" aria-roledescription="slide" aria-label="Slide <?php echo $index + 1; ?> de <?php echo count($hero_slides); ?>">
                        <div class="image">
                            <?php if( !empty( $imagen ) ): ?>
                                <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" <?php echo $is_first ? 'loading="eager"' : 'loading="lazy"'; ?>>
                            <?php endif; ?>
                        </div>
                        <div class="container content <?php echo ($bg_color === 'white-bg') ? esc_attr($bg_color) : ''; ?>">
                            <div class="col-12 col-lgg-6">
                                <div class="title-container">
                                    <?php if ($titulo) : ?>
                                        <h2 class="title h1"><?php echo wp_kses_post($titulo); ?></h2>
                                    <?php endif; ?>

                                    <?php if ($texto) : ?>
                                        <div class="text body-1">
                                            <?php echo wp_kses_post($texto); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($cta_texto) : ?>
                                    <?php
                                    get_template_part(
                                        'template-parts/components/button',
                                        null,
                                        [
                                            'data' => $cta,
                                            'class' => 'gantz-btn primary-btn'
                                        ]
                                    );
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php elseif ($tipo === 'datos' && $visible === 'on'): ?>
                    <div class="slide<?php echo $is_first ? ' is-active' : ''; ?> datos" aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>" role="group" aria-roledescription="slide" aria-label="Slide <?php echo $index + 1; ?> de <?php echo count($hero_slides); ?>">
                        <div class="image">
                            <?php if( !empty( $imagen ) ): ?>
                                <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" <?php echo $is_first ? 'loading="eager"' : 'loading="lazy"'; ?>>
                            <?php endif; ?>
                        </div>
                        <div class="content <?php echo ($bg_color === 'white-bg') ? esc_attr($bg_color) : ''; ?>">
                            <div class="container">
                                <?php if ($texto) : ?>
                                    <div class="text body-1">
                                        <?php echo wp_kses_post($texto); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (!empty($gdatos)) : ?>
                                    <ul class="datos">
                                        <?php foreach ($gdatos as $grupo) : ?>
                                            <?php foreach ($grupo as $dato) : ?>
                                                <li>
                                                    <?php echo esc_html($dato['valor']); ?>
                                                    <p class="body-2-bold"><?php echo esc_html($dato['texto']); ?></p>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <?php /* — Flechas de navegación */ ?>
        <div class="controls">
            <button class="prev-control"
                    type="button"
                    aria-label="Slide anterior">
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#left'; ?>" />
                </svg>
            </button>
        
            <button class="next-control"
                    type="button"
                    aria-label="Slide siguiente">
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#right'; ?>" />
                </svg>
            </button>
        </div>
        <?php /* — Dots */ ?>
        <div class="dots" role="tablist"
            aria-label="Navegación de slides">
            <?php foreach ($hero_slides as $index => $slide) : ?>
                <button class="dot<?php echo $index === 0 ? ' is-active' : ''; ?>"
                        type="button"
                        role="tab"
                        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                        aria-label="<?php printf(esc_attr__('Ir al slide %d', 'mi-tema'), $index + 1); ?>"
                        data-index="<?php echo esc_attr($index); ?>">
                </button>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="quienes-somos" aria-labelledby="titulo-quienes-somos">
        <div class="container">
            <div class="text-container">
                <h2 id="titulo-quienes-somos"><?php echo get_field('somos_titulo') ?: '¿Quiénes somos?'; ?></h2>
                <?php echo get_field('somos_texto') ?: 'Somos una institución chilena sin fines de lucro que se dedica al tratamiento de fisuras labiopalatinas.'; ?>
            </div>
            <ul class="datos">
                <li>
                    <?php echo get_field('somos_dato2_valor') ?: '+1.300'; ?>
                    <p class="nota"><?php echo get_field('somos_dato2_texto') ?: 'Pacientes activos'; ?></p>
                </li>
                <li>
                    <?php echo get_field('somos_dato3_valor') ?: '333.000'; ?>
                    <p class="nota"><?php echo get_field('somos_dato3_texto') ?: 'Atenciones entregadas'; ?></p>
                </li>
                <li>
                    <?php echo get_field('somos_dato4_valor') ?: '70'; ?>
                    <p class="nota"><?php echo get_field('somos_dato4_texto') ?: 'Profesionales del área del área de la salud'; ?></p>
                </li>
                <li>
                    <?php echo get_field('somos_dato5_valor') ?: '+7.000'; ?>
                    <p class="nota"><?php echo get_field('somos_dato5_texto') ?: 'Cirugías realizadas'; ?></p>
                </li>
                <li>
                    <?php
                    $fecha_inicio = new DateTime('1977-12-14');
                    echo $fecha_inicio->diff(new DateTime())->y;
                    ?>
                    años
                    <p class="nota"><?php echo get_field('somos_dato1_texto') ?: 'Entregando sonrisas'; ?></p>
                </li>
                <li>
                    <?php echo get_field('somos_dato6_valor') ?: '+600'; ?>
                    <p class="nota"><?php echo get_field('somos_dato6_texto') ?: 'Socios'; ?></p>
                </li>
            </ul>
            <?php
            get_template_part(
                'template-parts/components/button',
                null,
                [
                    'field_prefix' => 'somos_boton',
                    'class' => 'gantz-btn secondary-btn yellow'
                ]
            );
            ?>
        </div>
    </section>
    <section class="reconocimiento" aria-label="Reconocimientos y certificaciones">
        <div class="container">
            <div class="reconocimientos">
                <?php 
                $images = get_field('reconocimientos_sellos') ?: [];
                if (!empty($images)) {
                    foreach ($images as $image) {
                        echo '<img src="' . esc_attr($image['url']) . '" alt="' . esc_attr($image['alt']) . '">';
                    }
                }
                ?>
            </div>
            <div class="text-container">
                <?php echo get_field('reconocimientos_texto') ?: 'Reconocimientos y certificaciones'; ?>
            </div>
        </div>
    </section>
    <section class="atencion-exelencia" aria-labelledby="titulo-atencion-exelencia">
        <div class="container">
            <div class="top-content">
                <div class="text-container">
                    <h2 id="titulo-atencion-exelencia"><?php echo get_field('atencion_titulo') ?: 'Atención de excelencia'; ?></h2>
                    <div class="parrafos">
                        <?php
                        $texto = get_field('atencion_texto') ?: 'Contamos con un equipo de profesionales altamente capacitados y comprometidos con la excelencia en la atención, brindando un enfoque integral y personalizado para cada paciente.';

                        $texto = preg_replace('/<p>/', '<p class="body-2">', $texto);

                        echo wp_kses_post($texto);
                        ?>
                    </div>
                </div>
                <?php
                get_template_part(
                    'template-parts/components/button',
                    null,
                    [
                        'field_prefix' => 'atencion_boton',
                        'class' => 'gantz-btn secondary-btn blue'
                    ]
                );
                ?>
            </div>
            <div class="image">
                <img src="<?php echo get_field('atencion_imagen')['url']; ?>" alt="<?php echo get_field('atencion_imagen')['alt']; ?>">
            </div>
        </div>
    </section>
    <section class="fisuras" aria-labelledby="titulo-fisuras">
        <div class="galeria">
            <?php 
            $images = get_field('fisuras_galeria') ?: [];
            if (!empty($images)) {
                foreach ($images as $image) {
                    echo '<div class="galeria-item"><img src="' . esc_attr($image['url']) . '" alt="' . esc_attr($image['alt']) . '"></div>';
                }
            }
            ?>
        </div>
        <div class="container contenido">
            <div class="info">
                <div class="text-container">
                    <h2 id="titulo-fisuras"><?php echo get_field('fisuras_titulo') ?: '¿Qué son las fisuras?'; ?></h2>
                    <div class="text">
                        <?php
                        $texto = get_field('fisuras_texto') ?: 'Las fisuras labiop palatinas son una malformación congénita que ocurre durante el desarrollo fetal, resultando en una abertura o separación en el labio superior y/o el paladar. Esta condición puede afectar la apariencia facial, la alimentación, el habla y la audición de quienes la padecen. En nuestra fundación, nos dedicamos a brindar atención integral a pacientes con fisuras, ofreciendo tratamientos especializados y apoyo continuo para mejorar su calidad de vida.';

                        $texto = preg_replace('/<p>/', '<p class="body-2">', $texto);

                        echo wp_kses_post($texto);
                        ?>
                    </div>
                </div>
                <?php
                get_template_part(
                    'template-parts/components/button',
                    null,
                    [
                        'field_prefix' => 'fisuras_boton',
                        'class' => 'gantz-btn secondary-btn blue'
                    ]
                );
                ?>
            </div>
            <div class="imagen">
                <img src="<?php echo get_field('fisuras_imagen')['url']; ?>" alt="<?php echo get_field('fisuras_imagen')['alt']; ?>">
            </div>
        </div>
    </section>
    <section class="tu-opinion">
        <div class="container contenido">
            <div class="vector" aria-hidden="true" focusable="false">
                <?php
                $svg = get_field('tuopinion_vector');

                if ($svg && !empty($svg['url'])) {
                    $file_path = get_attached_file($svg['ID']);

                    if ($file_path && file_exists($file_path)) {
                        echo file_get_contents($file_path);
                    }
                }
                ?>
            </div>
            <div class="info-escritorio">
                <div class="logo">
                    <svg aria-hidden="true" focusable="false">
                        <use href="<?php echo esc_url($logo); ?>" />
                    </svg>
                </div>
                <div class="redes">
                    <?php
                    $url = $social_links['instagram']['url'];
                    $path = rtrim(parse_url($url, PHP_URL_PATH), '/');
                    $username = basename($path);
                    ?>

                    <a href="<?php echo esc_url($url); ?>"
                    target="_blank"
                    class="social-link instagram"
                    aria-label="<?php echo esc_attr($social_links['instagram']['label']); ?>">

                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_attr($social_links['instagram']['icon']); ?>" />
                        </svg>

                        <?php echo esc_html($username); ?>
                    </a>
                    <?php
                    $url = $social_links['facebook']['url'];
                    $path = rtrim(parse_url($url, PHP_URL_PATH), '/');
                    $username = basename($path);
                    ?>

                    <a href="<?php echo esc_url($url); ?>"
                    target="_blank"
                    class="social-link facebook"
                    aria-label="<?php echo esc_attr($social_links['facebook']['label']); ?>">

                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_attr($social_links['facebook']['icon']); ?>" />
                        </svg>

                        <?php echo esc_html($username); ?>
                    </a>
                </div>
            </div>
            <div class="text-container">
                <h2><?php echo get_field('tuopinion_titulo') ?: 'Queremos conocer tu opinión'; ?></h2>
                <p class="body-bold"><?php echo get_field('tuopinion_texto') ?: 'Para reclamos, sugerencias o felicitaciones'; ?></p>
            </div>
            <?php
            get_template_part(
                'template-parts/components/button',
                null,
                [
                    'field_prefix' => 'tuopinion_boton',
                    'class' => 'gantz-btn secondary-btn blue'
                ]
            );
            ?>
        </div>

    </section>
    <?php if ($images_banners) : ?>
        <section class="banners" aria-label="Eventos y campañas">
            <div class="slider" id="imgBanners" data-autoplay="5000" aria-live="polite">
                <?php foreach ($images_banners as $index => $banner) :
                
                    $sm_imagen = $banner['imagen_mobile'] ?? '';
                    $md_imagen = $banner['imagen_tablet'] ?? '';
                    $xl_imagen = $banner['imagen_escritorio'] ?? '';
                    
                    $enlace = $banner['enlace'] ?? [];

                    $type = $enlace['tipo'] ?? '';
                    $url  = $enlace['url'] ?? '';
                    $link = $enlace['link'] ?? '';

                    $href = '';
                    $target = '';

                    if ($type === 'interno' && !empty($link)) {
                        $href = $link;
                    } elseif ($type === 'externo' && !empty($url)) {
                        $href = $url;
                        $target = 'target="_blank" rel="noopener noreferrer"';
                    }

                    $is_first = $index === 0;
                ?>
                    <div class="slide<?php echo $is_first ? ' is-active' : ''; ?>"
                        role="group"
                        aria-roledescription="slide"
                        aria-label="<?php printf($index + 1, count($images_banners)); ?>"
                        aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>">

                        <?php if ($href) : ?>
                            <a href="<?php echo esc_url($href); ?>"
                            class="img-slide-link"
                            <?php echo $target; ?>
                            tabindex="<?php echo $is_first ? '0' : '-1'; ?>">
                        <?php endif; ?>

                            <picture>
                                <?php if (!empty($sm_imagen)) : ?>
                                    <source media="(max-width: 767px)"
                                            srcset="<?php echo esc_url($sm_imagen['url']); ?>">
                                <?php endif; ?>

                                <?php if (!empty($md_imagen)) : ?>
                                    <source media="(max-width: 1022px)"
                                            srcset="<?php echo esc_url($md_imagen['url']); ?>">
                                <?php endif; ?>

                                <img src="<?php echo esc_url($xl_imagen['url']); ?>"
                                    alt="<?php echo esc_attr($xl_imagen['alt']); ?>"
                                    class="img-slide-img"
                                    <?php echo $is_first ? 'loading="eager"' : 'loading="lazy"'; ?>>
                            </picture>

                        <?php if ($href) : ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php /* — Flechas de navegación */ ?>
            <div class="controls">
                <button class="prev-control"
                        type="button"
                        aria-label="Slide anterior">
                    <svg aria-hidden="true" focusable="false">
                        <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#left'; ?>" />
                    </svg>
                </button>
            
                <button class="next-control"
                        type="button"
                        aria-label="Slide siguiente">
                    <svg aria-hidden="true" focusable="false">
                        <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#right'; ?>" />
                    </svg>
                </button>
            </div>
            <?php /* — Dots */ ?>
            <div class="dots" role="tablist"
                aria-label="Navegación de slides">
                <?php foreach ($images_banners as $index => $slide) : ?>
                    <button class="dot<?php echo $index === 0 ? ' is-active' : ''; ?>"
                            type="button"
                            role="tab"
                            aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                            aria-label="<?php printf(esc_attr__('Ir al slide %d', 'mi-tema'), $index + 1); ?>"
                            data-index="<?php echo esc_attr($index); ?>">
                    </button>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <section class="noticias" aria-labelledby="titulo-noticias">
        <?php
        $noticias = get_field('noticias')
        ?>
        <div class="container contenido">
            <div class="title-container">
                <h2 id="titulo-noticias"><?php echo esc_html($noticias['titulo']) ?></h2>
                <p class="fecha-actual body-bold"><?php echo ucfirst(wp_date('l, d \d\e F \d\e Y')); ?></p>
            </div>
            <div class="lista-noticias">
                <?php
                $args = [
                    'post_type'      => 'noticia',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ];

                $noticias = new WP_Query($args);
                ?>

                <?php if ($noticias->have_posts()) : $count = 0; ?>
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
            <?php
            get_template_part(
                'template-parts/components/button',
                null,
                [
                    'field_prefix' => 'noticias_boton',
                    'class' => 'gantz-btn secondary-btn blue'
                ]
            );
            ?>
            <!-- <a class="gantz-btn secondary-btn blue" href="">Explorar todas las noticias →</a> -->
        </div>
    </section>
    <section class="alianzas">
        <div class="alianzas__contenido container">
            <?php
            $alianzasTitulo = get_field('alianzas_titulo') ?? 'Principales alianzas';
            $alianzasAliados = get_field('alianzas_aliados') ?? [];
            ?>
            <h2 class="alianzas__titulo"><?php echo esc_html($alianzasTitulo) ?></h2>
            <ul class="alianzas__aliados aliados">
                <?php
                $chunks = array_chunk($alianzasAliados, 2);
                ?>

                <?php foreach ($chunks as $grupo) : ?>
                    <li class="aliados__fila">
                        <?php foreach ($grupo as $aliado) : ?>
                            <!-- <div class="aliados__item"> -->
                                <img
                                    class="aliados__imagen"
                                    src="<?php echo esc_url($aliado['url']); ?>"
                                    alt="<?php echo esc_attr($aliado['alt']); ?>"
                                >
                            <!-- </div> -->
                        <?php endforeach; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>