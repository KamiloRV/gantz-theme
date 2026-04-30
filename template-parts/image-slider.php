<?php defined('ABSPATH') || exit;

/**
 * template-parts/image-slider.php
 *
 * Slider de imágenes con link.
 * Campos ACF (repeater): image_slider_slides
 *   → slide_imagen, slide_url, slide_alt (opcional, override del alt de la imagen)
 *
 * Uso desde cualquier template:
 *   get_template_part('template-parts/components/image-slider');
 */

$slides = get_field('image_slider_slides');
if (empty($slides)) return;

// ID único por si hay más de un slider en la misma página
$slider_id = 'imageSlider-' . uniqid();
?>

<div class="img-slider" id="<?php echo esc_attr($slider_id); ?>" data-autoplay="5000">

    <div class="img-slider__track">
        <?php foreach ($slides as $index => $slide) :
            $imagen    = $slide['slide_imagen'];
            $url       = $slide['slide_url']   ?? '';
            $alt       = $slide['slide_alt']   ?: ($imagen['alt'] ?? '');
            $is_first  = $index === 0;
        ?>
            <div class="img-slider__slide<?php echo $is_first ? ' is-active' : ''; ?>"
                 role="group"
                 aria-roledescription="slide"
                 aria-label="<?php printf(esc_attr__('Slide %d de %d', 'mi-tema'), $index + 1, count($slides)); ?>"
                 aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>">

                <?php if ($url) : ?>
                    <a href="<?php echo esc_url($url); ?>"
                       class="img-slider__link"
                       tabindex="<?php echo $is_first ? '0' : '-1'; ?>">
                <?php endif; ?>

                    <img src="<?php echo esc_url($imagen['url']); ?>"
                         alt="<?php echo esc_attr($alt); ?>"
                         width="<?php echo esc_attr($imagen['width']); ?>"
                         height="<?php echo esc_attr($imagen['height']); ?>"
                         <?php echo $is_first ? 'loading="eager"' : 'loading="lazy"'; ?>
                         class="img-slider__img">

                <?php if ($url) : ?>
                    </a>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>

    <?php /* — Flechas */ ?>
    <button class="img-slider__arrow img-slider__arrow--prev"
            type="button"
            aria-label="<?php esc_attr_e('Slide anterior', 'mi-tema'); ?>">
        <i class="bi bi-chevron-left" aria-hidden="true"></i>
    </button>

    <button class="img-slider__arrow img-slider__arrow--next"
            type="button"
            aria-label="<?php esc_attr_e('Slide siguiente', 'mi-tema'); ?>">
        <i class="bi bi-chevron-right" aria-hidden="true"></i>
    </button>

    <?php /* — Dots */ ?>
    <div class="img-slider__dots" role="tablist"
         aria-label="<?php esc_attr_e('Navegación de slides', 'mi-tema'); ?>">
        <?php foreach ($slides as $index => $slide) : ?>
            <button class="img-slider__dot<?php echo $index === 0 ? ' is-active' : ''; ?>"
                    type="button"
                    role="tab"
                    aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    aria-label="<?php printf(esc_attr__('Ir al slide %d', 'mi-tema'), $index + 1); ?>"
                    data-index="<?php echo esc_attr($index); ?>">
            </button>
        <?php endforeach; ?>
    </div>

</div>