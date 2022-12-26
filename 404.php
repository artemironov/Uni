<?php get_header(); ?>

<section class="fp fp-single">
    <div class="container">
        <?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
        <h1>404 страница</h1>
        <div class="entry">
            <p>Извините, но того, что Вы искали, тут нет.</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>