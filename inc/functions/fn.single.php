<?php

// Inject the TOC on each post

add_filter( 'the_content', 'toc_content' );
function toc_content($content) {
    global $tableOfContents;

    $tableOfContents = "<div class='post-toc-title'>Содержание статьи</div><div class='toggle'></div><div class='items'><div class='item-h2'><a href='#preface'>Начало статьи</a></div>";
    $index = 1;
    $indexes = [2 => 1, 3 => 0, 4 => 0, 5 => 0, 6 => 0];

    // Insert the IDs and create the TOC.
    $content = preg_replace_callback('#<(h[1-6])(.*?)>(.*?)</\1>#si', function ($matches) use (&$index, &$tableOfContents, &$indexes) {
        $tag = $matches[1];
        $title = strip_tags($matches[3]);
        $hasId = preg_match('/id=(["\'])(.*?)\1[\s>]/si', $matches[2], $matchedIds);
        $id = $hasId ? $matchedIds[2] : $index++ . '-' . sanitize_title($title);
        
        // Generate the prefix based on the heading value.
        $prefix = '';
        
        foreach (range(2, $tag[1]) as $i) {
            if ($i == $tag[1]) {
                $indexes[$i] += 1;
            }
            
            $prefix .= $indexes[$i] . '.';
        }
        
        //$title = "$prefix $title";
        $title = "$title";

        $tableOfContents .= "<div class='item-$tag'><a href='#$id'>$title</a></div>";

        if ($hasId) {
            return $matches[0];
        }

        return sprintf('<%s%s id="%s">%s</%s>', $tag, $matches[2], $id, $matches[3], $tag);
    }, $content);

    $tableOfContents .= '</div>';

    return $content;
}

function get_the_table_of_contents() {
    global $tableOfContents;
    return $tableOfContents;
}


// Gallery shortcode Output

add_filter('post_gallery','customFormatGallery',10,2);

function customFormatGallery($string,$attr){

    $posts_order_string = $attr['ids'];
    $posts_order = explode(',', $posts_order_string);

    $output = "<div class=\"sgallery row\">";
    $posts = get_posts(array(
          'include' => $posts_order,
          'post_type' => 'attachment', 
          'orderby' => 'post__in'
    ));

    if($attr['orderby'] == 'rand') {
        shuffle($posts); 
    } 

    foreach($posts as $imagePost){
        $output .= '<div class="col-6 col-md-3"><a href="' . wp_get_attachment_image_src($imagePost->ID, 'full')[0] . '"><img src="' . wp_get_attachment_image_src($imagePost->ID, 'thumbnail')[0] . '" alt="" /></a></div>';
    }

    $output .= "</div>";

    return $output;
}