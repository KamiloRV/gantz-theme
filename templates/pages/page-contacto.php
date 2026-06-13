<?php get_template_part('template-parts/header'); ?>

<main>
    <!-- Breadcrumb -->
    <?php get_template_part('template-parts/components/breadcrumb'); ?>
    <div class="hero">
        <div class="hero__container container">
            <h1 class="hero__titulo"><?php the_title(); ?></h1>
            <?php echo do_shortcode('[contact-form-7 id="af281b0" title="Formulario de contacto 1"]'); ?>
        </div>
    </div>
    
    <!-- <div class="gantz-form">
        <div class="gantz-form-inner">
            <div class="gantz-form-field gantz-form-field__xl-mid">
                <label class="gantz-form-label body-2 body-2-bold" for="nombres">Nombre(s)</label>
                [text* nombres autocomplete:given-name class:gantz-form-input class:body-2 id:nombres placeholder "ej. José Miguel"]
            </div>
            <div class="gantz-form-field gantz-form-field__xl-mid">
                <label class="gantz-form-label body-2 body-2-bold" for="apellidos">Apellido(s)</label>
                [text* apellidos autocomplete:fammily-name class:gantz-form-input class:body-2 id:apellidos placeholder "ej. Rivera Fuentes"]
            </div>
            <div class="gantz-form-field gantz-form-field--tel gantz-form-field__xl-mid body-2">
                <label class="gantz-form-label body-2 body-2-bold" for="telefono">Teléfono</label>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 22 16"><path fill="#fff" fill-rule="evenodd" d="M8.067 0H22v8H8.067z" clip-rule="evenodd"/><path fill="#0039a6" fill-rule="evenodd" d="M0 0h8.25v8H0z" clip-rule="evenodd"/><path fill="#fff" fill-rule="evenodd" d="M5.408 5.99 4.13 5.063 2.858 6l.474-1.525-1.27-.94 1.57-.016L4.119 2l.5 1.516 1.569.003-1.264.95z" clip-rule="evenodd"/><path fill="#d52b1e" fill-rule="evenodd" d="M0 8h22v8H0z" clip-rule="evenodd"/></svg>
                [tel* telefono autocomplete:tel class:gantz-form-input id:telefono minlength:9 maxlength:9 placeholder "9 1234 5678"]
            </div>
            <div class="gantz-form-field gantz-form-field__xl-mid">
                <label class="gantz-form-label body-2 body-2-bold" for="correo">Correo electrónico</label>
                [email* correo autocomplete:email class:gantz-form-input class:body-2 id:correo placeholder "ej. correo.electronico@gmail.com"]
            </div>
            <div class="gantz-form-field gantz-form-field--radio">
                <p class="body-2 body-2-bold text-pi m-0"> ¿Deseas recibir noticias sobre Fundación Gantz en tu correo eléctronico?</p>
                [radio suscribirse class:gantz-form-radio class:body-2 class:text-pb use_label_element "Sí, me quiero suscribir" "No por ahora."]
            </div>
            <div class="gantz-form-field">
                <label class="gantz-form-label body-2 body-2-bold" for="asunto">Asunto</label>
                [text* your-subject class:gantz-form-input class:body-2 id:asunto placeholder "Asunto de contacto (quiero donar en especies, quiero trabajar aquí, etcétera)"] 
            </div>
            <div class="gantz-form-field gantz-form-field--area">
                <label class="gantz-form-label body-2 body-2-bold" for="mensaje">Mensaje</label>
                [textarea* your-message placeholder class:gantz-form-input class:gantz-form-input--area class:body-2 id:mensaje "Relata en detalle el motivo de tu correo, de forma que podamos atenderte de la mejor manera."] 
            </div>
            

            <div class="gantz-form-field gantz-form-field--btn">
                <p class="gantz-form-required body-2 body-2-bold text-pb m-0">Todos los campos son obligatorios</p>
                [submit class:gantz-btn "Enviar mensaje"]
            </div>
        </div>
    </div> -->
</main>

<?php get_template_part('template-parts/footer'); ?>