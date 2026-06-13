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
    <!-- Hero -->
    <section class="hero">
        <?php 
        $hero = get_field('hero');
        ?>
        <div class="hero__container container">
            <div class="hero__header">

                <h1 class="hero__titulo">
                    <?php echo esc_html($hero['titulo']); ?>
                </h1>

                <div class="hero__beneficios">

                    <h2>
                        <?php echo esc_html($hero['beneficios']['subtitulo']); ?>
                    </h2>

                    <p class="hero__beneficios-texto body-bold text-pb">
                        <?php echo esc_html($hero['beneficios']['texto']); ?>
                    </p>

                </div>

                <div class="hero__texto body-2 text-pb">
                    <?php echo wp_kses_post($hero['texto']); ?>
                </div>

            </div>
            <?php if (!empty($hero['tabla']['titulo1']) && !empty($hero['tabla']['titulo2']) && !empty($hero['tabla']['filas'])) : ?>
                <div class="hero__tabla-comparativa tabla-comparativa">
                    <table class="tabla-comparativa__tabla">
                        <thead class="body-1 body-bold text-pi">
                            <tr>
                                <th></th>
                                <th class="body-bold">
                                    <?php echo esc_html($hero['tabla']['titulo1']); ?>
                                    <?php if (!empty($hero['tabla']['parentesis1'])) : ?>
                                        <span>
                                            <?php echo esc_html($hero['tabla']['parentesis1']); ?>
                                        </span>
                                    <?php endif; ?>
                                </th>
                                <th class="body-bold">
                                    <?php echo esc_html($hero['tabla']['titulo2']); ?>
                                    <?php if (!empty($hero['tabla']['parentesis2'])) : ?>
                                        <span>
                                            <?php echo esc_html($hero['tabla']['parentesis2']); ?>
                                        </span>
                                    <?php endif; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="body-2 text-pb">
                            <?php foreach ($hero['tabla']['filas'] as $fila) : ?>
                                <tr>
                                    <th class="text-pi body-2 body-2-bold"><?php echo wp_kses_post($fila['concepto']); ?></th>
                                    <td><?php echo wp_kses_post($fila['columna1']); ?></td>
                                    <td><?php echo wp_kses_post($fila['columna2']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!-- Beneficios Tributarios -->
    <section class="beneficios-tributarios">
        <?php 
        $beneficios_tributarios = get_field('beneficios');
        ?>
        <div class="beneficios-tributarios__container container">
            <h2 class="beneficios-tributarios__titulo"><?php echo esc_html($beneficios_tributarios['titulo']); ?></h2>
            <div class="beneficios-tributarios__beneficios">
                <div class="beneficios-tributarios__card">
                    <svg class="beneficios-tributarios__card-icon" aria-hidden="true" focusable="false">
                        <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#familyhome'; ?>" />
                    </svg>
                    <div class="beneficios-tributarios__empresas-texto">
                        <h3 class="beneficios-tributarios__empresas-titulo body-1 body-bold text-pb"><?php echo esc_html($beneficios_tributarios['empresas']['titulo']); ?></h3>
                        <p class="beneficios-tributarios__empresas-texto body-1 text-pb">
                            <?php echo esc_html('Beneficio tributario es de hasta un ' . $beneficios_tributarios['empresas']['beneficio'] . '%'); ?>
                        </p>
                    </div>
                </div>
                <div class="beneficios-tributarios__card">
                    <svg class="beneficios-tributarios__card-icon" aria-hidden="true" focusable="false">
                        <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#partnerheart'; ?>" />
                    </svg>
                    <div class="beneficios-tributarios__personas-texto">
                        <h3 class="beneficios-tributarios__personas-titulo body-1 body-bold text-pb"><?php echo esc_html($beneficios_tributarios['personas']['titulo']); ?></h3>
                        <p class="beneficios-tributarios__personas-texto body-1 text-pb">
                            <?php echo esc_html('Beneficio tributario es de hasta un ' . $beneficios_tributarios['personas']['beneficio'] . '%'); ?>
                        </p>
                    </div>
                </div>
            </div>
            <p class="beneficios-tributarios__nota body-2 body-2-bold text-pb">*<?php echo esc_html($beneficios_tributarios['nota']); ?></p>
        </div>
    </section>
    <!-- Pasos a donar -->
    <section class="pasos-donar">
        <?php 
        $pasos_donar = get_field('donar');
        ?>
        <div class="pasos-donar__container container">
            <div class="pasos-donar__header">
                <h2 class="pasos-donar__titulo"><?php echo esc_html($pasos_donar['titulo']); ?></h2>
                <p class="pasos-donar_texto body-1 body-bold text-pb"><?php echo esc_html($pasos_donar['texto']); ?></p>
            </div>
            <ol class="pasos-donar__pasos">
                <li class="pasos-donar__item">
                    <div class="pasos-donar__card">
                        <svg class="pasos-donar__card-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 56 64"><path fill="currentColor" d="m45.698 34.005.01-.006.014-.01z"/><path fill="currentColor" d="M54.369 34.28a5.4 5.4 0 0 0-1.892-1.323 6 6 0 0 0-2.33-.453 7.3 7.3 0 0 0-2.322.394 7.8 7.8 0 0 0-2.117 1.1l-.054.04-.017.011-.062.053c-.07.06-.204.162-.38.29-.614.455-1.751 1.239-3.099 2.153-.884.599-1.863 1.255-2.854 1.915q.005-.073.005-.145a5.82 5.82 0 0 0-1.712-4.124 5.83 5.83 0 0 0-4.127-1.71H21.042c-2.032 0-3.777.207-5.29.567-2.272.537-4.026 1.421-5.441 2.42s-2.492 2.103-3.447 3.077q-.294.304-.586.594L1.44 43.364A4.2 4.2 0 0 0 0 46.533v14.237a3.233 3.233 0 0 0 5.345 2.446l9.016-7.721 14.185 2.575a6.618 6.618 0 0 0 5.014-1.103c.97-.675 5.71-3.97 10.393-7.249 2.342-1.638 4.665-3.272 6.498-4.57.913-.652 1.705-1.216 2.313-1.66q.458-.331.773-.565c.209-.156.362-.275.472-.366l.037-.03.016-.013.048-.045a6 6 0 0 0 1.383-1.874c.32-.697.498-1.452.507-2.226v-.07c0-1.463-.59-2.887-1.631-4.018m-2.118 6.167c-1.392 1.157-20.264 14.268-20.264 14.268a3.91 3.91 0 0 1-2.95.655l-14.784-2.686a1.47 1.47 0 0 0-1.214.326l-9.487 8.127a.487.487 0 0 1-.806-.367V46.531c0-.425.183-.824.503-1.101l4.908-4.285c2.707-2.703 5.154-5.92 12.886-5.92h12.365a3.09 3.09 0 0 1 3.093 3.089 3.09 3.09 0 0 1-3.093 3.088h-8.504l.037.02a1.107 1.107 0 0 0-1.14 1.062 1.106 1.106 0 0 0 1.068 1.136l.035-.017h11.542s9.496-6.235 10.885-7.392c1.52-1.124 3.794-1.406 5.014-.078s1.234 3.094-.094 4.313M23.042 25.54c2.52 1.724 5.69 2.987 5.69 2.987.292.094.742.178.898.178s.606-.084.9-.178c0 0 3.167-1.263 5.69-2.987 3.837-2.613 10.06-7.744 10.06-14.974 0-7.336-4.153-10.66-8.721-10.564-3.484.065-5.543 2.12-6.924 4.148-.252.375-.63.617-1.005.628-.375-.011-.75-.253-1.003-.628-1.383-2.027-3.44-4.083-6.924-4.148-4.57-.095-8.723 3.228-8.723 10.564 0 7.23 6.225 12.36 10.062 14.974"/></svg>
                        <div class="pasos-donar__card-contenido">
                            <h3 class="pasos-donar__card-titulo text-py"><?php echo esc_html($pasos_donar['paso1']['titulo']); ?></h3>
                            <p class="pasos-donar__card-texto body-2 body-2-bold text-mw"><?php echo esc_html($pasos_donar['paso1']['texto']); ?></p>
                        </div>
                    </div>
                </li>
                <li class="pasos-donar__item">
                    <div class="pasos-donar__card">
                        <svg class="pasos-donar__card-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 98 64"><path fill="currentColor" d="M.832 46.929c-.577-.143-.937-.783-.805-1.43.133-.647.708-1.056 1.284-.913l14.622 3.619c.576.143.937.783.804 1.43-.132.647-.707 1.056-1.284.913zM6.753 9.182c-.591.032-1.09-.48-1.113-1.141-.023-.662.438-1.224 1.029-1.256l14.99-.8c.59-.032 1.089.479 1.112 1.14.024.662-.437 1.225-1.028 1.256zM2.064 33.271c-.587-.072-1.008-.665-.938-1.323.07-.66.602-1.135 1.19-1.062l14.897 1.831c.588.072 1.008.665.939 1.324-.07.658-.603 1.134-1.19 1.062zM3.991 20.834c-.591-.014-1.055-.562-1.035-1.225.02-.662.515-1.188 1.106-1.173l14.996.362c.591.014 1.055.563 1.035 1.225s-.515 1.188-1.106 1.174zM32.528 3.906 90.75.012c4.13-.282 6.912 4.347 6.414 8.94L91.863 58.1c-.513 4.794-5.45 5.9-6.82 5.9-.359 0-.723-.033-1.081-.1L27.303 53.34c-3.671-.688-3.826-5.085-3.623-6.97l3.893-36.093c.466-4.309 3.87-6.296 4.955-6.37M90.9 2.213 32.682 6.108c-.344.024-.725.213-1.091.533L42.11 21.82q.162-.709.413-1.39c3.644-9.734 12.082-5.935 12.679-.41 1.47-5.217 12.137-10.279 14.217.707.204 1.084.254 2.191.148 3.289L92.986 2.73a3.43 3.43 0 0 0-2.086-.517M29.79 10.509l-3.893 36.094a7 7 0 0 0 .025 1.701l17.168-17.699c-.741-1.798-1.228-3.682-1.295-5.598L30.265 8.62a7.1 7.1 0 0 0-.474 1.89m-2.074 40.66 56.658 10.562a3.68 3.68 0 0 0 2.353-.35L65.5 32.983c-3.722 4.649-8.99 8.182-11.532 9.887-.736.494-1.244.834-1.42 1.004-.169-.337-.767-1.002-1.6-1.93-1.827-2.032-4.787-5.326-6.847-9.195l-17.28 17.818c.275.333.584.544.896.602m61.929 5.593 5.303-49.146c.126-1.175-.054-2.295-.503-3.216l-26.076 24c-.427.94-.93 1.845-1.5 2.705L88.423 59.94c.661-.874 1.093-1.982 1.222-3.178"/></svg>
                        <div class="pasos-donar__card-contenido">
                            <h3 class="pasos-donar__card-titulo text-py"><?php echo esc_html($pasos_donar['paso2']['titulo']); ?></h3>
                            <p class="pasos-donar__card-texto body-2 body-2-bold text-mw"><?php echo esc_html($pasos_donar['paso2']['texto']); ?></p>
                        </div>
                    </div>
                </li>
                <li class="pasos-donar__item">
                    <div class="pasos-donar__card">
                        <svg class="pasos-donar__card-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 71 64"><path fill="currentColor" d="M34.342 50.346H20.657v2.529h13.685zM39.369 40.09H20.657v2.529H39.37zM47.313 29.836H20.657v2.529h26.656zM47.313 19.582H34.75v2.529h12.564z"/><path fill="currentColor" d="M54.529 58.604a2.373 2.373 0 0 1-2.379 2.362H15.82a2.373 2.373 0 0 1-2.378-2.362V25.06H27.98c1.608 0 2.916-1.299 2.916-2.895V7.698H52.15a2.37 2.37 0 0 1 2.378 2.36v17.044l3.057-3.034v-14.01c0-2.974-2.438-5.394-5.435-5.394H30.106a6 6 0 0 0-4.221 1.735l-13.75 13.653a5.9 5.9 0 0 0-1.75 4.191v34.361c0 2.976 2.44 5.396 5.435 5.396h36.33c2.997 0 5.435-2.42 5.435-5.396v-14.51l-3.056 3.034zM28.179 8.412v12.129c0 1.312-.515 1.822-1.836 1.822H14.127zM66.32 28.624l-3.24-3.217a1.45 1.45 0 0 0-2.041 0l-2.101 2.085 5.283 5.245 2.1-2.086a1.426 1.426 0 0 0 0-2.027"/><path fill="currentColor" d="m39.37 46.921-1.8 7.033 7.082-1.788zM40.45 45.848l5.283 5.245L63.26 33.69l-5.282-5.246zM60.02 32.857l-15.27 15.161-1.202-1.193 15.271-15.161zM9.017.282c.365-.472 1.12-.326 1.277.247l.902 3.284a.72.72 0 0 0 .46.488l3.252 1.128c.567.197.66.95.156 1.275l-2.886 1.862a.71.71 0 0 0-.328.582l-.082 3.402c-.014.593-.712.912-1.18.54l-2.685-2.133a.73.73 0 0 0-.663-.129l-3.303.975c-.576.17-1.1-.386-.885-.941l1.225-3.18a.71.71 0 0 0-.08-.662l-1.96-2.8c-.342-.488.032-1.15.633-1.121l3.443.168a.73.73 0 0 0 .612-.28zM64.458 12.766c.057-.433.603-.624.924-.324l1.84 1.723a.55.55 0 0 0 .486.134l2.543-.512c.444-.09.792.349.589.741l-1.164 2.252a.51.51 0 0 0 .01.49l1.246 2.166c.217.377-.114.84-.56.782l-2.56-.331a.57.57 0 0 0-.48.168l-1.774 1.851c-.31.323-.861.17-.934-.258l-.419-2.457a.52.52 0 0 0-.305-.384l-2.343-1.023a.517.517 0 0 1-.017-.941l2.301-1.188a.54.54 0 0 0 .29-.405zM2.183 48.47c.034-.3.412-.44.638-.234l1.299 1.177c.09.082.216.115.338.088l1.763-.384c.307-.067.554.234.417.51l-.783 1.577a.35.35 0 0 0 .011.34l.89 1.492c.156.26-.069.585-.38.55l-1.783-.203a.4.4 0 0 0-.331.123l-1.213 1.306c-.211.227-.597.128-.652-.17l-.318-1.703a.36.36 0 0 0-.217-.264l-1.64-.685a.36.36 0 0 1-.022-.654l1.586-.85a.38.38 0 0 0 .198-.286z"/></svg>
                        <div class="pasos-donar__card-contenido">
                            <h3 class="pasos-donar__card-titulo text-py"><?php echo esc_html($pasos_donar['paso3']['titulo']); ?></h3>
                            <p class="pasos-donar__card-texto body-2 body-2-bold text-mw"><?php echo esc_html($pasos_donar['paso3']['texto']); ?></p>
                        </div>
                    </div>
                </li>
            </ol>
            <div class="pasos-donar__contenido">
                <h2 class="pasos-donar__contenido-titulo"><?php echo esc_html($pasos_donar['titulo2']); ?></h2>
                <div class="pasos-donar__contenido-texto body-1 text-pb"><?php echo wp_kses_post($pasos_donar['texto2']); ?></div>
            </div>
        </div>
    </section>
    <!-- Certificado -->
    <section class="certificado">
        <?php 
        $certificado = get_field('certificado');
        ?>
        <div class="certificado__container container">
            <div class="certificado__container-inner">
                <div class="certificado__header">
                    <!-- <?php if (!empty($certificado['imagen'])): ?>
                        <img src="<?php echo esc_url($certificado['imagen']['url']); ?>" alt="<?php echo esc_attr($certificado['imagen']['alt']); ?>">
                    <?php endif; ?>  -->
                    <svg class="certificado__imagen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 128 165"><path fill="#fff" d="M.003 9.304a5.21 5.21 0 0 1 5.032-5.382l112.3-3.919a5.21 5.21 0 0 1 5.396 5.018l5.266 150.675a5.21 5.21 0 0 1-5.032 5.382l-112.3 3.919c-2.88.1-5.295-2.146-5.396-5.018z"/><path fill="#201547" d="m122.919 159.778.046 1.3-112.3 3.919-.046-1.301zm3.774-4.036L121.427 5.067a3.91 3.91 0 0 0-4.046-3.764L5.081 5.222a3.907 3.907 0 0 0-3.774 4.036l5.266 150.675a3.907 3.907 0 0 0 4.046 3.763l.046 1.301-.269.003c-2.76-.044-5.03-2.239-5.127-5.021L.003 9.304a5.21 5.21 0 0 1 4.764-5.366l.268-.016 112.3-3.919.268-.002a5.21 5.21 0 0 1 5.128 5.02l5.266 150.675.002.268a5.21 5.21 0 0 1-4.766 5.098l-.268.016-.046-1.3a3.906 3.906 0 0 0 3.774-4.036"/><path fill="#0265ca" d="M49.167 19.353 59.316 19l.808 23.07-10.15.353z"/><path fill="#dd323b" d="m59.316 18.885 15.814-.55.808 23.07-15.814.55z"/><path fill="#d9d9d9" d="M57.576 33.73a3.07 3.07 0 0 1-2.962 3.172 3.069 3.069 0 1 1-.214-6.132 3.07 3.07 0 0 1 3.176 2.96M61.01 30.54l12.037-.42.05 1.415-12.038.42zM61.693 50.115l13.218-.462.05 1.415-13.218.462z"/><path fill="#1c1b1f" d="m33.968 61.471 58.536-2.042.116 3.301-58.536 2.043zM23.841 75.992l79.779-2.784.049 1.415-79.778 2.783zM23.99 80.237l76.002-2.652.049 1.415-76.002 2.652zM24.138 84.482l79.779-2.784.049 1.415-79.779 2.784zM24.286 88.726l77.891-2.717.049 1.415-77.89 2.717zM24.88 105.707l79.779-2.784.049 1.415-79.779 2.784zM24.435 92.972l79.779-2.784.049 1.415-79.779 2.784zM25.028 109.951l77.891-2.718.049 1.415-77.89 2.718zM24.583 97.217l59.952-2.092.05 1.415-59.952 2.092zM36.062 141.679l59.952-2.092.05 1.415-59.952 2.092zM25.177 114.196l59.952-2.092.05 1.415-59.953 2.092z"/><path fill="#d9d9d9" d="m61.083 32.662 9.205-.32.05 1.414-9.205.321zM61.158 34.785l5.428-.19.05 1.416-5.429.189z"/><path fill="#000" d="M59.005 132.806a.723.723 0 0 1 .925.365c.083.168.105.362.115.48.024.257.047.693.03 1.131a5 5 0 0 1-.065.668 2 2 0 0 1-.215.657 7 7 0 0 1-.88 1.198l.103-.079c.48-.36.965-.672 1.385-.945.431-.282.779-.513 1.037-.737.126-.109.233-.219.336-.323.047-.049.103-.105.154-.152.04-.038.126-.118.236-.175a.74.74 0 0 1 .328-.087c.19-.003.38.072.519.224a.7.7 0 0 1 .169.33 1 1 0 0 1 .02.194c.002.173-.036.41-.085.67-.146.782-.505 2.361-.838 3.771q.252-.34.491-.64c.331-.418.614-.764.843-1.11.385-.583.643-1.101.815-1.487.087-.194.151-.355.203-.483.025-.061.05-.123.073-.174.013-.031.055-.127.118-.21l.036-.045a.66.66 0 0 1 1.007.018.7.7 0 0 1 .15.344c.014.084.017.183.018.24l.006.199c.108.041.273.086.505.127.2.035.507.027.815-.034.328-.064.522-.161.575-.207l.056-.044a.7.7 0 0 1 .13-.071c.041-.176.085-.356.127-.515.033-.124.068-.247.105-.353.018-.052.04-.11.065-.166a1 1 0 0 1 .138-.217l.04-.042c.108-.109.375-.32.736-.222l.085.028.09.042c.202.109.328.279.381.351.069.093.17.249.215.316.066.095.117.16.162.204.032.03.05.04.055.043a.9.9 0 0 1 .372.218q.055-.122.099-.23l.043-.094a1 1 0 0 1 .067-.109.73.73 0 0 1 .372-.271c.264-.082.5.01.642.126a.8.8 0 0 1 .207.265c.144.292.207.632.236.938q.005.057.008.115c.082.028.147.06.186.082.078.043.152.093.207.131l.021-.06c.028-.079.076-.216.15-.334l.116-.187.204-.078c.184-.069.389-.134.554-.188.179-.058.317-.106.42-.153l.09-.041.098-.012c.159-.021.331-.011.43-.007a.65.65 0 1 1-.056 1.3l-.142-.006c-.145.059-.297.11-.433.155l-.233.075c-.02.06-.042.131-.056.17a2 2 0 0 1-.154.349.96.96 0 0 1-.447.421c-.358.152-.689.025-.852-.053-.034.122-.069.248-.104.366a6 6 0 0 1-.168.507c-.006.013-.042.101-.106.184a.663.663 0 0 1-.589.252.65.65 0 0 1-.574-.519c-.026-.12-.011-.235-.01-.245a2 2 0 0 1 .02-.141c.027-.169.103-.661.13-1.196a.9.9 0 0 1-.904-.1 1 1 0 0 1-.26-.279l-.06-.097-.035-.059a1.5 1.5 0 0 1-.436-.29l-.049.21a9 9 0 0 1-.178.688 1 1 0 0 1-.064.161 1 1 0 0 1-.08.129.68.68 0 0 1-.7.248.67.67 0 0 1-.39-.282 4 4 0 0 1-.3.071c-.417.081-.893.108-1.294.038a3.7 3.7 0 0 1-.873-.246l-.06-.03c-.175.348-.397.75-.683 1.183-.268.405-.598.809-.906 1.199-.318.401-.63.809-.91 1.268-.578.945-1.008 1.644-1.285 2.071a6 6 0 0 1-.333.479 1 1 0 0 1-.1.106.666.666 0 0 1-.827.075.66.66 0 0 1-.294-.564.8.8 0 0 1 .032-.204l.154-.546c.082-.3.204-.765.393-1.539.288-1.175.715-2.991.993-4.273q-.247.169-.502.335c-.431.281-.876.567-1.313.895-.874.657-1.706 1.471-2.283 2.09-.286.307-.505.561-.674.759-.148.171-.31.363-.438.47-.04.034-.1.08-.174.118a.73.73 0 0 1-.374.079.69.69 0 0 1-.495-.258.7.7 0 0 1-.144-.316 1 1 0 0 1-.005-.326c.01-.082.027-.169.045-.25.035-.161.069-.339.106-.524a7 7 0 0 1-.341.158 1 1 0 0 1-.122.039c-.012.002-.084.02-.176.016a.649.649 0 0 1-.171-1.269l.036-.015q.076-.035.235-.113c.21-.105.514-.266.892-.481l.006-.005.016-.064c.15-.568.39-1.285 1.036-2.411a42 42 0 0 1 1.511-2.431c.102-.147.199-.282.288-.389q.068-.083.157-.164a.9.9 0 0 1 .27-.172m-.288 2.461c-.192.307-.388.63-.566.929.193-.236.367-.481.51-.732a.8.8 0 0 0 .056-.197"/></svg>
                    <div class="certificado__contenido">
                        <h3 class="certificado__titulo"><?php echo esc_html($certificado['titulo']); ?></h3>
                        <div class="certificado__texto text-pb">
                            <?php echo wp_kses_post($certificado['texto']); ?>
                        </div>
                    </div>
                </div>
                <div class="certificado__informacion">
                    <div class="certificado__informacion-contenido text-pb">
                        <h4 class="certificado__informacion-titulo">Persona Jurídica:</h4>
                        <div class="certificado__informacion-texto">
                            <?php echo wp_kses_post($certificado['infojuridica']); ?>
                        </div>
                    </div>
                    <div class="certificado__informacion-contenido text-pb">
                        <h4 class="certificado__informacion-titulo">Persona Natural:</h4>
                        <div class="certificado__informacion-texto">
                            <?php echo wp_kses_post($certificado['infonatural']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Aviso -->
    <section class="aviso">
        <?php 
        $aviso = get_field('aviso');
        ?>
        <div class="aviso__container container">
            <h4 class="aviso__titulo">
                <svg class="aviso__svg" aria-hidden="true" focusable="false">
                    <use href="<?php echo esc_attr($directory_uri) . '/assets/images/icons.svg#alert'; ?>" />
                </svg>
                <?php echo esc_html($aviso['titulo']); ?>
            </h4>
            <div class="aviso__texto body-2 text-pb">
                <?php echo wp_kses_post($aviso['texto']); ?>
            </div>
            <div class="aviso__descripcion body-2 text-pb">
                <?php echo wp_kses_post($aviso['descripcion']); ?>
            </div>
        </div>
    </section>
</main>

<?php get_template_part('template-parts/footer'); ?>