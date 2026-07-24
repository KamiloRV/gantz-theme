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
    <?php get_template_part('template-parts/components/breadcrumb'); ?>
    <!-- Hero -->
    <section class="hero">
        <?php 
        $hero = get_field('hero');
        ?>
        <div class="hero__container container">
            <div class="hero__header">
                <h1 class="hero__titulo">
                    <?php echo esc_html($hero['titulo']); ?>
                </h1>
                <div class="hero__que-es">
                    <h2><?php echo esc_html($hero['subtitulo']); ?></h2>
                    <div class="hero__texto text-pb">
                        <?php echo wp_kses_post($hero['texto']); ?>
                    </div>
                </div>
                <?php 
                $args = [
                    'post_type'      => 'fecu',
                    'post_status'    => 'publish',
                    'posts_per_page' => 1,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                ];

                $query = new WP_Query($args);
                ?>

                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) :
                        $query->the_post();

                        $year = get_field('year');
                        $final_year = $year === 'post_date' ? get_the_date('Y') : $year;

                        $file = get_field('file');
                        $url = $file['pdf'] ? $file['pdf']['url'] : '#';
                        $url_dir = get_field('file_type');

                        $title = $year >= 2016 ? 'FECU Social ' . $year : 'Memoria ' . $year;
                        ?>
                        <article class="hero__ultima-fecu ultima-fecu">
                            <svg class="ultima-fecu__svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 144 136">
                                <path fill="currentColor" d="M36.873 25.647H17.568a1.93 1.93 0 0 0-1.913 1.909v19.26c0 1.04.87 1.908 1.913 1.908h19.305a1.93 1.93 0 0 0 1.913-1.909v-19.26c0-1.04-.87-1.908-1.913-1.908m-3.653 9.577-5.39 6.42c-.349.347-.87.694-1.392.694s-1.044-.173-1.391-.52l-3.305-3.297c-.695-.694-.695-1.909 0-2.602.696-.695 1.913-.695 2.609 0l1.913 1.908 4.174-5.032a1.754 1.754 0 0 1 2.609-.173c.87.694.87 1.735.173 2.602M36.873 54.552H17.568a1.93 1.93 0 0 0-1.913 1.908v19.26c0 1.041.87 1.909 1.913 1.909h19.305a1.93 1.93 0 0 0 1.913-1.909V56.46c0-1.04-.87-1.908-1.913-1.908m-3.653 9.577-5.39 6.42c-.349.347-.87.694-1.392.694s-1.044-.173-1.391-.52l-3.305-3.297c-.695-.694-.695-1.909 0-2.603.696-.694 1.913-.694 2.609 0l1.913 1.909 4.174-5.032a1.754 1.754 0 0 1 2.609-.174c.87.694.87 1.736.173 2.603M36.873 83.456H17.568a1.93 1.93 0 0 0-1.913 1.91v19.259c0 1.041.87 1.909 1.913 1.909h19.305a1.93 1.93 0 0 0 1.913-1.909v-19.26c0-1.041-.87-1.909-1.913-1.909m-3.653 9.578-5.39 6.42c-.349.347-.87.694-1.392.694s-1.044-.174-1.391-.52l-3.305-3.297c-.695-.694-.695-1.909 0-2.603.696-.694 1.913-.694 2.609 0l1.913 1.909 4.174-5.032a1.754 1.754 0 0 1 2.609-.174c.87.694.87 1.735.173 2.603M63.655 16.484c0-1.041-.87-1.909-1.913-1.909H17.568a1.93 1.93 0 0 0-1.913 1.909c0 1.04.87 1.908 1.913 1.908h44.174a1.93 1.93 0 0 0 1.913-1.908M49.391 43.725a1.93 1.93 0 0 0-1.913 1.909c0 1.04.87 1.908 1.913 1.908H65.74a1.93 1.93 0 0 0 1.913-1.908c0-1.041-.87-1.909-1.913-1.909zM77.217 37.652c0-1.04-.87-1.909-1.913-1.909H49.391a1.93 1.93 0 0 0-1.913 1.91c0 1.04.87 1.908 1.913 1.908h25.913a1.93 1.93 0 0 0 1.913-1.909"/>
                                <path fill="currentColor" d="M92.174 113.997c-1.044 0-1.913 1.042-1.913 2.083v.867H3.652V3.644h71.826v13.36c0 1.041.87 1.909 1.913 1.909h12.87V42.51c0 1.04.87 1.908 1.913 1.908a1.93 1.93 0 0 0 1.913-1.908v-26.2q0-.869-15.652-15.79C78.087.174 77.565 0 77.217 0H1.913A1.93 1.93 0 0 0 0 1.909v116.773c0 1.041.87 1.909 1.913 1.909h90.26a1.93 1.93 0 0 0 1.914-1.909v-2.776c0-1.041-.87-1.909-1.913-1.909"/>
                                <path fill="currentColor" d="M103.478 61.216c-4.87-4.858-11.13-7.461-17.913-7.461s-13.217 2.603-17.913 7.461c-4.522 4.511-7.13 10.584-7.478 17.004v.867c0 2.95.522 5.727 1.391 8.503 1.217 3.47 3.304 6.767 5.913 9.37 5.044 5.031 11.478 7.461 17.913 7.461s13.044-2.43 17.913-7.462c4.87-4.858 7.478-11.104 7.478-17.871s-2.608-13.187-7.478-17.872zm-33.391 2.603c2.782-2.777 6.26-4.685 10.087-5.726L64.522 73.188c1.043-3.47 2.782-6.767 5.565-9.37M63.826 79.26 86.26 57.572c1.391 0 2.608.174 3.826.52L64.174 83.427c-.174-1.389-.348-2.777-.348-4.165m26.435 20.995c-2.435.521-5.044.694-7.479.347l7.479-7.287v7.114zm0-12.32L78.435 99.563c-1.218-.347-2.261-.867-3.305-1.561l15.305-14.922v4.684zm0-9.89L71.826 96.093c-.696-.52-1.217-1.041-1.74-1.562-.173-.173-.347-.52-.695-.694l20.87-20.474zm0-9.89-23.13 22.73c-.696-1.04-1.218-2.081-1.74-3.296l24.87-24.465z"/>
                                <path fill="currentColor" d="M125.043 103.553c-1.217-1.214-3.304-1.214-4.521 0l-7.131-7.114c3.131-5.032 4.87-10.931 4.87-17.177 0-8.676-3.304-17.005-9.565-23.078-12.696-12.666-33.565-12.666-46.261 0-2.087 1.909-3.652 4.165-5.044 6.594h-7.826a1.93 1.93 0 0 0-1.913 1.908c0 1.042.87 1.91 1.913 1.91h5.913c-.521 1.387-1.043 2.775-1.391 4.163h-4.522a1.93 1.93 0 0 0-1.913 1.91c0 1.04.87 1.908 1.913 1.908h3.826c-.173 1.561-.347 3.296-.347 4.858 0 3.817.695 7.635 1.913 11.105h-5.392a1.93 1.93 0 0 0-1.913 1.908c0 1.042.87 1.91 1.913 1.91h6.957a27.3 27.3 0 0 0 2.608 4.163h-9.565a1.93 1.93 0 0 0-1.913 1.909c0 1.041.87 1.909 1.913 1.909h12.522l.348.347c6.26 6.073 14.435 9.543 23.13 9.543 8.696 0 14.609-2.429 20.348-7.114l6.609 6.593-.522.521c-1.217 1.214-1.217 3.297 0 4.685l18.087 18.045c.696.694 1.565 1.041 2.261 1.041.695 0 1.739-.347 2.261-1.041l8.348-8.329c.695-.694 1.043-1.388 1.043-2.255 0-.868-.348-1.735-1.043-2.256zm-39.478 4.512c-7.652 0-14.956-2.95-20.522-8.503-5.565-5.552-8.521-12.666-8.521-20.474S57.739 69.371 60 65.207c1.391-2.43 2.957-4.511 4.87-6.593 5.739-5.553 13.043-8.502 20.521-8.502s14.783 2.776 20.522 8.502c5.391 5.379 8.522 12.666 8.522 20.474s-2.957 14.922-8.522 20.474c-5.391 5.379-12.696 8.503-20.522 8.503zm22.957-5.9c.869-.867 1.739-1.909 2.608-2.95l6.609 6.594-2.782 2.776zm24 29.324-17.565-17.525 1.391-1.388 5.391-5.206.87-.867 17.565 17.525-7.652 7.634z"/>
                            </svg>
                            <div class="ultima-fecu__info">
                                <h3 class="ultima-fecu__titulo"><?php echo esc_html($title); ?></h3>
                                <p class="body-1 text-pb">Conoce la última FECU Social realizada por nuestra fundación.</p>
                                <a class="gantz-btn secondary-btn blue" href="<?php echo esc_url($url); ?>" <?php if ($url_dir === 'open') echo 'target="_blank" rel="noopener noreferrer"'; elseif ($url_dir === 'download') echo 'download'; ?>>
                                    <svg aria-hidden="true" focusable="false">
                                        <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#download'); ?>" />
                                    </svg>
                                    Descargar documento
                                </a>
                            </div>
                        </article>
                    <?php endwhile;
                wp_reset_postdata();
                endif; ?>
            </div>
        </div>
    </section>
    <!-- FECUS Anteriores -->
    <section class="archivo-fecu" id="archivo-fecu">
        <div class="archivo-fecu__container container">
            <h2 class="archivo-fecu__titulo"><?php echo esc_html(get_field('fecu_titulo')); ?></h2>
            <ul class="archivo-fecu__lista lista">
                <?php 
                $args = [
                    'post_type'      => 'fecu',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                ];

                $query = new WP_Query($args); ?>
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) :
                        $query->the_post();

                        $year = get_field('year');
                        $final_year = $year === 'post_date' ? get_the_date('Y') : $year;
                        $file = get_field('file');
                        $url = $file['pdf'] ? $file['pdf']['url'] : '#';
                        $url_dir = get_field('file_type');

                        $title = $year >= 2016 ? 'FECU Social ' . $year : 'Memoria ' . $year;
                        ?>
                        <li class="lista__item item">
                            <a class="item__enlace text-pb" href="<?php echo esc_url($url); ?>" <?php if ($url_dir === 'open') echo 'target="_blank" rel="noopener noreferrer"'; elseif ($url_dir === 'download') echo 'download'; ?>>
                                <?php echo esc_html($title); ?>
                                <svg aria-hidden="true" focusable="false">
                                    <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#download'); ?>" />
                                </svg>
                            </a>
                        </li>
                    <?php endwhile;
                wp_reset_postdata();
                endif; ?>
            </ul>
            <a class="gantz-btn secondary-btn blue" href="#archivo-fecu">
                ↑ Volver arriba
            </a>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>