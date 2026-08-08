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
            <div class="newsletter-form__input-group">
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
            </div>

            <!-- <label class="newsletter-form__consent" for="newsletter-consent">
                <input type="checkbox" id="newsletter-consent" name="newsletter_consent" required>
                <span class="nota text-mw">
                    Acepto recibir correos de Fundación Gantz y que mi email sea almacenado para este fin, según la
                    <a href="<?php echo esc_url(home_url('/')); echo 'politica-de-privacidad'; ?>" target="_blank" class="nota text-py">Política de Privacidad</a>.
                </span>
            </label> -->
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const form = document.querySelector('.newsletter-form');
        const emailInput = document.querySelector('#newsletter-email');
        const consentInput = document.querySelector('#newsletter-consent');
        const submitButton = document.querySelector('#newsletter-submit');

        if (!form || !emailInput || !consentInput || !submitButton) {
            return;
        }

        function validateForm() {
            submitButton.disabled = !emailInput.checkValidity() || !consentInput.checked;
        }

        emailInput.addEventListener('input', validateForm);
        consentInput.addEventListener('change', validateForm);

        form.addEventListener('submit', async (e) => {

            e.preventDefault();

            submitButton.disabled = true;

            const formData = new FormData();

            formData.append('action', 'gantz_newsletter_subscribe');
            formData.append('email', emailInput.value);
            formData.append('newsletter_consent', consentInput.checked ? '1' : '0');
            formData.append('nonce', gantz.nonce);

            try {

                const response = await fetch(
                    gantz.ajaxUrl,
                    {
                        method: 'POST',
                        body: formData
                    }
                );

                const result = await response.json();

                if (result.success) {

                    form.classList.add('newsletter-form--success');

                    submitButton.innerHTML = '¡Muchas gracias!';

                    emailInput.disabled = true;
                    consentInput.disabled = true;
                    submitButton.disabled = true;

                } else {

                    console.error(result.data.message);
                    alert(result.data.message);
                    submitButton.disabled = false;
                }

            } catch (error) {

                console.error(error);
                alert('Error al enviar la suscripción.');
                submitButton.disabled = false;
            }
        });
    });
</script>