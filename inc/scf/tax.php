<?php
/* 
    SCF: Taxonomias
*/

add_action( 'init', function() {
	register_taxonomy( 'area', array(
	0 => 'equipo',
), array(
	'labels' => array(
		'name' => 'Áreas (Equipo)',
		'singular_name' => 'Área',
		'menu_name' => 'Áreas',
		'all_items' => 'Todas las Áreas',
		'edit_item' => 'Editar Área',
		'view_item' => 'Ver Área',
		'update_item' => 'Actualizar Área',
		'add_new_item' => 'Agregar nueva Área',
		'new_item_name' => 'Nombre de la nueva Área',
		'parent_item' => 'Área superior',
		'parent_item_colon' => 'Área superior:',
		'search_items' => 'Buscar Áreas',
		'not_found' => 'No se han encontrado áreas',
		'no_terms' => 'No hay áreas',
		'filter_by_item' => 'Filtrar por área',
		'items_list_navigation' => 'Navegación por la lista de Áreas',
		'items_list' => 'Lista de Áreas',
		'back_to_items' => '← Ir a áreas',
		'item_link' => 'Enlace a Área',
		'item_link_description' => 'Un enlace a un área',
	),
	'public' => true,
	'hierarchical' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
	'meta_box_cb' => false,
) );

	register_taxonomy( 'categoria', array(
	0 => 'noticia',
), array(
	'labels' => array(
		'name' => 'Categorías (Noticias)',
		'singular_name' => 'Categoría',
		'menu_name' => 'Categorías',
		'all_items' => 'Todas las Categorías',
		'edit_item' => 'Editar Categoría',
		'view_item' => 'Ver Categoría',
		'update_item' => 'Actualizar Categoría',
		'add_new_item' => 'Agregar nueva Categoría',
		'new_item_name' => 'Nombre de la nueva Categoría',
		'search_items' => 'Buscar Categorías',
		'popular_items' => 'Categorías (Noticias) populares',
		'separate_items_with_commas' => 'Separa los categorías (noticias) con comas',
		'add_or_remove_items' => 'Agregar o quitar categorías (noticias)',
		'choose_from_most_used' => 'Elige entre los categorías (noticias) más usados',
		'not_found' => 'No se han encontrado categorías',
		'no_terms' => 'No hay categorías',
		'items_list_navigation' => 'Navegación por la lista de Categorías',
		'items_list' => 'Lista de Categorías',
		'back_to_items' => '← Ir a categorías',
		'item_link' => 'Enlace a Categoría',
		'item_link_description' => 'Un enlace a un categoría',
	),
	'public' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
	'meta_box_cb' => false,
	'default_term' => array(
		'name' => 'Sin categoría',
		'slug' => 'sin-categoria',
	),
) );

	register_taxonomy( 'etiqueta', array(
	0 => 'noticia',
), array(
	'labels' => array(
		'name' => 'Etiquetas (Noticias)',
		'singular_name' => 'Etiqueta',
		'menu_name' => 'Etiquetas',
		'all_items' => 'Todas las Etiquetas',
		'edit_item' => 'Editar Etiqueta',
		'view_item' => 'Ver Etiqueta',
		'update_item' => 'Actualizar Etiqueta',
		'add_new_item' => 'Agregar nueva Etiqueta',
		'new_item_name' => 'Nombre de la nueva Etiqueta',
		'search_items' => 'Buscar Etiquetas',
		'popular_items' => 'Etiquetas populares',
		'separate_items_with_commas' => 'Separa las etiquetas con comas',
		'add_or_remove_items' => 'Agregar o quitar etiquetas',
		'choose_from_most_used' => 'Elige entre los etiquetas más usadas',
		'not_found' => 'No se han encontrado etiquetas',
		'no_terms' => 'No hay etiquetas',
		'items_list_navigation' => 'Navegación por la lista de Etiquetas',
		'items_list' => 'Lista de Etiquetas',
		'back_to_items' => '← Ir a etiquetas',
		'item_link' => 'Enlace a Etiqueta',
		'item_link_description' => 'Un enlace a un etiqueta',
	),
	'public' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
	'meta_box_cb' => false,
) );

	register_taxonomy( 'tipo-especialidad', array(
	0 => 'especialidad',
), array(
	'labels' => array(
		'name' => 'Tipos de especialidades (Especialidades)',
		'singular_name' => 'Tipo de especialidad',
		'menu_name' => 'Tipos de especialidades',
		'all_items' => 'Todos los Tipos de especialidades',
		'edit_item' => 'Editar Tipo de especialidad',
		'view_item' => 'Ver Tipo de especialidad',
		'update_item' => 'Actualizar Tipo de especialidad',
		'add_new_item' => 'Agregar nuevo Tipo de especialidad',
		'new_item_name' => 'Nombre del nuevo Tipo de especialidad',
		'search_items' => 'Buscar Tipos de especialidades',
		'popular_items' => 'Tipos de especialidades populares',
		'separate_items_with_commas' => 'Separa los tipos de especialidades con comas',
		'add_or_remove_items' => 'Agregar o quitar tipos de especialidades',
		'choose_from_most_used' => 'Elige entre los tipos de especialidades más usados',
		'not_found' => 'No se han encontrado tipos de especialidades',
		'no_terms' => 'No hay tipos de especialidades',
		'items_list_navigation' => 'Navegación por la lista de Tipos de especialidades',
		'items_list' => 'Lista de Tipos de especialidades',
		'back_to_items' => '← Ir a tipos de especialidades',
		'item_link' => 'Enlace a Tipo de especialidad',
		'item_link_description' => 'Un enlace a un tipo de especialidad',
	),
	'public' => true,
	'show_in_menu' => true,
	'show_in_rest' => true,
	'meta_box_cb' => false,
) );
} );