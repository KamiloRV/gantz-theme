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
    <!-- Testimonios Destacados -->
    <section class="testimonios-destacados">
        <?php 
        $testimonios = get_field('testimonios');
        ?>
        <div class="testimonios-destacados__container container">
            <div class="testimonios-destacados__header">
                <h2 class="testimonios-destacados__titulo"><?php echo esc_html($testimonios['titulo']) ?></h2>
                <div class="testimonios-destacados__texto body-2 text-pb">
                    <?php echo wp_kses_post($testimonios['texto']) ?>
                </div>
            </div>
            <div class="testimonios-destacados__lista">
                <?php
                function get_youtube_id($url) {
                    $patterns = [
                        '/youtube\.com\/watch\?v=([^&]+)/',
                        '/youtu\.be\/([^?]+)/',
                        '/youtube\.com\/shorts\/([^?]+)/',
                        '/youtube\.com\/embed\/([^?]+)/',
                    ];

                    foreach ($patterns as $pattern) {
                        if (preg_match($pattern, $url, $matches)) {
                            return $matches[1];
                        }
                    }

                    return false;
                }
                ?>
                <?php if (!empty($testimonios['list'])) : ?>
                    <?php foreach ($testimonios['list'] as $testimonio) : ?>
                        <?php
                        $name = $testimonio['name'] ?? '';
                        $title = $name ? 'Testimonial de ' . $name : '';
                        $date = $testimonio['date'] ?? '';
                        $url  = $testimonio['url'] ?? '';
                        $duration = $testimonio['duration'] ?? '';
                        $text = $testimonio['text'] ?? '';
                        $video_id = get_youtube_id($url);
                        $embed_url = "https://www.youtube.com/embed/{$video_id}";
                        $manual_image = $testimonio['image']['url'] ?? '';
                        $image = $video_id ? "https://i.ytimg.com/vi/{$video_id}/hqdefault.jpg" : '';

                        $final_image = $manual_image ? $manual_image : $image;

                        $date_formatted = $date
                            ? date_i18n(
                                'j \d\e F, Y',
                                strtotime($date)
                            )
                            : '';
                        ?>
                        <article class="testimonios-destacados__testimonio testimonio">
                            <a class="testimonio__video glightbox" href="<?php echo esc_url($embed_url); ?>" data-gallery="testimonios">
                                <div class="testimonio__media">
                                    <?php if ($image) : ?>
                                        <img src="<?php echo esc_url($final_image); ?>" alt="<?php echo esc_attr($title); ?>">
                                    <?php endif; ?>

                                    <span class="testimonio__play">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 48 48">
                                            <path fill="currentColor" fill-rule="evenodd" d="M24 0c13.255 0 24 10.745 24 24S37.255 48 24 48 0 37.255 0 24 10.745 0 24 0m-4.645 33.29L34.839 24l-15.484-9.29z" clip-rule="evenodd"/>
                                        </svg>
                                    </span>

                                    <?php if ($duration) : ?>
                                        <span class="testimonio__duracion">
                                            <?php echo esc_html($duration); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </a>
                            <div class="testimonio__contenido">
                                <div class="testimonio__info">
                                    <time class="testimonio__fecha nota text-ac" datetime="<?php echo esc_attr(date('Y-m-d', strtotime($date))); ?>">
                                        <?php echo esc_html($date_formatted); ?>
                                    </time>
                                    <h3 class="testimonio__titulo body-1 body-bold text-pi"><?php echo esc_html($title); ?></h3>
                                </div>
                                <p class="testimonio__resumen body-2 text-pb"><?php echo esc_html($text); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php
            get_template_part(
                'template-parts/components/button',
                null,
                [
                    'data' => $testimonios['boton'],
                    'class' => 'gantz-btn secondary-btn blue'
                ]
            );
            ?>
        </div>
    </section>
    <!-- Testimonios Extendidos -->
    
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        GLightbox({
            selector: '.glightbox'
        });
    });
</script>
<?php get_template_part('template-parts/footer'); ?>