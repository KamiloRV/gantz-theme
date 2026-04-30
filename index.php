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
                $tipo      = $slide['tipo'];
                $imagen    = $slide['imagen'];
                $titulo    = $slide['titulo']       ?? '';
                $texto     = $slide['texto']        ?? '';
                $cta       = $slide['cta']          ?? [];
                $gdatos    = $slide['datos']       ?? [];
                $bg_color  = $slide['bgcolor']     ?? [];

                $cta_icon  = $cta['icono']      ?? '';
                $cta_icon_url  = $directory_uri . '/assets/images/icons.svg#' . $cta['icono']      ?? '';
                $cta_texto = $cta['texto']      ?? '';
                $cta_tipo  = $cta['tipo']       ?? '';
                $cta_url   = $cta['url']        ?? '';
                $cta_link  = $cta['link']       ?? '';

                $datos = $slide['dato'] ?? '';

                if ($tipo === 'cta') : ?>
                    <div class="slide<?php echo $is_first ? ' is-active' : ''; ?> <?php echo ($bg_color === 'white-bg') ? esc_attr($bg_color) : ''; ?>" aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>" role="group" aria-roledescription="slide" aria-label="Slide <?php echo $index + 1; ?> de <?php echo count($hero_slides); ?>">
                        <div class="image">
                            <?php if( !empty( $imagen ) ): ?>
                                <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" <?php echo $is_first ? 'loading="eager"' : 'loading="lazy"'; ?>>
                            <?php endif; ?>
                        </div>
                        <div class="container content <?php echo ($bg_color === 'white-bg') ? esc_attr($bg_color) : ''; ?>">
                            <div class="col-12 col-xl-6">
                                <div class="title-container">
                                    <?php if ($titulo) : ?>
                                        <h2 class="title h1"><?php echo wp_kses_post($titulo); ?></h2>
                                    <?php endif; ?>

                                    <?php if ($texto) : ?>
                                        <p class="body-bold text"><?php echo wp_kses_post($texto); ?></p>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($cta_texto) : ?>
                                    <?php if ($cta_tipo === 'interno' && $cta_link) : ?>
                                        <a href="<?php echo esc_url($cta_link); ?>"
                                        class="gantz-btn cta <?php echo ($cta_icon === 'heart') ? esc_attr($cta_icon) : ''; ?>">
                                            <?php if (!empty($cta_icon) && $cta_icon !== 'none') : ?>
                                                <svg aria-hidden="true" focusable="false">
                                                    <use href="<?php echo esc_attr($cta_icon_url); ?>" />
                                                </svg>
                                            <?php endif; ?>
                                            <?php echo esc_html($cta_texto); ?>
                                        </a>
                                    <?php elseif ($cta_tipo === 'externo' && $cta_url) : ?>
                                        <a href="<?php echo esc_url($cta_url); ?>"
                                        target="_blank"
                                        class="gantz-btn cta <?php echo ($cta_icon === 'heart') ? esc_attr($cta_icon) : ''; ?>">
                                            <?php if (!empty($cta_icon) && $cta_icon !== 'none') : ?>
                                                <svg aria-hidden="true" focusable="false">
                                                    <use href="<?php echo esc_attr($cta_icon_url); ?>" />
                                                </svg>
                                            <?php endif; ?>
                                            <?php echo esc_html($cta_texto); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php elseif ($tipo === 'datos'): ?>
                    <div class="slide<?php echo $is_first ? ' is-active' : ''; ?> datos" aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>" role="group" aria-roledescription="slide" aria-label="Slide <?php echo $index + 1; ?> de <?php echo count($hero_slides); ?>">
                        <div class="image">
                            <?php if( !empty( $imagen ) ): ?>
                                <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" <?php echo $is_first ? 'loading="eager"' : 'loading="lazy"'; ?>>
                            <?php endif; ?>
                        </div>
                        <div class="content <?php echo ($bg_color === 'white-bg') ? esc_attr($bg_color) : ''; ?>">
                            <div class="container">
                                <?php if ($texto) : ?>
                                    <h2 class="body-1 body-bold text"><?php echo wp_kses_post($texto); ?></h2>
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
                <h2 id="titulo-quienes-somos"><?php echo get_field('quienessomos_titulo') ?: '¿Quiénes somos?'; ?></h2>
                <?php echo get_field('quienessomos_texto') ?: 'Somos una institución chilena sin fines de lucro que se dedica al tratamiento de fisuras labiopalatinas.'; ?>
            </div>
            <ul class="datos">
                <li>
                    <?php echo get_field('quienessomos_dato2_valor') ?: '+1.300'; ?>
                    <p class="nota"><?php echo get_field('quienessomos_dato2_texto') ?: 'Pacientes activos'; ?></p>
                </li>
                <li>
                    <?php echo get_field('quienessomos_dato3_valor') ?: '333.000'; ?>
                    <p class="nota"><?php echo get_field('quienessomos_dato3_texto') ?: 'Atenciones entregadas'; ?></p>
                </li>
                <li>
                    <?php echo get_field('quienessomos_dato4_valor') ?: '70'; ?>
                    <p class="nota"><?php echo get_field('quienessomos_dato4_texto') ?: 'Profesionales del área del área de la salud'; ?></p>
                </li>
                <li>
                    <?php echo get_field('quienessomos_dato5_valor') ?: '+7.000'; ?>
                    <p class="nota"><?php echo get_field('quienessomos_dato5_texto') ?: 'Cirugías realizadas'; ?></p>
                </li>
                <li>
                    <?php
                    $fecha_inicio = new DateTime('1977-12-14');
                    echo $fecha_inicio->diff(new DateTime())->y;
                    ?>
                    años
                    <p class="nota"><?php echo get_field('quienessomos_dato1_texto') ?: 'Entregando sonrisas'; ?></p>
                </li>
                <li>
                    <?php echo get_field('quienessomos_dato6_valor') ?: '+600'; ?>
                    <p class="nota"><?php echo get_field('quienessomos_dato6_texto') ?: 'Socios'; ?></p>
                </li>
            </ul>
            <?php
            $boton_tipo  = get_field('quienessomos_boton_tipo');
            $boton_link  = get_field('quienessomos_boton_link');
            $boton_url   = get_field('quienessomos_boton_url');
            $boton_texto = get_field('quienessomos_boton_texto') ?: 'Sobre la fundación →';

            $href = '#';
            $target = '';

            if ($boton_tipo === 'interno' && !empty($boton_link)) {
                $href = $boton_link;
            } elseif ($boton_tipo === 'externo' && !empty($boton_url)) {
                $href = $boton_url;
                $target = ' target="_blank" rel="noopener noreferrer"';
            }
            ?>

            <a class="gantz-btn secondary-btn yellow"
            href="<?php echo esc_url($href); ?>"
            <?php echo $target; ?>>
                <?php echo esc_html($boton_texto); ?>
            </a>
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
                $boton_tipo  = get_field('atencion_boton_tipo');
                $boton_link  = get_field('atencion_boton_link');
                $boton_url   = get_field('atencion_boton_url');
                $boton_texto = get_field('atencion_boton_texto') ?: 'Conoce las especialidades →';

                $href = '#';
                $target = '';

                if ($boton_tipo === 'interno' && !empty($boton_link)) {
                    $href = $boton_link;
                } elseif ($boton_tipo === 'externo' && !empty($boton_url)) {
                    $href = $boton_url;
                    $target = ' target="_blank" rel="noopener noreferrer"';
                }
                ?>

                <a class="gantz-btn secondary-btn blue"
                href="<?php echo esc_url($href); ?>"
                <?php echo $target; ?>>
                    <?php echo esc_html($boton_texto); ?>
                </a>
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
                $boton_tipo  = get_field('fisuras_boton_tipo');
                $boton_link  = get_field('fisuras_boton_link');
                $boton_url   = get_field('fisuras_boton_url');
                $boton_texto = get_field('fisuras_boton_texto') ?: 'Aprender más →';

                $href = '#';
                $target = '';

                if ($boton_tipo === 'interno' && !empty($boton_link)) {
                    $href = $boton_link;
                } elseif ($boton_tipo === 'externo' && !empty($boton_url)) {
                    $href = $boton_url;
                    $target = ' target="_blank" rel="noopener noreferrer"';
                }
                ?>

                <a class="gantz-btn secondary-btn blue"
                href="<?php echo esc_url($href); ?>"
                <?php echo $target; ?>>
                    <?php echo esc_html($boton_texto); ?>
                </a>
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
                    <a href="<?php echo esc_url($social_links['instagram']['url']); ?>" target="_blank" class="social-link instagram" aria-label="<?php echo esc_attr($social_links['instagram']['label']); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_attr($social_links['instagram']['icon']); ?>" />
                        </svg>
                        fundacion.gantz
                    </a>
                    <a href="<?php echo esc_url($social_links['facebook']['url']); ?>" target="_blank" class="social-link facebook" aria-label="<?php echo esc_attr($social_links['facebook']['label']); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_attr($social_links['facebook']['icon']); ?>" />
                        </svg>
                        fundacion.gantz
                    </a>
                </div>
            </div>
            <div class="text-container">
                <h2><?php echo get_field('tuopinion_titulo') ?: 'Queremos conocer tu opinión'; ?></h2>
                <p class="body-bold"><?php echo get_field('tuopinion_texto') ?: 'Para reclamos, sugerencias o felicitaciones'; ?></p>
            </div>
            <?php
            $boton_tipo  = get_field('tuopinion_boton_tipo');
            $boton_link  = get_field('tuopinion_boton_link');
            $boton_url   = get_field('tuopinion_boton_url');
            $boton_texto = get_field('tuopinion_boton_texto') ?: 'Accede al formulario de comentarios';

            $href = '#';
            $target = '';

            if ($boton_tipo === 'interno' && !empty($boton_link)) {
                $href = $boton_link;
            } elseif ($boton_tipo === 'externo' && !empty($boton_url)) {
                $href = $boton_url;
                $target = ' target="_blank" rel="noopener noreferrer"';
            }
            ?>

            <a class="gantz-btn secondary-btn blue"
            href="<?php echo esc_url($href); ?>"
            <?php echo $target; ?>>
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo $directory_uri . '/assets/images/icons.svg#form'; ?>" />
                </svg>
                <?php echo esc_html($boton_texto); ?>
            </a>

            <!-- <a class="gantz-btn secondary-btn blue" href="">
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo $directory_uri . '/assets/images/icons.svg#form'; ?>" />
                </svg>
                Accede al formulario de comentarios
            </a> -->
        </div>

    </section>
    <section class="banners img-slider" id="imgBanners" aria-label="Eventos y campañas">
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
                            <source media="(max-width: 1439px)"
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
        <div class="controls">
            <?php /* — Flechas */ ?>
            <button class="prev-control"
                    type="button"
                    aria-label="<?php esc_attr_e('Slide anterior', 'mi-tema'); ?>">
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#left'; ?>" />
                </svg>
            </button>
        
            <button class="next-control"
                    type="button"
                    aria-label="<?php esc_attr_e('Slide siguiente', 'mi-tema'); ?>">
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#right'; ?>" />
                </svg>
            </button>
        </div>
        
        <?php /* — Dots */ ?>
        <div class="dots" role="tablist"
            aria-label="<?php esc_attr_e('Navegación de slides', 'mi-tema'); ?>">
            <?php foreach ($images_banners as $index => $banner) : ?>
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
    <section class="noticias-recientes" aria-labelledby="titulo-noticias">
        <div class="container">
            <div class="title-container">
                <h2 id="titulo-noticias">Noticias recientes</h2>
                <p>Jueves, 06 de Noviembre de 2025</p>
            </div>
            <div class="noticias">

            </div>
            <a class="gantz-btn secondary-btn blue" href="">Explorar todas las noticias →</a>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>