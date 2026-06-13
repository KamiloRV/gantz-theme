<section class="pre-footer newsletter">
    <div class="container contenido">
        <div class="text-container">
            <h2 class="titulo"><?php echo $args['titulo'] ?></h2>

            <?php
            if (!empty($args['descripcion'])) :
                $descripcion = str_replace('<p>', '<p class="body-2">', $args['descripcion']);
                echo $descripcion;
            endif;
            ?>
        </div>

        <form class="newsletter-form" action="" method="post">
            <input
                type="email"
                id="newsletter-email"
                name="newsletter_email"
                placeholder="<?php echo esc_attr($args['input']['placeholder'] ?? 'Ingresa tu correo'); ?>"
                required>

            <button
                type="submit"
                id="newsletter-submit"
                disabled>
                <?php echo esc_html($args['input']['label'] ?? 'Suscribirse'); ?>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 16">
                    <path fill="currentColor" d="M12.175 9H0V7h12.175l-5.6-5.6L8 0l8 8-8 8-1.425-1.4z"/>
                </svg>
            </button>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const emailInput = document.querySelector('#newsletter-email');
        const submitButton = document.querySelector('#newsletter-submit');

        if (!emailInput || !submitButton) return;

        emailInput.addEventListener('input', () => {
            submitButton.disabled = !emailInput.checkValidity();
        });
    });
</script>