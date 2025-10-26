<?php
/**
 * Archive Template (Blog Listing)
 */

get_header(); ?>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="page-header-content">
                <nav class="breadcrumb">
                    <a href="<?php echo home_url(); ?>">Anasayfa</a>
                    <span>/</span>
                    <span>Blog</span>
                </nav>
                <h1>Blog & Rehberler</h1>
                <p>Seyahat deneyimleri, rehberler ve önerileri keşfedin</p>
            </div>
        </div>
    </section>

    <!-- Blog Grid Section -->
    <section class="blog-grid-section">
        <div class="container">
            <div class="blog-grid" id="blogGrid">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); 
                        $categories = get_the_category();
                        $category_slug = !empty($categories) ? $categories[0]->slug : '';
                        $category_name = !empty($categories) ? $categories[0]->name : 'Genel';
                        
                        // Get comment count
                        $comment_count = get_comments_number();
                        
                        // Calculate reading time (approx 200 words per minute)
                        $content = get_post_field('post_content', get_the_ID());
                        $word_count = str_word_count(strip_tags($content));
                        $reading_time = ceil($word_count / 200);
                        
                        // Get author name
                        $author_name = get_the_author();
                        
                        // Get excerpt - limit to 15 words for 2 lines
                        $excerpt = has_excerpt() ? wp_trim_words(get_the_excerpt(), 15, '...') : wp_trim_words(get_the_content(), 15, '...');
                        ?>
                        <article class="blog-card" data-category="<?php echo esc_attr($category_slug); ?>">
                            <div class="blog-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php 
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('large', array('alt' => get_the_title()));
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/images/1.jpg" alt="' . esc_attr(get_the_title()) . '">';
                                    }
                                    ?>
                                </a>
                                <div class="blog-badge popular">Popüler</div>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span class="blog-category"><?php echo esc_html($category_name); ?></span>
                                    <div class="blog-rating">
                                        <span>(<?php echo $comment_count; ?> yorum)</span>
                                    </div>
                                </div>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <div class="blog-details">
                                    <span><i class="fas fa-calendar"></i> <?php echo get_the_date('d M Y'); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo $reading_time; ?> dk okuma</span>
                                    <span><i class="fas fa-user"></i> <?php echo esc_html($author_name); ?></span>
                                </div>
                                <p><?php echo esc_html($excerpt); ?></p>
                                <div class="blog-highlights">
                                    <span><i class="fas fa-check"></i> Kapsamlı Bilgi</span>
                                    <span><i class="fas fa-check"></i> Pratik İpuçları</span>
                                    <span><i class="fas fa-check"></i> Deneyimler</span>
                                </div>
                                <div class="blog-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">Yazıyı Oku</a>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="no-posts-found">
                        <i class="fas fa-search"></i>
                        <h3>Blog Yazısı Bulunamadı</h3>
                        <p>Henüz blog yazısı bulunmuyor. Yakında yeni içerikler eklenecek.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if (have_posts() && $wp_query->max_num_pages > 1) : ?>
            <div class="load-more-section">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '<i class="fas fa-chevron-left"></i> Önceki',
                    'next_text' => 'Sonraki <i class="fas fa-chevron-right"></i>',
                    'before_page_number' => '<span class="screen-reader-text">Sayfa </span>',
                ));
                ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

<?php get_footer(); ?>
