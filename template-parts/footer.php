<?php 
// Variables reutilizables para el footer
$site_name = get_field('ajustes_name', 'option');
$directory_uri = get_template_directory_uri();
$home_url = esc_url(home_url('/'));
$logo = get_field('ajustes_logo', 'option')['url'];

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

$direccion = get_field('direccion', 'option', ) ?: 'El Lazo 8545, Pudahuel. Santiago, Chile.';
$horario = get_field('horario', 'option') ?: 'Lunes a viernes 09:00 a 17:30 hrs.';
$comentarios_url = get_field('comentarios_url', 'option') ?: '#'; // URL para la sección de comentarios o contacto

$contactos = [
    [
        'titulo' => get_field('contactos_recepcion_titulo', 'option') ?: 'Recepción',
        'items'  => [
            ['tipo' => 'email',  'valor' => get_field('contactos_recepcion_email', 'option') ?: 'recepcion@gantz.cl'],
            ['tipo' => 'phone',  'valor' => get_field('contactos_recepcion_phone', 'option') ?: '9 6878 1989'],
            ['tipo' => 'phone',  'valor' => get_field('contactos_recepcion_phone2', 'option') ?: '22 338 64 00'],
            ['tipo' => 'phone',   'valor' => get_field('contactos_recepcion_phone3', 'option') ?: '(Pendiente)'],
        ],
    ],
    [
        'titulo' => get_field('contactos_mesa_central_titulo', 'option') ?: 'Mesa Central',
        'items'  => [
            ['tipo' => 'email', 'valor' => get_field('contactos_mesa_central_email', 'option') ?: 'fundacion@gantz.cl'],
        ],
    ],
    [
        'titulo' => get_field('contactos_area_dental_titulo', 'option') ?: 'Área Dental',
        'items'  => [
            ['tipo' => 'email',    'valor' => get_field('contactos_area_dental_email', 'option') ?: 'dental@gantz.cl'],
            ['tipo' => 'whatsapp', 'valor' => get_field('contactos_area_dental_whatsapp', 'option') ?: '9 6844 8468'],
        ],
    ],
    [
        'titulo' => get_field('contactos_programas_medicos_titulo', 'option') ?: 'Programas Médicos',
        'items'  => [
            ['tipo' => 'email', 'valor' => get_field('contactos_programas_medicos_email', 'option') ?: 'programasgantz@gantz.cl'],
        ],
    ],
    [
        'titulo' => get_field('contactos_socios_titulo', 'option') ?: 'Socios',
        'items'  => [
            ['tipo' => 'email', 'valor' => get_field('contactos_socios_email', 'option') ?: 'socios@gantz.cl'],
            ['tipo' => 'phone', 'valor' => get_field('contactos_socios_phone', 'option') ?: '9 6844 8466'],
        ],
    ],
    [
        'titulo' => get_field('contactos_marketing_titulo', 'option') ?: 'Marketing y Comunicaciones',
        'items'  => [
            ['tipo' => 'email', 'valor' => get_field('contactos_marketing_email', 'option') ?: 'comunicaciones@gantz.cl'],
            ['tipo' => 'phone', 'valor' => get_field('contactos_marketing_phone', 'option') ?: '9 6878 4688'],
        ],
    ],
    [
        'titulo' => get_field('contactos_contabilidad_titulo', 'option') ?: 'Contabilidad',
        'items'  => [
            ['tipo' => 'email', 'valor' => get_field('contactos_contabilidad_email', 'option') ?: 'contabilidad@gantz.cl'],
        ],
    ],
    [
        'titulo' => get_field('contactos_adquisiciones_titulo', 'option') ?: 'Adquisiciones',
        'items'  => [
            ['tipo' => 'email', 'valor' => get_field('contactos_adquisiciones_email', 'option') ?: 'adquisiciones@gantz.cl'],
        ],
    ]
];
?>

<footer role="contentinfo" class="gantz-footer" aria-labelledby="footer-title">
    <h2 class="hidden" id="footer-title">Pie de página</h2>
    <div class="container">
        <div class="footer-content">
            <section class="brand">
                <?php if (is_front_page()) : ?>
                    <?php // Logo de la pagina Inicio ?>
                    <a class="logo" href="<?php echo esc_url($home_url); ?>" aria-label="<?php echo esc_attr($site_name); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $logo ); ?>" />
                        </svg>
                    </a>
                <?php else : ?>
                    <?php // Logo de las otras paginas ?>
                    <a class="logo" href="<?php echo esc_url($home_url); ?>" aria-label="Ir al inicio — <?php echo esc_attr($site_name); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $logo ); ?>" />
                        </svg>
                    </a>
                <?php endif; ?>
                <address class="address text-center" aria-label="Dirección y horario de atención">
                    <p class="body-2-bold m-0"><?php echo esc_html($horario);   ?></p>
                    <p class="body-2-bold m-0"><?php echo esc_html($direccion); ?></p>
                </address>
                <nav class="social" aria-label="Redes sociales">
                    <ul class="social-list">
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
                </nav>
                <div class="comments">
                    <p class="body-2 m-0"><?php echo get_field('comentarios', 'option') ?: '¿Tienes comentarios, reclamos, felicitaciones o alguna sugerencia?'; ?></p>
                    <a href="<?php echo get_field('comentarios_link_url', 'option') ?: '#' ?>" class="comments-link">
                        <?php echo get_field('comentarios_link_text', 'option') ?: 'Formulario de comentarios' ?> →
                    </a>
                </div>
            </section>
            <section class="links">
                <h3 class="links-title">Enlaces de interés</h3>
                <nav class="links-nav">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container' => false,
                        'menu_class' => 'nav-ul',
                        'fallback_cb' => '__return_false',
                        'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth' => 1,
                    ]);
                    ?>
                </nav>
            </section>
            <section class="contacts">
                <h3 class="contacts-title">Contactos</h3>
                <div class="contact-list">
                    <?php foreach ($contactos as $contacto) : ?>
                        <div class="contact-group">
                            <h4 class="group-title body-1 body-bold"><?php echo esc_html($contacto['titulo']); ?></h4>
                            <ul class="group-list">
                                <?php foreach ($contacto['items'] as $item) :
                                    $icon = match($item['tipo']) {
                                        'email'    =>  $directory_uri . '/assets/images/icons.svg#mail',
                                        'phone'    => $directory_uri . '/assets/images/icons.svg#tel',
                                        'whatsapp' => $directory_uri . '/assets/images/icons.svg#wsp',
                                        default    => '',
                                    };

                                    $href = match($item['tipo']) {
                                        'email'    => 'mailto:' . antispambot($item['valor']),
                                        'phone'    => 'tel:+56'  . preg_replace('/\D/', '', $item['valor']),
                                        'whatsapp' => 'https://wa.me/56' . preg_replace('/\D/', '', $item['valor']),
                                        default    => null,
                                    };
                                ?>
                                <li class="group-item">
                                    <?php if ($icon) : ?>
                                        <svg aria-hidden="true" focusable="false">
                                            <use href="<?php echo esc_attr($icon); ?>" />
                                        </svg>
                                    <?php endif; ?>

                                    <?php if ($href) : ?>
                                        <a href="<?php echo esc_url($href); ?>" <?php if ($item['tipo'] === 'whatsapp') echo 'target="_blank" rel="noopener noreferrer"'; ?>>
                                            <?php echo esc_html($item['valor']); ?>
                                        </a>
                                    <?php else : ?>
                                        <span><?php echo esc_html($item['valor']); ?></span>
                                    <?php endif; ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <section class="agendar">
                <div class="title">
                    <h3>Agenda tu hora</h3>
                    <p>¿Te interesa agendar una hora de atención con nuestros especialistas?</p>
                </div>
                <div class="contacts">
                    <a href="mailto:<?php echo antispambot(get_field('contactos_recepcion_email', 'option') ?: 'recepcion@gantz.cl'); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#mail' ); ?>" />
                        </svg>
                        <?php echo get_field('contactos_recepcion_email', 'option') ?: 'recepcion@gantz.cl' ?>
                    </a>
                    <a href="tel:+56<?php echo antispambot(get_field('contactos_recepcion_phone', 'option') ?: '9 6878 1989'); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#tel' ); ?>" />
                        </svg>
                        <?php echo get_field('contactos_recepcion_phone', 'option') ?: '9 6878 1989' ?>
                    </a>

                    <a href="tel:+56<?php echo antispambot(get_field('contactos_recepcion_phone2', 'option') ?: '22 338 64 00'); ?>">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url( $directory_uri . '/assets/images/icons.svg#tel' ); ?>" />
                        </svg>
                        <?php echo get_field('contactos_recepcion_phone2', 'option') ?: '22 338 64 00' ?>
                    </a>
                </div>
            </section>
        </div>
    </div>
    <div class="bottom">
        <div class="container">
            <p class="copyright nota m-0">
                <?php printf(
                    esc_html__('%d © %s. Todos los derechos reservados.'),
                    date('Y'),
                    esc_html($site_name)
                ); ?>
            </p>
        </div>
    </div>
    <a class="hidden" href="<?php echo esc_url($home_url); ?>">Volver al principio de la página</a>
</footer>

<?php wp_footer(); ?>
</body>
</html>