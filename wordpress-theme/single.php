<?php
/**
 * Single Post Template (Blog Detail)
 */

get_header();

while (have_posts()) : the_post(); 
    $categories = get_the_category();
    $category_name = !empty($categories) ? $categories[0]->name : 'Genel';
    $comment_count = get_comments_number();
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200);
    $author_name = get_the_author();
?>

    <!-- Article Header -->
    <section class="article-header">
        <div class="container">
            <nav class="breadcrumb">
                <a href="<?php echo home_url(); ?>">Ana Sayfa</a>
                <span>/</span>
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">Blog</a>
                <span>/</span>
                <span><?php the_title(); ?></span>
            </nav>
            
            <div class="article-meta">
                <div class="article-category">
                    <span class="category-tag"><?php echo esc_html($category_name); ?></span>
                </div>
                
                <h1><?php the_title(); ?></h1>
                
                <div class="article-info">
                    <div class="author-info">
                        <?php echo get_avatar(get_the_author_meta('ID'), 64, '', '', array('class' => 'author-avatar')); ?>
                        <div class="author-details">
                            <span class="author-name"><?php echo esc_html($author_name); ?></span>
                            <span class="author-title"><?php echo get_the_author_meta('description') ? esc_html(get_the_author_meta('description')) : 'Yazar'; ?></span>
                        </div>
                    </div>
                    
                    <div class="article-stats">
                        <span class="publish-date"><i class="fas fa-calendar"></i> <?php echo get_the_date('d F Y'); ?></span>
                        <span class="reading-time"><i class="fas fa-clock"></i> <?php echo $reading_time; ?> dk okuma</span>
                        <span class="views"><i class="fas fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?> görüntüleme</span>
                    </div>
                </div>
                
                <?php if (has_post_thumbnail()) : ?>
                    <div class="article-image">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="article-section">
        <div class="container">
            <div class="article-layout">
                <!-- Main Content -->
                <main class="article-content">
                    <div class="content-wrapper">
                        <div class="article-text">
                            <?php the_content(); ?>
                        </div>

                        <!-- Article Tags -->
                        <?php if (get_the_tags()) : ?>
                            <div class="article-tags">
                                <h4>Etiketler:</h4>
                                <div class="tags">
                                    <?php
                                    $tags = get_the_tags();
                                    foreach ($tags as $tag) {
                                        echo '<span class="tag">' . esc_html($tag->name) . '</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Comments Section -->
                    <div class="comments-section">
                        <div class="section-header-center">
                            <h2>Yorumlar</h2>
                            <p>Okuyucu yorumları (<?php echo get_comments_number(); ?>)</p>
                        </div>
                        
                        <!-- Comments Slider -->
                        <?php
                        $comments = get_comments(array(
                            'post_id' => get_the_ID(),
                            'status' => 'approve',
                            'type' => 'comment'
                        ));
                        
                        if (!empty($comments)) : ?>
                            <div class="reviews-slider-wrapper">
                                <button class="reviews-prev" aria-label="Önceki yorum">‹</button>
                                <div class="reviews-slider-track">
                                    <?php
                                    foreach ($comments as $comment) :
                                        $author_name = get_comment_author($comment);
                                        // Get initials
                                        $name_parts = explode(' ', trim($author_name));
                                        if (count($name_parts) >= 2) {
                                            $initial = strtoupper(substr($name_parts[0], 0, 1) . substr($name_parts[1], 0, 1));
                                        } else {
                                            $initial = strtoupper(substr($author_name, 0, 1));
                                        }
                                        
                                        // Format relative time
                                        $comment_time = strtotime($comment->comment_date);
                                        $current_time = current_time('timestamp');
                                        $time_diff = $current_time - $comment_time;
                                        
                                        if ($time_diff < 3600) {
                                            $time_text = ceil($time_diff / 60) . ' dakika önce';
                                        } elseif ($time_diff < 86400) {
                                            $time_text = ceil($time_diff / 3600) . ' saat önce';
                                        } elseif ($time_diff < 604800) {
                                            $time_text = ceil($time_diff / 86400) . ' gün önce';
                                        } elseif ($time_diff < 2592000) {
                                            $time_text = ceil($time_diff / 604800) . ' hafta önce';
                                        } elseif ($time_diff < 31536000) {
                                            $time_text = ceil($time_diff / 2592000) . ' ay önce';
                                        } else {
                                            $time_text = get_comment_date('j F Y', $comment);
                                        }
                                        ?>
                                        <div class="review-card">
                                            <div class="review-card-header">
                                                <div class="reviewer-avatar"><?php echo $initial; ?></div>
                                                <div class="reviewer-info-new">
                                                    <h4><?php echo get_comment_author($comment); ?></h4>
                                                    <div class="review-meta">
                                                        <span class="date"><?php echo $time_text; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="review-text"><?php echo get_comment_text($comment); ?></p>
                                        </div>
                                        <?php
                                    endforeach;
                                    ?>
                                </div>
                                <button class="reviews-next" aria-label="Sonraki yorum">›</button>
                            </div>
                        <?php else : ?>
                            <div class="no-comments-msg">Henüz yorum yapılmamış. İlk yorumu siz yapın!</div>
                        <?php endif; ?>
                        
                        <!-- Comment Form -->
                        <div class="comment-form-wrapper">
                            <h3>Yorum Yapın</h3>
                            <?php
                            $commenter = wp_get_current_commenter();
                            $comment_form_args = array(
                                'title_reply' => '',
                                'comment_field' => '<div class="form-group"><label for="comment">Yorumunuz *</label><textarea id="comment" name="comment" rows="5" required placeholder="Yorumunuzu yazın..."></textarea></div>',
                                'fields' => array(
                                    'author' => '<div class="form-row"><div class="form-group"><label for="author">Ad Soyad *</label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" required placeholder="Adınız ve Soyadınız" /></div>',
                                    'email' => '<div class="form-group"><label for="email">E-posta *</label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" required placeholder="ornek@email.com" /></div></div>',
                                ),
                                'class_submit' => 'btn btn-primary',
                                'label_submit' => 'Yorumu Gönder',
                                'logged_in_as' => '',
                                'comment_notes_before' => '',
                                'comment_notes_after' => ''
                            );
                            comment_form($comment_form_args);
                            ?>
                        </div>
                    </div>
                </main>

                <!-- Sidebar -->
                <aside class="article-sidebar">
                    <!-- Related Tours Widget -->
                    <?php
                    $tour_args = array(
                        'post_type' => 'tour',
                        'posts_per_page' => 2,
                        'orderby' => 'rand',
                    );
                    $related_tours = new WP_Query($tour_args);
                    
                    if ($related_tours->have_posts()) :
                    ?>
                        <div class="sidebar-widget">
                            <h3>🎯 İlgili Turlar</h3>
                            <div class="related-tours">
                                <?php while ($related_tours->have_posts()) : $related_tours->the_post(); 
                                    $sale_price = get_post_meta(get_the_ID(), '_tour_sale_price', true);
                                    $regular_price = get_post_meta(get_the_ID(), '_tour_regular_price', true);
                                    $price = $sale_price ?: $regular_price;
                                ?>
                                    <div class="tour-item">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        <?php endif; ?>
                                        <div class="tour-info">
                                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <?php if ($price) : ?>
                                                <p class="tour-price">$<?php echo number_format($price, 0); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endwhile; wp_reset_postdata(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Popular Posts Widget -->
                    <div class="sidebar-widget">
                        <h3>📌 Popüler Yazılar</h3>
                        <div class="popular-posts">
                            <?php
                            $popular_posts = new WP_Query(array(
                                'posts_per_page' => 3,
                                'post_status' => 'publish',
                                'post__not_in' => array(get_the_ID()),
                                'orderby' => 'comment_count',
                                'order' => 'DESC',
                            ));
                            
                            if ($popular_posts->have_posts()) :
                                while ($popular_posts->have_posts()) : $popular_posts->the_post();
                                    ?>
                                    <article class="popular-post">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <div class="post-thumb">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('thumbnail'); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <div class="post-info">
                                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            <span class="post-date"><?php echo get_the_date('d F Y'); ?></span>
                                            <div class="post-stats">
                                                <span class="read-count">⭐ <?php echo get_post_meta(get_the_ID(), 'post_views_count', true) ?: '0'; ?> görüntülenme</span>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile; wp_reset_postdata(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Related Articles -->
    <?php
    $categories = wp_get_post_categories(get_the_ID());
    $related_posts = new WP_Query(array(
        'category__in' => $categories,
        'post__not_in' => array(get_the_ID()),
        'posts_per_page' => 3,
    ));
    
    if ($related_posts->have_posts()) :
    ?>
        <section class="related-articles">
            <div class="container">
                <h3>📚 Benzer Yazılar</h3>
                <div class="articles-grid">
                    <?php while ($related_posts->have_posts()) : $related_posts->the_post(); 
                        $post_categories = get_the_category();
                        $post_category = !empty($post_categories) ? $post_categories[0]->name : 'Genel';
                        $post_content = get_post_field('post_content', get_the_ID());
                        $post_word_count = str_word_count(strip_tags($post_content));
                        $post_reading_time = ceil($post_word_count / 200);
                    ?>
                        <article class="article-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="article-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                    <div class="article-category">✨ <?php echo esc_html($post_category); ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="article-content">
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                                <div class="article-meta">
                                    <span class="date">📅 <?php echo get_the_date('d F Y'); ?></span>
                                    <span class="reading-time">⏱️ <?php echo $post_reading_time; ?> dk okuma</span>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
