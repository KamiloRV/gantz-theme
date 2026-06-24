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
            <?php wp_nonce_field('gantz_newsletter', 'newsletter_nonce'); ?>
            
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

        const form = document.querySelector('.newsletter-form');
        const emailInput = document.querySelector('#newsletter-email');
        const submitButton = document.querySelector('#newsletter-submit');

        if (!form || !emailInput || !submitButton) {
            return;
        }

        emailInput.addEventListener('input', () => {
            submitButton.disabled = !emailInput.checkValidity();
        });

        form.addEventListener('submit', async (e) => {

            e.preventDefault();

            submitButton.disabled = true;

            const formData = new FormData();

            formData.append(
                'action',
                'gantz_newsletter_subscribe'
            );

            formData.append(
                'email',
                emailInput.value
            );

            formData.append(
                'nonce',
                form.querySelector('[name="newsletter_nonce"]').value
            );

            try {

                const response = await fetch(
                    gantzNewsletter.ajax_url,
                    {
                        method: 'POST',
                        body: formData
                    }
                );

                console.log(response);

                const result = await response.json();

                console.log(result);

                if (result.success) {

                form.classList.add(
                    'newsletter-form--success'
                );

                submitButton.innerHTML =
                    '¡Muchas gracias!';

                emailInput.disabled = true;

                submitButton.disabled = true;

                console.log(
                    result.data.message
                );

            } else {

                console.error(
                    result.data.message
                );
            }

            } catch (error) {

                /* Manejo de errores */
                console.error(error);

                alert('Error al enviar la suscripción.');

            } finally {

                submitButton.disabled = false;
            }
        });
    });
</script>