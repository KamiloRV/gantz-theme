<?php get_template_part('template-parts/header'); ?>

<?php 
// Variables reutilizables para el footer
$site_name = get_field('ajustes_name', 'option');
$directory_uri = get_template_directory_uri();
$home_url = esc_url(home_url('/'));
$logo = get_field('ajustes_logo', 'option')['url'];
$cta_text = get_field('cta_text', 'option');
$cta_url = get_field('cta_url', 'option');
$cta_label = get_field('cta_label', 'option'); 
?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb'); ?>

    <div class="search-page container">
        <!-- Buscador -->
        <form class="search-page__form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">

            <label class="screen-reader-text" for="search-input">
                ¿Buscas algo en particular?
            </label>

            <input type="search" id="search-input" class="search-page__input" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="¿Buscas algo en particular?">

            <button type="submit" class="search-page__submit" aria-label="Buscar">
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#search'); ?>"></use>
                </svg>
            </button>

        </form>

        <!-- Encabezado -->
        <div class="search-page__header">

            <h1 class="search-page__title h3">
                <svg aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#search'); ?>"></use>
                </svg>
                <span><span class="result">Resultados para</span> “<?php echo esc_html(get_search_query()); ?>”</span>
            </h1>

            <?php if (have_posts()) : ?>

                <h4 class="search-page__count">

                    <?php
                    global $wp_query;

                    $total = $wp_query->found_posts;

                    printf(
                        '%d %s',
                        $total,
                        $total === 1
                            ? 'coincidencia'
                            : 'coincidencias'
                    );
                    ?>

                </h4>

            <?php endif; ?>

        </div>

        <!-- Posts -->
        
        <!-- Tags de resultados -->
        <?php
            defined('ABSPATH') || exit;

            /**
             * Devuelve el nombre que se mostrará como tipo
             * para un resultado de búsqueda.
             *
             * @return string
             */
            function gantz_get_search_result_type()
            {
                $post_type = get_post_type();

                $types = [
                    'noticia' => 'Noticia',
                    'page' => 'Página',
                    'galeria-de-fotos' => 'Archivo fotográfico',
                    'galeria-de-videos' => 'Archivo videográfico',
                    'especialidad' => 'Especialidad',
                    'publicacion' => 'Publicación',
                    'experto' => 'Experto'

                    // Agregar aquí los CPT del sitio.
                    /* 'archivo_fotografico' => 'Archivo fotográfico',
                    'archivo_videografico' => 'Archivo videográfico',
                    'especialidades' => 'Especialidades', */
                ];

                return $types[$post_type]
                    ?? 'Contenido';
            }
        ?>    

        <!-- Función para obtener el ID de YouTube -->
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

        <?php if (have_posts()) : ?>

            <div class="search-results">

                <?php while (have_posts()) : the_post(); ?>

                    <?php
                    $post_type = get_post_type();
                    $result_url = get_permalink();

                    switch ($post_type) {

                        case 'publicacion':
                            $archivolink = get_field('archivolink');

                            if (!empty($archivolink)) {
                                $tipo = $archivolink['tipo'] ?? '';

                                if ($tipo === 'link') {
                                    $result_url = $archivolink['link'] ?? '';
                                } elseif ($tipo === 'file') {
                                    $file = $archivolink['file'] ?? '';

                                    if (is_array($file)) {
                                        $result_url = $file['url'] ?? '';
                                    } else {
                                        $result_url = $file;
                                    }
                                }
                            }
                            break;


                        case 'galeria-de-videos':
                            // Reemplaza 'video' por el nombre real de tu campo ACF.
                            $video_url = get_field('video');
                            $video_id = get_youtube_id($video_url);
                            $embed_url = "https://www.youtube.com/embed/{$video_id}";

                            if ($embed_url) {
                                $result_url = $embed_url;
                            }

                            break;


                        case 'experto':
                            $expertos_page = get_page_by_path('nuestro-equipo');

                            if ($expertos_page) {
                                $result_url = get_permalink($expertos_page->ID)
                                    . '#experto-' . get_the_ID();
                            }

                            break;

                        case 'especialidad':
                            $especialidades_page = get_page_by_path('especialidades');

                            if ($especialidades_page) {
                                $result_url = get_permalink($especialidades_page->ID)
                                    . '#' . sanitize_title(get_the_title());
                            }
                            break;
                    }
                    ?>

                    <a class="search-result <?php if ($post_type === 'galeria-de-videos') : ?>glightbox<?php endif; ?>" href="<?php echo esc_url($result_url); ?>" <?php if ($post_type === 'galeria-de-videos') : ?>data-gallery="videos"<?php endif; ?>>
                        <article>
                            <p class="search-result__type body-bold text-pb">
                                <?php echo esc_html(gantz_get_search_result_type()); ?>
                            </p>


                            <div class="search-result__content">
                                <h4 class="search-result__title text-pi">
                                    <?php the_title(); ?>
                                </h4>

                                <?php if (has_excerpt()) : ?>
                                    <div class="search-result__excerpt body-2 text-pi">
                                        <?php the_excerpt(); ?>
                                    </div>
                                <?php elseif (get_the_content()) : ?>
                                    <div class="search-result__excerpt">
                                        <?php
                                        echo esc_html(
                                            wp_trim_words(
                                                wp_strip_all_tags(get_the_content()),
                                                30,
                                                '...'
                                            )
                                        );
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    </a>

                <?php endwhile; ?>

            </div>


            <!-- Paginador -->
            <?php if ($wp_query->max_num_pages > 1) : ?>
                <div class="gantz-paginador">

                    <?php
                    $current = max(1, get_query_var('paged'));
                    $total   = $wp_query->max_num_pages;
                    /*
                    * Conservamos el término de búsqueda al cambiar de página.
                    */
                    $query_args = array_filter([
                        's' => get_search_query(),
                    ]);
                    /**
                     * Prev
                     */
                    $prev_url = $current > 1
                        ? add_query_arg(
                            $query_args,
                            get_pagenum_link($current - 1)
                        )
                        : '#';
                    /**
                     * Next
                     */
                    $next_url = $current < $total
                        ? add_query_arg(
                            $query_args,
                            get_pagenum_link($current + 1)
                        )
                        : '#';
                    ?>

                    <!-- Botón Anterior -->
                    <a class="gantz-paginador__prev body-2 text-pb <?php echo $current === 1 ? 'is-disabled' : ''; ?>" href="<?php echo esc_url($prev_url); ?>" aria-label="Página anterior">
                        <span class="gantz-paginador__arrow-mobile" aria-hidden="true">«</span>

                        <span class="gantz-paginador__text-desktop">
                            ← Anterior
                        </span>
                    </a>


                    <?php
                    /*
                    * Cantidad de páginas vecinas que mostramos.
                    */
                    $VECINOS_MOBILE  = 1;
                    $VECINOS_DESKTOP = 2;
                    ?>


                    <?php for ($i = 1; $i <= $total; $i++) : ?>

                        <?php
                        /*
                        * URL de cada página.
                        *
                        * Conservamos ?s=termino para que la búsqueda
                        * continúe al cambiar de página.
                        */
                        $url = add_query_arg(
                            $query_args,
                            get_pagenum_link($i)
                        );


                        /*
                        * Páginas visibles en mobile.
                        */
                        $mostrar_en_mobile = (
                            $i === 1
                            || $i === $total
                            || abs($i - $current) <= $VECINOS_MOBILE
                        );


                        /*
                        * Páginas visibles en desktop.
                        */
                        $mostrar_en_desktop = (
                            $i === 1
                            || $i === $total
                            || abs($i - $current) <= $VECINOS_DESKTOP
                        );


                        /*
                        * Determinar si necesitamos mostrar "…"
                        * antes de esta página en mobile.
                        */
                        $anterior_visible_mobile = (
                            $i - 1 === 1
                            || abs(($i - 1) - $current) <= $VECINOS_MOBILE
                        );

                        $mostrar_puntos_mobile = (
                            $mostrar_en_mobile
                            && $i > 1
                            && !$anterior_visible_mobile
                        );


                        /*
                        * Determinar si necesitamos mostrar "…"
                        * antes de esta página en desktop.
                        */
                        $anterior_visible_desktop = (
                            $i - 1 === 1
                            || abs(($i - 1) - $current) <= $VECINOS_DESKTOP
                        );

                        $mostrar_puntos_desktop = (
                            $mostrar_en_desktop
                            && $i > 1
                            && !$anterior_visible_desktop
                        );
                        ?>


                        <?php if ($mostrar_puntos_mobile) : ?>

                            <span class="gantz-paginador__dots gantz-paginador__dots--mobile" aria-hidden="true">
                                …
                            </span>

                        <?php endif; ?>

                        <?php if ($mostrar_puntos_desktop) : ?>

                            <span class="gantz-paginador__dots gantz-paginador__dots--desktop" aria-hidden="true">
                                …
                            </span>

                        <?php endif; ?>

                        <a class="gantz-paginador__number body-1 body-bold text-pi <?php echo $i === $current ? 'is-active' : ''; ?>
                                <?php echo $mostrar_en_mobile ? 'is-visible-mobile' : 'is-hidden-mobile'; ?>
                                <?php echo $mostrar_en_desktop ? 'is-visible-desktop' : 'is-hidden-desktop'; ?>
                            "
                            href="<?php echo esc_url($url); ?>"
                            <?php echo $i === $current ? 'aria-current="page"' : ''; ?>
                        >
                            <?php echo esc_html($i); ?>
                        </a>

                    <?php endfor; ?>


                    <!-- Botón Siguiente -->
                    <a
                        class="gantz-paginador__next body-2 text-pb <?php echo $current === $total ? 'is-disabled' : ''; ?>"
                        href="<?php echo esc_url($next_url); ?>"
                        aria-label="Página siguiente"
                    >
                        <span class="gantz-paginador__text-desktop">
                            Siguiente →
                        </span>

                        <span
                            class="gantz-paginador__arrow-mobile"
                            aria-hidden="true"
                        >
                            »
                        </span>
                    </a>

                </div>

            <?php endif; ?>


        <?php else : ?>


            <!-- Sin resultados -->
            <section class="search-page__empty">

                <h2>
                    No encontramos resultados
                </h2>

                <p>
                    No encontramos contenido relacionado con
                    <strong>
                        “<?php echo esc_html(get_search_query()); ?>”
                    </strong>.
                </p>

            </section>


        <?php endif; ?>

        
    </div>
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