<?php get_header(); ?>

<section class="fp fp-popular">
    <div class="container">
        <div class="fp-title">
            <div class="fp-title-inner">
                <h2>Топ за месяц</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?php $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 1,
                        'order' => 'DESC',
                        'orderby'  => 'meta_value_num',
                        'meta_key' => 'post_views_count',
                        'order' => 'DESC',
                    );
                    $wp_query = new WP_Query( $args );
                    $n = 0; if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); $n++; ?>
                    <div <?php post_class('post center-contents'); ?>>
                        <?php if(has_post_thumbnail()) { ?>
                            <figure class="post-gallery">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('st-post', array('class' => 'wp-post-image lazyloaded')); ?>
                                </a>
                            </figure>
                        <?php } ?>
                        <aside class="post-category ">
                            <?php $category = get_the_category();
                                $categID = $category[0]->cat_ID; ?>
                            <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                        </aside>
                        <div class="post-title">
                            <h2><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <div class="post-excerpt">
                            <?php $excerpt = get_the_excerpt(); echo wp_trim_words($excerpt, 17); ?>
                        </div>
                        <aside class="post-bottom">
                            <ul>
                                <li class="post-date"><?php echo get_the_date('d.m.Y'); ?></li>
                                <li class="post-read"><?php $post_id = get_the_ID(); reading_time($post_id); ?></li>
                            </ul>
                        </aside>
                    </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
            
            <?php if( wp_is_mobile() ) { ?>
                <div class="col-12">
                    <div class="ads-home-mob">
                        <?php $ads = get_field('ads-home-mob-1', 'option'); echo $ads; ?>
                    </div>
                </div>
            <?php } ?>
            
            <div class="col-lg-6">
                <div class="row">
                    <?php $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 4,
                            'order' => 'DESC',
                            'offset' => '1',
                            'orderby'  => 'meta_value_num',
                            'meta_key' => 'post_views_count',
                            'order' => 'DESC',
                        );
                        $wp_query = new WP_Query( $args );
                        $n = 0; if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); $n++; ?>
                        <div class="col-md-6">
                            <div <?php post_class('post'); ?>>
                                <?php if(has_post_thumbnail()) { ?>
                                    <figure class="post-gallery">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail('min-post', array('class' => 'wp-post-image lazyloaded')); ?>
                                        </a>
                                    </figure>
                                <?php } ?>
                                <aside class="post-category ">
                                    <?php $category = get_the_category();
                                        $categID = $category[0]->cat_ID; ?>
                                    <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                                </aside>
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
                    <?php endwhile; wp_reset_postdata(); endif; ?>
                </div>
            </div>
        </div>
        <div class="fp-bot">
            <a class="btn" href="/velikolepnyj-vek" role="button" title="Топ историй" rel="category tag">Больше историй</a>
        </div>
    </div>
</section>

<section class="fp pto fp-ads">
    <div class="container">
        <div class="ads-home">
            <?php if( wp_is_mobile() ) {
                $ads = get_field('ads-home-mob-1', 'option');
                echo $ads;
            } else {
                $ads = get_field('ads-home-1', 'option');
                echo $ads;
            } ?>
        </div>
    </div>
</section>

<section class="fp pto fp-news">
    <div class="container">
        <div class="fp-title">
            <div class="fp-title-inner">
                <h2>Новости</h2>
            </div>
        </div>
        <div class="row">
            <?php $args = array('post_type' => 'post', 'cat' => 1, 'posts_per_page' => 4, 'order' => 'DESC');
                $wp_query = new WP_Query( $args );
                $n = 0; if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); $n++; ?>
                <div class="col-md-6 col-lg-3">
                    <div <?php post_class('post center-contents'); ?>>
                        <?php if(has_post_thumbnail()) { ?>
                            <figure class="post-gallery">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('min-post', array('class' => 'wp-post-image lazyloaded')); ?>
                                </a>
                            </figure>
                        <?php } ?>
                        <aside class="post-category ">
                            <?php $category = get_the_category();
                                $categID = $category[0]->cat_ID; ?>
                            <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                        </aside>
                        <div class="post-title">
                            <h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                        </div>
                        <aside class="post-bottom">
                            <ul>
                                <li class="post-date"><?php echo get_the_date('d.m.Y'); ?></li>
                                <li class="post-read"><?php $post_id = get_the_ID(); reading_time($post_id); ?></li>
                            </ul>
                        </aside>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
        <div class="fp-bot">
            <a class="btn" href="/novosti" role="button" title="Новости" rel="category tag">Все новости</a>
        </div>
    </div>
</section>

<section class="fp fp-articles">
    <div class="container">
        <div class="fp-title">
            <div class="fp-title-inner">
                <h2>Последние посты</h2>
            </div>
        </div>
        <div class="row fp-articles-row">
            <div class="col-lg-6 scnd">
                <?php $args = array('post_type' => 'post', 'category__not_in' => 1, 'posts_per_page' => 1, 'order' => 'DESC');
                    $wp_query = new WP_Query( $args );
                    $n = 0; if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); $n++; ?>
                    <div <?php post_class('post center-contents'); ?>>
                        <?php if(has_post_thumbnail()) { ?>
                            <figure class="post-gallery">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('st-post', array('class' => 'wp-post-image lazyloaded')); ?>
                                </a>
                            </figure>
                        <?php } ?>
                        <aside class="post-category ">
                            <?php $category = get_the_category();
                                $categID = $category[0]->cat_ID; ?>
                            <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                        </aside>
                        <div class="post-title">
                            <h2><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
                        </div>
                        <div class="post-excerpt">
                            <?php $excerpt = get_the_excerpt(); echo wp_trim_words($excerpt, 17); ?>
                        </div>
                        <aside class="post-bottom">
                            <ul>
                                <li class="post-date"><?php echo get_the_date('d.m.Y'); ?></li>
                                <li class="post-read"><?php $post_id = get_the_ID(); reading_time($post_id); ?></li>
                            </ul>
                        </aside>
                    </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
            <div class="col-lg-3 frst">
                <?php $args = array('post_type' => 'post', 'category__not_in' => 1, 'posts_per_page' => 2, 'order' => 'DESC', 'offset' => '1');
                    $wp_query = new WP_Query( $args );
                    $n = 0; if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); $n++; ?>
                    <div <?php post_class('post'); ?>>
                        <?php if(has_post_thumbnail()) { ?>
                            <figure class="post-gallery">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('min-post', array('class' => 'wp-post-image lazyloaded')); ?>
                                </a>
                            </figure>
                        <?php } ?>
                        <aside class="post-category ">
                            <?php $category = get_the_category();
                                $categID = $category[0]->cat_ID; ?>
                            <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                        </aside>
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
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
            <div class="col-lg-3 thrd">
                <?php $args = array('post_type' => 'post', 'category__not_in' => 1, 'posts_per_page' => 5, 'order' => 'DESC', 'offset' => '3');
                    $wp_query = new WP_Query( $args );
                    $n = 0; if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); $n++; ?>
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
                                <h6><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>
                            </div>
                            <aside class="post-bottom">
                                <ul>
                                    <li class="post-date"><?php echo get_the_date('d.m.Y'); ?></li>
                                    <li class="post-read"><?php $post_id = get_the_ID(); reading_time($post_id); ?></li>
                                </ul>
                            </aside>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>
        <div class="fp-bot">
            <a class="btn" href="/velikolepnyj-vek" role="button" title="Cтатьи" rel="category tag">Все статьи здесь</a>
        </div>
    </div>
</section>

<section class="fp pto fp-ads">
    <div class="container">
        <div class="ads-home">
            <?php if( wp_is_mobile() ) {
                $ads = get_field('ads-home-mob-2', 'option');
                echo $ads;
            } else {
                $ads = get_field('ads-home-2', 'option');
                echo $ads;
            } ?>
        </div>
    </div>
</section>

<section class="fp pto fp-gallery">
    <div class="container">
        <div class="fp-title">
            <div class="fp-title-inner">
                <h2>Фотогалерея</h2>
            </div>
        </div>
        <div class="row">
            <?php $args = array('post_type' => 'post', 'tag_id' => 210, 'posts_per_page' => 4, 'order' => 'DESC');
                $wp_query = new WP_Query( $args );
                $n = 0; if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); $n++; ?>
                <div class="col-md-6 col-lg-3">
                    <div <?php post_class('post center-contents'); ?>>
                        <?php if(has_post_thumbnail()) { ?>
                            <figure class="post-gallery">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('min-post', array('class' => 'wp-post-image lazyloaded')); ?>
                                </a>
                            </figure>
                        <?php } ?>
                        <aside class="post-category ">
                            <?php $category = get_the_category();
                                $categID = $category[0]->cat_ID; ?>
                            <a href="<?php echo get_category_link($categID); ?>" rel="category tag"><?php echo $category[0]->cat_name; ?></a>
                        </aside>
                        <div class="post-title">
                            <h4><a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                        </div>
                        <aside class="post-bottom">
                            <ul>
                                <li class="post-date"><?php echo get_the_date('d.m.Y'); ?></li>
                                <li class="post-read"><?php $post_id = get_the_ID(); reading_time($post_id); ?></li>
                            </ul>
                        </aside>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); endif; ?>
        </div>
        <div class="fp-bot">
            <a class="btn" href="/tag/foto-velikolepnyj-vek" role="button" title="Топ историй" rel="category tag">Перейти к галерее</a>
        </div>
    </div>
</section>

<?php if(get_sub_field('video-title', 'option')) { ?>
    <section class="fp fp-hometxt">
        <div class="container">        
            <div class="entry">
                <?php echo the_sub_field('video-title', 'option'); ?>
            </div>
        </div>
    </section>
<?php } ?>

<?php get_footer(); ?>