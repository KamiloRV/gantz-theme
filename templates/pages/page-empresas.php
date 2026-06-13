<?php get_template_part('template-parts/header'); ?>

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
    <!-- Involucra -->
    <section class="involucra-tu-empresa">
        <?php 
        $involucra = get_field('involucra');
        ?>
        <div class="involucra-tu-empresa__container container">
            <div class="involucra-tu-empresa__header">
                <h2 class="involucra-tu-empresa__titulo"><?php echo esc_html($involucra['titulo']) ?></h2>
                <h3 class="involucra-tu-empresa__subtitulo text-pb"><?php echo esc_html($involucra['subtitulo']) ?></h3>
                <div class="involucra-tu-empresa__texto">
                    <p class="body-2 text-pb"><?php echo esc_html($involucra['texto']) ?></p>
                </div>
            </div>
            <!-- Accesos rápidos -->
            <nav class="accesos" aria-labelledby="titulo-accesos">
                <div class="accesos__container container">
                    <h2 class="accesos__titulo body-1" id="titulo-accesos"><?php echo esc_html($involucra['accesos']) ?></h2>
                    <ul class="accesos__list">
                        <?php 

                        $accesos = [];

                        $formas = get_field('formas');

                        if (!empty($formas['lista'])) {

                            foreach ($formas['lista'] as $item) {

                                if (!empty($item['titulo'])) {
                                    $accesos[] = $item['titulo'];
                                }
                            }
                        }

                        $accesos[] = get_field('alternativas')['titulo'];
                        ?>
                        <?php foreach ($accesos as $acceso): ?>
                            <li class="accesos__item">
                                <a class="accesos__link chip" href="#<?php echo sanitize_title($acceso); ?>">
                                    <?php echo esc_html($acceso); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
        </div>
    </section>
    <!-- Formas -->
    <?php
    $formas = get_field('formas')['lista'];
    ?>

    <?php foreach ($formas as $forma): ?>
        <section class="forma <?php echo sanitize_title($forma['titulo']); ?>" id="<?php echo sanitize_title($forma['titulo']); ?>">
            <?php
            $imagen = $forma['imagen'];
            $titulo = $forma['titulo'];
            $texto  = $forma['texto'];
            $subtitulo = $forma['subtitulo'];
            $marcas = $forma['imagenes'];
            ?>
            <div class="forma__container container">
                <div class="forma__header">
                    <?php if ($imagen): ?>
                        <img class="forma__imagen" src="<?php echo esc_url($imagen['url']) ?>" alt="<?php echo esc_attr($imagen['alt']) ?>">
                    <?php endif; ?>
                    <div class="forma__descripcion">
                        <?php if ($titulo): ?>
                            <h3 class="forma__titulo <?php if (!$imagen): ?> text-center <?php endif; ?>"><?php echo esc_html($titulo); ?></h3>
                        <?php endif; ?>
                        <?php if ($texto): ?>
                            <div class="forma__texto body-1 text-pb <?php if (!$imagen): ?> text-center <?php endif; ?>">
                                <?php echo wp_kses_post($texto); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($marcas): ?>
                    <div class="forma__contenido">
                        <?php if ($subtitulo): ?>
                            <p class="forma__subtitulo body-1 body-bold text-pi"><?php echo esc_html($subtitulo); ?></p>
                        <?php endif; ?>
                        <div class="forma__marcas">
                            <?php foreach ($marcas as $marca): ?>
                                <img class="forma__marca" src="<?php echo esc_url($marca['url']) ?>" alt="<?php echo esc_attr($marca['alt']) ?>">
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php endforeach ?>   
    <!-- Otras alternativas -->
    <?php
    $alternativas = get_field('alternativas');
    ?> 
    <section class="forma <?php echo sanitize_title($alternativas['titulo']); ?>" id="<?php echo sanitize_title($alternativas['titulo']); ?>">
        <div class="forma__container container">
            <div class="forma__header">
                <?php if ($alternativas['imagen']): ?>
                    <img class="forma__imagen" src="<?php echo esc_url($alternativas['imagen']['url']) ?>" alt="<?php echo esc_attr($alternativas['imagen']['alt']) ?>">
                <?php endif; ?>
                <div class="forma__descripcion <?php if (!$alternativas['imagen']): ?> text-center <?php endif; ?>">
                <?php if ($alternativas['titulo']): ?>
                    <h3 class="forma__titulo"><?php echo esc_html($alternativas['titulo']); ?></h3>
                <?php endif; ?>
                <?php if ($alternativas['texto']): ?>
                    <div class="forma__texto body-1 text-pb">
                        <?php echo wp_kses_post($alternativas['texto']); ?>
                    </div>
                <?php endif; ?>
                <?php
                get_template_part(
                    'template-parts/components/button',
                    null,
                    [
                        'data' => $alternativas['boton'],
                        'class' => 'gantz-btn secondary-btn blue'
                    ]
                );
                ?>
            </div>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>