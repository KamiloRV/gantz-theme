<?php get_template_part('template-parts/header'); ?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb'); ?>
    <div class="hero">
        <div class="hero__container container">
            <h1 class="hero__titulo"><?php the_title(); ?></h1>
            <?php echo do_shortcode('[contact-form-7 id="892a5c0" title="Comentarios"]'); ?>
        </div>
    </div>
    <!-- <div class="gantz-form">
        <div class="gantz-form-inner">
            <div class="gantz-form-group">
                <p class="rotulo-pequeno text-pi">Datos del paciente</p>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="nombres-paciente">Nombre(s)</label>
                    [text* nombres-paciente autocomplete:off class:gantz-form-input class:body-2 id:nombres-paciente
                    placeholder "ej. José Miguel"]
                </div>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="apellidos-paciente">Apellido(s)</label>
                    [text* apellidos-paciente autocomplete:off class:gantz-form-input class:body-2 id:apellidos-paciente
                    placeholder "ej. Rivera Fuentes"]
                </div>
            </div>
            <div class="gantz-form-group">
                <p class="rotulo-pequeno text-pi">Datos del cuidador/a</p>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="nombres-cuidador">Nombre(s)</label>
                    [text* nombres-cuidador autocomplete:given-name class:gantz-form-input class:body-2 id:nombres-cuidador
                    placeholder "ej. José Miguel"]
                </div>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="apellidos-cuidador">Apellido(s)</label>
                    [text* apellidos-cuidador autocomplete:family-name class:gantz-form-input class:body-2 id:apellidos-cuidador
                    placeholder "ej. Rivera Fuentes"]
                </div>
                <div class="gantz-form-field gantz-form-field--tel gantz-form-field__xl-mid body-2">
                    <label class="gantz-form-label body-2 body-2-bold" for="telefono-cuidador">Teléfono</label>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 16"><path fill="#fff" fill-rule="evenodd" d="M8.067 0H22v8H8.067z" clip-rule="evenodd"/><path fill="#0039a6" fill-rule="evenodd" d="M0 0h8.25v8H0z" clip-rule="evenodd"/><path fill="#fff" fill-rule="evenodd" d="M5.408 5.99 4.13 5.063 2.858 6l.474-1.525-1.27-.94 1.57-.016L4.119 2l.5 1.516 1.569.003-1.264.95z" clip-rule="evenodd"/><path fill="#d52b1e" fill-rule="evenodd" d="M0 8h22v8H0z" clip-rule="evenodd"/></svg>
                    [tel* telefono autocomplete:tel class:gantz-form-input id:telefono-cuidador minlength:9 maxlength:9 placeholder "9 1234 5678"]
                </div>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="correo-cuidador">Correo electrónico</label>
                    [email* correo autocomplete:email class:gantz-form-input class:body-2 id:correo-cuidador placeholder "ej. correo.electronico@gmail.com"]
                </div>
            </div>
            <div class="gantz-form-group">
                <p class="rotulo-pequeno text-pi">Domicilio de paciente o cuidador/a</p>
                <div class="gantz-form-field gantz-form-field-select gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="region">Región</label>
                    [select* region autocomplete:address-level1 class:gantz-form-input id:region first_as_label "Selecciona la región donde vives" "Región de Antofagasta" "Región de Arica y Parinacota" "Región de Atacama" "Región de Aysén del General Carlos Ibáñez del Campo" "Región de Aysén del General Carlos Ibáñez del Campo" "Región de Coquimbo" "Región de La Araucanía" "Región del Maule" "Región de Los Lagos" "Región de Los Ríos" "Región Metropolitana de Santiago" "Región de Magallanes y de la Antártica Chilena" "Región de Ñuble" "Los Lagos" "Región de Tarapacá" "Región de Valparaíso"]
                </div>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="comuna">Comuna</label>
                    [text* comuna autocomplete:address-level2 class:gantz-form-input class:body-2 id:comuna
                    placeholder "ej. Pudahuel"]
                </div>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="calle">Calle</label>
                    [text* calle autocomplete:address-line1 class:gantz-form-input class:body-2 id:calle
                    placeholder "ej. El Lazo"]
                </div>
                <div class="gantz-form-field-double">
                    <div class="gantz-form-field">
                        <label class="gantz-form-label body-2 body-2-bold" for="numero-casa">Número</label>
                        [number* numero-casa autocomplete:off class:gantz-form-input class:body-2 id:numero-casa min:1 placeholder "ej. 1234"]
                    </div>
                    <div class="gantz-form-field">
                        <label class="gantz-form-label body-2 body-2-bold" for="dep">Torre / Departamento</label>
                        [text* dep autocomplete:address-line2 class:gantz-form-input class:body-2 id:dep
                        placeholder "Torre A, Dpto 101"]
                    </div>
                </div>
            </div>
            <div class="gantz-form-group">
                <p class="rotulo-pequeno text-pi">Sobre el reclamo, felicitación o sugerencia</p>
                <div class="gantz-form-field gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="area">Área, dependencia o persona a la que se dirige</label>
                    [text* area autocomplete:off class:gantz-form-input class:body-2 id:area
                    placeholder "ej. Área Dental"]
                </div>
                <div class="gantz-form-field gantz-form-field--date gantz-form-field__xl-mid">
                    <label class="gantz-form-label body-2 body-2-bold" for="fecha">Fecha</label>
                    [date* fecha class:gantz-form-input id:fecha]
                </div>
                <div class="gantz-form-field">
                    <label class="gantz-form-label body-2 body-2-bold" for="motivo">Motivo</label>
                    [text* motivo autocomplete:off class:gantz-form-input class:body-2 id:motivo
                    placeholder "Motivo de contacto (felicitaciones al equipo de fonoaudiología, reclamo por atención en caja, etcétera)"]
                </div>
                <div class="gantz-form-field gantz-form-field--area">
                    <label class="gantz-form-label body-2 body-2-bold" for="mensaje">Comentario</label>
                    [textarea* your-message placeholder class:gantz-form-input class:body-2
                    id:comentario "Cuéntanos en detalle el motivo del comentario."]
                </div>
            </div>
            <div class="gantz-form-field gantz-form-field--btn">
                <p class="gantz-form-required body-2 body-2-bold text-pb m-0">Todos los campos son obligatorios</p>
                [submit class:gantz-btn "Enviar mensaje"]
            </div>
        </div>
    </div> -->
</main>

<script>
    document.querySelectorAll('.wpcf7-select').forEach(select => {
        const custom = document.createElement('div');

        custom.className = 'gantz-form-input gantz-custom-select';

        const options = [...select.options];

        custom.innerHTML = `
            <button
                type="button"
                class="gantz-custom-select__trigger"
            >
                ${options[0].text}
            </button>

            <ul class="gantz-custom-select__list"></ul>
        `;

        const trigger = custom.querySelector(
            '.gantz-custom-select__trigger'
        );

        const list = custom.querySelector(
            '.gantz-custom-select__list'
        );

        options.forEach(option => {

            const item = document.createElement('li');

            item.className = 'gantz-custom-select__option body-2';

            item.textContent = option.text;

            item.dataset.value = option.value;

            list.appendChild(item);
        });

        select.insertAdjacentElement(
            'afterend',
            custom
        );

        trigger.addEventListener('click', () => {

            custom.classList.toggle('is-open');

        });

        list.addEventListener('click', (e) => {

            const option = e.target.closest(
                '.gantz-custom-select__option'
            );

            if (!option) {
                return;
            }

            select.value = option.dataset.value;

            select.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );

            trigger.classList.add('is-selected');

            trigger.textContent = option.textContent;

            custom.classList.remove('is-open');
        });

        select.addEventListener('change', () => {

            const selectedOption = select.options[
                select.selectedIndex
            ];

            trigger.textContent = selectedOption.text;

            if (select.value) {
                trigger.classList.add('is-selected');
            } else {
                trigger.classList.remove('is-selected');
            }

        });

        document.addEventListener('click', (e) => {
            document
            .querySelectorAll('.gantz-custom-select')
            .forEach(select => {

                if (!select.contains(e.target)) {
                    select.classList.remove('is-open');
                }
            });
        });
    });
</script>
<?php get_template_part('template-parts/footer'); ?>