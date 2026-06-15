<?php
$imagen = get_field('imagen');
$imagenfull = get_field('imagen_full');
$bajada = get_field('bajada');
$detalle = get_field('detalle');
$video = get_field('video');
$botones = get_field('botones');
?>

<main>
    <div class="landing-2 container">
        <h1 class="landing-2__titulo"><?php the_title(); ?></h1>
        <div class="landing-2__contenido">
            <div class="landing-2__col1">
                <?php if ($imagen): ?>
                    <img src="<?php echo esc_url($imagen['url']); ?>" alt="<?php echo esc_attr($imagen['alt']); ?>" class="landing-2__imagen">
                    <?php if ($imagen['caption']): ?>
                        <caption><?php echo esc_html($imagen['caption']); ?></caption>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($video): ?>
                    <div class="landing-2__video">
                        <?php echo $video; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="landing-2__col2">
                <div class="landing-2__bajada body-bold text-pb">
                    <?php if ($bajada): ?>
                        <?php echo esc_html($bajada); ?>
                    <?php endif; ?>
                </div>
                <div class="landing-2__detalle body-2 text-pb">
                    <?php if ($detalle): ?>
                        <?php echo wp_kses_post($detalle); ?>
                    <?php endif; ?>
                </div>
                <?php if ($botones): ?>
                    <div class="landing-2__botones">
                        <?php foreach ($botones as $boton): ?>
                            <?php
                            get_template_part(
                                'template-parts/components/button',
                                null,
                                [
                                    'data' => $boton['boton'],
                                    'class' => 'gantz-btn blue-btn'
                                ]
                            );
                            ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>