<?php
/**
 * Single Post Template (Blog Detail)
 */

get_header();

while (have_posts()) : the_post(); ?>

    <div class="page-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?php echo home_url(); ?>">Ana Sayfa</a>
                <i class="fas fa-chevron-right"></i>
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Blog</a>
                <i class="fas fa-chevron-right"></i>
                <span><?php the_title(); ?></span>
            </div>
        </div>
    </div>

    <section class="blog-detail">
        <div class="container">
            <div class="blog-content-wrapper">
                <article class="blog-main">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="post-featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="post-header">
                        <h1><?php the_title(); ?></h1>
                        
                        <div class="post-meta">
                            <span class="author">
                                <?php echo get_avatar(get_the_author_meta('ID'), 32); ?>
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                    <?php the_author(); ?>
                                </a>
                            </span>
                            <span class="date">
                                <i class="fas fa-calendar"></i>
                                <?php echo get_the_date(); ?>
                            </span>
                            <span class="category">
                                <i class="fas fa-folder"></i>
                                <?php the_category(', '); ?>
                            </span>
                            <span class="comments">
                                <i class="fas fa-comments"></i>
                                <?php comments_number('0 Yorum', '1 Yorum', '% Yorum'); ?>
                            </span>
                        </div>
                    </div>

                    <div class="post-content">
                        <?php the_content(); ?>
                        
                        <?php
                        wp_link_pages(array(
                            'before' => '<div class="page-links">' . esc_html__('Sayfalar:', 'safwa-tourism'),
                            'after' => '</div>',
                        ));
                        ?>
                    </div>

                    <?php if (get_the_tags()) : ?>
                        <div class="post-tags">
                            <i class="fas fa-tags"></i>
                            <?php the_tags('', ', ', ''); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Share Buttons -->
                    <div class="share-section">
                        <h4>Bu yazıyı paylaş:</h4>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                               target="_blank" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" 
                               target="_blank" class="share-btn twitter">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>" 
                               target="_blank" class="share-btn whatsapp">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>

                    <!-- Author Bio -->
                    <div class="author-bio">
                        <div class="author-avatar">
                            <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                        </div>
                        <div class="author-info">
                            <h4><?php the_author(); ?></h4>
                            <p><?php the_author_meta('description'); ?></p>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="btn btn-sm">
                                Yazarın Tüm Yazıları
                            </a>
                        </div>
                    </div>

                    <!-- Comments -->
                    <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>

                    <!-- Navigation -->
                    <div class="post-navigation">
                        <?php
                        $prev_post = get_previous_post();
                        $next_post = get_next_post();
                        ?>
                        
                        <?php if ($prev_post) : ?>
                            <div class="nav-previous">
                                <a href="<?php echo get_permalink($prev_post); ?>">
                                    <i class="fas fa-chevron-left"></i>
                                    <div class="nav-content">
                                        <span class="nav-label">Önceki Yazı</span>
                                        <span class="nav-title"><?php echo get_the_title($prev_post); ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($next_post) : ?>
                            <div class="nav-next">
                                <a href="<?php echo get_permalink($next_post); ?>">
                                    <div class="nav-content">
                                        <span class="nav-label">Sonraki Yazı</span>
                                        <span class="nav-title"><?php echo get_the_title($next_post); ?></span>
                                    </div>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>

                <!-- Sidebar -->
                <aside class="blog-sidebar">
                    <!-- Search -->
                    <div class="sidebar-widget">
                        <h3>Ara</h3>
                        <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                            <input type="search" class="search-field" placeholder="Ara..." value="<?php echo get_search_query(); ?>" name="s">
                            <button type="submit" class="search-submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>

                    <!-- Recent Posts -->
                    <div class="sidebar-widget">
                        <h3>Son Yazılar</h3>
                        <ul class="recent-posts">
                            <?php
                            $recent_posts = new WP_Query(array(
                                'posts_per_page' => 5,
                                'post_status' => 'publish',
                                'post__not_in' => array(get_the_ID())
                            ));
                            
                            if ($recent_posts->have_posts()) :
                                while ($recent_posts->have_posts()) : $recent_posts->the_post();
                                    ?>
                                    <li>
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="recent-post-thumb">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('thumbnail'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="recent-post-content">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            <span class="post-date"><?php echo get_the_date(); ?></span>
                                        </div>
                                    </li>
                                <?php endwhile; wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-widget">
                        <h3>Kategoriler</h3>
                        <ul class="category-list">
                            <?php
                            $categories = get_categories(array(
                                'orderby' => 'count',
                                'order' => 'DESC',
                                'hide_empty' => true,
                            ));
                            
                            foreach ($categories as $category) :
                                ?>
                                <li>
                                    <a href="<?php echo get_category_link($category->term_id); ?>">
                                        <i class="fas fa-folder"></i>
                                        <?php echo esc_html($category->name); ?>
                                        <span class="count">(<?php echo $category->count; ?>)</span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Related Posts -->
                    <?php
                    $categories = wp_get_post_categories(get_the_ID());
                    $related_posts = new WP_Query(array(
                        'category__in' => $categories,
                        'post__not_in' => array(get_the_ID()),
                        'posts_per_page' => 3,
                    ));
                    
                    if ($related_posts->have_posts()) :
                        ?>
                        <div class="sidebar-widget">
                            <h3>İlgili Yazılar</h3>
                            <ul class="related-posts">
                                <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
                                    <li>
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="related-post-thumb">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('thumbnail'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="related-post-content">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            <span class="post-date"><?php echo get_the_date(); ?></span>
                                        </div>
                                    </li>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>
