<?php defined('ABSPATH') || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" href="<?php echo get_template_directory_uri() . '/assets/images/favicon.svg' ; ?>" type="image/x-icon"> -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php 
// Variables reutilizables para el footer
$site_name = get_field('ajustes_name', 'option');
$directory_uri = get_template_directory_uri();
$home_url = esc_url(home_url('/'));
$logo = get_field('ajustes_logo', 'option')['url'];
$cta_text = get_field('cta_text', 'option'); // Texto del botón de llamada a la acción
$cta_url = get_field('cta_url', 'option'); // URL del botón de llamada a la acción
$cta_label = get_field('cta_label', 'option'); // Etiqueta aria para el botón de llamada a la acción

$social_links = [
    'instagram' => [ 
        'url' => get_field('instagram_url', 'option'),
        'label' => get_field('instagram_label', 'option') ?: 'Síguenos en Instagram',
        'icon' => $directory_uri . '/assets/images/icons.svg#instagram'
    ],
    'youtube' => [ 
        'url' => get_field('youtube_url', 'option'),
        'label' => get_field('youtube_label', 'option') ?: 'Ver nuestro canal de Youtube',
        'icon' => $directory_uri . '/assets/images/icons.svg#youtube'
    ],
    'linkedin' => [ 
        'url' => get_field('linkedin_url', 'option'),
        'label' => get_field('linkedin_label', 'option') ?: 'Conoce nuestro perfil de LinkedIn',
        'icon' => $directory_uri . '/assets/images/icons.svg#linkedin'
    ],
    'facebook' => [  
        'url' => get_field('facebook_url', 'option'),
        'label' => get_field('facebook_label', 'option') ?: 'Visita nuestra página de Facebook',
        'icon' => $directory_uri . '/assets/images/icons.svg#facebook'

    ],
    'tiktok' => [ 
        'url' => get_field('tiktok_url', 'option'),
        'label' => get_field('tiktok_label', 'option') ?: 'Interactúa con nuestro Tik Tok',
        'icon' => $directory_uri . '/assets/images/icons.svg#tiktok'
    ],
];
?>

<?php // Header Principal ?>
<header role="banner" class="gantz-header">
    <h1 class="hidden">Cabecera del Sitio</h1>
    <?php // Menú secundario del header // Todos los accesos deben ser editables ?> 
    <div class="top-menu">
        <?php // class hidden para el título del menú ?>
        <div class="container">
            <nav aria-labelledby="social-menu" class="menus">
                <h2 id="social-menu" class="hidden">Menú de Redes Sociales</h2>
                <a class="navbar-link nota" href="<?php echo esc_attr($home_url) . 'transparencia' ?>" rel="noopener" aria-label="transparencia">Transparencia</a>
                <ul class="social-menu">
                    <?php foreach ($social_links as $data) : 

                        $is_valid = !empty($data['url']) 
                            && !empty($data['label']) 
                            && !empty($data['icon']);

                        if (!$is_valid) continue;

                    ?>
                        <li class="social-item">
                            <a href="<?php echo esc_url($data['url']); ?>"
                            class="social-link"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="<?php echo esc_attr($data['label']); ?>">
                            
                                <svg aria-hidden="true" focusable="false">
                                    <use href="<?php echo esc_attr($data['icon']); ?>" />
                                </svg>

                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php // Menú principal del header // Todos los accesos deben ser editables ?>
    <nav aria-labelledby="main-menu" class="gantz-navbar">
        <?php // class hidden para el título del menú?>
        <h2 id="main-menu" class="hidden">Menú Principal</h2>
        <div class="container">
            <div class="navbar-content">
                <?php if (is_front_page()) : ?>
                    <?php // Logo de la pagina Inicio ?>
                    <a class="navbar-logo" href="<?php echo esc_url($home_url); ?>" aria-label="<?php echo esc_attr($site_name); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $logo ); ?>" />
                        </svg>
                    </a>
                <?php else : ?>
                    <?php // Logo de las otras paginas ?>
                    <a class="navbar-logo" href="<?php echo esc_url($home_url); ?>" aria-label="Ir al inicio — <?php echo esc_attr($site_name); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $logo ); ?>" />
                        </svg>
                    </a>
                <?php endif; ?>
                <?php // Acciones móviles (CTA Donar y Boton Hamburgesa) ?>
                <div class="mobile-actions">
                    <a href="<?php echo esc_url($cta_url); ?>" class="cta-button" aria-label="<?php echo esc_attr($cta_label); ?>" target="_blank">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#heart' ); ?>" />
                        </svg>
                        <?php echo esc_html($cta_text) ; ?>
                    </a>
                    <button 
                        class="navbar-toggle" 
                        aria-controls="mobile-nav" 
                        aria-expanded="false" 
                        aria-label="Abrir menú de navegación" 
                        data-bs-toggle="offcanvas"
                        data-bs-target="#navOffcanvas"
                        aria-controls="navOffcanvas"
                        aria-expanded="false" >
                        <span class="hamburger">
                            <svg aria-hidden="true" focusable="false">
                                <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#menu' ); ?>" />
                            </svg>
                        </span>
                    </button>
                </div>
                <?php // Navbar principal (Escritorio) ?>
                <div class="navbar-nav">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'header',
                        'container' => false,
                        'menu_class' => 'nav-ul',
                        'fallback_cb' => '__return_false',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth' => 3,
                    ]);
                    ?>
                </div>
                <?php // Controles de la navbar Escritorio (CTA Donar y Buscar) ?>
                <div class="navbar-controls">
                    <a href="<?php echo esc_url($cta_url) ; ?>" class="cta-button" aria-label="<?php echo esc_attr($cta_label); ?>" target="_blank">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#heart' ); ?>" />
                        </svg>
                        <?php echo esc_html($cta_text) ; ?>
                    </a>
                    <button class="search-button">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#search' ); ?>" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

<?php // Header Mobile (Offcanvas) ?>
<div role="banner" class="gantz-mobile-header offcanvas offcanvas-end" tabindex="-1" id="navOffcanvas" aria-labelledby="navOffcanvasLabel">
    <h2 id="navOffcanvasLabel" class="hidden">Cabecera del sitio</h2>
    <div aria-labelledby="mobile-menu" class="gantz-navbar mobile header-offcanvas">
        <h2 id="mobile-menu" class="hidden">Menú de navegación</h2>
        <div class="container">
            <div class="navbar-content">
                <?php if (is_front_page()) : ?>
                    <?php // Logo de la pagina Inicio ?>
                    <a class="navbar-logo" href="<?php echo esc_url($home_url); ?>" aria-label="<?php echo esc_attr($site_name); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $logo ); ?>" />
                        </svg>
                    </a>
                <?php else : ?>
                    <?php // Logo de las otras paginas ?>
                    <a class="navbar-logo" href="<?php echo esc_url($home_url); ?>" aria-label="Ir al inicio — <?php echo esc_attr($site_name); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#logo-gantz' ); ?>" />
                        </svg>
                    </a>
                <?php endif; ?>
                <div class="mobile-actions">
                    <a href="<?php echo esc_url($cta_url); ?>" class="cta-button" aria-label="<?php echo esc_attr($cta_label); ?>" target="_blank">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#heart' ); ?>" />
                        </svg>
                        <?php echo esc_html($cta_text) ; ?>
                    </a>
                    <button 
                        class="navbar-toggle" 
                        aria-label="Cerrar menú de navegación" 
                        data-bs-dismiss="offcanvas">
                        <span class="hamburger">
                            <svg aria-hidden="true" focusable="false">
                                <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#close' ); ?>" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="body-offcanvas">
        <nav class="social-media">
            <div class="container">
                <ul class="social-list">
                    <?php foreach ($social_links as $data) : ?>
                        <li class="social-item">
                            <a href="<?php echo esc_url($data['url']); ?>"
                                class="social-link"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="<?php echo esc_attr($data['label']); ?>">
                                <svg aria-hidden="true" focusable="false">
                                    <use href="<?php echo esc_attr($data['icon']); ?>" />
                                </svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </nav>
        <a href="#"
            class="featured-link body-1">
            <div class="container">
                <span class="featured-text">Agendar hora</span>
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#external-link' ); ?>" />
                </svg>
            </div>
        </a>
        <nav class="navbar-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'header',
                'container' => false,
                'menu_class' => 'nav-ul',
                'fallback_cb' => '__return_false',
                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'depth' => 3,
            ]);
            ?>
        </nav>
    </div>
</div>