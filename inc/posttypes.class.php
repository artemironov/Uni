<?php add_action('init', 'create_post_types_and_taxonomies');

function create_post_types_and_taxonomies() {
    
	register_taxonomy( 'characters', [ 'post' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Персонажи',
			'singular_name'     => 'Персонаж',
			'search_items'      => 'Поиск',
			'all_items'         => 'Все персонажи',
			'view_item '        => 'Перейти',
			'parent_item'       => 'Родительская',
			'parent_item_colon' => 'Родительская:',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить',
			'new_item_name'     => 'Имя',
			'menu_name'         => 'Персонажи',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		'hierarchical'          => true,

		'rewrite'               => true,
		'capabilities'          => array(),
		//'meta_box_cb'           => null, // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
		'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи
        'show_in_quick_edit'    => true, // Показывать ли таксономию в панели быстрого редактирования записи (в таблице, списке всех записей, при нажатии на кнопку "свойства"
		'show_in_rest'          => true, // true - таксономия будет видна в редакторе блоков Gutenberg, false - такса будет видна только в обычном редакторе"
	] );
    
    
    register_taxonomy( 'actors', [ 'post' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Актеры',
			'singular_name'     => 'Актер',
			'search_items'      => 'Поиск',
			'all_items'         => 'Все актеры',
			'view_item '        => 'Перейти',
			'parent_item'       => 'Родительская',
			'parent_item_colon' => 'Родительская:',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить',
			'new_item_name'     => 'Имя',
			'menu_name'         => 'Актеры',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		'hierarchical'          => true,

		'rewrite'               => true,
		'capabilities'          => array(),
		//'meta_box_cb'           => 'post_categories_meta_box', // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'meta_box_sanitize_cb'  => 'taxonomy_meta_box_sanitize_cb_input',
		'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи
        'show_in_quick_edit'    => true, // Показывать ли таксономию в панели быстрого редактирования записи (в таблице, списке всех записей, при нажатии на кнопку "свойства"
		'show_in_rest'          => true, // true - таксономия будет видна в редакторе блоков Gutenberg, false - такса будет видна только в обычном редакторе"
	] );
    
    
    register_taxonomy( 'tcat', [ 'turkey' ], [
		'label'                 => '', // определяется параметром $labels->name
		'labels'                => [
			'name'              => 'Рубрики',
			'singular_name'     => 'Рубрика',
			'search_items'      => 'Поиск',
			'all_items'         => 'Все рубрики',
			'view_item '        => 'Перейти',
			'parent_item'       => 'Родительская',
			'parent_item_colon' => 'Родительская:',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить',
			'new_item_name'     => 'Рубрика',
			'menu_name'         => 'Рубрики',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		'hierarchical'          => true,

		'rewrite'               => true,
		'capabilities'          => array(),
		//'meta_box_cb'           => 'post_categories_meta_box', // html метабокса. callback: `post_categories_meta_box` или `post_tags_meta_box`. false — метабокс отключен.
        'meta_box_sanitize_cb'  => 'taxonomy_meta_box_sanitize_cb_input',
		'show_admin_column'     => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи
        'show_in_quick_edit'    => true, // Показывать ли таксономию в панели быстрого редактирования записи (в таблице, списке всех записей, при нажатии на кнопку "свойства"
		'show_in_rest'          => true, // true - таксономия будет видна в редакторе блоков Gutenberg, false - такса будет видна только в обычном редакторе"
	] );
    
    
	register_post_type('turkey', array(
		'labels'             => array(
			'name'               => 'Статьи', // Основное название типа записи
			'singular_name'      => 'О турции', // отдельное название записи типа Book
			'add_new'            => 'Добавить статью',
			'add_new_item'       => 'Добавить новую статью',
			'edit_item'          => 'Редактировать',
			'new_item'           => 'Новая статья',
			'view_item'          => 'Посмотреть статью',
			'search_items'       => 'Найти статью',
			'not_found'          => 'Статей не найдено',
			'not_found_in_trash' => 'В корзине статей не найдено',
			'parent_item_colon'  => '',
			'menu_name'          => 'О турции'

		  ),
		'public'             => true,
		'publicly_queryable' => true,
		'menu_icon'          => 'dashicons-edit-page',
		'menu_position'      => 5,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'supports'           => array('title','editor','thumbnail','excerpt','comments')
	) );
}


// Replace the original (post_tag) metabox callback

/*
add_filter( 'register_taxonomy_args', 'register_taxonomy_args', 10, 2 );
function register_taxonomy_args( $args, $taxonomy ) {
    if( 'post_tag' === $taxonomy ) {
        $args['meta_box_cb'] = 'post_categories_meta_box';
        $args['meta_box_sanitize_cb']  = 'taxonomy_meta_box_sanitize_cb_input';
    }
    
    return $args;
}
*/



function change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Посты';
    $submenu['edit.php'][5][0] = 'Все посты';
    $submenu['edit.php'][10][0] = 'Добавить пост';
    $submenu['edit.php'][16][0] = 'Тэги';
}
add_action( 'admin_menu', 'change_post_label' );


/*

function change_cat_label() {
    global $submenu;
    $submenu['edit.php'][15][0] = 'Рубрики'; // Rename categories to Authors
}
add_action( 'admin_menu', 'change_cat_label' );


function change_cat_object() {
    global $wp_taxonomies;
    $labels = &$wp_taxonomies['category']->labels;
    $labels->name = 'Жанры';
    $labels->singular_name = 'Жанр';
    $labels->add_new = 'Добавить';
    $labels->add_new_item = 'Добавить жанр';
    $labels->edit_item = 'Редактировать';
    $labels->new_item = 'Жанр';
    $labels->view_item = 'Посмотреть';
    $labels->search_items = 'Поиск';
    $labels->not_found = 'Жанры не найдены';
    $labels->not_found_in_trash = 'В корзине жанры не найдены';
    $labels->all_items = 'Все жанры';
    $labels->menu_name = 'Жанры';
    $labels->name_admin_bar = 'Жанры';
}
add_action( 'init', 'change_cat_object' );




function change_tag_label() {
    global $submenu;
    $submenu['edit.php'][16][0] = 'Тип игры'; // Rename categories to Authors
}
add_action( 'admin_menu', 'change_tag_label' );


function change_tag_object() {
    global $wp_taxonomies;
    $labels = &$wp_taxonomies['post_tag']->labels;
    $labels->name = 'Тип игры';
    $labels->singular_name = 'Тип игры';
    $labels->add_new = 'Добавить';
    $labels->add_new_item = 'Добавить тип';
    $labels->edit_item = 'Редактировать';
    $labels->new_item = 'Тип';
    $labels->view_item = 'Посмотреть';
    $labels->search_items = 'Поиск';
    $labels->not_found = 'Типы не найдены';
    $labels->not_found_in_trash = 'В корзине типы не найдены';
    $labels->all_items = 'Все типы';
    $labels->menu_name = 'Тип игры';
    $labels->name_admin_bar = 'Тип игры';
}
add_action( 'init', 'change_tag_object' );

*/

?>