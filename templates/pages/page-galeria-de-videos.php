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
    <section class="archivo-galeria" id="archivo-galeria" aria-labelledby="titulo-archivo">
        <?php 
        $search = sanitize_text_field($_GET['buscar'] ?? '');
        $vista = $_GET['vista'] ?? 'mosaico';
        ?>
        <div class="archivo-galeria__container container">
            <h1 class="archivo-galeria__titulo"><?php echo get_the_title(); ?></h1>
            <div class="archivo-galeria__filtros filtros">
                <form class="gantz-search filtros-form" method="GET" action="<?php echo esc_url(get_permalink() . '#archivo-galeria'); ?>">
                    <input type="hidden" name="vista" value="<?php echo esc_attr($vista); ?>">
                    <input class="gantz-search__input body-2 text-mb" type="search" name="buscar" placeholder="¿Buscas algo en particular?" value="<?php echo esc_attr($search); ?>">
                    <button class="gantz-search__submit" type="submit" aria-label="Buscar">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#search'); ?>" />
                        </svg>
                    </button>
                </form>
                <div class="filtros__vista gantz-vista">
                    <p class="gantz-vista__label body-2 body-2-bold text-pi">Vista de la galería:</p>
                    <div class="gantz-vista__opciones">
                        <button type="button" class="gantz-vista__opcion body-2 <?php echo $vista === 'mosaico' ? 'is-active' : ''; ?>" data-view="mosaico" aria-pressed="<?php echo $vista === 'mosaico' ? 'true' : 'false'; ?>">
                            <svg class="gantz-vista__icon" aria-hidden="true">
                                <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#grid'); ?>" />
                            </svg>
                            <svg class="gantz-vista__icon-active" aria-hidden="true">
                                <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#bold-grid'); ?>" />
                            </svg>
                            <span>Mosaico</span>
                        </button>
                        <button type="button" class="gantz-vista__opcion body-2 <?php echo $vista === 'horizontal' ? 'is-active' : ''; ?>" data-view="horizontal" aria-pressed="<?php echo $vista === 'horizontal' ? 'true' : 'false'; ?>">
                            <svg class="gantz-vista__icon" aria-hidden="true">
                                <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#list'); ?>" />
                            </svg>
                            <svg class="gantz-vista__icon-active" aria-hidden="true">
                                <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#bold-list'); ?>" />
                            </svg>
                            <span>Horizontal</span>
                        </button>

                    </div>
                </div>
            </div>
            <ul class="archivo-galeria__lista lista" data-view="<?php echo esc_attr($vista); ?>">
                <?php 
                $paged = max(1, get_query_var('paged'));

                $posts_per_page = wp_is_mobile() ? 10 : 16;

                $args = [
                    'post_type'      => 'video',
                    'post_status'    => 'publish',
                    'order'          => 'DESC',
                    'posts_per_page' => $posts_per_page,
                    'paged'          => $paged,
                    's'              => $search,
                ];

                $query = new WP_Query($args);
                ?>
                <?php
                    function get_youtube_id($url)
                    {
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
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) :
                        $query->the_post();

                        $url         = get_field('video');
                        $video_id = get_youtube_id($url);
                        $embed_url = "https://www.youtube.com/embed/{$video_id}";

                        $plataforma  = get_field('plataforma');
                        $manualImage = get_field('imagen');
                        $title = get_the_title();

                        $image = '';
                        $image_alt = $title;

                        if (
                            $plataforma === 'yt'
                            && !empty($url)
                        ) {

                            $video_id = get_youtube_id($url);

                            if ($video_id) {
                                $image = "https://i.ytimg.com/vi/{$video_id}/hqdefault.jpg";

                                $image_alt = $title;
                            }
                        }

                        if (
                            empty($image)
                            && !empty($manualImage['url'])
                        ) {
                            $image = $manualImage['url'];

                            $image_alt = !empty($manualImage['alt'])
                                ? $manualImage['alt']
                                : $title;
                        }

                        $title = get_the_title();
                    ?>
                    <li class="lista__item item" aria-labelledby="titulo-<?php echo get_the_ID(); ?>">
                        <a class="item__card glightbox" href="<?php echo esc_url($embed_url); ?>" data-gallery="videos">
                            <img class="item__imagen" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
                            <h2 class="item__titulo body-1 body-bold text-pi" id="titulo-<?php echo get_the_ID(); ?>"><?php echo esc_html($title); ?></h2>
                        </a>
                    </li>
                    <?php endwhile; ?>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </ul>
            <!-- PAGINACIÓN -->
            <?php if ($query->max_num_pages > 1) : ?>
                <div class="gantz-paginador">
                    <?php
                    $current = max(1, $paged);
                    $total   = $query->max_num_pages;

                    $query_args = array_filter([
                        'buscar' => $search,
                        'vista'  => $vista,
                    ]);

                    /**
                     * Prev
                     */
                    $prev_url = $current > 1
                        ? add_query_arg(
                            $query_args,
                            get_pagenum_link($current - 1)
                        ) . '#archivo-galeria'
                        : '#';
                    ?>

                    <a
                        class="gantz-paginador__prev body-2 text-pb <?php echo $current === 1 ? 'is-disabled' : ''; ?>"
                        href="<?php echo esc_url($prev_url); ?>"
                    >
                        ← Anterior
                    </a>

                    <?php for ($i = 1; $i <= $total; $i++) : ?>

                        <?php
                        $url = add_query_arg(
                            $query_args,
                            get_pagenum_link($i)
                        ) . '#archivo-galeria';
                        ?>

                        <a
                            class="gantz-paginador__number body-1 body-bold text-pi <?php echo $i === $current ? 'is-active' : ''; ?>"
                            href="<?php echo esc_url($url); ?>"
                        >
                            <?php echo $i; ?>
                        </a>

                    <?php endfor; ?>

                    <?php
                    /**
                     * Next
                     */
                    $next_url = $current < $total
                        ? add_query_arg(
                            $query_args,
                            get_pagenum_link($current + 1)
                        ) . '#archivo-galeria'
                        : '#';
                    ?>

                    <a
                        class="gantz-paginador__next body-2 text-pb <?php echo $current === $total ? 'is-disabled' : ''; ?>"
                        href="<?php echo esc_url($next_url); ?>"
                    >
                        Siguiente →
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        GLightbox({
            selector: '.glightbox'
        });
    });

    document.querySelectorAll('.gantz-vista__opcion').forEach(btn => {

        btn.addEventListener('click', () => {

            const url = new URL(window.location.href);

            url.searchParams.set(
                'vista',
                btn.dataset.view
            );

            url.hash = 'archivo-galeria';

            window.location.href = url.toString();
        });

    });

    const input = document.querySelector('.gantz-search__input');

    input.addEventListener('search', function () {

        if (this.value !== '') {
            return;
        }

        const url = new URL(window.location.href);

        url.searchParams.delete('buscar');

        window.location.href = url.toString();
    });
</script>
<?php get_template_part('template-parts/footer'); ?>