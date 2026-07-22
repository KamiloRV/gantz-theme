<?php get_template_part('template-parts/header'); ?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb', null, ['class' => 'absolute']); ?>
    <!-- Hero -->
    <section class="hero" aria-labelledby="titulo-hero">
        <?php 
        $hero = get_field('hero');
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
    <!-- Cronograma tratamiento -->
    <section class="cronograma-quirurgico" aria-labelledby="titulo-cronograma-quirurgico">
        <?php 
        $quirurgico = get_field('quirurgico'); 
        ?>
        <div class="cronograma-quirurgico__container container">
            <div class="cronograma-quirurgico__container-inner">
                <div class="cronograma-quirurgico__header">
                    <h2 class="cronograma-quirurgico__titulo" id="titulo-cronograma-quirurgico">
                        <?php echo esc_html($quirurgico['titulo']) ?>
                    </h2>
                    <div class="cronograma-quirurgico__descripcion body-2 text-pb">
                        <?php echo wp_kses_post($quirurgico['desc']) ?>
                    </div>
                </div>
                <div class="cronograma-quirurgico__contenido">
                    <?php 
                    $timeline = get_field('quirurgico')['items']; 
                    ?>
                    <?php if ($timeline): ?>
                        <ul class="cronograma-quirurgico__timeline timeline">
                            <?php foreach ($timeline as $item): ?>
                                <li class="timeline__item">
                                    <div class="timeline__card">
                                        <h3 class="timeline__titulo">
                                            <span class="timeline__desde">
                                                <?php echo esc_html($item['edad']['desde']); ?>
                                                <span aria-hidden="true" focusable="false" class="timeline__periodo-inner body-1 body-bold text-pb">
                                                    <?php echo esc_html($item['edad']['selector']); ?>
                                                </span>
                                            </span>
                                            <span class="timeline__hasta">
                                                <?php
                                                if (
                                                    $item['edad']['hasta'] == 18 &&
                                                    $item['edad']['selector'] === 'Años'
                                                ) :
                                                    echo esc_html('+' . $item['edad']['hasta']);
                                                else :
                                                    echo esc_html($item['edad']['hasta']);
                                                endif;
                                                ?>
                                                <span aria-hidden="true" focusable="false" class="timeline__periodo-inner body-1 body-bold text-pb">
                                                    <?php echo esc_html($item['edad']['selector']); ?>
                                                </span>
                                            </span>
                                            <span class="timeline__periodo">
                                                <?php echo esc_html($item['edad']['selector']); ?>
                                            </span>
                                        </h3>
                                        <div class="timeline__desktop-separator">
                                        </div>
                                        <div class="timeline__descripcion descripcion">
                                            <h4 class="descripcion__titulo body-2 body-2-bold text-pb">
                                                <?php echo esc_html($item['titulo']) . ':'; ?>
                                            </h4>
                                            <div class="descripcion__texto body-2 text-pb">
                                                <?php echo wp_kses_post($item['descripcion']); ?>
                                            </div>
                                        </div>
                                    </div>

                                </li>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Cronograma rehabilitación del tratamiento -->
    <section class="cronograma-rehabilitacion" aria-labelledby="titulo-cronograma-rehabilitacion">
        <div class="cronograma-rehabilitacion__container container">
            <div class="cronograma-rehabilitacion__container-inner container-inner">
                <div class="cronograma-rehabilitacion__container-inner">
                    <div class="cronograma-rehabilitacion__header">
                        <h2 class="cronograma-rehabilitacion__titulo text-center mb-5">
                            Cronograma de rehabilitación<br> y seguimiento en fisura labiopalatina
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="cronograma-rehabilitacion__caja mb-4 border bg-white">
                                <h3 class="cronograma-rehabilitacion__subtitulo">Especialidades <span class="d-block h4 mt-2 fw-semibold">15</span></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="cronograma-rehabilitacion__caja mb-4 border bg-white">
                                <h3 class="cronograma-rehabilitacion__subtitulo">Total de visitas <span class="d-block h4 mt-2 fw-semibold">120</span></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="cronograma-rehabilitacion__caja mb-4 border bg-white">
                                <h3 class="cronograma-rehabilitacion__subtitulo">Inicio del tratamiento <span class="d-block h4 mt-2 fw-semibold">Mes 1</span></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="cronograma-rehabilitacion__caja mb-4 border bg-white">
                                <h3 class="cronograma-rehabilitacion__subtitulo">Seguimiento hasta <span class="d-block h4 mt-2 fw-semibold">18 años</span></h3>
                            </div>
                        </div>
                    </div>
                    
                    <img src="https://gantz.cl/wp-content/themes/gantz/assets/images/cronograma-rehabilitacion.png" class="d-none d-md-block w-100 mb-4">
                    <p class="cronograma-rehabilitacion__nota text-center">Este cronograma es una guía orientativa. El tratamiento específico debe ser personalizado según las necesidades de cada paciente.</p>
                    <a class="gantz-btn secondary-btn blue d-flex d-md-none text-center my-4" href="https://gantz.cl/wp-content/uploads/2026/07/infografia-cronograma.pdf" target="_blank" rel="noopener noreferrer">

                        <svg aria-hidden="true" focusable="false">
                            <use href="https://gantz.cl/wp-content/themes/gantz/assets/images/icons.svg#download"></use>
                        </svg>
        
                        Descargar documento
                    </a>  
                </div>
            </div>
        </div>
    </section>
    <!-- Guía para padres -->
    <section class="guia" aria-labelledby="titulo-guia">
        <?php 
        $guia = get_field('guia'); 
        ?>
        <div class="guia__container container">
            <div class="guia__container-inner container-inner">
                <?php if ($guia['imagen']) : ?>
                    <div class="guia__portada">
                        <img class="imagen" src="<?php echo esc_url($guia['imagen']['url']) ?>" alt="<?php echo esc_attr($guia['imagen']['alt']) ?>">
                    </div>
                <?php endif; ?>
                <h2 class="guia__titulo">
                    <?php echo esc_html($guia['titulo']) ?>
                </h2>
                <div class="guia__contenido">
                    <div class="guia__texto">
                        <div class="guia__descripcion body-2 text-pb">
                            <?php echo wp_kses_post($guia['texto']); ?>
                        </div>
                    </div>
                    <?php
                    get_template_part(
                        'template-parts/components/button',
                        null,
                        [
                            'field_prefix' => 'guia_boton',
                            'class' => 'gantz-btn secondary-btn blue'
                        ]
                    );
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>
