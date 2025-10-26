<?php
/**
 * Front Page Template (Home Page)
 */

get_header(); ?>

    <!-- Banner Slider -->
    <section id="home" class="banner-slider">
        <div class="slider-container">
            <?php
            $banners = new WP_Query(array(
                'post_type' => 'banner',
                'posts_per_page' => -1,
                'orderby' => 'menu_order',
                'order' => 'ASC'
            ));
            
            $slide_count = 0;
            if ($banners->have_posts()) :
                while ($banners->have_posts()) : $banners->the_post();
                    $subtitle = get_post_meta(get_the_ID(), '_banner_subtitle', true);
                    $button_text = get_post_meta(get_the_ID(), '_banner_button_text', true);
                    $button_link = get_post_meta(get_the_ID(), '_banner_button_link', true);
                    $active_class = ($slide_count === 0) ? 'active' : '';
                    ?>
                    <div class="slide <?php echo $active_class; ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="slide-bg" style="background-image: url('<?php echo get_the_post_thumbnail_url(null, 'full'); ?>')"></div>
                        <?php endif; ?>
                        <div class="slide-content">
                            <div class="container">
                                <h1><?php the_title(); ?></h1>
                                <?php if ($subtitle || get_the_content()) : ?>
                                    <p><?php echo $subtitle ?: wp_strip_all_tags(get_the_content()); ?></p>
                                <?php endif; ?>
                                <?php if ($button_text && $button_link) : ?>
                                    <a href="<?php echo esc_url($button_link); ?>" class="btn btn-primary"><?php echo esc_html($button_text); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php 
                $slide_count++;
                endwhile; 
                wp_reset_postdata();
            else : 
                // Default slides if no banners exist
                ?>
                <div class="slide active">
                    <div class="slide-bg" style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/1.jpg')"></div>
                    <div class="slide-content">
                        <div class="container">
                            <h1>Kutsal Topraklara Yolculuk</h1>
                            <p>Umre ve Kudüs turlarımızla manevi bir deneyim yaşayın</p>
                            <a href="#tours" class="btn btn-primary">Turları İncele</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="slider-controls">
            <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
            <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
        </div>
        
        <div class="slider-dots">
            <?php for ($i = 0; $i < max($slide_count, 1); $i++) : ?>
                <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
            <?php endfor; ?>
        </div>
    </section>

    <!-- Tour Categories -->
    <section id="tours" class="tours-section">
        <div class="container">
            <div class="section-header">
                <h2>Popüler Turlarımız</h2>
                <p>En çok tercih edilen destinasyonlarımızı keşfedin</p>
            </div>
            
            <div class="tour-categories">
                <?php
                $terms = get_terms(array(
                    'taxonomy' => 'tour_category',
                    'hide_empty' => false,
                ));
                
                if (!empty($terms)) :
                    $first = true;
                    foreach ($terms as $term) :
                        ?>
                        <div class="category-tab <?php echo $first ? 'active' : ''; ?>" data-category="<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </div>
                        <?php
                        $first = false;
                    endforeach;
                else :
                    ?>
                    <div class="category-tab active" data-category="umre">Umre Turları</div>
                    <div class="category-tab" data-category="kudus">Kudüs Turları</div>
                    <div class="category-tab" data-category="turkey">Türkiye Turları</div>
                    <div class="category-tab" data-category="international">Uluslararası</div>
                <?php endif; ?>
            </div>
            
            <?php
            // Get tour categories
            $tour_terms = get_terms(array('taxonomy' => 'tour_category', 'hide_empty' => false));
            
            if (!empty($tour_terms)) :
                $first_grid = true;
                foreach ($tour_terms as $term) :
                    $tours = new WP_Query(array(
                        'post_type' => 'tour',
                        'posts_per_page' => 6,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'tour_category',
                                'field' => 'slug',
                                'terms' => $term->slug,
                            ),
                        ),
                    ));
                    
                    if ($tours->have_posts()) :
                        ?>
                        <div class="tour-grid <?php echo $first_grid ? 'active' : ''; ?>" id="<?php echo esc_attr($term->slug); ?>">
                            <?php
                            while ($tours->have_posts()) : $tours->the_post();
                                $regular_price = get_post_meta(get_the_ID(), '_tour_regular_price', true);
                                $sale_price = get_post_meta(get_the_ID(), '_tour_sale_price', true);
                                $duration = get_post_meta(get_the_ID(), '_tour_duration', true);
                                $location = get_post_meta(get_the_ID(), '_tour_location', true);
                                $badge = get_post_meta(get_the_ID(), '_tour_badge', true);
                                ?>
                                <div class="tour-card">
                                    <div class="tour-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php 
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('tour-thumbnail');
                                            } else {
                                                echo '<img src="' . get_template_directory_uri() . '/images/1.jpg" alt="' . get_the_title() . '">';
                                            }
                                            ?>
                                        </a>
                                        <?php if ($badge) : ?>
                                            <div class="tour-badge"><?php echo esc_html(ucfirst($badge)); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tour-content">
                                        <h3><?php the_title(); ?></h3>
                                        <div class="tour-details">
                                            <?php if ($duration) : ?>
                                                <span><i class="fas fa-calendar"></i> <?php echo esc_html($duration); ?> Gün</span>
                                            <?php endif; ?>
                                            <?php if ($location) : ?>
                                                <span><i class="fas fa-map-marker-alt"></i> <?php echo esc_html($location); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <p class="tour-description-2lines"><?php echo wp_trim_words(get_the_excerpt() ?: get_the_content(), 15, '...'); ?></p>
                                        <div class="tour-price">
                                            <?php if ($sale_price && $regular_price && $sale_price < $regular_price) : ?>
                                                <span class="old-price">$<?php echo number_format($regular_price, 0); ?></span>
                                                <span class="current-price">$<?php echo number_format($sale_price, 0); ?></span>
                                            <?php else : ?>
                                                <span class="current-price">$<?php echo number_format($sale_price ?: $regular_price, 0); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="btn btn-outline">Detayları Gör</a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <?php
                        $first_grid = false;
                    endif;
                    wp_reset_postdata();
                endforeach;
            endif;
            ?>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Safwa Tourism Hakkında</h2>
                    <p>2010 yılından beri turizm sektöründe hizmet veren Safwa Tourism, müşterilerinin güvenli ve konforlu seyahat deneyimi yaşaması için çalışmaktadır.</p>
                    <div class="features">
                        <div class="feature">
                            <i class="fas fa-award"></i>
                            <div>
                                <h4>15+ Yıl Tecrübe</h4>
                                <p>Sektörde uzun yıllara dayanan deneyim</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-users"></i>
                            <div>
                                <h4>10,000+ Mutlu Müşteri</h4>
                                <p>Binlerce müşterimizin güvenini kazandık</p>
                            </div>
                        </div>
                        <div class="feature">
                            <i class="fas fa-globe"></i>
                            <div>
                                <h4>50+ Destinasyon</h4>
                                <p>Dünyanın dört bir yanına turlar</p>
                            </div>
                        </div>
                    </div>
                    <a href="#contact" class="btn btn-primary">Bizimle İletişime Geçin</a>
                </div>
                <div class="about-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/2.jpg" alt="Safwa Tourism">
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="blog-section">
        <div class="container">
            <div class="section-header">
                <h2>Blog & Haberler</h2>
                <p>Seyahat önerileri ve destinasyon rehberleri</p>
            </div>
            
            <div class="blog-grid">
                <?php
                $blog_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3
                ));
                
                if ($blog_posts->have_posts()) :
                    while ($blog_posts->have_posts()) : $blog_posts->the_post();
                        $categories = get_the_category();
                        $category_slug = !empty($categories) ? $categories[0]->slug : '';
                        $category_name = !empty($categories) ? $categories[0]->name : 'Genel';
                        $comment_count = get_comments_number();
                        $content = get_post_field('post_content', get_the_ID());
                        $word_count = str_word_count(strip_tags($content));
                        $reading_time = ceil($word_count / 200);
                        $author_name = get_the_author();
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
                    <?php endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header">
                <h2>İletişim</h2>
                <p>Sorularınız için bize ulaşın</p>
            </div>
            
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>Adres</h4>
                            <p>Prizren/ Kosova</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>Telefon</h4>
                            <p>+383 49 319 299</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>E-posta</h4>
                            <p>info@safwaturizm.com</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h4>Çalışma Saatleri</h4>
                            <p>Pzt-Cum: 09:00 - 18:00</p>
                        </div>
                    </div>
                </div>
                
                <form class="contact-form" id="contact-form">
                    <div class="form-row">
                        <input type="text" name="name" placeholder="Adınız" required>
                        <input type="email" name="email" placeholder="E-posta" required>
                    </div>
                    <div class="form-row">
                        <input type="tel" name="phone" placeholder="Telefon">
                        <input type="text" name="subject" placeholder="Konu">
                    </div>
                    <textarea name="message" placeholder="Mesajınız" rows="5" required></textarea>
                    <button type="submit" class="btn btn-primary">Gönder</button>
                </form>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
