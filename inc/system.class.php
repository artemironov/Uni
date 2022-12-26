<?php

/**
 * Системные функции
 */

class system {
	// Возвращает шорт-код Contact Form 7 по ее ID
	public static function cf7_shortcode( $id ) {
		return sprintf( '[contact-form-7 id="%s"]', $id );
	}

	// Возвращает список постов заданного типа (для userform)
	public static function get_posts_list($args) {
		$posts = array();

    	$default = array(
			'post_type'      => 'post',
			'posts_per_page' => -1,
			'order'          => 'DESC',
			'orderby'        => 'date',
		);

		$args = array_merge($default, $args);
		$q = new WP_Query($args);

		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				$posts[ get_the_ID() ] = get_the_title();
			}
		}
		wp_reset_postdata();

		return $posts;
	}
}


//Remove JQuery migrate

function remove_jquery_migrate( $scripts ) {
 	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
 		$script = $scripts->registered['jquery'];
 
 		if ( $script->deps ) { // Check whether the script has any dependencies
 			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
 		}
 	}
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );


// Post count

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 просмотров";
    }
    
    $count = $count * 3;
    if($count>1000) return round(($count/1000),1).'K';
    
    return number_format($count);
}

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}


// Excerpt

function new_excerpt($charlength) {
   $excerpt = get_the_excerpt();
   $charlength++;
   if(strlen($excerpt)>$charlength) {
       $subex = substr($excerpt,0,$charlength-5);
       $exwords = explode(" ",$subex);
       $excut = -(strlen($exwords[count($exwords)-1]));
       if($excut<0) {
            echo substr($subex,0,$excut);
       } else {
       	    echo $subex;
       }
       echo "";
   } else {
	   echo $excerpt;
   }
}


//remove_filter( 'the_content', 'wpautop' );
//remove_filter( 'the_excerpt', 'wpautop' );
