<?php get_header();
$curr_term = get_queried_object();
$curr_id = $curr_term->term_taxonomy_id; ?>

<?php if( !is_paged() ) : ?>
    <section class="fp fp-archive">
        <div class="container">
            <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
            <?php $images = get_field('gallery', $curr_term);
                if( $images ): ?>
                <div class="row">
                    <div class="col-md-4 col-lg-3">
                        <div class="char-gallery">
                            <?php $p = 0; foreach( $images as $image ): $p++;
                                if($p == 1) { ?>
                                    <div class="char-photo">
                                        <a href="<?php echo esc_url($image['url']); ?>">
                                            <img src="<?php echo esc_url($image['sizes']['st-post']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
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
                                            <img src="<?php echo esc_url($image['sizes']['min-post']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="char-thumb">
                                        <a href="<?php echo esc_url($image['url']); ?>">
                                            <img src="<?php echo esc_url($image['sizes']['min-post']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-6">
                        <h1><?php single_cat_title(); ?></h1>
                        <?php echo category_description(); ?>
                    </div>
                    <div class="col-lg-3">
                        <?php if( !wp_is_mobile() ) { ?>
                            <div class="widget widget-mbo">
                                <div class="swidget">
                                    <div class="swidget-bot">
                                        <a class="stg" rel="noopener noreferrer nofollow" href="https://t.me/suleymaniya" target="_blank" title="????????????????"><i class="icon-paper-plane-1"></i></a>
                                        <a class="syt" rel="noopener noreferrer nofollow" href="https://www.youtube.com/channel/UCexDuRshhanLukE-NlQlcJQ" target="_blank" title="Youtube"><i class="icon-youtube-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php else : ?>
                <h1><?php single_cat_title(); ?></h1>
                <?php echo category_description(); ?>
            <?php endif; ?>
        </div>
    </section>
    
    <?php $all_actors = get_field('all-actors', $curr_term);
        if( $all_actors ) : ?>
        <section class="fp pto">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="titles">
                            <h2>????????????</h2>
                        </div>
                        <div class="list-row">
                            <?php foreach($all_actors as $actor) : 
                                $actor_image = get_field('foto-one', $actor); ?>
                                <a class="list-term" href="<?php echo get_term_link( $actor->term_id, $actor->taxonomy ); ?>">
                                    <?php if($actor_image) { ?>
                                        <div class="list-term-img">
                                            <img src="<?php echo esc_url($actor_image['sizes']['thumbnail']); ?>" alt="<?php echo $actor->name; ?>">
                                        </div>
                                    <?php } ?>
                                    <?php if($actor->name) { ?>
                                        <div class="list-term-name"><?php echo $actor->name; ?></div>
                                    <?php } ?>
                                </a>
                            <?php endforeach; ?>
                            <a class="list-term" href="<?php if(get_field('all-actors-link', $curr_term)) { echo the_field('all-actors-link', $curr_term); } ?>">
                                <div class="list-term-ico"><i class="icon-angle-right"></i></div>
                                <div class="list-term-txt">?????? <br/>????????????</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="titles">
                            <h2>??????????????????</h2>
                        </div>
                        <div class="list-row">
                            <?php $all_characters = get_field('all-characters', $curr_term);
                                if( $all_characters ) :
                                    foreach($all_characters as $charos) : 
                                        $char_image = get_field('foto-one', $charos); ?>
                                    <a class="list-term" href="<?php echo get_term_link( $charos->term_id, $charos->taxonomy ); ?>">
                                        <?php if($char_image) { ?>
                                            <div class="list-term-img">
                                                <img src="<?php echo esc_url($char_image['sizes']['thumbnail']); ?>" alt="<?php echo $charos->name; ?>">
                                            </div>
                                        <?php } ?>
                                        <?php if($charos->name) { ?>
                                            <div class="list-term-name"><?php echo $charos->name; ?></div>
                                        <?php } ?>
                                    </a>
                            <?php endforeach; endif; ?>
                            <a class="list-term last" href="<?php if(get_field('all-characters-link', $curr_term)) { echo the_field('all-characters-link', $curr_term); } ?>">
                                <div class="list-term-ico"><i class="icon-angle-right"></i></div>
                                <div class="list-term-txt">?????? <br/>??????????????????</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>                      
    <?php endif; ?>
    
    <?php $n = 0; if( have_rows('chactor-loop', $curr_term) ) : while ( have_rows('chactor-loop', $curr_term) ) : the_row(); $n++; ?>
        <section class="fp pto fp-chactor">
            <div class="container">
                <?php $chactor_title = get_sub_field('chactor-title');
                    if( $chactor_title ) : ?>
                        <div class="titles">
                            <h2><a href="<?php echo get_term_link($chactor_title->term_id, $chactor_title->taxonomy); ?>"><?php echo $chactor_title->name; ?></a></h2>
                        </div>
                    <?php endif; ?>
                    
                    <?php $charactors = get_sub_field('chactor-tax');
                        if($charactors) : ?>
                        <div class="chactors-row">
                            <?php foreach($charactors as $charactor) :
                                $charactor_image = get_field('foto-one', $charactor);
                                $charactor_img = $charactor_image['sizes']['min-post'];
                                $charactor_char = get_field('select-character', $charactor);
                                $charactor_char = $charactor_char[0]; ?>
                                <div class="chactor-col">
                                    <div class="chactor-item">
                                        <div class="chactor-img">
                                            <a href="<?php echo get_term_link( $charactor->term_id, $charactor->taxonomy ); ?>">
                                                <?php if($charactor_img) { ?>
                                                    <img src="<?php echo $charactor_img; ?>" alt="<?php echo $charactor->name; ?>">
                                                <?php } ?>
                                                <div class="chactor-img-txt"><?php echo $charactor->name; ?></div>
                                            </a>
                                        </div>
                                        <div class="chactor-name">
                                            <?php if($charactor_char) : ?>
                                                    <a href="<?php echo get_term_link($charactor_char->term_id, 'characters'); ?>"><?php echo $charactor_char->name; ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
               </div>
        </section>         
    <?php endwhile; endif; ?>
    
    <?php $args = array( 'parent' => $curr_id, );
        $categories = get_categories( $args );
        if ( $categories ) : ?>
        <section class="fp pto">
            <div class="container">
                <div class="titles">
                    <h2>??????????????</h2>
                </div>
                <div class="archive-sub-categories">
                    <?php foreach($categories as $category) :
                        $cat_img = get_field('foto-one', $category); ?>
                        <div class="arch-item">
                            <a class="list-term" href="<?php echo get_category_link( $category->term_id ); ?>">
                                <?php if( $cat_img ) : ?>
                                    <div class="list-term-img">
                                        <img src="<?php echo esc_url( $cat_img['sizes']['min-post'] ); ?>" alt="<?php echo $category->name; ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if( $category->name ) : ?>
                                    <div class="list-term-name"><?php echo $category->name; ?></div>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
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
                                        'terms' => $photo,
                                    ),
                                    array(
                                        'taxonomy' => 'category',
                                        'field' => 'id',
                                        'terms' => $curr_id,
                                    )
                                ),
                            );
                            $photo_query = new WP_Query( $args );
                            $n = 0; if($photo_query->have_posts()) : ?>
                            <div class="postainer">
                                <div class="titler">
                                    <h2>??????????????????????</h2>
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
                                                <div class="titler-arrow" data-tainer="1" data-page="2" data-postype="post" data-tagname="<?php echo $photo; ?>" data-catname="<?php echo $curr_id; ?>" data-termname="" data-perpage="2" data-postid=""><i class="icon-angle-right"></i></div>
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
                                        'terms' => 1, $curr_id,
                                    ),
                                ),
                            );
                            $news_query = new WP_Query( $args );
                            $n = 0; if($news_query->have_posts()) : ?>
                            <div class="postainer">
                                <div class="titler">
                                    <h2>??????????????</h2>
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
                                                <div class="titler-arrow" data-tainer="2" data-page="2" data-postype="post" data-catname="1, <?php echo $curr_id; ?>" data-termname="" data-perpage="2" data-postid=""><i class="icon-angle-right"></i></div>
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
    
    <?php $sec_txt = get_field('sec-txt', $curr_term);
        if( $sec_txt ) : ?>
        <section class="fp pto">
            <div class="container">
                <div class="archive-descr">
                    <?php echo $sec_txt; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

<section class="fp<?php if( !is_paged() ) { echo ' pto'; } else { echo ' fp-archive'; } ?>">
    <div class="container">
        <h2><?php if( is_paged() ) { echo single_cat_title() . ' ??? ???????????????? ' . $paged; } else { ?>?????? ??????????????????<?php } ?></h2>
        <div class="row all-posts">
            <?php $p = 0; if(have_posts()) : while(have_posts()) : the_post(); $p++; ?>
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
             <?php endwhile; ?>
                <?php if (  $wp_query->max_num_pages > 1 ) { ?>
                    <div class="loadmore misha_loadmore">?????????????????? ?????? ??????????</div>
                <?php } ?>
            <?php else : endif; ?>
        </div>
    </div>
</section>

<?php if( !is_paged() ) :
    $main_txt = get_field('main-txt', $curr_term);
        if( $main_txt ) : ?>
        <section class="fp pto">
            <div class="container">
                <div class="archive-main">
                    <?php echo $main_txt; ?>
                </div>
            </div>
        </section>
    <?php endif;
endif; ?>

<?php get_footer(); ?>