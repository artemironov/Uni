<?php get_header(); ?>

<section class="fp fp-single">
    <div class="container">
        <?php if(have_posts() ) : while( have_posts() ) : the_post(); setPostViews(get_the_ID()); ?>
            <article class="content-container">
                <div class="article-container">
                    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
                    <h1><?php the_title(); ?></h1>
                    <div class="entry">
                        <?php the_content(); ?>
                    </div>
                </div>
                <aside class="sidebar">
                    <div class="widget">
                        <div class="w-title"><span>Топ за месяц</span></div>
                        <?php $topcurID = get_the_ID();
                            $topargs = array(
                                'post_type' => 'post',
                                'posts_per_page' => 3,
                                'order' => 'DESC',
                                'orderby'  => 'meta_value_num',
                                'meta_key' => 'post_views_count',
                                'order' => 'DESC',
                            );
                            $topquery = new WP_Query( $topargs );
                            if( $topquery->have_posts() ) : while( $topquery->have_posts() ) : $topquery->the_post(); ?>
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
                </aside>
            </article>
        <?php endwhile; else : ?>
            <div class="entry">
                <p>Извините, но того, что Вы искали, тут нет.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>