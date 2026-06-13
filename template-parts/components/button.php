<?php
$field_prefix = $args['field_prefix'] ?? null;
$data         = $args['data'] ?? null;
$button_class = $args['class'] ?? 'gantz-btn';

if (!$field_prefix && !$data) return;

if ($data) {
    $tipo   = $data['tipo'] ?? '';
    $dir    = $data['direccion'] ?? '';
    $link   = $data['link'] ?? '';
    $url    = $data['url'] ?? '';
    $mail   = $data['correo'] ?? '';
    $tel    = $data['telefono'] ?? '';
    $file   = $data['archivo'] ?? [];
    $texto  = $data['texto'] ?? '';
    $icono  = $data['icono'] ?? '';
} else {
    $tipo   = get_field($field_prefix . '_tipo');
    $dir    = get_field($field_prefix . '_direccion');
    $link   = get_field($field_prefix . '_link');
    $url    = get_field($field_prefix . '_url');
    $mail   = get_field($field_prefix . '_mail');
    $tel    = get_field($field_prefix . '_tel');
    $file   = get_field($field_prefix . '_archivo');
    $texto  = get_field($field_prefix . '_texto');
    $icono  = get_field($field_prefix . '_icono');
}

/* var_dump($field_prefix); */
/* var_dump($tipo, $dir, $link, $url, $mail, $tel, $texto, $icono); */

$directory_uri = get_template_directory_uri();

$icono_url = !empty($icono)
    ? $directory_uri . '/assets/images/icons.svg#' . $icono
    : '';

$href = '#';
$target = '';

switch ($tipo) {
    case 'url':
        if ($dir === 'interno' && !empty($link)) {
            $href = $link;
        } elseif ($dir === 'externo' && !empty($url)) {
            $href = $url;
            $target = ' target="_blank" rel="noopener noreferrer"';
        }
        break;
    case 'mail':
        if (!empty($mail)) {
            $href = 'mailto:' . sanitize_email($mail);
            $texto = $mail;
        }
        break;
    case 'tel':
        if (!empty($tel)) {
            $phone = gantz_parse_phone_cl($tel);
            $href = 'tel:' . $phone['e164'];
            // si no definiste texto manual, usa el teléfono formateado
            $texto = $phone['formatted'];
        }
        break;
    case 'download':
        if ($dir === 'interno' && !empty($file['url'])) {
            $href = $file['url'];
            // descarga directa
            $target = ' download';
            // si no hay texto, usar nombre archivo
            if (empty($texto) && !empty($file['title'])) {
                $texto = $file['title'];
            }
        } elseif ($dir === 'externo' && !empty($url)) {
            $href = $file['url'];
            // Abrir archivo en el navegador
            $target = ' target="_blank" rel="noopener noreferrer"';
            // si no hay texto, usar nombre archivo
            if (empty($texto) && !empty($file['title'])) {
                $texto = $file['title'];
            }
        }
        break;
}

if ($href === '#') return;
?>

<a
    class="<?php echo esc_attr($button_class); ?> <?php echo ($icono === 'heart') ? esc_attr($icono) : ''; ?>"
    href="<?php echo esc_url($href); ?>"
    <?php echo $target; ?>>

    <?php if (!empty($icono) && $icono !== 'none') : ?>
        <svg aria-hidden="true" focusable="false">
            <use href="<?php echo esc_attr($icono_url); ?>" />
        </svg>
    <?php endif; ?>

    <?php echo esc_html($texto); ?>
</a>