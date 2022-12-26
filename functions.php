<?php require( TEMPLATEPATH.'/inc/theme.class.php' );

register_nav_menus(array(
	'top-bar'  => 'Основное меню',
    'bot-bar'  => 'Нижнее меню',
));


// ACF Theme Settings

function register_acf_options_pages() {

    // Check function exists.
    if( !function_exists('acf_add_options_page') )
        return;

    // register options page.
    $option_page = acf_add_options_page(array(
        'page_title'    => 'Настройки темы',
        'menu_title'    => 'Настройки темы',
        'menu_slug'     => 'thset',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));
}
// Hook into acf initialization.
add_action('acf/init', 'register_acf_options_pages');


//post thumbnail

add_theme_support('post-thumbnails');
set_post_thumbnail_size(150, 150, true);

add_image_size('min-post', 350, 220, true);
add_image_size('st-post', 750, 500, true);


// Editor style

function theme_add_editor_styles() {
    add_editor_style( '/assets/css/admin.css' );
}
add_action( 'admin_init', 'theme_add_editor_styles' );


//Remove Gutenberg Block Library CSS from loading on the frontend

function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    //wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );


// Ajax search

add_action( 'wp_ajax_data_fetch' , 'data_fetch' );
add_action( 'wp_ajax_nopriv_data_fetch','data_fetch' );

function data_fetch(){
	$args = array(
		'post_type'        => any, 
		//'post_type'        => array('post','page','service'), 
		'post_status'      => 'publish', 
		'order'            => 'DESC', 
		'orderby'          => 'date', 
		'posts_per_page' => 4,
		's' => esc_attr( $_POST['keyword'] ),
    );
	
    $the_query = new WP_Query($args);
    if( $the_query->have_posts() ) : while( $the_query->have_posts() ): $the_query->the_post(); ?>
    <div class="col-md-6">
        <div <?php post_class('post post-row'); ?>>
            <?php if(has_post_thumbnail()) { ?>
                <figure class="post-gallery">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('thumbnail', array('class' => 'wp-post-image lazyloaded')); ?>
                    </a>
                </figure>
            <?php } ?>
            <div class="post-inner">
                <div class="post-title">
                    <h6><a href="<?php echo get_permalink(); ?>" title="<?php the_title();?>"><?php the_title();?></a></h6>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; wp_reset_postdata(); endif;
    die();
}


// Ajax пагинация

function misha_my_load_more_scripts() {
 	global $wp_query;
 
	wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/assets/js/myloadmore.js', array('jquery') );

	wp_localize_script( 'my_loadmore', 'misha_loadmore_params', array(
		'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php', // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	));
    
    if(is_archive() || is_search()) {
        wp_enqueue_script( 'my_loadmore' );
    }
}
add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );

function loadmore(){
    $args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1;
	$args['post_status'] = 'publish';
 
	query_posts( $args );
 
	if( have_posts() ) : while( have_posts() ): the_post(); ?>
        <div class="col-md-6 col-lg-3">
            <div <?php post_class('post post-row mobi'); ?>>
                <?php if(has_post_thumbnail()) { ?>
                    <figure class="post-gallery">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('min-post', array('class' => 'wp-post-image lazyloaded')); ?>
                        </a>
                    </figure>
                <?php } ?>
                <div class="post-inner">
                    <?php if( !wp_is_mobile() ) { ?>
                        <aside class="post-category ">
                            <?php $category = get_the_category();
                                $categID = $category[0]->cat_ID; ?>
                            <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                        </aside>
                    <?php } ?>
                    <div class="post-title">
                        <h5><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <aside class="post-bottom">
                        <ul>
                            <li class="post-date"><?php echo get_the_date('d.m.Y'); ?></li>
                            <li class="post-read"><?php $post_id = get_the_ID(); reading_time($post_id); ?></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
    <?php endwhile;
 
	endif;
	die;
}
add_action('wp_ajax_loadmore', 'loadmore');
add_action('wp_ajax_nopriv_loadmore', 'loadmore');


// Ajax get terms

function uni_get_terms() {
    global $post;
    
	//$ordero = explode( '-', $_POST['ordero'] );
    $tainer = isset($_POST['tainer']) ? $_POST['tainer'] : '';
	$postype = isset($_POST['postype']) ? $_POST['postype'] : '';
    $catis = isset($_POST['category']) ? $_POST['category'] : '';
    $tagis = isset($_POST['tag']) ? $_POST['tag'] : '';
	$termis = isset($_POST['term']) ? $_POST['term'] : '';
    $chars = isset($_POST['char']) ? $_POST['char'] : '';
    $mypostid = isset($_POST['mypostid']) ? $_POST['mypostid'] : '';
    $perpage = isset($_POST['perpage']) ? $_POST['perpage'] : '';    
    $paged = isset($_POST['paged']) ? $_POST['paged'] : 1;
    
    //print_r($perpage);
    
    $return_html = ''; // Весь HTML код мы записываем в переменную
	
    $args = array(
        'order' => 'DESC',
        'paged' => $paged,
    );
	if (!empty($postype)) {
		$args['post_type'] = array($postype);
	}
    if (!empty($perpage)) {
		$args['posts_per_page'] = $perpage;
	}
	if (!empty($mypostid)) {
		$args['post__not_in'] = array($mypostid);
	}
    if (!empty($catis) && !empty($termis)) { // если переменные с ID таксономий не пусты, то добавляем tax_query с отношением "И"
        $args['relation'] = 'AND';
    }
    if (!empty($catis)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $catis,
        );
    }
    if (!empty($tagis)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'post_tag',
            'field' => 'id',
            'terms' => $tagis,
        );
    }
    if (!empty($termis)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'actors',
            'field' => 'id',
            'terms' => $termis,
        );
    }
    if (!empty($chars)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'characters',
            'field' => 'id',
            'terms' => $chars,
        );
    }
    	
    $projects = new WP_Query($args);
    $max_pages = $projects->max_num_pages; // получаем общее число страниц с выбранными постами
    if ($projects->have_posts()):
        while ($projects->have_posts()): $projects->the_post(); ?>
        <div class="col-lg-6">
            <div <?php post_class('post post-row mobi'); ?>>
                <?php if(has_post_thumbnail()) { ?>
                    <figure class="post-gallery">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('min-post', array('class' => 'wp-post-image lazyloaded')); ?>
                        </a>
                    </figure>
                <?php } ?>
                <div class="post-inner">
                    <?php if( !wp_is_mobile() ) { ?>
                        <aside class="post-category ">
                            <?php $category = get_the_category();
                                $categID = $category[0]->cat_ID; ?>
                            <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                        </aside>
                    <?php } ?>
                    <div class="post-title">
                        <h5><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <aside class="post-bottom">
                        <ul>
                            <li class="post-date"><?php echo get_the_date('d.m.Y'); ?></li>
                            <li class="post-read"><?php $post_id = get_the_ID(); reading_time($post_id); ?></li>
                        </ul>
                    </aside>
                </div>
            </div>
        </div>
        <?php endwhile;
    endif;
	
    if ($paged < $max_pages && $paged >= 2)  { // если текущая страница меньше общего числа страниц, то выводим кнопку для подгрузки
        $next_page = $paged + 1; // в дата атрибуты кнопки передаем номер следующей страницы и id текущих терминов
		$prev_page = $paged - 1;
		
		$return_html .= '
			<div class="titler-arrows">
				<div class="titler-arrow" data-tainer="'. $tainer .'" data-page="'. $prev_page .'" data-postype="'. $postype .'" data-catname="'. $catis .'" data-tagname="'. $tagis .'" data-termname="'. $termis .'" data-charname="'. $chars .'" data-perpage="'. $perpage .'" data-postid="'. $mypostid .'"><i class="icon-angle-left"></i></div>
				<div class="titler-arrow" data-tainer="'. $tainer .'" data-page="'. $next_page .'" data-postype="'. $postype .'" data-catname="'. $catis .'" data-tagname="'. $tagis .'" data-termname="'. $termis .'" data-charname="'. $chars .'" data-perpage="'. $perpage .'" data-postid="'. $mypostid .'"><i class="icon-angle-right"></i></div>
			</div>';
	} elseif ($paged == $max_pages) {
		$prev_page = $paged - 1;
		
		$return_html .= '
			<div class="titler-arrows">
				<div class="titler-arrow" data-tainer="'. $tainer .'" data-page="'. $prev_page .'" data-postype="'. $postype .'" data-catname="'. $catis .'" data-tagname="'. $tagis .'" data-termname="'. $termis .'" data-charname="'. $chars .'" data-perpage="'. $perpage .'" data-postid="'. $mypostid .'"><i class="icon-angle-left"></i></div>
				<div class="titler-arrow non-active"><i class="icon-angle-right"></i></div>
			</div>';
	} else {
		$return_html .= '
			<div class="titler-arrows">
				<div class="titler-arrow non-active"><i class="icon-angle-left"></i></div>
				<div class="titler-arrow" data-tainer="'. $tainer .'" data-page="2" data-postype="'. $postype .'" data-catname="'. $catis .'" data-tagname="'. $tagis .'" data-termname="'. $termis .'" data-charname="'. $chars .'" data-perpage="'. $perpage .'" data-postid="'. $mypostid .'"><i class="icon-angle-right"></i></div>
			</div>';
	}
		
    wp_reset_postdata();
    echo $return_html; // возвращаем html код
    wp_die(); // обязательно "умираем"
}
add_action('wp_ajax_uni_get_terms', 'uni_get_terms'); // наши хуки
add_action('wp_ajax_nopriv_uni_get_terms', 'uni_get_terms');


// Reading counter

if ( ! function_exists( 'mb_str_word_count' ) ) {
	function mb_str_word_count( $string, $format = 0, $charlist = '[]' ) {
		$string = trim( $string );
		if ( empty( $string ) ) {
			$words = array();
		} else {
			$words = preg_split( '~[^\p{L}\p{N}\']+~u', $string );
		}
		switch ( $format ) {
			case 0:
				return count( $words );
				break;
			case 1:
			case 2:
				return $words;
				break;
			default:
				return $words;
				break;
		}
	}
}

function reading_time( $post_id ) {
	$post_id = isset( $post_id ) ? $post_id : get_the_ID();

	$the_content      = get_post_field( 'post_content', $post_id );
	$number_of_images = substr_count( strtolower( $the_content ), '<img ' );

	// Strip Shortcodes.
	$the_content = preg_replace( '~(?:\[/?)[^/\]]+/?\]~s', '', $the_content );

	// Strip Tags.
	$the_content = wp_strip_all_tags( $the_content );

	// Word Count.
	$word_count = mb_str_word_count( $the_content );

	// Images.
	$additional_words_for_images = thb_calculate_images( $number_of_images, 300 );
	$word_count                 += $additional_words_for_images;

	// Calculate Time.
	$reading_time = ceil( $word_count / 300 );

	if ( 1 > $reading_time ) {
		$reading_time = '< 1';
	}

	// Append text.
	if ( $reading_time > 1 ) {
		$postfix = 'мин';
	} else {
		$postfix = 'мин';
	}
	echo esc_html( $reading_time . ' ' . $postfix );
}

function thb_calculate_images( $total_images ) {
	$additional_time = 0;
	// For the first image add 12 seconds, second image add 11, ..., for image 10+ add 3 seconds.
	for ( $i = 1; $i <= $total_images; $i++ ) {
		if ( $i >= 10 ) {
			$additional_time += 3 * (int) 300 / 60;
		} else {
			$additional_time += ( 12 - ( $i - 1 ) ) * (int) 300 / 60;
		}
	}

	return $additional_time;
}


// Show gallery in Photobox

function gallery_shortcode_scripts() {
    global $post;
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gallery') || is_tax('characters') || is_tax('actors')) {
        wp_register_style( 'photobox', get_template_directory_uri() . '/assets/css/photobox.css', array(), null, 'all' );
        wp_enqueue_style( 'photobox' );
        
        wp_register_script('photobox', get_template_directory_uri() . '/assets/js/photobox.js', array(), null, true);
        wp_enqueue_script( 'photobox' );
    }
}
add_action( 'wp_enqueue_scripts', 'gallery_shortcode_scripts');



// ADS after second paragraph of single post content.

function prefix_insert_after_paragraph2( $ads, $content ) {
    if ( ! is_array( $ads ) ) {
        return $content;
    }
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );

    foreach ($paragraphs as $index => $paragraph) {
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
        $n = $index + 1;
        if ( isset( $ads[ $n ] ) ) {
            $paragraphs[$index] .= $ads[ $n ];
        }
    }
    return implode( '', $paragraphs );
}

add_filter( 'the_content', 'prefix_insert_post_ads' );
function prefix_insert_post_ads( $content ) {
    if ( is_single() && ! is_admin() ) {
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $country_code = tabgeo_country_v4($ip);
        if( $country_code == US || $country_code == DE ) {
            
            if( wp_is_mobile() ) {
                $content = prefix_insert_after_paragraph2( array(
                    // The format is: '{PARAGRAPH_NUMBER}' => 'AD_CODE',
                    '3' => '<div class="ads-post">'. get_field('ads-post-mob-p-1', 'option') .'</div>',
                    '8' => '<div class="ads-post">'. get_field('ads-post-mob-p-1', 'option') .'</div>',
                    '15' => '<div class="ads-post">'. get_field('ads-post-mob-p-1', 'option') .'</div>',
                    '23' => '<div class="ads-post">'. get_field('ads-post-mob-p-1', 'option') .'</div>',
                    //'2' => '<div>Ad code after SECOND paragraph goes here</div>',
                ), $content );
            } else {
                $content = prefix_insert_after_paragraph2( array(
                    // The format is: '{PARAGRAPH_NUMBER}' => 'AD_CODE',
                    '3' => '<div class="ads-post">'. get_field('ads-post-p-1', 'option') .'</div>',
                    '8' => '<div class="ads-post">'. get_field('ads-post-p-1', 'option') .'</div>',
                    '15' => '<div class="ads-post">'. get_field('ads-post-p-1', 'option') .'</div>',
                    '23' => '<div class="ads-post">'. get_field('ads-post-p-1', 'option') .'</div>',
                    //'2' => '<div>Ad code after SECOND paragraph goes here</div>',
                ), $content );
            }
            
        } else {
        
            if( wp_is_mobile() ) {
                $content = prefix_insert_after_paragraph2( array(
                    // The format is: '{PARAGRAPH_NUMBER}' => 'AD_CODE',
                    '3' => '<div id="ads-post-1" class="ads-post" style="min-width: 300px; min-height: 120px; max-height: 80vh;"><div id="yandex_rtb_R-A-417693-21-1"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-21-1",
        blockId: "R-A-417693-21",
        pageNumber: 1,
      })
    })</script></div>',
                    '8' => '<div id="ads-post-2" class="ads-post" style="min-width: 300px; min-height: 120px; max-height: 80vh;"><div id="yandex_rtb_R-A-417693-21-2"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-21-2",
        blockId: "R-A-417693-21",
        pageNumber: 2,
      })
    })</script></div>',
                    '15' => '<div id="ads-post-3" class="ads-post" style="min-width: 300px; min-height: 120px; max-height: 80vh;"><div id="yandex_rtb_R-A-417693-21-3"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-21-3",
        blockId: "R-A-417693-21",
        pageNumber: 3,
      })
    })</script></div>',
                    '23' => '<div id="ads-post-4" class="ads-post" style="min-width: 300px; min-height: 120px; max-height: 80vh;"><div id="yandex_rtb_R-A-417693-21-4"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-21-4",
        blockId: "R-A-417693-21",
        pageNumber: 4,
      })
    })</script></div>',
                    //'2' => '<div>Ad code after SECOND paragraph goes here</div>',
                ), $content );
            } else {
                $content = prefix_insert_after_paragraph2( array(
                    // The format is: '{PARAGRAPH_NUMBER}' => 'AD_CODE',
                    '3' => '<div class="ads-post"><div id="yandex_rtb_R-A-417693-23-1"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-23-1",
        blockId: "R-A-417693-23",
        pageNumber: 1,
      })
    })</script></div>',
                    '8' => '<div class="ads-post"><div id="yandex_rtb_R-A-417693-23-2"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-23-2",
        blockId: "R-A-417693-23",
        pageNumber: 2,
      })
    })</script></div>',
                    '15' => '<div class="ads-post"><div id="yandex_rtb_R-A-417693-23-3"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-23-3",
        blockId: "R-A-417693-23",
        pageNumber: 3,
      })
    })</script></div>',
                    '23' => '<div class="ads-post"><div id="yandex_rtb_R-A-417693-23-4"></div>
    <script>window.yaContextCb.push(()=>{
      Ya.Context.AdvManager.render({
        renderTo: "yandex_rtb_R-A-417693-23-4",
        blockId: "R-A-417693-23",
        pageNumber: 4,
      })
    })</script></div>',
                    //'2' => '<div>Ad code after SECOND paragraph goes here</div>',
                ), $content );
            }
            
        }
    }
    return $content;
}




// SEO RANK MATH


// Pre get Posts

function limit_posts_per_home_page() {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $first_page_limit = 4;
    $limit = get_option('posts_per_page');

    if(!is_admin()) {
        if (is_category() && !is_category([1, 182, 195, 196, 197]) || is_tax()) {
            if ($paged == 1) {
                $limit = $first_page_limit;
            } else {
                $offset = $first_page_limit + (($paged - 2) * $limit);
                set_query_var('offset', $offset);   
            }
            set_query_var('posts_per_archive_page', $limit);
            set_query_var('posts_per_page', $limit);
        }
    }
}
add_filter('pre_get_posts', 'limit_posts_per_home_page');


// title

add_filter( 'rank_math/frontend/title', function( $title ) {
    //global $wp_query;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if (is_paged()) {
        //return $title . ' – Страница ' . $paged . ' из ' . $wp_query->max_num_pages;
        return $title . ' – Страница ' . $paged;
    }
	return $title;
});


// Description

add_filter( 'rank_math/frontend/description', function( $description ) {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if (is_paged()) {
        return $description . ' – Страница ' . $paged;
    }
	return $description;
});


// Canonical pagination

add_filter( 'rank_math/frontend/canonical', function( $canonical ) {
    if ( is_paged() ) {
        if ( is_home() ) {
            return home_url();
        } elseif(is_category() || is_tax()) {
            $rm_term = get_queried_object();        
            $rm_term_id = $rm_term->term_id;
            $rm_term_tax = $rm_term->taxonomy;
            $rm_link = get_term_link( $rm_term_id, $rm_tax );
            return $rm_link;
        }
    }
	return $canonical;
});


// CSS validator

add_filter( 'autoptimize_filter_imgopt_lazyload_cssoutput', '__return_false' );
add_action( 'wp_head', function() { echo '<style>.lazyload,.lazyloading{opacity:0;}.lazyloaded{opacity:1;transition:opacity 300ms;}</style>'; }, 2147483647 );

?>