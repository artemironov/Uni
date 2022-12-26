<?php get_header();
    $gallery = get_post_meta($post->ID, 'post-gallery', true);
?>

<section class="fp fp-single">
    <div class="container">
        <?php if(have_posts() ) : while( have_posts() ) : the_post(); setPostViews(get_the_ID()); ?>
            <article class="content-container">
                <div class="article-container">
                    <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
                    <h1><?php the_title(); ?></h1>
                    <div class="entry-top">
                        <div class="entry-top-left">
                            <div class="entry-date">Обновление: <?php the_modified_date('j F Y'); ?></div>
                            <div class="entry-time"><i class="icon-clock"></i> <?php $post_id = get_the_ID(); reading_time($post_id); ?></div>
                        </div>
                        <div class="entry-top-right">
                            <div class="entry-com"><i class="icon-comment"></i> <?php comments_number( '0', '1', '%' ); ?></div>
                            <div class="entry-view"><i class="icon-eye"></i> <?php echo getPostViews(get_the_ID()); ?></div>
                        </div>
                    </div>
                    <div id="preface" class="post-content article-body">
                        <div class="entry noselect<?php if($gallery === '1') { echo ' full'; } ?>">
                            <?php the_content(); ?>
                        </div>
                        <?php if($gallery === '1') {} else { ?>
                            <aside class="fixed-container">
                                <div class="sin-fixed">
                                    <div class="post-toc">
                                        <div class="post-toc-wrap">
                                            <?php echo get_the_table_of_contents(); ?>
                                        </div>
                                    </div>
                                    <div class="progress-indicator">
                                        <svg id="svg1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="70" height="70" viewBox="0 0 120 120" >
                                            <defs>
                                                <mask id="msk1">
                                                    <rect width="100%" height="100%" fill="white" />
                                                    <circle class="anicircle" cx="60" cy="60" r="50"  stroke= "black"  fill="none" stroke-width="14" ></circle>
                                                </mask>
                                            </defs>
                                            <circle cx="60" cy="60" r="50" fill="none" stroke="#fff" stroke-width="12"/>
                                            <circle  cx="60" cy="60" r="50" mask="url(#msk1)" transform="rotate(-90 60 60)" fill="none" stroke-dashoffset="314" stroke-dasharray="3.14, 3.14"  stroke="#ccc" stroke-width="12" />
                                        </svg>     
                                        <div class="progress-count"></div>
                                    </div>
                                    <div class="linktc">
                                        <div class="linktc-title">Понравилась статья?<br/>комментарии ниже</div>
                                        <?php $com_num = get_comments_number();
                                            //if($com_num > 0) {
                                                echo '<div class="linktc-com"><i class="icon-comment"></i>' . $com_num . '</div>';
                                            //}
                                        ?>
                                    </div>
                                </div>
                            </aside>
                        <?php } ?>
                    </div>
                    
                    <div class="next-prev row">
                        <div class="col-md-6 sinprev">
                            <?php $prev_post = get_previous_post();
                                if($prev_post) { ?>
                                <div class="npspan">Предыдущая статья</div>
                                <a href="<?php echo get_permalink($prev_post); ?>"><?php echo esc_html($prev_post->post_title); ?></a>
                            <?php } ?>
                        </div>
                        <div class="col-md-6 sinext">
                            <?php $next_post = get_next_post();
                                if($next_post) { ?>
                                <div class="npspan">Следующая статья</div>
                                <a href="<?php echo get_permalink($next_post); ?>"><?php echo esc_html($next_post->post_title); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div class="shares">
                        <div class="sharethis-inline-share-buttons"></div>
                    </div>

                    <div class="related">
                        <div class="w-title"><span>Схожие статьи</span></div>
                        <div class="row">
                            <?php $curID = get_the_ID();
                                $currterms = wp_get_post_terms( $curID,'tcat' );
                                foreach( $currterms as $currterm ) {
                                    $term_link_array[] = $currterm->term_id;
                                }
                                $termies = implode(', ', $term_link_array);
                            
                                $args = array(
                                    'post_type' => 'turkey',
                                    'showposts' => 3,
                                    'orderby'=> 'rand',
                                    'post__not_in' => array($curID),
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'tcat',
                                            'terms'    => $termies,
                                        ),
                                    ),
                                );
                                $query = new WP_Query( $args );
                                if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>
                                <div class="col-md-4">
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
                            <?php endwhile; wp_reset_postdata(); endif; ?>
                        </div>
                    </div>
                    
                    <?php comments_template(); ?>
                </div>
                <aside class="sidebar">
                    <?php if( !wp_is_mobile() ) { ?>
                        <div class="widget">
                            <div class="swidget">
                                <div class="swidget-bot">
                                    <a class="stg" rel="noopener noreferrer nofollow" href="https://t.me/suleymaniya" target="_blank" title="Телеграм"><i class="icon-paper-plane-1"></i></a>
                                    <a class="syt" rel="noopener noreferrer nofollow" href="https://www.youtube.com/channel/UCexDuRshhanLukE-NlQlcJQ" target="_blank" title="Youtube"><i class="icon-youtube-play"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                    <div class="ads-sidebar">
                        <?php if( wp_is_mobile() ) {
                        } else {
                            $ads = get_field('ads-sidebar', 'option');
                            echo $ads;
                        } ?>
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