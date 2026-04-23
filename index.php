<?php get_template_part('template-parts/header'); ?>

<?php 
// Variables reutilizables para el footer
$site_name = get_field('ajustes_name', 'option');
$directory_uri = get_template_directory_uri();
$home_url = esc_url(home_url('/'));
$logo = get_field('logo', 'option');

$hero_slides = get_field('hero_slide')
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
                                            <svg aria-hidden="true" focusable="false">
                                                <use href="<?php echo esc_attr($cta_icon_url); ?>" />
                                            </svg>
                                            <?php echo esc_html($cta_texto); ?>
                                        </a>
                                    <?php elseif ($cta_tipo === 'externo' && $cta_url) : ?>
                                        <a href="<?php echo esc_url($cta_url); ?>"
                                        target="_blank"
                                        class="gantz-btn cta <?php echo ($cta_icon === 'heart') ? esc_attr($cta_icon) : ''; ?>">
                                            <svg aria-hidden="true" focusable="false">
                                                <use href="<?php echo esc_attr($cta_icon_url); ?>" />
                                            </svg>
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
    <section class="quienes-somos">
        <div class="container">
            <div class="text-container">
                <h2>¿Quiénes somos?</h2>
                <p>Somos una institución chilena <b>sin fines de lucro</b> que se dedica al tratamiento de <b>fisuras labiopalatinas</b>.</p>
                <p>Ofrecemos atención ambulatoria multidisciplinaria, rehabilitación integral y de calidad a personas de todas las edades, <b>independiente de su procedencia, tipo de previsión, diagnóstico o situación socioeconómica.</b></p>
            </div>
            <ul class="datos">
                <li>
                    +1.300
                    <p class="nota">Pacientes activos</p>
                </li>
                <li>
                    333.000
                    <p class="nota">Atenciones entregadas</p>
                </li>
                <li>
                    70
                    <p class="nota">Profesionales del área del área de la salud</p>
                </li>
                <li>
                    +7.000
                    <p class="nota">Cirugías realizadas</p>
                </li>
                <li>
                    48 años
                    <p class="nota">Entregando sonrisas</p>
                </li>
                <li>
                    +600
                    <p class="nota">Socios</p>
                </li>
            </ul>
            <a class="gantz-btn secondary-btn yellow" href="#">
                Sobre la fundación →
            </a>
        </div>
    </section>
    <section class="reconocimiento">
        <div class="container">
            <div class="reconocimientos">
                <img src="<?php echo esc_attr($directory_uri) . '/assets/images/reconocimientos/smiletrain.jpg' ?>" alt="">
                <img src="<?php echo esc_attr($directory_uri) . '/assets/images/reconocimientos/elegimos.png' ?>" alt="">
                <img src="<?php echo esc_attr($directory_uri) . '/assets/images/reconocimientos/superintendenciadesalud.jpg' ?>" alt="">
            </div>
            <div class="text-container">
                <p><b>Fundación Gantz</b> está reconocida como el <b>único centro en Chile y referente en Latinoamérica en el tratamiento de la fisura labiopalatina.</b></p>
                <p>Además, está certificado por la <b>Comunidad de Organizaciones Solidarias</b> como una organización destacada por su <b>transparencia</b> y <b>efectividad.</b></p>
            </div>
        </div>
    </section>
    <section class="atencion-exelencia">
        <div class="container">
            <div class="top-content">
                <div class="text-container">
                    <h2>Atención de <u>excelencia</u></h2>
                    <div class="parrafos">
                        <p class="body-2">Fundación Gantz está conformada por <b>equipos especializados con amplia experiencia</b> en el tratamiento integral de pacientes con fisura labiopalatina.</p>
                        <p class="body-2">Nuestro compromiso es entregar atención de excelencia, basada en protocolos modernos y técnicas de vanguardia que cumplen con los más altos estándares internacionales, <b>garantizando resultados para cada paciente.</b></p>
                    </div>
                </div>
                <a class="gantz-btn secondary-btn blue" href="<?php echo esc_attr($home_url) . 'especialidades' ?>">Conoce las especialidades →</a>
            </div>
            <div class="image">
                <img src="<?php echo esc_attr($directory_uri) . '/assets/images/atencion-de-exelencia.jpg' ?>" alt="">
            </div>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>