<?php get_template_part('template-parts/header'); ?>

<?php 
// Variables de la galeria
$title = get_the_title() ?? 'Sin titulo';
$tags = get_field('etiquetas');
$date = get_the_date('j F \d\e Y');
$datetime = get_the_date('Y-m-d');
$fotos = get_field('fotos');
?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb'); ?>
    <section class="galeria-de-fotos" aria-labelledby="titulo-galeria">
        <div class="galeria-de-fotos__container container">
            <h1 class="galeria-de-fotos__titulo h2" id="titulo-galeria"><?php echo esc_html($title); ?></h1>
            <ul class="galeria-de-fotos__lista">
                <?php
                $total = count($fotos);

                $initial_target = $total > 20
                    ? 19 // imagen 20
                    : $total - 1;
                ?>
                <?php foreach ($fotos as $index => $foto) : ?>
                    <li class="galeria-de-fotos__item" <?php echo $index === $initial_target ? 'id="ultima-imagen"' : ''; ?>>
                        <a href="<?php echo esc_url($foto['url']); ?>" class="glightbox" data-gallery="fotos">
                            <img class="galeria-de-fotos__imagen" src="<?php echo esc_url($foto['url']) ?>" alt="<?php echo esc_attr($foto['alt']) ?>">
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
            <?php if (count($fotos) > 20) : ?>
                <button id="galeria-de-fotos" class="gantz-btn secondary-btn blue galeria__toggle" type="button" aria-expanded="false">
                    Ver todas las fotos →
                </button>
            <?php endif; ?>
        </div>
    </section>
</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });

    const galeria = document.querySelector('.galeria-de-fotos__lista');
    const boton = document.querySelector('.galeria__toggle');

    if (galeria && boton) {
        const images = galeria.querySelectorAll('.galeria-de-fotos__item');

        const totalImages = images.length;

        boton.addEventListener('click', () => {
            galeria.classList.toggle('is-open');

            const abierta = galeria.classList.contains('is-open');

            const actual = document.getElementById('ultima-imagen');

            if (actual) {
                actual.removeAttribute('id');
            }

            if (abierta) {
                images[totalImages - 1]?.setAttribute('id', 'ultima-imagen');
            } else {
                const target = totalImages > 20 ? 19 : totalImages - 1;

                images[target]?.setAttribute('id', 'ultima-imagen');

                document.getElementById('ultima-imagen')
                ?.scrollIntoView({
                    behavior: 'smooth'
                });
            }

            boton.textContent = abierta ? 'Ver menos' : 'Ver todas las fotos →';

            boton.setAttribute('aria-expanded', abierta);
        })
    }
</script>
<?php get_template_part('template-parts/footer'); ?>