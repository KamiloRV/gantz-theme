<?php
$imagen = get_field('imagen');
$imagenfull = get_field('imagen_full');
$bajada = get_field('bajada');
$detalle = get_field('detalle');
$video = get_field('video');
$botones = get_field('botones');
?>

<main>
    <div class="landing-1 container">
        <h1 class="landing-1__titulo"><?php the_title(); ?></h1>
        <?php if ($imagenfull): ?>
            <img src="<?php echo $imagenfull['url']; ?>" alt="<?php echo $imagenfull['alt']; ?>" class="landing-1__imagenfull">
        <?php endif; ?>
        <div class="landing-1__contenido">
            <div class="landing-1__bajada body-bold text-pb">
                <?php if ($bajada): ?>
                    <?php echo esc_html($bajada); ?>
                <?php endif; ?>
            </div>
            <div class="landing-1__detalle body-2 text-pb">
                <?php if ($detalle): ?>
                    <?php echo wp_kses_post($detalle); ?>
                <?php endif; ?>
            </div>
            <?php if ($botones): ?>
                <div class="landing-1__botones">
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
            <?php if ($video): ?>
            <div class="landing-1__video">
                <?php echo $video; ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</main>