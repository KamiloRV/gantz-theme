<?php get_template_part('template-parts/header'); ?>

<?php 
// Variables de la noticia
$category = get_field('categoria') ?? null;
$title = get_the_title() ?? 'Sin titulo';
$tags = get_field('etiquetas');
$date = get_the_date('j F \d\e Y');
$datetime = get_the_date('Y-m-d');
$image = get_field('imagen');
$lead = get_field('bajada') ?? 'Sin bajada';
$body = get_field('detalle') ?? 'Sin cuerpo';
$gallery = get_field('activar_galeria');
$galleryID = get_field('galeria');
?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb'); ?>
    <div class="container">
        <article class="noticia" aria-labelledby="new-title">
            <header class="noticia__titular">
                <?php
                $noticias_url = get_permalink(
                    get_page_by_path('noticias')
                );
                ?>

                <p class="noticia__categoria body-1">
                    <?php if ($category) : ?>
                        <a
                            class="body-1"
                            href="<?php echo esc_url(
                                add_query_arg(
                                    'categoria',
                                    $category->slug,
                                    $noticias_url
                                ) . '#archivo-noticias'
                            ); ?>"
                        >
                            <?php echo esc_html($category->name); ?>
                        </a>
                    <?php else : ?>
                        <span class="body-1">Sin categoría</span>
                    <?php endif; ?>
                </p>

                <h1 id="new-title" class="noticia__titulo h3">
                    <?php echo esc_html($title); ?>
                </h1>

                <ul class="noticia__etiquetas">
                    <?php if( $tags ): ?>
                        <?php foreach ($tags as $tag) : ?>
                            <li class="etiqueta nota"><?php echo $tag->name; ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </header>

            <figure class="noticia__imagen">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            </figure>

            <section class="noticia__contenido">
                <p class="noticia__fecha nota">
                    <time datetime="<?php echo esc_attr($datetime); ?>">
                        Publicado el <?php echo esc_html($date); ?>
                    </time>
                </p>

                <p class="noticia__bajada body-1 body-bold">
                    <?php echo esc_html($lead); ?>
                </p>

                <div class="noticia__cuerpo body-2">
                    <?php echo wp_kses_post($body); ?>
                </div>
            </section>
            
            <?php if ($gallery === 'on' && $galleryID) : ?>
                <?php
                $fotos = get_field(
                    'fotos',
                    $galleryID
                );
                ?>
                <section class="noticia__galeria galeria" id="galeria" aria-labelledby="gallery-title">
                    <h3 class="galeria__titulo" id="gallery-title">Galería de imágenes</h3>
                    <ul class="galeria__lista">
                        <?php foreach ($fotos as $foto) : ?>
                            <li class="galeria__item">
                                <a href="<?php echo esc_url($foto['url']); ?>" class="glightbox" data-gallery="noticia">
                                    <img class="galeria__imagen" src="<?php echo esc_url($foto['url']) ?>" alt="<?php echo esc_attr($foto['alt']) ?>">
                                </a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <?php if (count($fotos) > 2) : ?>
                        <button class="gantz-btn secondary-btn blue galeria__toggle" type="button" aria-expanded="false">
                            Ver todas las fotos →
                        </button>
                    <?php endif; ?>
                </section>
            <?php endif ?>
            
        </article>
    </div>

    <aside class="noticias-relacionadas" aria-labelledby="related-news-title">
        <div class="container">
            <h2 id="related-news-title" class="noticias-relacionadas__titulo">Noticias relacionadas</h2>
            <ul class="noticias-relacionadas__lista">
                <?php
                $categories = wp_get_post_terms(get_the_ID(), 'categoria', ['fields' => 'ids']);

                $args = [
                    'post_type'      => 'noticia',
                    'posts_per_page' => 3,
                    'post_status'    => 'publish',
                    'post__not_in'   => [get_the_ID()],
                    'tax_query'      => [
                        [
                            'taxonomy' => 'categoria',
                            'field'    => 'term_id',
                            'terms'    => $categories,
                        ]
                    ],
                ];

                $noticias = new WP_Query($args);
                ?>

                <?php if ($noticias->have_posts()) : ?>
                    <?php while ($noticias->have_posts()) : 
                        $noticias->the_post(); 
                        $terms = get_the_terms(get_the_ID(), 'categoria'); 
                        $category = (!empty($terms) && !is_wp_error($terms)) ? $terms[0]->name : 'Sin categoría';
                        $imagen = get_field('imagen');
                        $title = get_the_title(); ?>

                        <li class="noticias-relacionadas__item">
                            <article class="card-noticia">
                                <a class="card-noticia__link" href="<?php the_permalink(); ?>">
                                    <img 
                                        class="card-noticia__imagen"
                                        src="<?php echo esc_url($imagen['url']); ?>"
                                        alt="<?php echo esc_attr($imagen['alt']); ?>"
                                    >

                                    <div class="card-noticia__contenido">
                                        <h3 class="card-noticia__titulo body-2 body-2-bold">
                                            <?php echo esc_html($title); ?>
                                        </h3>

                                        <span class="card-noticia__categoria nota">
                                            <?php echo esc_html($category); ?>
                                        </span>
                                    </div>
                                </a>
                            </article>
                        </li>

                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </ul>
        </div>
    </aside>
    
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });

    const galeria = document.querySelector('.galeria');
    const boton = document.querySelector('.galeria__toggle');

    if (galeria && boton) {
        const totalImages = galeria.querySelectorAll('.galeria__item').length;
        /* console.log(totalImages); */

        const updateButton = () => {
            const isDesktop = window.matchMedia('(min-width: 1200px)').matches;

            boton.hidden = isDesktop
                ? totalImages <= 3
                : totalImages <= 2;
        };

        updateButton();
        window.addEventListener('resize', updateButton);

        boton.addEventListener('click', () => {

            galeria.classList.toggle('is-open');

            const abierta = galeria.classList.contains('is-open');

            boton.textContent = abierta
                ? 'Ver menos'
                : 'Ver todas las fotos →';

            boton.setAttribute(
                'aria-expanded',
                abierta
            );

            if (!abierta) {
                requestAnimationFrame(() => {
                    document.getElementById('galeria')
                        ?.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                });
            }
        });
    }
</script>
<?php get_template_part('template-parts/footer'); ?>