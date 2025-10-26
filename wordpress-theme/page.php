<?php
/**
 * Page Template
 */

get_header(); ?>

<?php while (have_posts()) : the_post(); ?>

    <div class="page-header">
        <div class="container">
            <h1><?php the_title(); ?></h1>
        </div>
    </div>

    <section class="page-content">
        <div class="container">
            <article class="page-article">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="page-featured-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="page-main-content">
                    <?php the_content(); ?>
                    
                    <?php
                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Sayfalar:', 'safwa-tourism'),
                        'after' => '</div>',
                    ));
                    ?>
                </div>

                <?php if (comments_open() || get_comments_number()) : ?>
                    <div class="page-comments">
                        <?php comments_template(); ?>
                    </div>
                <?php endif; ?>
            </article>
        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>
