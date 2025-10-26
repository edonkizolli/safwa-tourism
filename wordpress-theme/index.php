<?php
/**
 * Main Template File
 */

get_header(); ?>

<main class="main-content">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
                <?php
            endwhile;
            
            the_posts_pagination();
        else :
            ?>
            <p>İçerik bulunamadı.</p>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
