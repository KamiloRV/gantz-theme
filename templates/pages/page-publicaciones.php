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
                    <div class="hero__texto body-bold text-pb">
                        <?php echo wp_kses_post($hero['texto']) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Todas las publicaciones -->
    <section class="archivo-publicaciones" aria-labelledby="titulo-archivo" id="archivo-publicaciones">
        <div class="archivo-publicaciones__container container">
            <div class="archivo-publicaciones__header">
                <h2 class="archivo-publicaciones__titulo">Todas las publicaciones</h2>
                <?php $search = sanitize_text_field($_GET['buscar'] ?? ''); ?>
                <form class="gantz-search filtros-form" method="GET" action="<?php echo esc_url(get_permalink() . '#archivo-publicaciones'); ?>">
                    <input class="gantz-search__input body-2 text-mb" type="search" name="buscar" placeholder="¿Buscas algo en particular?" value="<?php echo esc_attr($search); ?>">
                    <button class="gantz-search__submit" type="submit" aria-label="Buscar">
                        <svg aria-hidden="true" focusable="false">
                            <use href="<?php echo esc_url($directory_uri . '/assets/images/icons.svg#search'); ?>" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="archivo-publicaciones__lista lista">
                <?php 
                $paged = max(1, get_query_var('paged'));

                $posts_per_page = wp_is_mobile() ? 10 : 16;

                $args = [
                    'post_type'      => 'publicacion',
                    'post_status'    => 'publish',
                    'posts_per_page' => $posts_per_page,
                    'paged'          => $paged,
                    's'              => $search,
                ];

                $query = new WP_Query($args);
                ?>

                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : ?>
                        <?php
                        $query->the_post();

                        $title  = get_the_title();
                        $autors = get_field('autores') ?: [];
                        $public = get_field('publicado');
                        $volume = get_field('volumen');
                        $year   = get_field('year');
                        $final_year = $year === 'post_date' ? get_the_date('Y') : $year;
                        
                        $archiveorlink = get_field('archivolink');

                        $type = $archiveorlink['tipo'] ?? '';
                        $link = $archiveorlink['link'] ?? '#';
                        $file = $archiveorlink['file'] ?? null;

                        if ($type === 'file' && $file) {
                            $link = $file;
                        }

                        $publicacion = [];

                        if ($public) {
                            $publicacion[] = $public;
                        }

                        if ($volume) {
                            $publicacion[] = $volume;
                        }

                        if ($final_year) {
                            $publicacion[] = $final_year;
                        }

                        $texto_publicacion = implode(' ', $publicacion);

                        $autors_strings = '';

                        if (!empty($autors)) {
                            $autors_strings = implode(
                                ', ',
                                array_column($autors, 'nombre')
                            );
                        }
                        ?>

                        <article class="lista__item item">
                            <div class="item__info">
                                <h3 class="item__titulo body-1 body-bold text-pi"><?php echo esc_html($title); ?></h3>
                                <?php if ($autors_strings) : ?>
                                    <p class="item__autores body-2 body-2-bold text-pb"><?php echo esc_html($autors_strings); ?></p>
                                <?php endif; ?>
                                <?php if ($public) : ?>
                                    <p class="item__publicacion nota text-pb">
                                        Publicado en: <?php echo esc_html($texto_publicacion); ?>.
                                    </p>
                                <?php endif; ?>
                            </div>

                            <a class="item__enlace" href="<?php echo esc_url($link); ?>" target="_blank" rel="noopener noreferrer">
                                Ver publicación →
                            </a>
                        </article>

                    <?php endwhile; ?>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            </div>
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

<script>
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