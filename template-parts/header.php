<?php defined('ABSPATH') || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php 
// Variables reutilizables para el header
$site_name = get_bloginfo('name');
$directory_uri = get_template_directory_uri();
$home_url = esc_url(home_url('/'));
$logo = the_field('logo'); // Ruta del logo, asegúrate de que el archivo exista
$cta_text = get_field('cta_text'); // Texto del botón de llamada a la acción
$cta_url = get_field('cta_url'); // URL del botón de llamada a la acción
$cta_label = get_field('cta_label'); // Etiqueta aria para el botón de llamada a la acción

$social_links = [
    'instagram' => [ 
        'url' => get_field('instagram_url'),
        'label' => 'Conoce nuestro Instagram',
        'icon' => 'instagram-icon.svg'
    ],
    'youtube' => [ 
        'url' => get_field('youtube_url'),
        'label' => 'Ver nuestro canal de Youtube',
        'icon' => 'youtube-icon.svg'
    ],
    'linkedin' => [ 
        'url' => get_field('linkedin_url'),
        'label' => 'Conoce nuestro perfil de LinkedIn',
        'icon' => 'linkedin-icon.svg'
    ],
    'facebook' => [ 
        'url' => get_field('facebook_url'),
        'label' => 'Visita nuestra página de Facebook',
        'icon' => 'facebook-icon.svg'
    ],
    'tiktok' => [ 
        'url' => get_field('tiktok_url'),
        'label' => 'Interactúa con nuestro Tik Tok',
        'icon' => 'tiktok-icon.svg'
    ],
];
?>

<header role="banner" id="gantz-header" class="gantz-header">
    <?php // Menú secundario del header // Todos los accesos deben ser editables ?> 
    <nav aria-labelledby="social-menu" class="top-menu">
        <?php // class hidden para el título del menú ?>
        <h2 id="social-menu" class="hidden">Menú de Redes Sociales</h2>
        <div class="container">
            <div class="menus">
                <a class="navbar-link nota" href="#" rel="noopener" aria-label="Transpariencia">Transpariencia</a>
                <ul class="social-menu">
                    <li class="social-item">
                        <a class="social-link" href="<?php echo esc_url($social_links['instagram']['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_links['instagram']['label']); ?>">
                            <svg aria-hidden="true" focusable="false">
                                <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#instagram" />
                            </svg>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="<?php echo esc_url($social_links['youtube']['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_links['youtube']['label']); ?>">
                            <svg aria-hidden="true" focusable="false">
                                <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#youtube" />
                            </svg>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="<?php echo esc_url($social_links['linkedin']['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_links['linkedin']['label']); ?>">
                            <svg aria-hidden="true" focusable="false">
                                <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#linkedin" />
                            </svg>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="<?php echo esc_url($social_links['facebook']['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_links['facebook']['label']); ?>">
                            <svg aria-hidden="true" focusable="false">
                                <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#facebook" />
                            </svg>
                        </a>
                    </li>
                    <li class="social-item">
                        <a class="social-link" href="<?php echo esc_url($social_links['tiktok']['url']); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr($social_links['tiktok']['label']); ?>">
                            <svg aria-hidden="true" focusable="false">
                                <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#tiktok" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php // Menú principal del header // Todos los accesos deben ser editables ?>
    <nav aria-labelledby="main-menu" class="gantz-navbar">
        <?php // class hidden para el título del menú?>
        <h2 id="main-menu" class="hidden">Menú Principal</h2>
        <div class="container">
            <div class="navbar-content">
                <?php if (is_front_page()) : ?>
                    <h1 class="m-0" aria-label="<?php echo esc_attr($site_name); ?>">
                        <a class="navbar-logo" href="<?php echo esc_url($home_url); ?>" aria-label="<?php echo esc_attr($site_name); ?>">
                            <svg aria-hidden="true" focusable="false">
                                <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#logo-gantz" />
                            </svg>
                        </a>
                    </h1>
                <?php else : ?>
                    <a class="navbar-logo" href="<?php echo esc_url($home_url); ?>" aria-label="Ir al inicio — <?php echo esc_attr($site_name); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#logo-gantz" />
                        </svg>
                    </a>
                <?php endif; ?>
                <div class="mobile-actions">
                    <a href="<?php echo esc_url($cta_url); ?>" class="cta-button" aria-label="<?php echo esc_attr($cta_label); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#heart" />
                        </svg>
                        Dona
                    </a>
                    <button class="navbar-toggle" aria-controls="mobile-nav" aria-expanded="false" aria-label="Abrir menú de navegación">
                        <span class="hamburger">
                            <svg aria-hidden="true" focusable="false">
                                <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#menu" />
                            </svg>
                        </span>
                    </button>
                </div>
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
                <div class="navbar-controls">
                    <a href="<?php echo esc_url($cta_url); ?>" class="cta-button" aria-label="<?php echo esc_attr($cta_label); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#heart" />
                        </svg>
                        Dona
                    </a>
                    <button class="search-button">
                        <svg aria-hidden="true" focusable="false">
                            <use xlink:href="<?php echo esc_url( $directory_uri ); ?>/assets/images/icons.svg#search" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>