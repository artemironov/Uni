<?php get_header();
$curr_term = get_queried_object();
$curr_id = $curr_term->term_taxonomy_id; ?>

<?php if( !is_paged() ) { ?>
    <section class="fp fp-archive">
        <div class="container">    
            <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="char-gallery">
                        <?php $images = get_field('gallery', $curr_term);
                            if( $images ):
                                $p = 0; foreach( $images as $image ): $p++; ?>
                                <?php if($p == 1) { ?>
                                    <div class="char-photo">
                                        <a href="<?php echo esc_url($image['url']); ?>">
                                            <img src="<?php echo esc_url($image['sizes']['st-post']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" width="<?php echo esc_attr($image['width']); ?>" height="<?php echo esc_attr($image['height']); ?>" />
                                        </a>
                                    </div>
                                <?php } elseif($p == 2) { ?>
                                    <?php $video = get_field('video', $curr_term);
                                        if($video) { ?>
                                        <div class="char-thumb">
                                            <a href="https://www.youtube.com/embed/<?php echo $video; ?>" rel="video">
                                                <img width="150" height="150" src="/wp-content/themes/uni/images/char-video.jpg" alt="">
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="char-thumb">
                                        <a href="<?php echo esc_url($image['url']); ?>">
                                            <img src="<?php echo esc_url($image['sizes']['min-post']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" width="<?php echo esc_attr($image['width']); ?>" height="<?php echo esc_attr($image['height']); ?>" />
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="char-thumb">
                                        <a href="<?php echo esc_url($image['url']); ?>">
                                            <img src="<?php echo esc_url($image['sizes']['min-post']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" width="<?php echo esc_attr($image['width']); ?>" height="<?php echo esc_attr($image['height']); ?>" />
                                        </a>
                                    </div>
                                <?php } ?>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
                <div class="col-md-8 col-lg-6">
                    <?php if( wp_is_mobile() ) {
                                    
                                } ?>
                    <h1><?php single_term_title(); ?></h1>
                    <?php echo term_description(); ?>
                </div>
                <div class="col-lg-3">
                    <?php if( !wp_is_mobile() ) { ?>
                        <div class="widget widget-mbo">
                            <div class="swidget">
                                <div class="swidget-bot">
                                    <a class="stg" rel="noopener noreferrer nofollow" href="https://t.me/suleymaniya" target="_blank" title="Телеграм"><i class="icon-paper-plane-1"></i></a>
                                    <a class="syt" rel="noopener noreferrer nofollow" href="https://www.youtube.com/channel/UCexDuRshhanLukE-NlQlcJQ" target="_blank" title="Youtube"><i class="icon-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

    <?php $characters = get_field('select-character', $curr_term);
        if($characters) { ?>
        <section class="fp pto">
            <div class="container">
                <div class="chars">
                    <div class="titler">
                        <h2>Фильмография</h2>
                    </div>
                    <div class="char-serials">
                        <?php foreach($characters as $character) {
                            $character_image = get_field('foto-one', $character);
                            $character_img = $character_image['url'];
                            $character_parent = get_term($character->parent, 'characters');
                            $serial = get_field('select-serial', $character_parent);
                            $serial_image = get_field('foto-one', $serial); ?>
                            <div class="arch-item">
                                <div class="char-item">
                                    <div class="char-person">
                                        <a href="<?php echo get_term_link( $character->term_id, $character->taxonomy ); ?>" <?php if($character_img) { ?>style="background-image: url(<?php echo $character_img; ?>);"<?php } ?>><?php echo $character->name; ?></a>
                                    </div>
                                    <div class="char-serial">
                                        <a href="<?php echo get_category_link($serial->term_id); ?>"><?php echo $serial->name; ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php $photo = get_field('select-photo', $curr_term);
        if( $photo ) : ?>
        <section class="fp pto">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <?php $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 2,
                                'order' => 'DESC',
                                'tax_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'post_tag',
                                        'field' => 'id',
                                        'terms' => $photo
                                    ),
                                    array(
                                        'taxonomy' => 'actors',
                                        'field' => 'id',
                                        'terms' => $curr_id,
                                    )
                                ),
                            );
                            $photo_query = new WP_Query( $args );
                            $n = 0; if($photo_query->have_posts()) : ?>
                            <div class="postainer">
                                <div class="titler">
                                    <h2>Фотогалерея</h2>
                                </div>
                                <div id="ajax-container-1" class="row">
                                    <?php while($photo_query->have_posts()) : $photo_query->the_post(); $n++; ?>
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
                                    <?php endwhile; ?>
                                        <?php if ($photo_query->max_num_pages > 1) { ?> 
                                            <div class="titler-arrows">
                                                <div class="titler-arrow non-active"><i class="icon-angle-left"></i></div>
                                                <div class="titler-arrow" data-tainer="1" data-page="2" data-postype="post" data-tagname="<?php echo $photo; ?>" data-catname="" data-termname="<?php echo $curr_id; ?>" data-perpage="2" data-postid=""><i class="icon-angle-right"></i></div>
                                            </div>
                                        <?php } ?>
                                    <?php wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-6">
                        <?php $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 2,
                                //'orderby' => 'date',
                                //'order' => 'DESC',
                                'tax_query' => array(
                                    'relation' => 'AND',
                                    array(
                                        'taxonomy' => 'category',
                                        'field' => 'id',
                                        'terms' => 1
                                    ),
                                    array(
                                        'taxonomy' => 'actors',
                                        'field' => 'id',
                                        'terms' => $curr_id,
                                    ),
                                ),
                            );
                            $news_query = new WP_Query( $args );
                            $n = 0; if($news_query->have_posts()) : ?>
                            <div class="postainer">
                                <div class="titler">
                                    <h2>Новости</h2>
                                </div>
                                <div id="ajax-container-2" class="row">
                                    <?php while($news_query->have_posts()) : $news_query->the_post(); $n++; ?>
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
                                    <?php endwhile; ?>
                                        <?php if ($news_query->max_num_pages > 1) { ?> 
                                            <div class="titler-arrows">
                                                <div class="titler-arrow non-active"><i class="icon-angle-left"></i></div>
                                                <div class="titler-arrow" data-tainer="2" data-page="2" data-postype="post" data-catname="1" data-termname="<?php echo $curr_id; ?>" data-perpage="2" data-postid=""><i class="icon-angle-right"></i></div>
                                            </div>
                                        <?php } ?>
                                    <?php wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php } ?>

<?php $p = 0; if(have_posts()) : ?>
    <section class="fp<?php if( !is_paged() ) { echo ' pto'; } else { echo ' fp-archive'; } ?>">
        <div class="container">
            <h2><?php if( is_paged() ) { echo single_term_title() . ' – Страница ' . $paged; } else { ?>Все материалы<?php } ?></h2>
            <div class="row all-posts">
                <?php while(have_posts()) : the_post(); $p++; ?>
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
                    if (  $wp_query->max_num_pages > 1 ) { ?>
                    <div class="loadmore misha_loadmore">Загрузить еще посты</div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php else : endif; ?>

<?php if( !is_paged() ) { ?>
    <section class="fp pto">
        <div class="container">
            <?php $main_txt = get_field('main-txt', $curr_term);
                if( $main_txt ) { ?>
                <div class="archive-main">
                    <?php if( wp_is_mobile() ) {
                    
                    } ?>
                    <?php echo $main_txt; ?>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } ?>

<?php get_footer(); ?>