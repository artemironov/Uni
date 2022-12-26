<?php get_header(); ?>

<section class="fp fp-archive">
    <div class="container">
        <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        <div class="archive-title">
            <h1>
                <?php single_cat_title(); if( is_paged() ) { echo ' – Страница ' . $paged . ' из ' . $wp_query->max_num_pages; } ?>
            </h1>
        </div>
        <?php $currcat = get_queried_object();
            $catid = $currcat->term_id;
            $args = array('parent' => $catid);
            $categories = get_categories( $args );
            if($categories) { ?>
            <div class="archive-sub-categories">
                <?php foreach($categories as $category) { ?>
                    <a href="<?php echo get_category_link( $category->term_id ); ?>" class="tag-cloud-link"><?php echo $category->name; ?></a>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="archive-descr">
            <?php if( !is_paged() ) { echo category_description(); } ?>
        </div>

        <div class="row all-posts">
            <?php $n = 0; if(have_posts()) : while(have_posts()) : the_post(); $n++;
                if($n == 5) {
                    $ads = get_field('ads-archive-post', 'option');
                    echo $ads;
                } else { ?>
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
             <?php }
             endwhile; ?>
                <?php if (  $wp_query->max_num_pages > 1 ) { ?>
                    <div class="loadmore misha_loadmore">Загрузить еще посты</div>
                <?php } ?>
            <?php else : endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>