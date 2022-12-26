<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<div class="w-title"><span><?php comments_number('Нет комментариев', '1 комментарий', '% комментариев'); ?></span></div>
		<ul class="commentlist">
			<?php wp_list_comments('callback=mytheme_comment'); ?>
		</ul>
		<?php the_comments_pagination(
            array(
                'prev_text' => '<i class="icon-angle-left"></i>',
                'next_text' => '<i class="icon-angle-right"></i>',
            )
        ); ?>
		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments">Комментарии закрыты</p>
		<?php endif; ?>
	<?php endif; ?>

	<?php comment_form(); ?>
</div>