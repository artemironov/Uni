<?php

// Category Tag remove description columns

function uni_remove_taxonomy_description($columns) {
    if ( $posts = $columns['description'] ){
        unset($columns['description']);
    }
    return $columns;
}
add_filter('manage_edit-category_columns','uni_remove_taxonomy_description');
add_filter('manage_edit-post_tag_columns','uni_remove_taxonomy_description');
add_filter('manage_edit-characters_columns','uni_remove_taxonomy_description');
add_filter('manage_edit-actors_columns','uni_remove_taxonomy_description');
add_filter('manage_edit-tcat_columns','uni_remove_taxonomy_description');


/*

function manage_my_category_columns($columns)
{
 // add 'My Column'
 $columns['my_column'] = 'My Column';

 return $columns;
}
add_filter('manage_edit-category_columns','manage_my_category_columns');
Next we want to put the data in it:

function manage_category_custom_fields($deprecated,$column_name,$term_id)
{
 if ($column_name == 'my_column') {
   echo 'test';
 }
}
add_filter ('manage_category_custom_column', 'manage_category_custom_fields', 10,3);

*/



// Posts columns

add_filter( 'manage_posts_columns', 'uni_filter_posts_columns' );
function uni_filter_posts_columns( $columns ) {
    $post_type = get_post_type();
    if ( $post_type == 'post' ) {
        $columns = array(
            'cb' => $columns['cb'],
            'image' => 'Миниатюра',
            'title' => 'Заголовок',
            //'author' => 'Автор',
            'categories' => 'Рубрики',
            'tags' => 'Теги',
            'actors' => 'Актеры',
            'chars' => 'Персонажи',
            'comments' => 'Комы',
            'date' => 'Дата',
        );
    } else {
        $columns = array(
            'cb' => $columns['cb'],
            'image' => 'Миниатюра',
            'title' => 'Заголовок',
            'categories' => 'Рубрики',
            'comments' => 'Комы',
            'date' => 'Дата',
        );
    }
    return $columns;
}


add_action( 'manage_posts_custom_column', 'uni_realestate_column', 10, 2);
function uni_realestate_column( $column, $post_id ) {
    global $post;    
    
    // Image column
    
    if ( 'image' === $column ) {
        echo get_the_post_thumbnail( $post_id, array(60, 60) );
    }
    
    
    // Actors column
    
    if ( 'actors' === $column ) {
        $terms = get_the_terms( $post_id, 'actors' );
        if ( !empty( $terms ) ) {
            $out = array();
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<a href="%s">%s</a>',
                    esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'actors' => $term->slug ), 'edit.php' ) ),
                    esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'actors', 'display' ) )
                );
            }
            echo join( ', ', $out );
        } else {
            echo '—';
        }
    }
    
    
    // Actors column
    
    if ( 'chars' === $column ) {
        $terms = get_the_terms( $post_id, 'characters' );
        if ( !empty( $terms ) ) {
            $out = array();
            foreach ( $terms as $term ) {
                $out[] = sprintf( '<a href="%s">%s</a>',
                    esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'characters' => $term->slug ), 'edit.php' ) ),
                    esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'characters', 'display' ) )
                );
            }
            echo join( ', ', $out );
        } else {
            echo '—';
        }
    }
}




/*

// Sortable columns

add_filter( 'manage_edit-realestate_sortable_columns', 'uni_realestate_sortable_columns');
function uni_realestate_sortable_columns( $columns ) {
  $columns['price'] = 'price_per_month';
  return $columns;
}

add_action( 'pre_get_posts', 'uni_posts_orderby' );
function uni_posts_orderby( $query ) {
  if( ! is_admin() || ! $query->is_main_query() ) {
    return;
  }

  if ( 'price_per_month' === $query->get( 'orderby') ) {
    $query->set( 'orderby', 'meta_value' );
    $query->set( 'meta_key', 'price_per_month' );
    $query->set( 'meta_type', 'numeric' );
  }
}



// Post meta info

  if ( 'price' === $column ) {
    $price = get_post_meta( $post_id, 'price_per_month', true );

    if ( ! $price ) {
      _e( 'n/a' );  
    } else {
      echo '$ ' . number_format( $price, 0, '.', ',' ) . ' p/m';
    }
  }
*/