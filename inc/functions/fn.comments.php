<?php

// Hierarchical type comment script

function enqueue_comment_reply() {
	if( is_singular() && comments_open() && (get_option('thread_comments') == 1) ) 
		wp_enqueue_script('comment-reply');
}
add_action( 'wp_enqueue_scripts', 'enqueue_comment_reply' );


// Comments list

function mytheme_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $author_adm = $comment->user_id; ?>
    <li class="comment" id="li-comment-<?php comment_ID(); ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-wrap<?php if($author_adm == 1) { echo ' admins'; } ?>">
            <div class="comment-avatar">
                <?php echo get_avatar($comment, $size='40'); ?>
            </div>
            <div class="comment-author"><?php if($author_adm == 1) { echo get_the_author_meta('nickname'); } else { comment_author(); } ?></div>
            <?php if ($comment->comment_approved == '0') : ?>  
                <?php _e('Your comment is awaiting moderation.') ?>
            <?php endif; ?>
            <div class="comment-text">
                <?php comment_text() ?>
            </div>
            <div class="comment-meta">
                <?php echo get_comment_date('d F, Y'); ?> в <?php echo get_comment_time('h:m'); ?>
                <span class="comment-reply-link btn" onclick="return addComment.moveForm('comment-<?php echo $comment->comment_ID; ?>', '<?php echo $comment->comment_ID; ?>', 'respond', '<?php echo $comment->comment_post_ID; ?>')">Ответить</span>
            </div>
        </div>
<?php }


// Remove H2 tag from comment navi title

function sanitize_pagination($content) {
    $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);
    return $content;
}
add_action('navigation_markup_template', 'sanitize_pagination');


// Delete link from cansel comment reply

add_filter('cancel_comment_reply_link', function($formatted_link, $link, $text){
	return '<span id="cancel-comment-reply-link" style="display:none;">'. $text .'</span>';
}, 10, 3);


// Remove H3 tag from respond title

add_filter( 'comment_form_defaults', 'custom_reply_title' );
function custom_reply_title( $defaults ){
    $defaults['title_reply_before'] = '<div id="reply-title" class="comment-reply-title w-title"><span>';
    $defaults['title_reply_after'] = '</span></div>';
    $defaults['title_reply'] = 'Оставьте комментарий';
    $defaults['comment_notes_before'] = '';
    // удалим текст, который будет показан после того, как коммент отправлен
    $defaults['comment_notes_after'] = '';
    $defaults['label_submit'] = 'Отправить';
    return $defaults;
}


// placeholder в поля комментариев

add_filter( 'comment_form_fields', 'com_update_fields' );
function com_update_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
 
    $fields['author'] =
        '<div class="comment-form-field">
            <input required minlength="3" maxlength="30" placeholder="Ваше имя*" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' />
        </div>';
 
    $fields['email'] =
        '<div class="comment-form-field">
            <input required placeholder="Ваш Email*" id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' />
        </div>';
 
    unset( $fields['url'] );
    //unset( $fields['comment'] );
    
    $fields['comment'] = 
        '<div class="comment-form-comment">
            <textarea required placeholder="Ваш комментарий.." id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
 
    return $fields;
}


add_action('comment_form_before_fields', function () {
    echo '<div class="comment-form-row">';
});

add_action('comment_form_after_fields', function () {
    echo '</div>';
});

/*
add_action('comment_form_after', function () {
    echo '<p>Текст, который будет показан после формы комментирования.</p>';
});
*/