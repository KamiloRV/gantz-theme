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
    <!-- Tipos de fisuras -->
    <section class="fisuras" aria-labelledby="titulo-fisuras">
        <?php  
        $fisuras = get_field('fisuras');
        ?>
        <div class="fisuras__contenido">
            <div class="fisuras__container container">
                <h2 class="fisuras__titulo" id="titulo-fisuras"><?php echo esc_html($fisuras['titulo']); ?></h2>
                
                <?php if ($fisuras['fisura']) : ?>
                    <ul class="fisuras__lista">
                        <?php foreach ($fisuras['fisura'] as $fisura) : ?>
                            <li class="fisuras__item">
                                <article class="fisura-card">
                                    <?php if ($fisura['imagen']) : ?>
                                        <img class="fisura-card__imagen" src="<?php echo esc_url($fisura['imagen']['url']); ?>" alt="<?php echo esc_attr($fisura['imagen']['alt']); ?>">
                                    <?php endif ?>
                                    <div class="fisura-card__contenido">
                                        <h3 class="fisura-card__titulo text-pb"><?php echo esc_html($fisura['titulo']); ?></h3>
                                        <div class="fisura-card__texto text-pb">
                                            <?php echo wp_kses_post($fisura['texto']); ?>
                                        </div>
                                    </div>
                                </article>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </div>
        </div>
    </section>
    <!-- La fisura -->
    <section class="la-fisura" aria-labelledby="titulo-lafisura">
        <?php 
        $lafisura = get_field('lafisura');
        ?>
        <h2 class="la-fisura__titulo container" id="titulo-lafisura"><?php echo esc_html($lafisura['titulo']) ?></h2>
        <div class="la-fisura__container container">
            <div class="la-fisura__contenido">
                <div class="la-fisura__texto">
                    <div class="la-fisura__parrafos body-2 text-pb">
                        <?php echo wp_kses_post($lafisura['texto']) ?>
                    </div>
                </div>
                <?php
                get_template_part(
                    'template-parts/components/button',
                    null,
                    [
                        'field_prefix' => 'lafisura_boton',
                        'class' => 'gantz-btn secondary-btn blue'
                    ]
                );
                ?>
            </div>
            <div class="la-fisura-testimonio">
                <?php 
                $testimonio = get_field('lafisura')['testimonio'];
                ?>
                <img class="la-fisura-testimonio__imagen" src="<?php echo esc_url($testimonio['imagen']['url']) ?>" alt="<?php echo esc_attr($testimonio['imagen']['alt']) ?>">
                <div class="la-fisura-testimonio__contenido">
                    <div class="la-fisura-testimonio__texto cita text-ac">
                        <?php echo wp_kses_post($testimonio['texto']) ?>
                    </div>
                    <div class="la-fisura-testimonio__info">
                        <p class="la-fisura-testimonio__nombre body-2 body-2-bold text-pi">
                            <?php echo esc_html($testimonio['nombre']) ?>
                        </p>
                        <p class="la-fisura-testimonio__cargo body-2 text-pb">
                            <?php echo esc_html($testimonio['cargo']) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Sindromes -->
    <section class="sindromes-asociados" aria-labelledby="titulo-sindromes">
        <?php 
        $sindromes = get_field('sindromes');
        ?>
        <div class="sindromes-asociados__container container">
            <div class="sindromes-asociados__contenido">
                <h2 class="sindromes-asociados__titulo" id="titulo-sindromes"><?php echo esc_html($sindromes['titulo']); ?></h2>
                <div class="sindromes-asociados__texto body-2 text-pb">
                    <?php echo wp_kses_post($sindromes['texto']); ?>
                </div>
            </div>
            <?php 
            $sindromesItems = get_field('sindromes')['group']['items'];
            ?>
            <?php if ($sindromesItems) : ?>
                <div class="sindromes-asociados__sindromes sindromes">
                    <!-- SELECT MOBILE -->
                    <div class="sindromes__mobile mobile">
                        <h3 class="mobile__titulo body-2 body-2-bold">
                            <?php echo esc_html(get_field('sindromes')['group']['titulo']); ?>
                        </h3>

                        <div class="mobile-select" data-custom-select>

                            <!-- BOTÓN -->
                            <button class="mobile-select__trigger" type="button" aria-expanded="false" aria-haspopup="listbox">
                                <span class="mobile-select__value">
                                    <?php echo esc_html($sindromesItems[0]['nombre']); ?>
                                </span>
                                <span class="mobile-select__icon" aria-hidden="true"></span>
                            </button>

                            <!-- DROPDOWN -->
                            <div class="mobile-select__dropdown" role="listbox">
                                <?php foreach ($sindromesItems as $index => $sindrome) : ?>
                                    <button class="mobile-select__option <?php echo $index === 0 ? 'is-active' : ''; ?>" type="button" role="option" data-select-option="<?php echo esc_attr($index); ?>">
                                        <?php echo esc_html($sindrome['nombre']); ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>

                            <!-- SELECT REAL (accesibilidad/form fallback) -->
                            <select id="sindrome-select" class="mobile-select__native sr-only">
                                <?php foreach ($sindromesItems as $index => $sindrome) : ?>
                                    <option value="<?php echo esc_attr($index); ?>">
                                        <?php echo esc_html($sindrome['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>


                    <!-- TABS DESKTOP -->
                    <div class="sindromes__desktop desktop">
                        <h3 class="desktop__titulo body-2 body-2-bold">
                            <?php echo esc_html(get_field('sindromes')['group']['titulo']); ?>
                        </h3>
                        <div class="desktop__tabs" role="tablist">
                            <?php foreach ($sindromesItems as $index => $sindrome) : ?>
                                <button class="desktop__tab chip text-pi <?php echo $index === 0 ? 'is-active' : ''; ?>" type="button" role="tab" data-tab="<?php echo esc_attr($index); ?>">
                                    <?php echo esc_html($sindrome['nombre']); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Contenido -->
                    <div class="sindromes__contenido">
                        <?php foreach ($sindromesItems as $index => $sindrome) : ?>
                            <article class="sindrome-panel <?php echo $index === 0 ? 'is-active' : ''; ?>" data-panel="<?php echo esc_attr($index); ?>">
                                <h3 class="sindrome-panel__titulo body-1 body-bold text-pb">
                                    <?php echo esc_html('Síndrome ' . $sindrome['nombre']); ?>
                                </h3>
                                <div class="sindrome-panel__description body-2 text-pb">
                                    <?php echo wp_kses_post(($sindrome['desc'])); ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- Preguntas frecuentes -->
    <section class="preguntas" aria-labelledby="titulo-preguntas">

    <?php
    $preguntasg = get_field('preguntas');
    ?>

    <div class="preguntas__container container">
        <div class="preguntas__contenido contenido">
            <?php
            $preguntas = $preguntasg['preguntas'];
            ?>
            <h2 class="preguntas__titulo" id="titulo-preguntas"><?php echo esc_html($preguntasg['titulo']); ?></h2>
            <?php if ($preguntas) : ?>
                <ul class="preguntas__lista">
                    <?php foreach ($preguntas as $index => $pregunta) :
                        $titulo   = $pregunta['pregunta'];
                        $contenido = $pregunta['respuesta'];

                        $is_first = $index === 0;
                    ?>
                        <li class="pregunta" id="pregunta-<?php echo $index; ?>">
                            <div class="pregunta__card">
                                <button class="pregunta__trigger" type="button" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="pregunta-panel-<?php echo $index; ?>" id="pregunta-trigger-<?php echo $index; ?>">
                                    <h3 class="pregunta__pregunta">
                                        <?php echo esc_html($titulo); ?>
                                    </h3>
                                    <span class="pregunta__icon" aria-hidden="true"></span>
                                </button>
                                <div class="pregunta__contenido" id="pregunta-panel-<?php echo $index; ?>" role="region" aria-labelledby="pregunta-trigger-<?php echo $index; ?>" <?php if (!$is_first) : ?> hidden <?php endif; ?>>
                                    <div class="pregunta__contenido-inner text-pb">
                                        <?php echo wp_kses_post(($contenido)); ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</section>
</main>

<?php if ($sindromesItems) : ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {

        /* Sindromes */
        const tabs = document.querySelectorAll('[data-tab]');
        const panels = document.querySelectorAll('[data-panel]');

        const customSelect = document.querySelector('[data-custom-select]');

        if (!customSelect) return;

        const trigger = customSelect.querySelector('.mobile-select__trigger');
        const value = customSelect.querySelector('.mobile-select__value');
        const options = customSelect.querySelectorAll('[data-select-option]');
        const nativeSelect = customSelect.querySelector('#sindrome-select');

        function activatePanel(id) {

            // contenido
            panels.forEach(panel => {
                panel.classList.toggle(
                    'is-active',
                    panel.dataset.panel === id
                );
            });

            // tabs desktop
            tabs.forEach(tab => {
                tab.classList.toggle(
                    'is-active',
                    tab.dataset.tab === id
                );
            });

            // opciones mobile
            options.forEach(option => {
                option.classList.toggle(
                    'is-active',
                    option.dataset.selectOption === id
                );

                updateVisibleLastItem();
            });

            // actualizar texto
            const activeOption = customSelect.querySelector(
                `[data-select-option="${id}"]`
            );

            if (activeOption) {
                value.textContent = activeOption.textContent;
            }

            // select real
            if (nativeSelect) {
                nativeSelect.value = id;
            }
        }

        // abrir/cerrar
        trigger.addEventListener('click', () => {

            const isOpen = customSelect.classList.contains('is-open');

            customSelect.classList.toggle('is-open');

            trigger.setAttribute(
                'aria-expanded',
                !isOpen
            );
        });

        // seleccionar opción
        options.forEach(option => {

            option.addEventListener('click', () => {

                const id = option.dataset.selectOption;

                activatePanel(id);

                customSelect.classList.remove('is-open');

                trigger.setAttribute(
                    'aria-expanded',
                    'false'
                );
            });

            updateVisibleLastItem();
        });

        // tabs desktop
        tabs.forEach(tab => {

            tab.addEventListener('click', () => {

                activatePanel(tab.dataset.tab);
            });
        });

        // cerrar afuera
        document.addEventListener('click', (event) => {

            if (!customSelect.contains(event.target)) {

                customSelect.classList.remove('is-open');

                trigger.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }
        });

        function updateVisibleLastItem() {

            const items = document.querySelectorAll('.mobile-select__option');

            items.forEach(item => {
                item.classList.remove('is-last-visible');
            });

            const visibles = [...items].filter(item => {
                return window.getComputedStyle(item).display !== 'none';
            });

            const ultimo = visibles[visibles.length - 1];

            if (ultimo) {
                ultimo.classList.add('is-last-visible');
            }
        }

        function updateSindromeHeight() {

        // solo desktop
        if (window.innerWidth < 1340) {

            // limpiar height inline en mobile/tablet
            document.querySelectorAll(
                '.sindromes__contenido'
            ).forEach(description => {
                description.style.height = '';
            });

            return;
        }

        const desktop = document.querySelector(
            '.sindromes__desktop'
        );

        const descriptions = document.querySelectorAll(
            '.sindromes__contenido'
        );

        if (!desktop) return;

        const height = desktop.offsetHeight;

        descriptions.forEach(description => {
            description.style.height = `${height}px`;
        });
    }

    window.addEventListener(
        'load',
        updateSindromeHeight
    );

    window.addEventListener(
        'resize',
        updateSindromeHeight
    );

        /* Preguntas */
        const triggers = document.querySelectorAll(
        '.pregunta__trigger'
        );

        triggers.forEach(trigger => {

            trigger.addEventListener('click', () => {

                const expanded =
                    trigger.getAttribute('aria-expanded') === 'true';

                const currentPanel = document.getElementById(
                    trigger.getAttribute('aria-controls')
                );

                // cerrar todos
                triggers.forEach(otherTrigger => {

                    otherTrigger.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    const otherPanel = document.getElementById(
                        otherTrigger.getAttribute('aria-controls')
                    );

                    otherPanel.hidden = true;
                });

                // abrir el actual si estaba cerrado
                if (!expanded) {

                    trigger.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                    currentPanel.hidden = false;
                }

                trigger?.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
    </script>
<?php endif; ?>
<?php get_template_part('template-parts/footer'); ?>