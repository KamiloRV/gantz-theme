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
    <!-- Ultimos Newsletters -->
    <section class="ultimos-newsletters" aria-labelledby="titulo-ultimos-newsletters" id="ultimos-newsletters">
        <div class="ultimos-newsletters__container container">
            <h2 class="ultimos-newsletters__titulo" id="titulo-ultimos-newsletters">Últimos newsletters</h2>
            <div class="ultimos-newsletters__lista">
                <?php
                $args = [
                    'post_type'      => 'newsletter',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                ];

                $query = new WP_Query($args);

                if ($query->have_posts()) : $count = 0; ?>
                    <?php while ($query->have_posts()) : 
                        $query->the_post(); 
                        $image = get_field('image');
                        $year = get_field('info')['year'] ?? '';
                        $final_year = $year === 'post_date' ? get_the_date('Y') : $year;
                        $number = get_field('info')['number'] ?? '';
                        $from = get_field('info')['from'] ?? '';
                        $to = get_field('info')['to'] ?? '';
                        $title = $final_year ? 'Newsletter ' . $final_year : '';
                        $period = $from && $to ? $from . ' - ' . $to : '';
                        $pdf_url = get_field('file')['pdf']['url'] ?? '';
                        $dir_url = get_field('file')['type'] ?? '';
                        ?>
                    
                        <article class="ultimos-newsletters__card card<?php echo $count === 0 ? '--destacada' : ''; ?>">
                            <img class="card__imagen" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                            <div class="card__info">
                                <h3 class="card__titulo"><?php echo esc_html($title); ?></h3>
                                <p class="card__periodo body-1 body-bold text-pb"><?php echo esc_html($period); ?></p>
                            </div>
                            <a href="<?php echo esc_url($pdf_url); ?>" class="card__enlace gantz-btn secondary-btn blue" <?php if ($dir_url === 'open') echo 'target="_blank" rel="noopener noreferrer"'; elseif ($dir_url === 'download') echo 'download'; ?>>
                                <svg aria-hidden="true" focusable="false">
                                    <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#download'); ?>" />
                                </svg>
                                Descargar documento
                            </a>
                        </article>
                        <?php $count++; ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Archivo de Newsletters -->
    <section class="archivo-newsletters" aria-labelledby="titulo-archivo-newsletters">
        <div class="archivo-newsletters__container container">
            <h2 class="archivo-newsletters__titulo" id="titulo-archivo-newsletters">Archivo de newsletters</h2>
            <div class="archivo-newsletters__lista-anual lista-anual">
                
                <?php
                $args = [
                    'post_type'      => 'newsletter',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                ];
                $query = new WP_Query($args);

                $newsletters_por_anio = [];

                if ($query->have_posts()) :
                    while ($query->have_posts()) :
                        $query->the_post();

                        $info = get_field('info');

                        $year   = $info['year'] ?? '';
                        $final_year = $year === 'post_date' ? get_the_date('Y') : $year;
                        $number = $info['number'] ?? '';
                        $from   = $info['from'] ?? '';
                        $to     = $info['to'] ?? '';
                        $period = $from !== 'Ninguno' && $to !== 'Ninguno' ? $from . ' - ' . $to : ' ';

                        $newsletters_por_anio[$final_year][] = [
                            'id'       => get_the_ID(),
                            'image'    => get_field('image'),
                            'year'     => $final_year,
                            'number'   => (int) $number,
                            'period'   => $period,
                            'pdf_url'  => get_field('file')['pdf']['url'] ?? '',
                            'dir_url'  => get_field('file')['type'] ?? '',
                            'title'    => ($final_year && $number && $period) ? 'Newsletter ' . $final_year . '-' . $number . '<br>' . $period : '',
                        ];
                    endwhile;
                    wp_reset_postdata();
                endif;

                /**
                 * Ordenar años DESC
                 * 2026
                 * 2025
                 * 2024
                 */
                krsort($newsletters_por_anio);

                /**
                 * Ordenar newsletters dentro de cada año
                 * 2025-3
                 * 2025-2
                 * 2025-1
                 */
                foreach ($newsletters_por_anio as &$grupo) {
                    usort($grupo, function ($a, $b) {
                        return $b['number'] <=> $a['number'];
                    });
                } unset($grupo);?>

                <?php foreach ($newsletters_por_anio as $year => $newsletters) : ?>
                    <section class="lista-anual__item">
                        <h3 class="lista-anual__titulo body-1 body-bold text-pi"><?php echo esc_html($year); ?></h3>
                        <ul class="lista-anual__newsletters newsletters">
                            <?php foreach ($newsletters as $newsletter) : ?>
                                <li class="newsletters__item">
                                    <a class="newsletters__enlace body-2 body-2-bold text-pb" href="<?php echo esc_url($newsletter['pdf_url']); ?>" <?php if ($newsletter['dir_url'] === 'open') echo 'target="_blank" rel="noopener noreferrer"'; elseif ($newsletter['dir_url'] === 'download') echo 'download'; ?>>
                                        <?php echo wp_kses_post($newsletter['title']); ?>
                                        <svg aria-hidden="true" focusable="false">
                                            <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#download'); ?>" />
                                        </svg>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </section>
                <?php endforeach; ?>
            </div>
            <a class="gantz-btn secondary-btn blue" href="#ultimos-newsletters">
                ↑ Volver arriba
            </a>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>