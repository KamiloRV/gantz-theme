<?php
/*
Template Name: Landing
*/
get_template_part('template-parts/header'); ?>
<!-- Breadcrumb -->
<?php get_template_part('template-parts/components/breadcrumb'); ?>

<?php 
$tipo = get_field('type');

switch ($tipo) {

    case 'col1':
        get_template_part(
            'templates/landings/landing',
            'col1'
        );
        break;

    case 'col2':
        get_template_part(
            'templates/landings/landing',
            'col2'
        );
        break;

    case 'hero':
        get_template_part(
            'templates/landings/landing',
            'hero'
        );
        break;

    default:
        echo '<p>Seleccione un tipo de landing.</p>';
}
?>

<?php get_template_part('template-parts/footer'); ?>

