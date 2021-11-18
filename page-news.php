<?php

get_header();
pageBanner(array(
    'title' => 'Recent News.',
    'subtitle' => 'Keep up with our latest news.'
));
?>

<div class="container container--narrow page-section">
    <?php

    $allPosts = new WP_Query(array(
        'post_type' => 'post',
        'posts_per_page' => -1,

    ));

    while ($allPosts->have_posts()) {
        $allPosts->the_post(); ?>
        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?></p>
            </div>

            <div class="generic-content">
                <?php the_excerpt(); ?>
                <p><a class="btn btn--yellow" href="<?php the_permalink(); ?>">Continue reading &raquo;</a></p>
            </div>

        </div>
    <?php }
    echo paginate_links();
    wp_reset_postdata();
    ?>
</div>

<?php get_footer();

?>