<?php
/**
 * Archive Tour Template (Tours Listing Page)
 */

get_header(); ?>

    <!-- Page Header -->
    <section class="page-header">
        <style>
            @media (max-width: 768px) {
                .page-header {
                    margin-top: 0 !important;
                }
            }
        </style>
        <div class="container">
            <div class="page-header-content">
                <nav class="breadcrumb">
                    <a href="<?php echo home_url(); ?>">Anasayfa</a>
                    <span>/</span>
                    <span>Turlarımız</span>
                </nav>
                <h1>Tüm Turlarımız</h1>
                <p>Hayalinizdeki seyahati bulun ve unutulmaz anılar yaşayın</p>
            </div>
        </div>
    </section>

    <!-- Tours Filter Section -->
    <section class="tours-filter-section">
        <div class="container">
            <div class="filter-controls" style="justify-content: center; align-items: center;">
                <div class="filter-categories" style="justify-content: center;">
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'tour_category',
                        'hide_empty' => false,
                    ));
                    ?>
                    <button class="filter-btn active" data-category="all">Tümü</button>
                    <?php 
                    if (!empty($terms)) :
                        foreach ($terms as $term) : ?>
                            <button class="filter-btn" data-category="<?php echo esc_attr($term->slug); ?>">
                                <?php echo esc_html($term->name); ?>
                            </button>
                        <?php endforeach;
                    endif; ?>
                </div>
                
                <div class="filter-search" style="justify-content: center;">
                    <div class="search-box">
                        <input type="text" id="tourSearch" placeholder="Tur ara...">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="filter-options" style="justify-content: center;">
                        <select id="sortBy">
                            <option value="default">Sırala</option>
                            <option value="price-low">Fiyat: Düşük → Yüksek</option>
                            <option value="price-high">Fiyat: Yüksek → Düşük</option>
                            <option value="duration">Süre</option>
                            <option value="popular">Popülerlik</option>
                        </select>
                        <select id="priceRange">
                            <option value="all">Tüm Fiyatlar</option>
                            <option value="0-1000">$0 - $1000</option>
                            <option value="1000-2000">$1000 - $2000</option>
                            <option value="2000-3000">$2000 - $3000</option>
                            <option value="3000+">$3000+</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tours Grid -->
    <section class="tours-grid-section">
        <div class="container">
            <div class="tours-grid" id="toursGrid">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        $regular_price = get_post_meta(get_the_ID(), '_tour_regular_price', true);
                        $sale_price = get_post_meta(get_the_ID(), '_tour_sale_price', true);
                        $duration = get_post_meta(get_the_ID(), '_tour_duration', true);
                        $location = get_post_meta(get_the_ID(), '_tour_location', true);
                        $max_people = get_post_meta(get_the_ID(), '_tour_max_people', true);
                        $departure = get_post_meta(get_the_ID(), '_tour_departure', true);
                        $badge = get_post_meta(get_the_ID(), '_tour_badge', true);
                        
                        // Get categories for filtering
                        $categories = wp_get_post_terms(get_the_ID(), 'tour_category', array('fields' => 'slugs'));
                        $category_str = !empty($categories) ? $categories[0] : 'all';
                        ?>
                        <div class="tour-card" 
                             data-category="<?php echo esc_attr($category_str); ?>" 
                             data-price="<?php echo esc_attr($sale_price ?: $regular_price); ?>" 
                             data-duration="<?php echo esc_attr($duration); ?>"
                             style="height: 650px;">
                            <div class="tour-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php 
                                    if (has_post_thumbnail()) {
                                        the_post_thumbnail('large');
                                    } else {
                                        echo '<img src="' . get_template_directory_uri() . '/images/1.jpg" alt="' . get_the_title() . '">';
                                    }
                                    ?>
                                </a>
                                <?php if ($badge) : ?>
                                    <div class="tour-badge"><?php echo esc_html(ucfirst($badge)); ?></div>
                                <?php endif; ?>
                                <div class="tour-wishlist">
                                    <i class="far fa-heart"></i>
                                </div>
                            </div>
                            <div class="tour-content">
                                <div class="tour-meta">
                                    <span class="tour-category">
                                        <?php 
                                        $terms = wp_get_post_terms(get_the_ID(), 'tour_category');
                                        if (!empty($terms)) {
                                            echo esc_html($terms[0]->name);
                                        }
                                        ?>
                                    </span>
                                    <div class="tour-rating">
                                        <div class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span>(<?php echo rand(20, 100); ?> değerlendirme)</span>
                                    </div>
                                </div>
                                <h3><?php the_title(); ?></h3>
                                <div class="tour-details">
                                    <?php if ($duration) : ?>
                                        <span><i class="fas fa-calendar"></i> <?php echo esc_html($duration); ?> Gün <?php echo esc_html($duration - 1); ?> Gece</span>
                                    <?php endif; ?>
                                    <?php if ($departure) : ?>
                                        <span><i class="fas fa-plane"></i> <?php echo esc_html($departure); ?></span>
                                    <?php endif; ?>
                                    <?php if ($max_people) : ?>
                                        <span><i class="fas fa-users"></i> Max <?php echo esc_html($max_people); ?> Kişi</span>
                                    <?php endif; ?>
                                </div>
                                <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <div class="tour-highlights">
                                    <span><i class="fas fa-check"></i> 5 Yıldızlı Otel</span>
                                    <span><i class="fas fa-check"></i> Özel Rehber</span>
                                    <span><i class="fas fa-check"></i> Haram'a Yakın Konaklama</span>
                                </div>
                                <div class="tour-price">
                                    <?php if ($sale_price && $regular_price && $sale_price < $regular_price) : ?>
                                        <span class="old-price">$<?php echo number_format($regular_price, 0); ?></span>
                                        <span class="current-price">$<?php echo number_format($sale_price, 0); ?></span>
                                    <?php else : ?>
                                        <span class="current-price">$<?php echo number_format($sale_price ?: $regular_price, 0); ?></span>
                                    <?php endif; ?>
                                    <span class="price-note">Kişi başı</span>
                                </div>
                                <div class="tour-actions">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-outline">Detayları Gör</a>
                                    <button class="btn btn-primary quick-book" data-tour="<?php echo esc_attr(get_the_ID()); ?>">Hemen Rezerve Et</button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <div class="no-tours-found">
                        <i class="fas fa-search"></i>
                        <h3>Tur Bulunamadı</h3>
                        <p>Aradığınız kriterlere uygun tur bulunamadı. Lütfen farklı filtreler deneyin.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php get_footer(); ?>
