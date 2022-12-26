<?php

require( TEMPLATEPATH.'/inc/posttypes.class.php' );
require( TEMPLATEPATH.'/inc/system.class.php' );
require( TEMPLATEPATH.'/inc/russian.class.php' );

require( TEMPLATEPATH.'/inc/functions/fn.turbotax.php' );

// GEO
require_once( TEMPLATEPATH.'/inc/geo/tabgeo_country_v4.php' );

//require( TEMPLATEPATH.'/inc/schema.php' );


// Подключаем функции для нужных страниц

add_action( 'init', 'uni_admin_functions' );
function uni_admin_functions() {
    if( is_admin() ) {
        require( TEMPLATEPATH.'/inc/functions/fn.admin.php' );
        wp_enqueue_style( 'admin', get_template_directory_uri() . '/assets/css/admin.css', array(), null, 'all' );
    }
}


// Расширение админки

class theme {
	private function __construct() {}

    public static function get_option($id) {
		return Theme_Options::get($id);
	}

	// Установка
	public static function setup() {
		add_action( 'after_setup_theme', array( __CLASS__, 'after_setup_theme' ) );
	}
	
	// Действия при инициализации
	public static function after_setup_theme() {
        global $theme_image_sizes;
        
        add_action( 'wp', 'uni_load_functions' );
        function uni_load_functions() {
            if ( is_singular( 'post' ) || is_singular( 'turkey' ) ) {
                require( TEMPLATEPATH.'/inc/functions/fn.single.php' );
                require( TEMPLATEPATH.'/inc/functions/fn.comments.php' );
            }
        }
        
        // Убираем "лишние" теги из head	
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'rsd_link');
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
        
        // Закрывает REST API от публичного доступа
        if ( ! is_user_logged_in() ) {
            remove_action('wp_head', 'rest_output_link_wp_head', 10);
            remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
            remove_action('template_redirect', 'rest_output_link_header', 11, 0);
        }
		
		// Отключаем emoji
        if ( ! is_user_logged_in() ) {
            remove_action( 'admin_print_styles', 'print_emoji_styles' );
            remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
            remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
            remove_action( 'wp_print_styles', 'print_emoji_styles' );
            remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
            remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
            remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
        }
        
		// Убираем ненужные виджеты
		add_action( 'widgets_init', array( __CLASS__, 'widgets_init' ) );

		// Загрузка CSS и JS
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'wp_enqueue_scripts' ) );

		// Убираем "лишние" <p> в шорткодах
		//remove_filter( 'the_content', 'wpautop' );
		//add_filter( 'the_content', 'wpautop', 12);

		
		// Добавляем meta robots noindex, nofollow для пагинации
        /*
		function my_meta_noindex () {
			if (
				is_paged() // Все и любые страницы пагинации
			) {echo "".'<meta name="robots" content="noindex,nofollow" />'."\n";}
		}
		add_action('wp_head', 'my_meta_noindex', 3); // добавляем свой noindex,nofollow в head
        */
	
	
		// Attachment redirect
		add_action( 'template_redirect', 'attachment_redirect', 1 );
		function attachment_redirect() {
            global $post;
  		    if ( is_attachment() AND isset( $post->post_parent) AND is_numeric( $post->post_parent ) ) {
    		  wp_redirect( get_permalink( $post->post_parent ), 301 );
	  	        exit();
  		    }
		}


		// Walidator rel category and rel tag
		add_filter( 'the_category', 't5_remove_cat_rel' );
		function t5_remove_cat_rel( $list ) {
    		return str_replace(
        		array ( 'rel="category tag"', 'rel="category"' ), '', $list
    		);
		}
	
	
		// Aim Jabber Yim off
		add_filter('user_contactmethods','add_extra_contactmethod',10,1);
		function add_extra_contactmethod( $contactmethods ) {
    		// remove unwanted
    		unset($contactmethods['user_url']);
    		unset($contactmethods['aim']);
    		unset($contactmethods['jabber']);
    		unset($contactmethods['yim']);

    		return $contactmethods;
		}
	}

    
	
	// Убираем ненужные виджеты
	
	public static function widgets_init() {
		unregister_widget('WP_Widget_RSS');
		unregister_widget('WP_Widget_Meta');
		unregister_widget('WP_Widget_Recent_Posts');
	}
    

	// Загрузка CSS и JS
	
	public static function wp_enqueue_scripts() {
		// Регистрация стилей
		wp_register_style( 'style', get_template_directory_uri() . '/style.css', array(), null, 'all' );
        wp_register_style( 'css-style', get_template_directory_uri() . '/assets/css/style.css', array(), null, 'all' );
        
		wp_enqueue_style( 'style' );
		wp_enqueue_style( 'css-style' );
		
		// Регистрация скриптов
        //wp_register_script( 'owl', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), null, true);
		wp_register_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), null, true);
        //wp_register_script( 'archive', get_template_directory_uri() . '/assets/js/archive.js', array(), null, true);
        wp_register_script( 'single', get_template_directory_uri() . '/assets/js/single.js', array(), null, true);
        
        wp_enqueue_script('jquery');
        wp_enqueue_script('scripts');
        
        global $post;
        if ( is_single() && !has_shortcode( $post->post_content, 'gallery') ) {
            wp_enqueue_script('single');
        } elseif( is_archive() ) {
            //wp_enqueue_script('owl');
            //wp_enqueue_script('archive');
        }
	}

	
	// Обработка содержания постов и страниц
	
	public static function the_content( $content ) {
		// Оборачиваем таблицы
		$content = str_replace( '<table', '<div class="table-wrap"><table', $content);
		$content = str_replace( '</table>', '</table></div>', $content);

		return $content;
	}
}

theme::setup();
