<?php
/* 
    SCF: Pagina de opciones
*/

add_action( 'acf/init', function() {
	acf_add_options_page( array(
	'page_title' => 'Ajustes del sitio',
	'menu_slug' => 'ajustes-del-sitio',
	'position' => '',
	'redirect' => false,
	'menu_icon' => array(
		'type' => 'dashicons',
		'value' => 'dashicons-admin-generic',
	),
	'icon_url' => 'dashicons-admin-generic',
) );
} );