<?php get_header(); ?>

<section class="fp fp-archive">
    <div class="container">
        <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        <div class="archive-title">
            <h1>
                <?php echo 'Статьи о Турции'; if( is_paged() ) { echo ' – Страница ' . $paged . ' из ' . $wp_query->max_num_pages; } ?>
            </h1>
        </div>
        <div class="archive-descr">
            <?php if( !is_paged() ) { echo ''; } ?>
        </div>
        <div class="row all-posts">
            <?php $n = 0; if(have_posts()) : while(have_posts()) : the_post(); $n++; $post_id = get_the_ID(); ?>
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
                                    <?php $terms = wp_get_post_terms( $post_id,'tcat' );         
                                        if($terms) :
                                            $termID = $terms[0]->term_id; ?>
                                        <a href="<?php echo get_term_link( $termID, 'tcat' ); ?>" rel="category tag"><?php echo $terms[0]->name; ?></a>
                                    <?php endif; ?>
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
                    <div class="loadmore misha_loadmore">Загрузить еще посты</div>
                <?php } ?>
            <?php else : endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>